@extends('layouts.appdashadmin')

@section('content')
<h2 class="text-2xl font-semibold mb-6">📊 Tableau de bord RH</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-lg shadow border">
        <h3 class="text-gray-600 text-sm">Employés enregistrés</h3>
        <p class="text-3xl font-bold text-indigo-600">{{ $totalEmployees }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border">
        <h3 class="text-gray-600 text-sm">Présents aujourd'hui</h3>
        <p class="text-3xl font-bold text-green-600">{{ $presentToday }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border">
        <h3 class="text-gray-600 text-sm">Absents aujourd'hui</h3>
        <p class="text-3xl font-bold text-red-600">{{ $absentToday }}</p>
    </div>

</div>
@endsection
