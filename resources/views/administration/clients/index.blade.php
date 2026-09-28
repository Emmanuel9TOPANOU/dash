@extends('layouts.appdashadmin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Clients</h2>
                <p class="mt-1 text-sm text-gray-500">Gérez les clients et leurs projets.</p>
            </div>
            <a href="{{ route('clients.create') }}"
                class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-yellow-600 text-white text-sm font-semibold hover:bg-yellow-700">Nouveau
                client</a>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                class="p-4 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm font-medium shadow-sm transition-all">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="flex gap-3">
            <input name="search" value="{{ request('search') }}" placeholder="Rechercher un client..."
                class="flex-1 rounded-lg border-gray-300 text-sm focus:border-yellow-500 focus:ring-yellow-500">
            <button
                class="px-4 py-2 rounded-lg bg-gray-800 text-white text-sm font-semibold hover:bg-gray-700">Rechercher</button>
        </form>

        <div class="overflow-hidden bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Client</th>
                            <th class="px-6 py-3">Contact</th>
                            <th class="px-6 py-3">Coordonnées</th>
                            <th class="px-6 py-3">Projets</th>
                            <th class="px-6 py-3">Statut</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($clients as $client)
                            <tr>
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $client->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $client->contact_name ?: '—' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $client->email ?: ($client->phone ?: '—') }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $client->projects_count }}</td>
                                <td class="px-6 py-4"><span
                                        class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $client->status === 'actif' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800' }}">{{ ucfirst($client->status) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap"><a
                                        class="text-yellow-700 hover:text-yellow-900 font-semibold"
                                        href="{{ route('clients.edit', $client) }}">Modifier</a>
                                    <form class="inline" method="POST" action="{{ route('clients.destroy', $client) }}"
                                        onsubmit="return confirm('Supprimer ce client et ses projets ?')">@csrf
                                        @method('DELETE')<button
                                            class="ml-3 text-red-700 hover:text-red-900 font-semibold">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">Aucun client trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4">{{ $clients->links() }}</div>
        </div>
    </div>
@endsection
