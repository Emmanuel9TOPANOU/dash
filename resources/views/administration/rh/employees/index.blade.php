@extends('layouts.appdashadmin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">👥 Liste des employés</h2>

<form method="GET" class="mb-4">
    <input type="text" name="search" placeholder="Rechercher nom, prénom, matricule..."
           value="{{ request('search') }}"
           class="w-full md:w-1/3 border px-3 py-2 rounded">
</form>
<div class="flex justify-between items-center mb-4">
    <a href="{{ route('administration.rh.employees.create') }}"
       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md font-medium">
       ➕ Ajouter un employé
    </a>
</div>


<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm text-left min-w-[700px]">
        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Photo</th>
                <th class="px-4 py-3">Nom complet</th>
                <th class="px-4 py-3">Matricule</th>
                <th class="px-4 py-3">Service</th>
                <th class="px-4 py-3">Poste</th>
                <th class="px-4 py-3">Rôle</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($employees as $emp)
        <tr class="border-t hover:bg-gray-50">
            <td class="px-4 py-2">
                <img src="{{ $emp->photo ? asset('storage/'.$emp->photo) : 'https://via.placeholder.com/40' }}"
                     class="w-10 h-10 rounded-full object-cover">
            </td>

            <td class="px-4 py-2">{{ $emp->prenom }} {{ $emp->nom }}</td>
            <td class="px-4 py-2">{{ $emp->matricule }}</td>
            <td class="px-4 py-2">{{ $emp->service ?? '—' }}</td>
            <td class="px-4 py-2">{{ $emp->poste ?? '—' }}</td>
            <td class="px-4 py-2">{{ $emp->role ?? '—' }}</td>

            <td class="px-4 py-2">
                <a href="{{ route('administration.rh.employees.show', $emp) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md transition-all duration-200 hover:bg-indigo-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Voir détails</a>

            </td>
        </tr>
        @empty
            <tr><td colspan="6" class="text-center py-4 text-gray-500">Aucun employé trouvé.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $employees->links() }}</div>
@endsection
