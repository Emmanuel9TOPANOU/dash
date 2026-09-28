@extends('layouts.appdashadmin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Projets</h2>
                <p class="mt-1 text-sm text-gray-500">Pilotez les projets, budgets et échéances.</p>
            </div><a href="{{ route('projects.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-yellow-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-yellow-700">Nouveau
                projet</a>
        </div>
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-700 shadow-sm transition-all">
                {{ session('success') }}
            </div>
        @endif
        <form method="GET" class="flex flex-col sm:flex-row gap-3"><input name="search" value="{{ request('search') }}"
                placeholder="Rechercher un projet ou client..."
                class="flex-1 rounded-lg border-gray-300 text-sm focus:border-yellow-500 focus:ring-yellow-500"><select
                name="status" class="rounded-lg border-gray-300 text-sm focus:border-yellow-500 focus:ring-yellow-500">
                <option value="">Tous les statuts</option>
                @foreach (['planifie' => 'Planifié', 'en_cours' => 'En cours', 'suspendu' => 'Suspendu', 'termine' => 'Terminé'] as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="rounded-lg bg-gray-800 px-4 py-2 text-sm font-semibold text-white">Filtrer</button>
        </form>
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Projet</th>
                            <th class="px-6 py-3">Client</th>
                            <th class="px-6 py-3">Responsable</th>
                            <th class="px-6 py-3">Avancement</th>
                            <th class="px-6 py-3">Échéance</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($projects as $project)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $project->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $project->tasks_count }} tâche(s)</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $project->client->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $project->manager?->full_name ?: 'Non défini' }}</td>
                                <td class="px-6 py-4 min-w-[160px]">
                                    <div class="flex justify-between text-xs text-gray-500">
                                        <span>{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span><span>{{ $project->progress }}%</span>
                                    </div>
                                    <div class="mt-1 h-2 rounded-full bg-gray-100">
                                        <div class="h-2 rounded-full bg-yellow-500"
                                            style="width: {{ $project->progress }}%"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $project->ends_at?->format('d/m/Y') ?: '—' }}</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap"><a
                                        class="font-semibold text-yellow-700 hover:text-yellow-900"
                                        href="{{ route('projects.edit', $project) }}">Modifier</a>
                                    <form class="inline" method="POST" action="{{ route('projects.destroy', $project) }}"
                                        onsubmit="return confirm('Supprimer ce projet ?')">@csrf @method('DELETE')<button
                                            class="ml-3 font-semibold text-red-700 hover:text-red-900">Supprimer</button>
                                    </form>
                                </td>
                        </tr>@empty<tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">Aucun projet trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4">{{ $projects->links() }}</div>
        </div>
    </div>
@endsection
