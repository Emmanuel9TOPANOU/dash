@extends('layouts.appdashadmin')

@section('content')
    @php
        $employee = \App\Models\Employee::find(session('employee_id'));

        // Transformation du rôle en texte lisible
        $roleLabel =
            [
                'rh' => 'Ressources Humaines',
                'communication' => 'Chef de la communication',
                'comptable' => 'Comptable',
                'direction' => 'Direction Générale',
            ][$employee->role ?? ''] ?? ucfirst($employee->role ?? 'Administrateur');
    @endphp

    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold">Dashboard Administration</h1>

        <p class="text-gray-600 mt-2">
            Bienvenue dans l’espace administratif
            <span class="font-semibold text-yellow-600">
                {{ $roleLabel }}
            </span>.
        </p>
    </div>
@endsection
