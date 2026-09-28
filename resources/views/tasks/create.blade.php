@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-yellow-500 flex items-center justify-center shadow-lg shadow-amber-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Nouvelle tâche</h2>
                    <p class="text-sm text-gray-500">Ajoutez une nouvelle tâche à assigner à un collaborateur</p>
                </div>
            </div>
            <a href="{{ route('tasks.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </a>
        </div>

        {{-- Formulaire --}}
        <form action="{{ route('tasks.store') }}" method="POST"
            class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8 space-y-6">
            @csrf

            {{-- En-tête du formulaire avec logo --}}
            <div class="flex items-center gap-4 pb-6 border-b border-gray-100">
                <div class="flex items-center ">
                    <span class="text-2xl font-bold tracking-tight text-amber-500">ELVI</span>
                    <span class="text-2xl font-bold tracking-tight text-yellow-500">REX</span>
                </div>
                <div class="h-8 w-px bg-gray-200"></div>
                <span class="text-xs font-medium text-gray-400 tracking-wide uppercase">NOUS VOUS FAISONS GAGNER DU
                    TEMPS</span>
            </div>

            {{-- Champ Employé --}}
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                    Employé <span class="text-rose-500">*</span>
                </label>
                <select name="employee_id"
                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                           focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                           hover:border-amber-300 transition-all duration-200 outline-none appearance-none
                           cursor-pointer"
                    required>
                    <option value="">— Sélectionner un employé —</option>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->prenom }} {{ $emp->nom }} ({{ $emp->matricule }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Champ Projet --}}
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">Projet</label>
                <select name="project_id"
                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white hover:border-amber-300 transition-all duration-200 outline-none appearance-none cursor-pointer">
                    <option value="">— Tâche hors projet —</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>{{ $project->name }} —
                            {{ $project->client->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Champ Description --}}
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                    Description <span class="text-rose-500">*</span>
                </label>
                <textarea name="description" rows="4"
                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                             focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                             hover:border-amber-300 transition-all duration-200 outline-none resize-y"
                    placeholder="Décrivez la tâche à réaliser..." required></textarea>
                <p class="text-xs text-gray-400">Décrivez clairement la tâche à réaliser par le collaborateur</p>
            </div>

            {{-- Grille Date / Priorité --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Date limite --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Date limite
                    </label>
                    <div class="relative">
                        <input type="date" name="date_limite"
                            class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                                  focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                                  hover:border-amber-300 transition-all duration-200 outline-none">
                    </div>
                </div>

                {{-- Priorité --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Priorité
                    </label>
                    <select name="priorite"
                        class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                               focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                               hover:border-amber-300 transition-all duration-200 outline-none appearance-none
                               cursor-pointer">
                        <option value="basse" class="flex items-center gap-2">🟢 Basse</option>
                        <option value="moyenne" selected>🟡 Moyenne</option>
                        <option value="haute">🔴 Haute</option>
                    </select>
                    <p class="text-xs text-gray-400">Définissez le niveau d'urgence de la tâche</p>
                </div>
            </div>

            {{-- Champs supplémentaires optionnels --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-gray-100">
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Statut
                    </label>
                    <select name="statut"
                        class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                               focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                               hover:border-amber-300 transition-all duration-200 outline-none appearance-none
                               cursor-pointer">
                        <option value="en attente">En attente</option>
                        <option value="en cours">En cours</option>
                        <option value="terminée">Terminée</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Commentaire
                    </label>
                    <input type="text" name="commentaire" placeholder="Ajouter un commentaire..."
                        class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                              focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                              hover:border-amber-300 transition-all duration-200 outline-none">
                </div>
            </div>

            {{-- Boutons d'action --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-yellow-500 
                           hover:from-amber-600 hover:to-yellow-600 active:scale-[0.98]
                           text-white font-semibold px-8 py-3.5 rounded-xl 
                           shadow-lg shadow-amber-500/25 hover:shadow-amber-500/35 
                           transition-all duration-200 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer la tâche
                </button>

                <a href="{{ route('tasks.index') }}"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 
                      text-gray-700 font-medium px-8 py-3.5 rounded-xl transition-all duration-200 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Annuler
                    </button>
            </div>

            {{-- Informations supplémentaires --}}
            <div class="flex items-center gap-4 pt-2 text-xs text-gray-400">
                <span class="flex items-center gap-1">
                    <span class="text-rose-500">*</span> Champs obligatoires
                </span>
                <span class="w-px h-3 bg-gray-200"></span>
                <span>Une notification sera envoyée à l'employé</span>
            </div>
        </form>

        {{-- Pied de page avec le logo --}}
        <div class="mt-8 text-center">
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-gray-50 rounded-2xl border border-gray-100">
                <div class="flex items-center gap-1.5">
                    <span class="text-lg font-bold tracking-tight text-amber-500">ELV</span>
                    <span class="text-lg font-bold tracking-tight text-yellow-500">REX</span>
                </div>
                <span class="text-[10px] font-medium text-gray-400 uppercase tracking-widest">● NOUS VOUS FAISONS GAGNER DU
                    TEMPS</span>
            </div>
        </div>
    </div>
@endsection
