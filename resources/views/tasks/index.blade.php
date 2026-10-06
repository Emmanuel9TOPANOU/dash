@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 flex items-center gap-3">
                    Liste des tâches
                    <span
                        class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full border border-gray-200">
                        {{ $tasks->total() }} tâche(s)
                    </span>
                </h2>
                <p class="mt-1 text-sm text-gray-500">Gérez et suivez l'avancement des tâches de vos collaborateurs</p>
            </div>
            <a href="{{ route('tasks.create') }}"
                class="inline-flex items-center gap-2 bg-yellow-600  active:scale-95 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm hover:shadow-md transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle tâche
            </a>
        </div>

        {{-- Barre de recherche et filtres --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-[200px]">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="date" name="date" value="{{ $selectedDate ?? '' }}" placeholder="Filtrer par date"
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 
                              focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/10 focus:bg-white
                              hover:border-gray-300 transition-all duration-200 outline-none">
                </div>

                <div class="relative min-w-[150px]">
                   
                   
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none">

                    </div>
                </div>

                <button type="submit"
                    class="inline-flex items-center gap-2 bg-yellow-600  text-white px-5 py-2.5 rounded-xl text-sm font-medium shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filtrer
                </button>

                @if ($selectedDate || request('statut'))
                    <a href="{{ route('tasks.index') }}"
                        class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 px-4 py-2.5 rounded-xl transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Réinitialiser
                    </a>
                @endif
            </form>
        </div>

        {{-- Tableau des tâches --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50/80 text-gray-500 font-semibold uppercase text-xs tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left">Employé</th>
                            <th scope="col" class="px-6 py-3.5 text-left">Projet</th>
                            <th scope="col" class="px-6 py-3.5 text-left">Description</th>
                            <th scope="col" class="px-6 py-3.5 text-center">Priorité</th>
                            <th scope="col" class="px-6 py-3.5 text-center">Statut</th>
                            <th scope="col" class="px-6 py-3.5 text-left">Date limite</th>
                            <th scope="col" class="px-6 py-3.5 text-left">Commentaire</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($tasks as $task)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150 group">
                                {{-- Employé --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if ($task->employee)
                                            <div
                                                class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-200 text-indigo-700 font-bold flex items-center justify-center text-xs shadow-sm ring-2 ring-white">
                                                {{ strtoupper(substr($task->employee->prenom, 0, 1) . substr($task->employee->nom, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">
                                                    {{ $task->employee->prenom }} {{ $task->employee->nom }}
                                                </div>
                                                <div class="text-[10px] text-gray-400">
                                                    #{{ $task->employee->id }}
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic text-sm">Employé indisponible</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Projet --}}
                                <td class="px-6 py-4">
                                    @if ($task->project)
                                        <div class="font-semibold text-amber-700">{{ $task->project->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $task->project->client->name }}</div>
                                    @else
                                        <span class="text-gray-400">Hors projet</span>
                                    @endif
                                </td>

                                {{-- Description --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 max-w-xs">
                                        {{ Str::limit($task->description, 60) }}
                                        @if (strlen($task->description) > 60)
                                            <span class="text-gray-400 text-xs cursor-help"
                                                title="{{ $task->description }}">…</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Priorité --}}
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @php
                                        $priorityColors = [
                                            'haute' => 'bg-rose-100 text-rose-700 border-rose-200',
                                            'moyenne' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'basse' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        ];
                                        $priorityIcons = [
                                            'haute' => '🔴',
                                            'moyenne' => '🟡',
                                            'basse' => '🟢',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $priorityColors[$task->priorite] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        {{ $priorityIcons[$task->priorite] ?? '⚪' }}
                                        {{ ucfirst($task->priorite) }}
                                    </span>
                                </td>

                                {{-- Statut --}}
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'terminée' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'en cours' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'en attente' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        ];
                                        $statusDots = [
                                            'terminée' => 'bg-emerald-500',
                                            'en cours' => 'bg-blue-500 animate-pulse',
                                            'en attente' => 'bg-amber-500 animate-pulse',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$task->statut] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full {{ $statusDots[$task->statut] ?? 'bg-gray-400' }}"></span>
                                        {{ ucfirst($task->statut) }}
                                    </span>
                                </td>

                                {{-- Date limite --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($task->date_limite)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ \Carbon\Carbon::parse($task->date_limite)->format('d/m/Y') }}
                                            </span>
                                            @if (\Carbon\Carbon::parse($task->date_limite)->isPast() && $task->statut !== 'terminée')
                                                <span
                                                    class="text-[10px] font-bold text-rose-500 bg-rose-50 px-1.5 py-0.5 rounded border border-rose-200">
                                                    En retard
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- Commentaire --}}
                                <td class="px-6 py-4">
                                    @if ($task->commentaire)
                                        <div class="flex items-center gap-2 text-sm text-gray-600 max-w-xs">
                                            <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            <span class="truncate">{{ Str::limit($task->commentaire, 40) }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 transition duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Modifier
                                        </a>

                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-100 transition duration-150"
                                                onclick="return confirm(' Êtes-vous sûr de vouloir supprimer cette tâche ? Cette action est irréversible.')">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-base font-medium text-gray-600">Aucune tâche trouvée</p>
                                            <p class="text-sm text-gray-400 mt-0.5">
                                                @if ($selectedDate || request('statut'))
                                                    Aucune tâche ne correspond aux critères sélectionnés.
                                                @else
                                                    Commencez par créer votre première tâche.
                                                @endif
                                            </p>
                                        </div>
                                        @if ($selectedDate || request('statut'))
                                            <a href="{{ route('tasks.index') }}"
                                                class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                                Voir toutes les tâches →
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($tasks->hasPages())
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-t border-gray-200 pt-4">
                <div class="text-sm text-gray-500">
                    Affichage de <span class="font-medium text-gray-700">{{ $tasks->firstItem() ?? 0 }}</span>
                    à <span class="font-medium text-gray-700">{{ $tasks->lastItem() ?? 0 }}</span>
                    sur <span class="font-medium text-gray-700">{{ $tasks->total() }}</span> résultats
                </div>
                <div>
                    {{ $tasks->appends(['date' => $selectedDate, 'statut' => request('statut')])->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
