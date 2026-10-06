@extends('layouts.appdashadmin')

@section('content')
<h2 class="text-2xl font-semibold mb-6">➕ Ajouter un employé</h2>

<div class="bg-white p-6 rounded shadow max-w-xl">
    <form method="POST" action="{{ route('administration.rh.employees.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        {{-- Matricule --}}
        <div>
            <label class="font-medium">Matricule</label>
            <input type="text" name="matricule" value="{{ old('matricule') }}" 
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        {{-- Prénom --}}
        <div>
            <label class="font-medium">Prénom</label>
            <input type="text" name="prenom" value="{{ old('prenom') }}" 
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        {{-- Nom --}}
        <div>
            <label class="font-medium">Nom</label>
            <input type="text" name="nom" value="{{ old('nom') }}" 
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        {{-- Email --}}
        <div>
            <label class="font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        {{-- Contact --}}
        <div>
            <label class="font-medium">Contact</label>
            <input type="text" name="contact" value="{{ old('contact') }}" 
                   class="w-full border px-3 py-2 rounded">
        </div>

        {{-- Service --}}
        <div>
            <label class="font-medium">Service</label>
            <input type="text" name="service" value="{{ old('service') }}" 
                   class="w-full border px-3 py-2 rounded">
        </div>

        {{-- Poste --}}
        <div>
            <label class="font-medium">Poste</label>
            <input type="text" name="poste" value="{{ old('poste') }}" 
                   class="w-full border px-3 py-2 rounded">
        </div>

        {{-- Rôle --}}
        <div>
            <label class="font-medium">Rôle (optionnel)</label>
            <select name="role" class="w-full border px-3 py-2 rounded">
                <option value="">— Aucun —</option>
                <option value="rh">RH</option>
                <option value="comptable">Comptable</option>
                <option value="communication">Communication</option>
                <option value="secretaire">Secrétaire</option>
            </select>
        </div>

        {{-- Photo --}}
        <div>
            <label class="font-medium">Photo</label>
            <input type="file" name="photo" class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit"
            class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 rounded font-medium">
            Enregistrer l’employé
        </button>

    </form>
</div>

@endsection
