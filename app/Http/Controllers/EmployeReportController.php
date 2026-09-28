<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Absence;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;




class EmployeReportController extends Controller
{

    public function index(Request $request)
    {
        // Récupère l'employé connecté via la session
        $employee = Employee::find(session('employee_id'));

        if (!$employee) {
            return redirect()->route('employe.login')->with('error', 'Veuillez vous connecter.');
        }

        // Mois et année sélectionnés
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        // Récupération des présences, absences et tâches du mois
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $absences = Absence::where('employee_id', $employee->id)
            ->whereMonth('date_debut', $month)
            ->whereYear('date_debut', $year)
            ->get();

        $tasks = Task::where('employee_id', $employee->id)
            ->whereMonth('date_attribution', $month)
            ->whereYear('date_attribution', $year)
            ->get();



        // Calculs statistiques
        $presenceDays = $attendances->count();
        $punctualDays = $attendances->filter->isPunctual()->count();
        $absenceDays = $absences->count();
        $tasksDone = $tasks->where('statut', 'terminée')->count();
        $tasksTotal = $tasks->count();

        $punctuality = $presenceDays > 0
            ? round(($punctualDays / $presenceDays) * 100, 2)
            : 0;

        // Envoi à la vue
        return view('employe.rapports.index', compact(
            'employee',
            'attendances',
            'absences',
            'tasks',
            'presenceDays',
            'absenceDays',
            'tasksDone',
            'tasksTotal',
            'punctuality',
            'month',
            'year'
        ));
    }

    public function exportPdf(Request $request)
    {
        $employee = \App\Models\Employee::find(session('employee_id'));

        if (!$employee) {
            return redirect()->route('employe.login')->with('error', 'Veuillez vous connecter.');
        }

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $attendances = \App\Models\Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $absences = \App\Models\Absence::where('employee_id', $employee->id)
            ->whereMonth('date_debut', $month)
            ->whereYear('date_debut', $year)
            ->get();

        $tasks = \App\Models\Task::where('employee_id', $employee->id)
            ->whereMonth('date_attribution', $month)
            ->whereYear('date_attribution', $year)
            ->get();

        $presenceDays = $attendances->count();
        $punctualDays = $attendances->filter->isPunctual()->count();
        $absenceDays = $absences->count();
        $tasksDone = $tasks->where('statut', 'terminée')->count();
        $tasksTotal = $tasks->count();

        $punctuality = $presenceDays > 0
            ? round(($punctualDays / $presenceDays) * 100, 2)
            : 0;

        $pdf = Pdf::loadView('employe.rapports.pdf', [
            'employee' => $employee,
            'month' => $month,
            'year' => $year,
            'presenceDays' => $presenceDays,
            'absenceDays' => $absenceDays,
            'tasksDone' => $tasksDone,
            'tasksTotal' => $tasksTotal,
            'punctuality' => $punctuality,

            'attendances' => $attendances,
            'absences' => $absences,
            'tasks' => $tasks
        ]);

        return $pdf->download("rapport_{$employee->prenom}_{$month}_{$year}.pdf");
    }
}
