@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold">Nouvelle absence</h2>
    <a href="{{ route('absences.index') }}" class="text-indigo-600 hover:underline">← Retour</a>
</div>

<div class="bg-white p-6 rounded shadow max-w-lg mx-auto">
    <form method="POST" action="{{ route('absences.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium text-gray-700">Date début</label>
            <input type="date" name="date_debut" value="{{ old('date_debut') }}" class="w-full border-gray-300 rounded-md">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Date fin</label>
            <input type="date" name="date_fin" value="{{ old('date_fin') }}" class="w-full border-gray-300 rounded-md">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Motif</label>
            <input type="text" name="motif" value="{{ old('motif') }}" class="w-full border-gray-300 rounded-md">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Justificatif (PDF/Image)</label>
            <input type="file" name="justificatif" class="w-full border-gray-300 rounded-md">
        </div>

        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
            Enregistrer
        </button>
    </form>
</div>
@endsection
