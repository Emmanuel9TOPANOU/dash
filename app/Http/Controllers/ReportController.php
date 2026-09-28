<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Absence;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Afficher le tableau de bord des rapports
     */
    public function index(Request $request)
    {
        $employees = Employee::where('actif', true)->count();
        $presences = Attendance::whereNotNull('heure_arrivee')->count();
        $absences = Absence::count();
        $tasksTotal = Task::count();
        $tasksDone = Task::where('statut', 'terminee')->count();

        $firstAttendanceDate = Attendance::min('date');
        $lastAttendanceDate = Attendance::max('date');
        $coveredDays = $firstAttendanceDate && $lastAttendanceDate
            ? Carbon::parse($firstAttendanceDate)->diffInDays(Carbon::parse($lastAttendanceDate)) + 1
            : 0;
        $tauxPresence = $employees > 0 && $coveredDays > 0
            ? round(($presences / ($employees * $coveredDays)) * 100, 1)
            : 0;
        $tauxTaches = $tasksTotal > 0 ? round(($tasksDone / $tasksTotal) * 100, 1) : 0;

        $attendances = Attendance::with('employee')
            ->latest()
            ->take(10)
            ->get();

        return view('reports.index', compact(
            'employees',
            'presences',
            'absences',
            'tasksTotal',
            'tasksDone',
            'tauxPresence',
            'tauxTaches',
            'attendances'
        ));
    }

    /**
     * Génération PDF du rapport mensuel
     */
    public function generatePdf()
    {
        $employees = Employee::with(['attendances', 'absences', 'tasks'])->get();
        $pdf = Pdf::loadView('reports.pdf', compact('employees'))->setPaper('a4', 'landscape');

        return $pdf->download('rapport_elvirex_' . now()->format('Y_m_d') . '.pdf');
    }

    /**
     * Export Excel du rapport complet
     */
    public function exportExcel()
    {
        return Excel::download(new ReportsExport, 'rapport_elvirex_' . now()->format('Y_m_d') . '.xlsx');
    }
}