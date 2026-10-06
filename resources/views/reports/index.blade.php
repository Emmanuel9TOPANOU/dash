@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">

                    <div>
                        <p class="text-sm text-gray-500">Vue d'ensemble de la gestion du personnel</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('reports.pdf') }}"
                    class="group inline-flex min-h-11 items-center gap-2.5 rounded-xl bg-green-800 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-amber-500/20 transition-all duration-200 hover:-translate-y-0.5 hover:from-amber-600 hover:to-yellow-600 hover:shadow-lg hover:shadow-amber-500/30 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 active:translate-y-0">
                    <svg class="h-4 w-4 transition-transform duration-200 group-hover:-translate-y-0.5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span>Exporter en PDF</span>
                </a>
                <a href="{{ route('reports.excel') }}"
                    class="group inline-flex min-h-11 items-center gap-2.5 rounded-xl border border-emerald-200 bg-white px-5 py-2.5 text-sm font-bold text-emerald-700 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-emerald-300 hover:bg-emerald-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 active:translate-y-0">
                    <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-y-0.5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                    </svg>
                    <span>Exporter en Excel</span>
                </a>
            </div>
        </div>

        {{-- Cartes de statistiques --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Employés --}}
            <div
                class="group bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Employés</p>
                        <h3 class="text-3xl font-bold text-amber-500 mt-1">{{ $employees }}</h3>
                    </div>

                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <span class="text-xs text-gray-400">Effectif total</span>
                </div>
            </div>

            {{-- Présences --}}
            <div
                class="group bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Présences</p>
                        <h3 class="text-3xl font-bold text-emerald-500 mt-1">{{ $presences }}</h3>
                    </div>

                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <span class="text-xs text-gray-400">Enregistrées</span>
                </div>
            </div>

            {{-- Absences --}}
            <div
                class="group bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Absences</p>
                        <h3 class="text-3xl font-bold text-rose-500 mt-1">{{ $absences }}</h3>
                    </div>

                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <span class="text-xs text-gray-400">À surveiller</span>
                </div>
            </div>

            {{-- Tâches --}}
            <div
                class="group bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Tâches terminées</p>
                        <h3 class="text-3xl font-bold text-yellow-600 mt-1">{{ $tasksDone }}/{{ $tasksTotal }}</h3>
                    </div>

                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <span class="text-xs text-gray-400">{{ $tasksTotal - $tasksDone }} restante(s)</span>
                </div>
            </div>
        </div>

        {{-- Taux --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Taux de présence --}}
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-800">Taux de présence global</h3>
                    <span class="text-sm font-bold text-emerald-600">{{ $tauxPresence }}%</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-3 bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full transition-all duration-1000"
                        style="width: {{ $tauxPresence }}%"></div>
                </div>
                <div class="flex justify-between mt-2 text-xs text-gray-400">
                    <span>0%</span>
                    <span>50%</span>
                    <span>100%</span>
                </div>
            </div>

            {{-- Taux de tâches --}}
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-800">Taux de tâches terminées</h3>
                    <span class="text-sm font-bold text-amber-500">{{ $tauxTaches }}%</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-3 bg-gradient-to-r from-amber-400 to-yellow-500 rounded-full transition-all duration-1000"
                        style="width: {{ $tauxTaches }}%"></div>
                </div>
                <div class="flex justify-between mt-2 text-xs text-gray-400">
                    <span>0%</span>
                    <span>50%</span>
                    <span>100%</span>
                </div>
            </div>
        </div>

        {{-- Dernières présences --}}
        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <h3 class="font-semibold text-gray-800">Dernières présences enregistrées</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Les 5 derniers enregistrements</p>
                </div>
                <a href="{{ route('attendances.index') }}"
                    class="text-xs font-medium text-amber-500 hover:text-amber-600 transition-colors">
                    Voir tout →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/80 text-gray-500 font-semibold text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Employé</th>
                            <th class="px-6 py-3.5">Date</th>
                            <th class="px-6 py-3.5">Arrivée</th>
                            <th class="px-6 py-3.5">Départ</th>
                            <th class="px-6 py-3.5 text-center">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($attendances as $a)
                            <tr class="hover:bg-amber-50/30 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-100 to-yellow-100 text-amber-700 font-bold flex items-center justify-center text-xs shadow-sm ring-2 ring-white">
                                            {{ strtoupper(substr($a->employee->prenom, 0, 1) . substr($a->employee->nom, 0, 1)) }}
                                        </div>
                                        <span class="font-semibold text-gray-900">{{ $a->employee->prenom }}
                                            {{ $a->employee->nom }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-mono text-xs">{{ $a->date }}</td>
                                <td class="px-6 py-4 text-gray-600 font-mono text-xs">{{ $a->heure_arrivee ?? '—' }}</td>
                                <td class="px-6 py-4 text-gray-600 font-mono text-xs">{{ $a->heure_depart ?? '—' }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if ($a->statut === 'en retard')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                            En retard
                                        </span>
                                    @elseif($a->statut === 'présent' || $a->statut === 'a_lheure')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Présent
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            {{ ucfirst($a->statut) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="text-3xl"></span>
                                        <p class="text-sm text-gray-500">Aucune présence enregistrée</p>
                                        <p class="text-xs text-gray-400">Les dernières présences apparaîtront ici</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

      
    </div>
@endsection
