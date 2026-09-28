@extends('layouts.appdashadmin')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">✏️ Modifier la tâche</h2>

        <a href="{{ route('administration.communication.tasks.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md">
           ← Retour
        </a>
    </div>

    <form action="{{ route('administration.communication.tasks.update', $task->id) }}" 
          method="POST"
          class="bg-white p-6 rounded-lg shadow-md space-y-5 border border-gray-200">

        @csrf
        @method('PUT')

        {{-- Employé --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">👤 Employé</label>
            <select name="employee_id" class="w-full border-gray-300 rounded-md" required>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" 
                        {{ $task->employee_id == $emp->id ? 'selected' : '' }}>
                        {{ $emp->prenom }} {{ $emp->nom }} ({{ $emp->matricule }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">📝 Description</label>
            <textarea name="description" rows="4" 
                      class="w-full border-gray-300 rounded-md" 
                      required>{{ $task->description }}</textarea>
        </div>

        {{-- Date limite + Priorité --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div>
                <label class="block text-gray-700 font-medium mb-2">📅 Date limite</label>
                <input type="date" name="date_limite" 
                       value="{{ $task->date_limite }}" 
                       class="w-full border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">⚠️ Priorité</label>
                <select name="priorite" class="w-full border-gray-300 rounded-md">
                    <option value="faible" {{ $task->priorite == 'faible' ? 'selected' : '' }}>Faible</option>
                    <option value="moyenne" {{ $task->priorite == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                    <option value="haute" {{ $task->priorite == 'haute' ? 'selected' : '' }}>Haute</option>
                </select>
            </div>

        </div>

        {{-- Statut --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">📌 Statut</label>
            <select name="statut" class="w-full border-gray-300 rounded-md">
                <option value="en attente"  {{ $task->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="en cours"    {{ $task->statut == 'en cours' ? 'selected' : '' }}>En cours</option>
                <option value="terminée"    {{ $task->statut == 'terminée' ? 'selected' : '' }}>Terminée</option>
            </select>
        </div>

        {{-- Commentaire --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">✍️ Commentaire</label>
            <textarea name="commentaire" rows="3" 
                      class="w-full border-gray-300 rounded-md">{{ $task->commentaire }}</textarea>
        </div>

        {{-- Évaluation --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">⭐ Évaluation</label>
            <input type="text" name="evaluation" 
                   value="{{ $task->evaluation }}"
                   class="w-full border-gray-300 rounded-md"
                   placeholder="Ex : Très bien, 8/10, À améliorer...">
        </div>

        {{-- Bouton --}}
        <div class="pt-4">
            <button type="submit"
                    class="w-full sm:w-auto bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-md font-medium">
                💾 Mettre à jour la tâche
            </button>
        </div>

    </form>
</div>
@endsection
