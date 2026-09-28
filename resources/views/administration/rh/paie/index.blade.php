@extends('layouts.appdashadmin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">📄 Fiches de paie générées</h2>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
            class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm font-medium text-emerald-700 shadow-sm transition-all">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('administration.rh.paie.create') }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md font-medium">
            ➕ Nouvelle fiche de paie
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="w-full text-sm min-w-[700px]">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Employé</th>
                    <th class="px-4 py-3">Période</th>
                    <th class="px-4 py-3">Salaire net</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payrolls as $p)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">
                            {{ $p->employee->prenom }} {{ $p->employee->nom }}
                        </td>
                        <td class="px-4 py-2">{{ $p->periode }}</td>
                        <td class="px-4 py-2 font-semibold">{{ number_format($p->net, 0, ',', ' ') }} FCFA</td>
                        <td class="px-4 py-2">{{ $p->created_at->format('d-m-Y') }}</td>

                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('administration.rh.paie.download', $p->id) }}"
                                class="text-blue-600 hover:underline font-medium">
                                Télécharger PDF
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">Aucune fiche disponible.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $payrolls->links() }}
    </div>
@endsection
