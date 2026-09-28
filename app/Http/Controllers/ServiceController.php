<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Employee;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('responsable')->latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $employees = Employee::where('actif', true)->get();
        return view('services.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'duree_estimee' => 'nullable|string|max:100',
            'categorie' => 'nullable|string|max:100',
            'responsable_id' => 'nullable|exists:employees,id',
            'est_actif' => 'boolean',
        ]);

        $validated['est_actif'] = $request->has('est_actif');

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Prestation ajoutée au catalogue avec succès.');
    }

    public function edit(Service $service)
    {
        $employees = Employee::where('actif', true)->get();
        return view('services.edit', compact('service', 'employees'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'duree_estimee' => 'nullable|string|max:100',
            'categorie' => 'nullable|string|max:100',
            'responsable_id' => 'nullable|exists:employees,id',
            'est_actif' => 'boolean',
        ]);

        $validated['est_actif'] = $request->has('est_actif');

        $service->update($validated);

        return redirect()->route('services.index')->with('success', 'Prestation mise à jour avec succès.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Prestation supprimée du catalogue.');
    }
}