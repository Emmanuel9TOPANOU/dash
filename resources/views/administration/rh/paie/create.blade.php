@extends('layouts.appdashadmin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">➕ Générer une fiche de paie</h2>

<div class="bg-white shadow p-6 rounded-lg max-w-2xl">

    <form method="POST" action="{{ route('administration.rh.paie.generate') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Employé</label>
            <select name="employee_id" class="w-full border px-3 py-2 rounded" required>
                <option value="">— Sélectionnez —</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->prenom }} {{ $emp->nom }} ({{ $emp->matricule }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Période</label>
            <input type="month" name="periode" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="block text-gray-700 mb-1">Jours travaillés</label>
                <input type="number" name="jours_travailles" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Salaire brut (FCFA)</label>
                <input type="number" name="salaire_brut" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Avance perçue (FCFA)</label>
                <input type="number" name="avance" class="w-full border px-3 py-2 rounded">
            </div>

        </div>

        <button class="mt-6 bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded">
            Générer la fiche PDF
        </button>

    </form>

</div>
@endsection
