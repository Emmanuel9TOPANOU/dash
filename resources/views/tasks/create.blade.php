@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
               
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
                        <option value="basse" class="flex items-center gap-2"> Basse</option>
                        <option value="moyenne" selected>Moyenne</option>
                        <option value="haute">Haute</option>
                    </select>
                    <p class="text-xs text-gray-400">Définissez le niveau d'urgence de la tâche</p>
                </div>
            </div>

            {{-- Champs supplémentaires optionnels --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-gray-100">
              

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
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-black
                        
                           text-white font-semibold px-8 py-3.5 rounded-xl 
                           shadow-lg s 
                           transition-all duration-200 text-sm">
                  
                    Enregistrer la tâche
                </button>

                <a href="{{ route('tasks.index') }}"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 
                      text-gray-700 font-medium px-8 py-3.5 rounded-xl transition-all duration-200 text-sm">
                  
                    Annuler
                    </button>
            </div>

        </form>

       
    </div>
@endsection
