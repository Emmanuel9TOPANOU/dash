@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight"> Liste des présences</h2>
                <p class="text-sm text-slate-500 mt-1">Suivi quotidien et analyse des heures de présence des employés</p>
            </div>
        </div>

        <!-- Statistiques rapides - Cartes stylisées -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
            <!-- Carte Présents -->
            <div
                class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300 cursor-default">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Présents</span>
                            <span class="text-xs text-emerald-400">●</span>
                        </div>
                        <p class="text-3xl font-extrabold text-slate-800">{{ $stats['present'] }}</p>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-emerald-100 flex items-center justify-center shadow-inner">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-emerald-200/40">
                    <span class="text-xs text-emerald-600 font-medium">✓ Taux de présence</span>
                    <span
                        class="text-xs text-emerald-400 ml-2">{{ $stats['total'] > 0 ? round(($stats['present'] / $stats['total']) * 100, 1) : 0 }}%</span>
                </div>
            </div>

            <!-- Carte En retard -->
            <div
                class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300 cursor-default">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-600">En retard</span>
                            <span class="text-xs text-amber-400">●</span>
                        </div>
                        <p class="text-3xl font-extrabold text-slate-800">{{ $stats['late'] }}</p>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-amber-100 flex items-center justify-center shadow-inner">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-amber-200/40">
                    <span class="text-xs text-amber-600 font-medium"> Retard moyen</span>
                    <span class="text-xs text-amber-400 ml-2">{{ $stats['late_average'] }} min</span>
                </div>
            </div>

            <!-- Carte Absents -->
            <div
                class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300 cursor-default">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold uppercase tracking-wider text-rose-600">Absents</span>
                            <span class="text-xs text-rose-400">●</span>
                        </div>
                        <p class="text-3xl font-extrabold text-slate-800">{{ $stats['absent'] }}</p>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-rose-100 flex items-center justify-center shadow-inner">
                        <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-rose-200/40">
                    <span class="text-xs text-rose-600 font-medium À surveiller</span>
                <span class="text-xs
                        text-rose-400
                        ml-2">{{ $stats['total'] > 0 ? round(($stats['absent'] / $stats['total']) * 100, 1) : 0 }}%</span>
                </div>
            </div>

            <!-- Carte Durée moyenne -->
            <div
                class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300 cursor-default">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">Durée moyenne</span>
                            <span class="text-xs text-indigo-400"></span>
                        </div>
                        <p class="text-3xl font-extrabold text-slate-800">{{ $stats['avg'] }} <span
                                class="text-lg font-medium text-slate-400">h</span></p>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-indigo-100 flex items-center justify-center shadow-inner">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-indigo-200/40">
                    <span class="text-xs text-indigo-600 font-medium"> Objectif</span>
                    <span
                        class="text-xs text-indigo-400 ml-2">{{ $stats['avg'] > 0 ? round(($stats['avg'] / 7.5) * 100) : 0 }}%
                        de l’objectif</span>
                </div>
            </div>
        </div>

        <!-- Barre de filtrage -->
        <form method="GET" action="{{ route('attendances.index') }}"
            class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 mb-8 hover:shadow-md transition-shadow duration-300">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2"> Date</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition duration-200">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2"> Employé</label>
                    <select name="employee_id"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition duration-200">
                        <option value="">— Tous —</option>
                        @foreach ($employees as $emp)
                            <option value="{{ $emp->id }}"
                                {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->prenom }} {{ $emp->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm px-6 py-2.5 rounded-xl font-semibold shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtrer
                    </button>
                    <a href="{{ route('attendances.index') }}"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm px-6 py-2.5 rounded-xl font-medium transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Réinitialiser
                    </a>
                </div>
            </div>
        </form>

        <!-- Tableau des présences -->
        <div
            class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-slate-600">
                    <thead
                        class="bg-gradient-to-r from-slate-50 to-slate-100/50 border-b border-slate-200 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4"> Employé</th>
                            <th class="px-6 py-4"> Date</th>
                            <th class="px-6 py-4"> Arrivée</th>
                            <th class="px-6 py-4"> Départ</th>
                            <th class="px-6 py-4"> Statut</th>
                            <th class="px-6 py-4">Durée</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($attendances as $a)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150 group">
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs group-hover:bg-indigo-200 transition-colors">
                                            {{ $a->employee?->prenom[0] ?? '?' }}
                                        </div>
                                        <span>
                                            {{ $a->employee?->prenom ?? 'Employé supprimé' }}
                                            @if ($a->employee)
                                                {{ $a->employee->nom }}
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500 font-mono text-xs">{{ $a->date }}</td>
                                <td class="px-6 py-4 text-slate-600 font-mono text-xs">{{ $a->heure_arrivee ?? '—' }}</td>
                                <td class="px-6 py-4 text-slate-600 font-mono text-xs">{{ $a->heure_depart ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @if ($a->statut === 'a_lheure')
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60 shadow-sm">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                            À l’heure
                                        </span>
                                    @elseif($a->statut === 'en_retard')
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/60 shadow-sm">
                                            <span class="h-2 w-2 rounded-full bg-rose-500 animate-pulse"></span>
                                            En retard ({{ $a->retard_minutes }} min)
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60 shadow-sm">
                                            <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                            {{ ucfirst($a->statut) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-700 font-mono text-xs">
                                    {{ $a->minutes_travaillees ? round($a->minutes_travaillees / 60, 2) . ' h' : '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-slate-400 py-16 text-sm">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Aucun enregistrement trouvé.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 flex justify-center">
            {{ $attendances->links() }}
        </div>
    </div>
@endsection
