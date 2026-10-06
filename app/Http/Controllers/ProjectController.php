<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with(['client', 'manager'])
            ->withCount('tasks')
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->status))
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = $request->string('search');
                $query->where('name', 'like', "%{$term}%")
                    ->orWhereHas('client', fn($client) => $client->where('name', 'like', "%{$term}%"));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = Client::where('status', 'actif')->orderBy('name')->get();
        $employees = Employee::where('actif', true)->orderBy('nom')->orderBy('prenom')->get();

        return view('projects.create', compact('clients', 'employees'));
    }

    public function store(Request $request)
    {
        Project::create($this->validated($request));

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès.');
    }

    public function edit(Project $project)
    {
        $clients = Client::where('status', 'actif')->orWhereKey($project->client_id)->orderBy('name')->get();
        $employees = Employee::where('actif', true)->orWhereKey($project->manager_id)->orderBy('nom')->orderBy('prenom')->get();

        return view('projects.edit', compact('project', 'clients', 'employees'));
    }

    public function update(Request $request, Project $project)
    {
        $project->update($this->validated($request));

        return redirect()->route('projects.index')->with('success', 'Projet mis à jour avec succès.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'manager_id' => ['nullable', 'exists:employees,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);
    }
}
