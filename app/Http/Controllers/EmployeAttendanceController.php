<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeAttendanceController extends Controller
{
    public function index()
    {
        $employee = Auth::guard('employee')->user();

        if (!$employee) {
            abort(403, 'Employé non connecté.');
        }

        $today = Carbon::today();

        // 🔍 Vérifie la dernière présence enregistrée
        $lastAttendance = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->first();

        if ($lastAttendance) {
            $lastDate = Carbon::parse($lastAttendance->date);

            // 🧮 Remplit les jours manquants (sauf weekends)
            while ($lastDate->addDay()->lte($today)) {
                if ($lastDate->isWeekend()) continue;

                $exists = Attendance::where('employee_id', $employee->id)
                    ->whereDate('date', $lastDate)
                    ->exists();

                if (!$exists) {
                    Attendance::create([
                        'employee_id' => $employee->id,
                        'date' => $lastDate->toDateString(),
                        'statut' => 'absent',
                    ]);
                }
            }
        }

        // 🔄 Récupère toutes les présences
        $attendances = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('employe.presences', compact('attendances'));
    }
}
