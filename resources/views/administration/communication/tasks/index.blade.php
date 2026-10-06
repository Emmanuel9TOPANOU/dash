@extends('layouts.appdashadmin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">📁 Tâches – Département Communication</h2>

        <a href="{{ route('administration.communication.tasks.create') }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md font-medium">
            ➕ Nouvelle tâche
        </a>
    </div>

    {{-- 🔎 Barre de recherche --}}
    <form method="GET" action="{{ route('administration.communication.tasks.index') }}"
        class="flex items-center space-x-3 mb-6">

        <input type="text" name="search" placeholder="Rechercher une tâche..." value="{{ request('search') }}"
            class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-yellow-500 focus:border-yellow-500">

        <button type="submit"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium">
            🔍 Chercher
        </button>

        @if (request('search'))
            <a href="{{ route('administration.communication.tasks.index') }}" class="text-sm text-gray-600 hover:underline">
                ❌ Réinitialiser
            </a>
        @endif
    </form>

    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr class="text-left text-gray-700">
                    <th class="p-3">Employé</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Priorité</th>
                    <th class="p-3">Statut</th>
                    <th class="p-3">Date limite</th>
                    <th class="p-3">Commentaire</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($tasks as $task)
                    <tr class="border-t hover:bg-gray-50">

                        {{-- Employé --}}
                        <td class="p-3">
                            {{ $task->employee->prenom }} {{ $task->employee->nom }}
                        </td>

                        {{-- Description --}}
                        <td class="p-3 text-sm text-gray-700">
                            {{ Str::limit($task->description, 50) }}
                        </td>

                        {{-- Priorité --}}
                        <td class="p-3">
                            <span
                                class="px-2 py-1 text-xs rounded 
                            {{ $task->priorite === 'haute'
                                ? 'bg-red-100 text-red-700'
                                : ($task->priorite === 'moyenne'
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-green-100 text-green-700') }}">
                                {{ ucfirst($task->priorite) }}
                            </span>
                        </td>

                        {{-- Statut --}}
                        <td class="p-3">
                            <span
                                class="px-2 py-1 text-xs rounded 
                            {{ $task->statut === 'terminée'
                                ? 'bg-green-100 text-green-700'
                                : ($task->statut === 'en cours'
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($task->statut) }}
                            </span>
                        </td>

                        {{-- Date limite --}}
                        <td class="p-3 text-gray-600">
                            {{ $task->date_limite ?? '—' }}
                        </td>

                        {{-- Commentaire --}}
                        <td class="p-3 text-gray-600 text-sm">
                            {{ $task->commentaire ? Str::limit($task->commentaire, 40) : '—' }}
                        </td>

                        {{-- Actions --}}
                        <td class="p-3 text-right">
                            {{-- Pour Communication : Édition + Suppression --}}
                            <a href="{{ route('administration.communication.tasks.edit', $task->id) }}"
                                class="text-blue-600 hover:underline mr-2">
                                Modifier
                            </a>

                            <form action="{{ route('administration.communication.tasks.destroy', $task->id) }}"
                                method="POST" class="inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-600 hover:underline"
                                    onclick="return confirm('Supprimer cette tâche ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">
                            Aucune tâche trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tasks->appends(['search' => request('search')])->links() }}
    </div>
@endsection
