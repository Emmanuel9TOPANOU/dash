<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Http\Request;

class EmployeTaskController extends Controller
{
    public function index()
    {
        $employee = Employee::find(session('employee_id'));

        if (!$employee) {
            return redirect()->route('employe.login')->with('error', 'Veuillez vous connecter.');
        }

        $tasks = Task::with(['project.client'])
            ->where('employee_id', $employee->id)
            ->orderByDesc('created_at')
            ->get();

        return view('employe.taches.index', compact('tasks', 'employee'));
    }

    public function markAsDone(Task $task)
    {
        $employee = Employee::find(session('employee_id'));

        if (!$employee || $task->employee_id !== $employee->id) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        $task->update(['statut' => 'terminée']);

        Notification::notifyAdmins(
            'task',
            'Tâche terminée',
            $employee->prenom . ' ' . $employee->nom . ' a terminé la tâche : ' . $task->description . '.',
            route('tasks.index')
        );

        return redirect()->back()->with('success', '✅ Tâche marquée comme terminée.');
    }
}
