<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Absence;
use App\Models\Employee;
use Illuminate\Http\Request;

class RhController extends Controller
{
    public function dashboard()
    {
        $totalEmployees = Employee::count();
        $presentToday = Attendance::where('date', today())->count();
        $absentToday = Employee::count() - $presentToday;

        return view('administration.rh.dashboard', compact(
            'totalEmployees',
            'presentToday',
            'absentToday'
        ));
    }

    public function attendances(Request $request)
    {
        $employees = Employee::orderBy('prenom')->get();

        $query = Attendance::with('employee');

        // 🔎 Recherche par nom ou prénom
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                    ->orWhere('prenom', 'like', "%$search%");
            });
        }

        // 📌 Filtre par employé
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // 📅 Filtre par date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->latest()->paginate(10);

        return view('administration.rh.attendances', compact('attendances', 'employees'));
    }


    public function absences()
    {
        $absences = Absence::with('employee')
            ->latest()
            ->paginate(20);

        return view('administration.rh.absences', compact('absences'));
    }

    // 📌 Liste des employés
    public function employees(Request $request)
    {
        $search = $request->search;

        $employees = Employee::when($search, function ($q) use ($search) {
            $q->where('nom', 'like', "%$search%")
                ->orWhere('prenom', 'like', "%$search%")
                ->orWhere('matricule', 'like', "%$search%");
        })
            ->orderBy('prenom')
            ->paginate(10);

        return view('administration.rh.employees.index', compact('employees'));
    }

    // 📌 Fiche d’un employé
    public function employeeShow(Employee $employee)
    {
        // Récupérer ses présences
        $attendances = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->limit(20)
            ->get();

        return view('administration.rh.employees.show', compact('employee', 'attendances'));
    }

    // Formulaire création employé
    public function createEmployee()
    {
        return view('administration.rh.employees.create');
    }

    // Enregistrement employé
    public function storeEmployee(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|unique:employees,matricule',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'poste' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:50',
            'role' => 'nullable|string', // si tu veux RH, comptable, etc.
            'photo' => 'nullable|image|max:10000',
        ]);

        // Upload photo
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employees', 'public');
        }

        Employee::create($validated);

        return redirect()->route('administration.rh.employees')
            ->with('success', 'Employé ajouté avec succès 🎉');
    }
}
