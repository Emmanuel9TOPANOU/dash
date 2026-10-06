@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Modifier la tâche</h2>
                    <p class="text-sm text-gray-500">Modifiez les informations de la tâche sélectionnée</p>
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

        <form action="{{ route('tasks.update', $task->id) }}" method="POST"
            class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                    Employé <span class="text-rose-500">*</span>
                </label>
                <select name="employee_id"
                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white hover:border-amber-300 transition-all duration-200 outline-none appearance-none cursor-pointer"
                    required>
                    <option value="">— Sélectionner un employé —</option>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('employee_id', $task->employee_id) == $emp->id ? 'selected' : '' }}>
                            {{ $emp->prenom }} {{ $emp->nom }} ({{ $emp->matricule ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                    Description <span class="text-rose-500">*</span>
                </label>
                <textarea name="description" rows="4"
                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white hover:border-amber-300 transition-all duration-200 outline-none resize-y"
                    placeholder="Décrivez la tâche à réaliser..." required>{{ old('description', $task->description) }}</textarea>
                <p class="text-xs text-gray-400">Décrivez clairement la tâche à réaliser par le collaborateur</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Date limite
                    </label>
                    <div class="relative">
                        <input type="date" name="date_limite" value="{{ old('date_limite', $task->date_limite) }}"
                            class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white hover:border-amber-300 transition-all duration-200 outline-none">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Priorité
                    </label>
                    <select name="priorite"
                        class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white hover:border-amber-300 transition-all duration-200 outline-none appearance-none cursor-pointer">
                        <option value="basse" {{ old('priorite', $task->priorite) == 'basse' ? 'selected' : '' }}>Basse</option>
                        <option value="moyenne" {{ old('priorite', $task->priorite) == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="haute" {{ old('priorite', $task->priorite) == 'haute' ? 'selected' : '' }}>Haute</option>
                    </select>
                    <p class="text-xs text-gray-400">Définissez le niveau d'urgence de la tâche</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-gray-100">
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Commentaire
                    </label>
                    <input type="text" name="commentaire" value="{{ old('commentaire', $task->commentaire) }}" placeholder="Ajouter un commentaire..."
                        class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white hover:border-amber-300 transition-all duration-200 outline-none">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Statut
                    </label>
                    <select name="statut"
                        class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white hover:border-amber-300 transition-all duration-200 outline-none appearance-none cursor-pointer">
                        <option value="en attente" {{ old('statut', $task->statut) == 'en attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en cours" {{ old('statut', $task->statut) == 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="terminée" {{ old('statut', $task->statut) == 'terminée' ? 'selected' : '' }}>Terminée</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-black text-white font-semibold px-8 py-3.5 rounded-xl shadow-lg transition-all duration-200 text-sm">
                    Mettre à jour la tâche
                </button>

                <a href="{{ route('tasks.index') }}"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-8 py-3.5 rounded-xl transition-all duration-200 text-sm">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
