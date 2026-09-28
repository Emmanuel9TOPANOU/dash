<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Task::with(['employee', 'project']);

        // ✅ Filtre par date d’attribution (ou date_limite selon ton besoin)
        if ($request->filled('date')) {
            $query->whereDate('date_attribution', $request->date);
        }

        $tasks = $query->orderByDesc('id')->paginate(10);

        return view('tasks.index', compact('tasks'))
            ->with('selectedDate', $request->date);
    }


    public function create()
    {
        $employees = Employee::where('actif', true)->get();
        $projects = Project::whereIn('status', ['planifie', 'en_cours'])->orderBy('name')->get();
        return view('tasks.create', compact('employees', 'projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'project_id' => 'nullable|exists:projects,id',
            'description' => 'required|string',
            'date_limite' => 'nullable|date',
            'priorite' => 'nullable|string',
        ]);

        Task::create([
            'employee_id' => $validated['employee_id'],
            'project_id' => $validated['project_id'] ?? null,
            'description' => $validated['description'],
            'date_attribution' => now(),
            'date_limite' => $validated['date_limite'],
            'priorite' => $validated['priorite'] ?? 'moyenne',
            'statut' => 'en attente',
        ]);

        return redirect()->route('tasks.index')->with('success', '✅ Tâche créée avec succès.');
    }

    public function edit(Task $task)
    {
        $employees = Employee::where('actif', true)->get();
        $projects = Project::whereIn('status', ['planifie', 'en_cours'])->orWhereKey($task->project_id)->orderBy('name')->get();
        return view('tasks.edit', compact('task', 'employees', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'project_id' => 'nullable|exists:projects,id',
            'description' => 'required|string',
            'date_limite' => 'nullable|date',
            'priorite' => 'nullable|string',
            'statut' => 'required|string',
            'commentaire' => 'nullable|string',
            'evaluation' => 'nullable|string',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', '✅ Tâche mise à jour avec succès.');
    }


    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', '🗑️ Tâche supprimée avec succès.');
    }
}
