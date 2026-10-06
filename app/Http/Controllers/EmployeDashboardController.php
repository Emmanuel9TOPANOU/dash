<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Absence;
use App\Models\Task;

class EmployeDashboardController extends Controller
{
    // Tableau de bord employé
    public function index()
    {
        $employee = \App\Models\Employee::find(session('employee_id'));

        if (!$employee) {
            return redirect()->route('employe.login');
        }

        // Présence du jour
        $today = now()->toDateString();
        $attendance = \App\Models\Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

        // Statistiques du mois en cours
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $presencesCount = \App\Models\Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->count();

        $absencesCount = \App\Models\Absence::where('employee_id', $employee->id)
            ->whereBetween('date_debut', [$monthStart, $monthEnd])
            ->count();

        $tachesTerminees = \App\Models\Task::where('employee_id', $employee->id)
            ->where('statut', 'terminée')
            ->count();

        $tachesTotal = \App\Models\Task::where('employee_id', $employee->id)->count();

        // Calcul ponctualité (présences sans retard)
        $presencesSansRetard = \App\Models\Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get()
            ->filter->isPunctual()
            ->count();

        $ponctualite = $presencesCount > 0 ? round(($presencesSansRetard / $presencesCount) * 100) : 0;

        return view('employe.dashboard', compact(
            'employee',
            'attendance',
            'presencesCount',
            'absencesCount',
            'tachesTerminees',
            'tachesTotal',
            'ponctualite'
        ));
    }


    // Mes présences
    public function presences()
    {
        $employee = Employee::find(session('employee_id'));
        $attendances = Attendance::where('employee_id', $employee->id)
            ->latest('date')
            ->paginate(10);

        return view('employe.presences', compact('employee', 'attendances'));
    }

    // Mes absences
    public function absences()
    {
        $employee = Employee::find(session('employee_id'));
        $absences = Absence::where('employee_id', $employee->id)
            ->latest()
            ->paginate(10);


        return view('employe.absences.index', compact('employee', 'absences'));
    }

    // Mes tâches
    public function taches()
    {
        $employee = Employee::find(session('employee_id'));
        $tasks = Task::where('employee_id', $employee->id)
            ->latest()
            ->paginate(10);

        return view('employe.taches.index', compact('employee', 'tasks'));
    }

    // Mes rapports
    public function rapports()
    {
        $employee = Employee::find(session('employee_id'));
        return view('employe.rapports.index', compact('employee'));
    }

    // Profil personnel
    public function profile()
    {
        $employee = \App\Models\Employee::find(session('employee_id'));

        if (!$employee) {
            return redirect()->route('employe.login')->with('error', 'Veuillez vous connecter.');
        }

        return view('employe.profile', compact('employee'));
    }

    public function updateProfile(Request $request)
    {
        $employee = \App\Models\Employee::find(session('employee_id'));

        if (!$employee) {
            return redirect()->route('employe.login')->with('error', 'Veuillez vous connecter.');
        }

        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email',
            'contact' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'mot_de_passe' => 'nullable|confirmed|min:6',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos_employes', 'public');
            $validated['photo'] = $path;
        }

        if ($request->filled('mot_de_passe')) {
            $validated['mot_de_passe'] = \Illuminate\Support\Facades\Hash::make($validated['mot_de_passe']);
        } else {
            unset($validated['mot_de_passe']);
        }

        $employee->update($validated);

        return back()->with('success', '✅ Profil mis à jour avec succès.');
    }

    public function adminDashboard()
    {
        $employee = Employee::find(session('employee_id'));

        return view('administration.dashboard', compact('employee'));
    }
}
