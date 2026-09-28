@extends('layouts.appdashadmin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">📅 Absences des employés</h2>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Employé</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Motif</th>
                <th class="px-4 py-3 text-center">Statut</th>
            </tr>
        </thead>

        <tbody>
            @foreach($absences as $abs)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-2">{{ $abs->employee->prenom }} {{ $abs->employee->nom }}</td>
                <td class="px-4 py-2">{{ $abs->date }}</td>
                <td class="px-4 py-2">{{ $abs->motif }}</td>
                <td class="px-4 py-2 text-center">
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                        {{ ucfirst($abs->statut ?? 'En attente') }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

<div class="mt-4">{{ $absences->links() }}</div>
@endsection
