@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Gestion des Dépenses</h1>
            <p class="text-xs font-semibold text-slate-500 mt-1">Enregistrement et suivi des sorties d'argent.</p>
        </div>
        <a href="{{ route('expenses.create') }}" class="inline-flex items-center justify-center space-x-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-4 py-3 rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
            <i class="fas fa-plus"></i>
            <span>Nouvelle Dépense</span>
        </a>
    </div>

    <!-- Tableau des dépenses -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                        <th class="py-4 px-6">Date</th>
                        <th class="py-4 px-6">Catégorie / Motif</th>
                        <th class="py-4 px-6">Montant</th>
                        <th class="py-4 px-6">Payé par</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                    @forelse($expenses ?? [] as $expense)
                        <tr class="hover:bg-amber-50/40 transition">
                            <td class="py-4 px-6 text-slate-500">{{ \Carbon\Carbon::parse($expense->created_at)->format('d/m/Y') }}</td>
                            <td class="py-4 px-6 font-bold text-slate-900">{{ $expense->title }}</td>
                            <td class="py-4 px-6 font-bold text-rose-600">-{{ number_format($expense->amount ?? 0, 0, ',', ' ') }} FCFA</td>
                            <td class="py-4 px-6">{{ $expense->user->name ?? 'Admin' }}</td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('expenses.edit', $expense) }}" class="p-2 text-slate-400 hover:text-amber-600 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cette dépense ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <i class="fas fa-wallet text-4xl mb-3 opacity-40"></i>
                                <p class="text-xs font-bold">Aucune dépense enregistrée.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection