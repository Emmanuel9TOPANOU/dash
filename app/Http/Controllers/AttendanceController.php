<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date');
        $employeeId = $request->input('employee_id');

        $query = Attendance::with('employee')
            ->when($date, fn($q) => $q->whereDate('date', $date))
            ->when($employeeId, fn($q) => $q->where('employee_id', $employeeId));

        $statsQuery = clone $query;

        $attendances = $query->latest('date')
            ->paginate(10)
            ->appends(['date' => $date, 'employee_id' => $employeeId]);

        $employees = Employee::orderBy('nom')->get();

        $total = $statsQuery->count();
        $present = $statsQuery->whereNotNull('heure_arrivee')->count();
        $late = $statsQuery->where('statut', 'en_retard')->count();
        $absent = $statsQuery->where('statut', 'absent')->count();
        $avgMinutes = $statsQuery->avg('minutes_travaillees');
        $lateAverage = $statsQuery->where('statut', 'en_retard')->avg('retard_minutes');

        $stats = [
            'total' => $total,
            'present' => $present,
            'late' => $late,
            'absent' => $absent,
            'avg' => $avgMinutes ? round($avgMinutes / 60, 2) : 0,
            'late_average' => $lateAverage ? round($lateAverage, 1) : 0,
        ];

        return view('attendances.index', compact('attendances', 'employees', 'date', 'employeeId', 'stats'));
    }

    // Page de pointage pour l'employé
    public function create()
    {
        $employee = Auth::user()->employee ?? null;
        $today = Carbon::today()->toDateString();
        $attendance = $employee ? Attendance::where('employee_id', $employee->id)->where('date', $today)->first() : null;
        return view('attendances.create', compact('attendance'));
    }

    public function show(Attendance $attendance)
    {
        return view('attendances.show', compact('attendance'));
    }

    // Marquer l'arrivée (gère Auth::user() et session('employee_id'))
    public function clockIn(Request $request)
    {
        $employee = null;
        if (session('employee_id')) {
            $employee = Employee::find(session('employee_id'));
        } elseif (Auth::check() && Auth::user()->employee) {
            $employee = Auth::user()->employee;
        } else {
            $employee = null;
        }



        if (!$employee) {
            return redirect()->route('employe.login')->with('error', 'Veuillez vous connecter.');
        }

        if (now()->isWeekend()) {
            return back()->with('error', 'Le pointage est disponible du lundi au vendredi uniquement.');
        }

        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('employee_id', $employee->id)->where('date', $today)->first();

        if ($attendance && $attendance->heure_arrivee) {
            return back()->with('error', 'Vous avez déjà pointé votre arrivée aujourd’hui.');
        }

        $heureArrivee = now();

        if ($attendance) {
            $attendance->update([
                'heure_arrivee' => $heureArrivee->format('H:i:s'),
            ]);
        } else {
            Attendance::create([
                'employee_id' => $employee->id,
                'date' => $today,
                'heure_arrivee' => $heureArrivee->format('H:i:s'),
            ]);
        }

        Notification::notifyAdmins(
            'attendance',
            'Arrivée pointée',
            $employee->prenom . ' ' . $employee->nom . ' a pointé son arrivée le ' . $heureArrivee->format('d/m/Y') . ' à ' . $heureArrivee->format('H:i:s') . '.',
            route('attendances.index', ['date' => $today, 'employee_id' => $employee->id])
        );

        return back()->with('success', '✅ Arrivée enregistrée à ' . $heureArrivee->format('H:i:s'));
    }

    // Marquer le départ (gère Auth::user() et session('employee_id'))
    public function clockOut(Request $request)
    {
        $employee = null;
        if (Auth::check() && Auth::user()->employee) {
            $employee = Auth::user()->employee;
        } elseif (session('employee_id')) {
            $employee = Employee::find(session('employee_id'));
        }

        if (!$employee) {
            return redirect()->route('employe.login')->with('error', 'Veuillez vous connecter.');
        }

        if (now()->isWeekend()) {
            return back()->with('error', 'Le pointage est disponible du lundi au vendredi uniquement.');
        }

        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('employee_id', $employee->id)->where('date', $today)->first();

        if (!$attendance || !$attendance->heure_arrivee) {
            return back()->with('error', 'Aucune arrivée enregistrée aujourd\'hui.');
        }

        if ($attendance->heure_depart) {
            return back()->with('error', 'Votre départ est déjà enregistré.');
        }

        $dateTimeDepart = now();
        $heureDepart = $dateTimeDepart->format('H:i:s');
        $attendance->update(['heure_depart' => $heureDepart]);

        // Le modèle calcule automatiquement la durée travaillée et le départ anticipé.
        $attendance->refresh();

        Notification::notifyAdmins(
            'attendance',
            'Départ pointé',
            $employee->prenom . ' ' . $employee->nom . ' a pointé son départ le ' . $dateTimeDepart->format('d/m/Y') . ' à ' . $heureDepart . '.',
            route('attendances.index', ['date' => $today, 'employee_id' => $employee->id])
        );

        return back()->with('success', '👋 Départ enregistré à ' . $heureDepart);
    }
}
