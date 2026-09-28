<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function index(Request $request)
    {
        $employeeId = $request->input('employee_id');

        $absences = Absence::with('employee')
            ->when($employeeId, fn($q) => $q->where('employee_id', $employeeId))
            ->latest()
            ->paginate(10)
            ->appends(['employee_id' => $employeeId]);

        $employees = Employee::orderBy('nom')->get();

        return view('absences.index', compact('absences', 'employees', 'employeeId'));
    }

    public function create()
    {
        return view('absences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'required|string|max:255',
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $validated['employee_id'] = Auth::user()->employee->id ?? null;

        if ($request->hasFile('justificatif')) {
            $validated['justificatif'] = $request->file('justificatif')->store('justificatifs', 'public');
        }

        Absence::create($validated);

        return redirect()->route('absences.index')->with('success', 'Demande d\'absence enregistrée.');
    }

    public function show(Absence $absence)
    {
        return view('absences.show', compact('absence'));
    }

    public function edit(Absence $absence)
    {
        return view('absences.edit', compact('absence'));
    }

    public function update(Request $request, Absence $absence)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en attente,validee,refusee,terminee',
        ]);

        $absence->update(['statut' => $validated['statut']]);

        return redirect()->route('absences.index')->with('success', '✅ Statut mis à jour avec succès.');
    }


    public function destroy(Absence $absence)
    {
        $absence->delete();
        return redirect()->route('absences.index')->with('success', 'Absence supprimée.');
    }
}
