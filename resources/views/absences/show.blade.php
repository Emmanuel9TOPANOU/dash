@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    {{-- En-tête avec bouton de retour --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-5">
        <div>
            <h2 class="text-3xl font-bold tracking-tight text-gray-900">Détail de l'absence</h2>
            <p class="mt-1 text-sm text-gray-500">Fiche récapitulative des informations relatives à la demande d'absence.</p>
        </div>
        <div>
            <a href="{{ route('absences.index') }}" 
               class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-medium text-sm px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm transition duration-150">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour
            </a>
        </div>
    </div>

    {{-- Carte principale d'information --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        {{-- Bannière supérieure de statut --}}
        <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-200 flex items-center justify-between flex-wrap gap-2">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Statut de la demande</span>
            <div>
                @switch($absence->statut)
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
            </div>
        </div>

        {{-- Grille de détails --}}
        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Employé --}}
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Employé</p>
                    <p class="text-base font-semibold text-gray-900">
                        {{ $absence->employee->prenom ?? '—' }} {{ $absence->employee->nom ?? '' }}
                    </p>
                </div>

                {{-- Matricule --}}
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Matricule</p>
                    <p class="text-base font-medium text-gray-800">
                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 text-gray-700 text-xs font-mono border border-gray-200">
                            {{ $absence->employee->matricule ?? '—' }}
                        </span>
                    </p>
                </div>

                {{-- Période --}}
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Période</p>
                    <p class="text-base font-medium text-gray-900 flex items-center gap-2">
                        <span>{{ $absence->date_debut }}</span>
                        <span class="text-gray-400">→</span>
                        <span>{{ $absence->date_fin }}</span>
                        <span class="ml-1 px-2 py-0.5 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">
                            {{ $absence->duree }} j
                        </span>
                    </p>
                </div>

                {{-- Motif --}}
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Motif</p>
                    <p class="text-base font-medium text-gray-900">{{ $absence->motif }}</p>
                </div>

                {{-- Commentaire --}}
                <div class="sm:col-span-2 space-y-1 bg-gray-50/50 p-4 rounded-lg border border-gray-100">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Commentaire</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $absence->commentaire ?? '—' }}</p>
                </div>

                {{-- Justificatif --}}
                <div class="sm:col-span-2 space-y-1 pt-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Justificatif</p>
                    <div>
                        @if($absence->justificatif)
                            <a href="{{ asset('storage/' . $absence->justificatif) }}" target="_blank" 
                               class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50/80 hover:bg-indigo-100/80 px-3.5 py-2 rounded-lg border border-indigo-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Voir le justificatif
                            </a>
                        @else
                            <p class="text-sm text-gray-500 italic">Aucun justificatif fourni</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- Actions de gestion --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center flex-wrap gap-2">
                @can('update', $absence)
                    @if($absence->statut !== 'validee')
                        <form action="{{ route('absences.update', $absence) }}" method="POST" class="inline">
                            @csrf @method('PUT')
                            <input type="hidden" name="statut" value="validee">
                            <button type="submit" 
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-lg shadow-sm transition duration-150" 
                                    onclick="return confirm('Valider cette absence ?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Valider
                            </button>
                        </form>
                    @endif

                    @if($absence->statut !== 'refusee')
                        <form action="{{ route('absences.update', $absence) }}" method="POST" class="inline">
                            @csrf @method('PUT')
                            <input type="hidden" name="statut" value="refusee">
                            <button type="submit" 
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-medium text-sm rounded-lg shadow-sm transition duration-150" 
                                    onclick="return confirm('Refuser cette absence ?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Refuser
                            </button>
                        </form>
                    @endif

                    @if($absence->statut === 'validee')
                        <form action="{{ route('absences.update', $absence) }}" method="POST" class="inline">
                            @csrf @method('PUT')
                            <input type="hidden" name="statut" value="terminee">
                            <button type="submit" 
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition duration-150" 
                                    onclick="return confirm('Marquer comme terminée ?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Terminer
                            </button>
                        </form>
                    @endif
                @endcan

                {{-- Bouton modifier --}}
                <a href="{{ route('absences.edit', $absence) }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 font-medium text-sm rounded-lg border border-gray-300 shadow-sm transition duration-150">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Modifier
                </a>
            </div>

            {{-- Bouton Supprimer à droite --}}
            <form action="{{ route('absences.destroy', $absence) }}" method="POST" onsubmit="return confirm('Supprimer cette absence ?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-lg text-sm font-medium transition duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection