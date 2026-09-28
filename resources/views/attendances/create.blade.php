@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-semibold mb-4"> Pointage du jour</h2>

    <div class="bg-white p-6 rounded shadow max-w-md mx-auto text-center">
        @if ($attendance && $attendance->heure_arrivee && $attendance->heure_depart)
            <p class="text-green-600 font-semibold mb-2">Tu as déjà terminé ta journée !</p>
            <p>Arrivée : {{ $attendance->heure_arrivee }} | Départ : {{ $attendance->heure_depart }}</p>
        @else
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

            @if (!$attendance || !$attendance->heure_arrivee)
                <form method="POST" action="{{ route('attendance.clockin') }}">
                    @csrf
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded">
                        Pointer l'arrivée
                    </button>
                </form>
            @elseif(!$attendance->heure_depart)
                <form method="POST" action="{{ route('attendance.clockout') }}" class="mt-4">
                    @csrf
                    <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded">
                        Pointer le départ
                    </button>
                </form>
            @endif
        @endif
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('attendances.index') }}" class="text-indigo-600 hover:underline">← Voir les présences</a>
    </div>
@endsection
