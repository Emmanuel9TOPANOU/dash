@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">📝 Liste des tâches</h2>
        <a href="{{ route('tasks.create') }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md font-medium">
            ➕ Nouvelle tâche
        </a>
    </div>

    {{-- ✅ Barre de recherche par date --}}
    <form method="GET" action="{{ route('tasks.index') }}" class="flex items-center space-x-3 mb-6">
        <input type="date" name="date" value="{{ $selectedDate ?? '' }}"
            class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-yellow-500 focus:border-yellow-500">

        <button type="submit"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium">
            🔍 Rechercher
        </button>

        @if ($selectedDate)
            <a href="{{ route('tasks.index') }}" class="text-sm text-gray-600 hover:underline">
                ❌ Réinitialiser
            </a>
        @endif
    </form>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
            class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm font-medium text-emerald-700 shadow-sm transition-all">
            {{ session('success') }}
        </div>
    @endif

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
                        <td class="p-3">
                            {{ $task->employee?->prenom ?? 'Employé supprimé' }}
                            @if ($task->employee)
                                {{ $task->employee->nom }}
                            @endif
                        </td>
                        <td class="p-3 text-sm text-gray-700">{{ Str::limit($task->description, 50) }}</td>
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
                        <td class="p-3 text-gray-600">{{ $task->date_limite ?? '—' }}</td>
                        <td class="p-3 text-gray-600 text-sm">
                            {{ $task->commentaire ? Str::limit($task->commentaire, 40) : '—' }}
                        </td>
                        <td class="p-3 text-right">
                            <a href="{{ route('tasks.edit', $task->id) }}"
                                class="text-blue-600 hover:underline mr-2">Modifier</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
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
                        <td colspan="7" class="p-4 text-center text-gray-500">Aucune tâche trouvée pour cette date.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tasks->appends(['date' => $selectedDate])->links() }}
    </div>
@endsection
