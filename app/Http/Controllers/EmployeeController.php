<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $employees = Employee::query()
            ->when($search, function ($query, $search) {
                $query->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('poste', 'like', "%{$search}%")
                    ->orWhere('service', 'like', "%{$search}%");
            })
            ->orderBy('nom')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('employees.index', compact('employees', 'search'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|unique:employees,matricule',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'nullable|in:M,F',
            'email' => 'required|email|unique:employees,email',
            'poste' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'role' => 'required|string|max:255',
            'contact' => 'nullable|string|max:50',
            'type_contrat' => 'nullable|string|max:255',
            'date_embauche' => 'nullable|date',
            'salaire' => 'nullable|numeric|min:0',
            'prime' => 'nullable|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Upload photo si présente
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employees', 'public');
        }

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employé ajouté avec succès.');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'matricule' => 'required|unique:employees,matricule,' . $employee->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'nullable|in:M,F',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'poste' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'role' => 'required|string|max:255',
            'contact' => 'nullable|string|max:50',
            'type_contrat' => 'nullable|string|max:255',
            'date_embauche' => 'nullable|date',
            'salaire' => 'nullable|numeric|min:0',
            'prime' => 'nullable|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Gérer l'upload de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l’ancienne si existe
            if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
                Storage::disk('public')->delete($employee->photo);
            }

            $validated['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employé mis à jour.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employé supprimé.');
    }
}
