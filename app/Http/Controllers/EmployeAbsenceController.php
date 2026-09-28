<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Http\Request;

class EmployeAbsenceController extends Controller
{
    // Liste des absences de l'employé connecté
    public function index()
    {
        $employee = Employee::find(session('employee_id'));

        if (!$employee) {
            return redirect()->route('employe.login')->with('error', 'Veuillez vous connecter.');
        }

        $absences = Absence::where('employee_id', $employee->id)
            ->orderByDesc('created_at')
            ->get();

        return view('employe.absences.index', compact('employee', 'absences'));
    }

    // Formulaire de demande d'absence
    public function create()
    {
        return view('employe.absences.create');
    }

    // Enregistrement d'une demande
    public function store(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'required|string|max:255',
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $employee = Employee::find(session('employee_id'));

        if (!$employee) {
            return redirect()->route('employe.login');
        }

        $filePath = null;
        if ($request->hasFile('justificatif')) {
            $filePath = $request->file('justificatif')->store('justificatifs', 'public');
        }

        $absence = Absence::create([
            'employee_id' => $employee->id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'motif' => $request->motif,
            'justificatif' => $filePath,
            'statut' => 'en_attente',
        ]);

        Notification::notifyAdmins(
            'absence',
            'Nouvelle demande d\'absence',
            $employee->prenom . ' ' . $employee->nom . ' a soumis une demande d\'absence du ' . $absence->date_debut . ' au ' . $absence->date_fin . '.',
            route('absences.index', ['employee_id' => $employee->id])
        );

        return redirect()->route('employe.absences.index')->with('success', '✅ Demande d\'absence envoyée avec succès.');
    }
}
