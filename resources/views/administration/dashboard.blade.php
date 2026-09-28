@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
        class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm font-medium text-emerald-700 shadow-sm transition-all">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
        class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm font-medium text-red-700 shadow-sm transition-all">
        {{ session('error') }}
    </div>
@endif

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
