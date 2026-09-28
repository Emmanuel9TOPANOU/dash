@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Projets</h1>
            <p class="text-xs font-semibold text-slate-500 mt-1">Pilotez les projets, budgets et échéances.</p>
        </div>
        <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center space-x-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-4 py-3 rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
            <i class="fas fa-plus"></i>
            <span>Nouveau projet</span>
        </a>
    </div>

    <!-- Barre de recherche et filtres -->
    <form method="GET" action="{{ route('projects.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un projet ou client..." class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:border-amber-500 transition">
        </div>
        <select name="status" class="bg-white border border-slate-200 rounded-2xl px-4 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:border-amber-500 transition">
            <option value="">Tous les statuts</option>
            <option value="planifie" {{ request('status') === 'planifie' ? 'selected' : '' }}>Planifié</option>
            <option value="en_cours" {{ request('status') === 'en_cours' ? 'selected' : '' }}>En cours</option>
            <option value="suspendu" {{ request('status') === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
            <option value="termine" {{ request('status') === 'termine' ? 'selected' : '' }}>Terminé</option>
        </select>
        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-5 py-2.5 rounded-2xl transition">
            Filtrer
        </button>
    </form>

    <!-- Tableau des projets -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                        <th class="py-4 px-6">Projet</th>
                        <th class="py-4 px-6">Client</th>
                        <th class="py-4 px-6">Responsable</th>
                        <th class="py-4 px-6">Avancement</th>
                        <th class="py-4 px-6">Échéance</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                    @forelse($projects as $project)
                        <tr class="hover:bg-amber-50/40 transition">
                            <td class="py-4 px-6 font-bold text-slate-900">{{ $project->name }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $project->client->name ?? 'Non assigné' }}</td>
                            <td class="py-4 px-6 text-slate-600">
                                {{ $project->manager ? $project->manager->prenom . ' ' . $project->manager->nom : 'Non assigné' }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $project->progress ?? 0 }}%"></div>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-500">{{ $project->progress ?? 0 }}%</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $project->ends_at ? \Carbon\Carbon::parse($project->ends_at)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('projects.edit', $project) }}" class="p-2 text-slate-400 hover:text-amber-600 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer ce projet ?');">
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
                                <i class="fas fa-folder-open text-4xl mb-3 opacity-40"></i>
                                <p class="text-xs font-bold">Aucun projet trouvé.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($projects->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection