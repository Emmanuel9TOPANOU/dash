<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Employee;
use Illuminate\Http\Request;

class CommunicationTaskController extends Controller
{
    /**
     * Liste des tâches
     */
    public function index(Request $request)
    {
        $query = Task::with('employee')->where('created_by_role', 'communication');

        if ($request->filled('date')) {
            $query->whereDate('date_attribution', $request->date);
        }

        $tasks = $query->orderByDesc('id')->paginate(10);

        return view('administration.communication.tasks.index', compact('tasks'))
            ->with('selectedDate', $request->date);
    }

    /**
     * Formulaire
     */
    public function create()
    {
        $employees = Employee::where('actif', true)->get();

        return view('administration.communication.tasks.create', compact('employees'));
    }

    /**
     * Enregistrer tâche
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'description' => 'required|string',
            'date_limite' => 'nullable|date',
            'priorite' => 'nullable|string',
        ]);

        Task::create([
            'employee_id' => $validated['employee_id'],
            'description' => $validated['description'],
            'date_attribution' => now(),
            'date_limite' => $validated['date_limite'],
            'priorite' => $validated['priorite'] ?? 'moyenne',
            'statut' => 'en attente',

                //important :
            'created_by_role' => 'communication',
        ]);

        return redirect()->route('administration.communication.tasks.index')
            ->with('success', 'Tâche ajoutée avec succès 🎉');
    }

    /**
     * Edit
     */
    public function edit(Task $task)
    {
        $employees = Employee::where('actif', true)->get();

        return view('administration.communication.tasks.edit', compact('task', 'employees'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'description' => 'required|string',
            'date_limite' => 'nullable|date',
            'priorite' => 'nullable|string',
            'statut' => 'required|string',
            'commentaire' => 'nullable|string',
            'evaluation' => 'nullable|string',
        ]);

        $task->update($validated);

        return redirect()->route('administration.communication.tasks.index')
            ->with('success', 'Tâche mise à jour ✔');
    }

    /**
     * Suppression
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('administration.communication.tasks.index')
            ->with('success', 'Tâche supprimée 🗑️');
    }
}
