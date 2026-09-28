@extends('layouts.appdashadmin')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">➕ Nouvelle tâche – Communication</h2>

        <a href="{{ route('administration.communication.tasks.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md">
            ← Retour
        </a>
    </div>

    <form action="{{ route('administration.communication.tasks.store') }}" 
          method="POST"
          class="bg-white p-6 rounded-lg shadow-md space-y-5 border border-gray-200">

        @csrf

        {{-- Employé --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">👤 Employé</label>
            <select name="employee_id" class="w-full border-gray-300 rounded-md" required>
                <option value="">— Sélectionner —</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">
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
                      placeholder="Décrire la tâche attribuée..." 
                      required></textarea>
        </div>

        {{-- Date limite & Priorité --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div>
                <label class="block text-gray-700 font-medium mb-2">📅 Date limite</label>
                <input type="date" name="date_limite" class="w-full border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">⚠️ Priorité</label>
                <select name="priorite" class="w-full border-gray-300 rounded-md">
                    <option value="faible">Faible</option>
                    <option value="moyenne" selected>Moyenne</option>
                    <option value="haute">Haute</option>
                </select>
            </div>

        </div>

        {{-- Bouton sauvegarde --}}
        <div class="pt-4">
            <button type="submit"
                    class="w-full sm:w-auto bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-md font-medium">
                💾 Enregistrer la tâche
            </button>
        </div>

    </form>
</div>
@endsection
