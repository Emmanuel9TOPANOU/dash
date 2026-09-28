@extends('layouts.appdashadmin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">📋 Présences des employés</h2>

{{-- 🔍 Filtres --}}
<form method="GET" action="{{ route('administration.rh.attendances') }}"
      class="bg-white p-4 rounded shadow mb-5 grid grid-cols-1 md:grid-cols-3 gap-4">

    {{-- Recherche par nom --}}
    <div>
        <label class="text-sm text-gray-600">Rechercher</label>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Nom ou prénom..."
               class="w-full border border-gray-300 rounded px-3 py-2">
    </div>

    {{-- Liste des employés --}}
    <div>
        <label class="text-sm text-gray-600">Employé</label>
        <select name="employee_id"
                class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="">Tous</option>
            @foreach($employees as $emp)
                <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                    {{ $emp->prenom }} {{ $emp->nom }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Filtre date --}}
    <div>
        <label class="text-sm text-gray-600">Date</label>
        <input type="date" name="date" value="{{ request('date') }}"
               class="w-full border border-gray-300 rounded px-3 py-2">
    </div>

    {{-- Boutons --}}
    <div class="md:col-span-3 flex gap-3 mt-2">
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Filtrer</button>
        <a href="{{ route('administration.rh.attendances') }}"
           class="px-4 py-2 rounded bg-gray-300 text-gray-800">
           Réinitialiser
        </a>
    </div>

</form>


{{-- 🧾 Tableau --}}
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm text-left min-w-[700px]">
        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
        <tr>
            <th class="px-4 py-3">Employé</th>
            <th class="px-4 py-3">Date</th>
            <th class="px-4 py-3">Arrivée</th>
            <th class="px-4 py-3">Départ</th>
            <th class="px-4 py-3">Statut</th>
        </tr>
        </thead>

        <tbody>
        @forelse($attendances as $a)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-2">{{ $a->employee->prenom }} {{ $a->employee->nom }}</td>
                <td class="px-4 py-2">{{ $a->date }}</td>
                <td class="px-4 py-2">{{ $a->heure_arrivee ?? '—' }}</td>
                <td class="px-4 py-2">{{ $a->heure_depart ?? '—' }}</td>
                <td class="px-4 py-2">
                    @if($a->statut === 'a_lheure')
                        <span class="text-green-600 font-semibold">À l’heure</span>
                    @elseif($a->statut === 'en_retard')
                        <span class="text-red-600 font-semibold">Retard</span>
                    @else
                        <span class="text-gray-500">—</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">
                    Aucun résultat trouvé.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $attendances->links() }}</div>
@endsection
