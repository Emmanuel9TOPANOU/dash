<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Affiche la liste des dépenses.
     */
    public function index()
    {
        $expenses = Expense::latest()->get();
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Affiche le formulaire de création d'une dépense.
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Enregistre une nouvelle dépense en base de données.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'motif' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'categorie' => 'nullable|string|max:255',
        ]);

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Dépense enregistrée avec succès.');
    }

    /**
     * Affiche les détails d'une dépense.
     */
    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    /**
     * Affiche le formulaire d'édition d'une dépense.
     */
    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    /**
     * Met à jour une dépense existante.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'motif' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'categorie' => 'nullable|string|max:255',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Dépense mise à jour avec succès.');
    }

    /**
     * Supprime une dépense.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Dépense supprimée avec succès.');
    }
}
