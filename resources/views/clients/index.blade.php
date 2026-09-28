@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Gestion des Clients</h1>
            <p class="text-xs font-semibold text-slate-500 mt-1">Gérez votre portefeuille client et leurs coordonnées.</p>
        </div>
        <a href="{{ route('clients.create') }}" class="inline-flex items-center justify-center space-x-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-4 py-3 rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
            <i class="fas fa-plus"></i>
            <span>Nouveau Client</span>
        </a>
    </div>

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('clients.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom, contact ou email..." class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:border-amber-500 transition">
        </div>
        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-5 py-2.5 rounded-2xl transition">
            Filtrer
        </button>
    </form>

    <!-- Tableau -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                        <th class="py-4 px-6">Client / Entreprise</th>
                        <th class="py-4 px-6">Personne de contact</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Téléphone</th>
                        <th class="py-4 px-6">Statut</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                    @forelse($clients as $client)
                        <tr class="hover:bg-amber-50/40 transition">
                            <td class="py-4 px-6 font-bold text-slate-900">{{ $client->name }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $client->contact_name ?? 'N/A' }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $client->email ?? 'N/A' }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $client->phone ?? 'N/A' }}</td>
                            <td class="py-4 px-6">
                                <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full {{ $client->status === 'actif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $client->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('clients.edit', $client) }}" class="p-2 text-slate-400 hover:text-amber-600 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline-block" onsubmit="return confirm('Confirmer la suppression ?');">
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
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fas fa-user-tie text-4xl mb-3 opacity-40"></i>
                                <p class="text-xs font-bold">Aucun client trouvé.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clients->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</div>
@endsection