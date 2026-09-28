@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    {{-- En-tête de la page --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-3xl font-bold tracking-tight text-gray-900">Gestion des absences</h2>
            <p class="mt-1 text-sm text-gray-500">Consultez, filtrez et validez les demandes d'absences de vos collaborateurs.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1.5 rounded-full border border-gray-200">
                {{ $absences->total() }} demande(s)
            </span>
        </div>
    </div>

    {{-- Filtres & Barre d'outils --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <form method="GET" action="{{ route('absences.index') }}" class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative min-w-[240px]">
                    <select name="employee_id"
                            class="w-full appearance-none bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-2.5 pr-10 transition duration-150 ease-in-out hover:bg-gray-100">
                        <option value="">— Tous les employés —</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->prenom }} {{ $emp->nom }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <div class="relative min-w-[160px]">
                    <select name="statut"
                            class="w-full appearance-none bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-2.5 pr-10 transition duration-150 ease-in-out hover:bg-gray-100">
                        <option value="">— Tous les statuts —</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="validee" {{ request('statut') == 'validee' ? 'selected' : '' }}>Validée</option>
                        <option value="refusee" {{ request('statut') == 'refusee' ? 'selected' : '' }}>Refusée</option>
                        <option value="terminee" {{ request('statut') == 'terminee' ? 'selected' : '' }}>Terminée</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <button type="submit"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow-sm hover:shadow-md transition duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filtrer
                </button>

                <a href="{{ route('absences.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm px-5 py-2.5 rounded-lg transition duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    {{-- Tableau des absences --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50/80 text-gray-500 font-semibold uppercase text-xs tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 text-left">Employé</th>
                        <th scope="col" class="px-6 py-3.5 text-left">Période</th>
                        <th scope="col" class="px-6 py-3.5 text-left">Motif</th>
                        <th scope="col" class="px-6 py-3.5 text-center">Statut</th>
                        <th scope="col" class="px-6 py-3.5 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($absences as $a)
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-150 group">
                            {{-- Employé --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-200 text-indigo-700 font-bold flex items-center justify-center text-xs shadow-sm ring-2 ring-white">
                                        {{ strtoupper(substr($a->employee->prenom, 0, 1) . substr($a->employee->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">
                                            {{ $a->employee->prenom }} {{ $a->employee->nom }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            #{{ $a->employee->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Période --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($a->date_debut)->format('d/m/Y') }}</span>
                                        <span class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($a->date_debut)->format('H:i') }}</span>
                                    </div>
                                    <span class="text-gray-300">→</span>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($a->date_fin)->format('d/m/Y') }}</span>
                                        <span class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($a->date_fin)->format('H:i') }}</span>
                                    </div>
                                    <span class="ml-1 px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                        {{ $a->duree }}j
                                    </span>
                                </div>
                            </td>

                            {{-- Motif --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-700 max-w-xs truncate">{{ $a->motif }}</span>
                                    @if($a->commentaire)
                                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-gray-100 text-gray-500 text-[10px] font-bold cursor-help"
                                              title="{{ $a->commentaire }}">i</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Statut --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @switch($a->statut)
                                    @case('validee')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Validée
                                        </span>
                                        @break
                                    @case('refusee')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Refusée
                                        </span>
                                        @break
                                    @case('terminee')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Terminée
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            En attente
                                        </span>
                                @endswitch
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('absences.show', $a) }}"
                                       class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 transition duration-150">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Détails
                                    </a>

                                    @if($a->statut === 'en_attente')
                                        <form action="{{ route('absences.update', $a) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="statut" value="validee">
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 transition duration-150"
                                                    onclick="return confirm('Valider cette demande d\'absence ?')">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Valider
                                            </button>
                                        </form>

                                        <form action="{{ route('absences.update', $a) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="statut" value="refusee">
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-100 transition duration-150"
                                                    onclick="return confirm('Refuser cette demande d\'absence ?')">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Refuser
                                            </button>
                                        </form>
                                    @endif

                                    @if($a->statut === 'validee')
                                        <form action="{{ route('absences.update', $a) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="statut" value="terminee">
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-100 transition duration-150"
                                                    onclick="return confirm('Marquer cette absence comme terminée ?')">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Terminer
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-base font-medium text-gray-600">Aucune absence trouvée</p>
                                        <p class="text-sm text-gray-400 mt-0.5">Aucun enregistrement ne correspond aux critères sélectionnés.</p>
                                    </div>
                                    <a href="{{ route('absences.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                        Voir toutes les demandes →
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($absences->hasPages())
        <div class="flex items-center justify-between border-t border-gray-200 pt-4">
            <div class="text-sm text-gray-500">
                Affichage de <span class="font-medium text-gray-700">{{ $absences->firstItem() ?? 0 }}</span>
                à <span class="font-medium text-gray-700">{{ $absences->lastItem() ?? 0 }}</span>
                sur <span class="font-medium text-gray-700">{{ $absences->total() }}</span> résultats
            </div>
            <div>
                {{ $absences->links() }}
            </div>
        </div>
    @endif
</div>
@endsection