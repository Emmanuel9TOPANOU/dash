@extends('layouts.appdashadmin')

@section('content')
<h2 class="text-2xl font-semibold mb-6">👤 Détails de l’employé</h2>

<div class="bg-white shadow rounded p-6 mb-6">
    <div class="flex items-center space-x-4">
        <img src="{{ $employee->photo ? asset('storage/'.$employee->photo) : 'https://via.placeholder.com/80' }}"
             class="w-20 h-20 rounded-full object-cover">

        <div>
            <h3 class="text-xl font-semibold">{{ $employee->prenom }} {{ $employee->nom }}</h3>
            <p class="text-gray-600">{{ $employee->matricule }}</p>
            <p class="text-gray-500">{{ $employee->poste }} | {{ $employee->service }}</p>
        </div>
    </div>
</div>

<h3 class="text-lg font-semibold mb-2">🕓 Dernières présences</h3>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full min-w-[600px] text-sm">
        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Arrivée</th>
                <th class="px-4 py-3">Départ</th>
                <th class="px-4 py-3">Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $a)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-2">{{ $a->date }}</td>
                <td class="px-4 py-2">{{ $a->heure_arrivee ?? '—' }}</td>
                <td class="px-4 py-2">{{ $a->heure_depart ?? '—' }}</td>
                <td class="px-4 py-2">{{ ucfirst($a->statut) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
