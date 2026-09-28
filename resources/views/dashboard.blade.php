@extends('layouts.app')

@section('content')
    <div class="space-y-8 font-sans">
        {{-- En-tête de la page --}}
        <div
            class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-200/40 sm:p-8">
            <div class="pointer-events-none absolute -right-16 -top-20 h-56 w-56 rounded-full bg-amber-100/70 blur-3xl">
            </div>
            <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span
                        class="mb-2 inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-amber-700">
                        <i class="fas fa-shield-halved"></i> Centre de contrôle
                    </span>
                    <h2 class="text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">Vue d'ensemble</h2>
                    <p class="mt-1 text-sm font-semibold text-slate-500">Supervision globale, performance RH et finances</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <span
                        class="inline-flex items-center gap-2 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-700">
                        <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500"></span> Système actif
                    </span>
                    <span
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold text-slate-500">
                        {{ now()->locale('fr')->translatedFormat('d F Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Section Financière & Globale (Section 10 Cahier des charges) --}}
        <div>
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4 flex items-center gap-2">
                <i class="fas fa-wallet text-amber-500"></i> Indicateurs Financiers & Projets
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Chiffre d'Affaires --}}
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Chiffre d'Affaires</span>
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-inner">
                            <i class="fas fa-coins text-sm"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-2xl font-black text-slate-900 tracking-tight">{{ number_format($chiffreAffaires ?? 0, 2, ',', ' ') }} FCFA</p>
                    <p class="mt-2 text-xs font-bold text-emerald-600"><i class="fas fa-check-circle mr-1"></i>Factures encaissées</p>
                </div>

                {{-- Dépenses --}}
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Dépenses Totales</span>
                        <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center shadow-inner">
                            <i class="fas fa-receipt text-sm"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-2xl font-black text-slate-900 tracking-tight">{{ number_format($totalDepenses ?? 0, 2, ',', ' ') }} FCFA</p>
                    <p class="mt-2 text-xs font-bold text-rose-600"><i class="fas fa-arrow-down mr-1"></i>Sorties de trésorerie</p>
                </div>

                {{-- Bénéfice Net --}}
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Bénéfice Net</span>
                        <div class="w-10 h-10 rounded-2xl {{ ($beneficeNet ?? 0) >= 0 ? 'bg-indigo-100 text-indigo-600' : 'bg-rose-100 text-rose-600' }} flex items-center justify-center shadow-inner">
                            <i class="fas fa-chart-pie text-sm"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-2xl font-black {{ ($beneficeNet ?? 0) >= 0 ? 'text-indigo-900' : 'text-rose-600' }} tracking-tight">
                        {{ number_format($beneficeNet ?? 0, 2, ',', ' ') }} FCFA
                    </p>
                    <p class="mt-2 text-xs font-bold {{ ($beneficeNet ?? 0) >= 0 ? 'text-indigo-600' : 'text-rose-600' }}">
                        <i class="fas fa-calculator mr-1"></i>Résultat comptable
                    </p>
                </div>

                {{-- Factures impayées --}}
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Factures Impayées</span>
                        <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shadow-inner">
                            <i class="fas fa-exclamation-circle text-sm"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-2xl font-black text-slate-900 tracking-tight">{{ $facturesImpayeesCount ?? 0 }}</p>
                    <p class="mt-2 text-xs font-bold text-amber-600">
                        Total : {{ number_format($facturesImpayeesMontant ?? 0, 2, ',', ' ') }} FCFA
                    </p>
                </div>
            </div>
        </div>

        {{-- Cartes de statistiques RH, Clients & Projets --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Employés actifs --}}
            <div class="group bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Employés Actifs</span>
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-600">
                        <i class="fas fa-users text-sm"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $actifs ?? 0 }}</p>
                </div>
                <div class="mt-3 flex items-center text-xs font-bold text-emerald-600">
                    <i class="fas fa-check-circle mr-1.5"></i>
                    {{ $totalEmployes > 0 ? round(($actifs / $totalEmployes) * 100) : 0 }}% du personnel
                </div>
            </div>

            {{-- Présents aujourd'hui --}}
            <div class="group bg-gradient-to-br from-amber-500/5 to-amber-500/10 border border-amber-500/20 rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-amber-800 uppercase tracking-wider">Présents Aujourd'hui</span>
                    <div class="w-10 h-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/30">
                        <i class="fas fa-clock text-sm"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $presents ?? 0 }}</p>
                </div>
                <div class="mt-3 flex items-center text-xs font-bold text-amber-700">
                    <i class="fas fa-chart-line mr-1.5"></i> {{ $tauxPresence ?? 0 }}% du personnel
                </div>
            </div>

            {{-- Total Clients --}}
            <div class="group bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Clients enregistrés</span>
                    <div class="w-10 h-10 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center">
                        <i class="fas fa-user-tie text-sm"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $totalClients ?? 0 }}</p>
                </div>
                <div class="mt-3 flex items-center text-xs font-bold text-sky-600">
                    <i class="fas fa-address-book mr-1.5"></i> Portefeuille client
                </div>
            </div>

            {{-- Projets En cours --}}
            <div class="group bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Projets Actifs</span>
                    <div class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center">
                        <i class="fas fa-folder-open text-sm"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $projetsActifs ?? 0 }}</p>
                </div>
                <div class="mt-3 flex items-center text-xs font-bold text-purple-600">
                    <i class="fas fa-spinner mr-1.5"></i> En cours d'exécution
                </div>
            </div>
        </div>

        {{-- Graphique + Raccourcis rapides --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Graphique --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm p-6 lg:col-span-2 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-base font-extrabold text-slate-900">Évolution du taux de présence</h3>
                        <span class="text-xs font-bold text-slate-400">Cette semaine</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 mb-6">
                        Taux moyen : <span class="font-black text-amber-600">{{ $weekAverage }}%</span>
                        <span class="inline-flex items-center ml-2 {{ $weekChange >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} px-2 py-0.5 rounded-md font-bold text-[11px]">
                            <i class="fas fa-arrow-{{ $weekChange >= 0 ? 'up' : 'down' }} mr-1 text-[9px]"></i>
                            {{ abs($weekChange) }}% vs semaine précédente
                        </span>
                    </p>
                </div>
                <div class="relative w-full h-64">
                    <canvas id="presenceChart"></canvas>
                </div>
            </div>

            {{-- Raccourcis --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-1">Raccourcis rapides</h3>
                    <p class="text-xs font-semibold text-slate-400 mb-6">Actions fréquemment utilisées</p>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('employees.create') }}"
                        class="flex items-center justify-center space-x-2 bg-amber-500 hover:bg-amber-600 active:scale-95 text-white px-5 py-3.5 rounded-2xl text-xs font-bold shadow-lg shadow-amber-500/25 transition-all">
                        <i class="fas fa-plus"></i>
                        <span>Ajouter un employé</span>
                    </a>
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center justify-center space-x-2 border border-slate-200 bg-slate-50 hover:bg-white hover:border-slate-300 active:scale-95 px-5 py-3.5 rounded-2xl text-xs font-bold text-slate-700 shadow-sm transition-all">
                        <i class="fas fa-chart-pie text-slate-400"></i>
                        <span>Générer un rapport</span>
                    </a>
                    <a href="{{ route('commercial-documents.index') }}"
                        class="flex items-center justify-center space-x-2 border border-slate-200 bg-slate-50 hover:bg-white hover:border-slate-300 active:scale-95 px-5 py-3.5 rounded-2xl text-xs font-bold text-slate-700 shadow-sm transition-all">
                        <i class="fas fa-file-invoice text-slate-400"></i>
                        <span>Factures & Devis</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Présence du jour --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Présence du jour</h3>
                    <p class="text-xs font-semibold text-slate-400">Pointage en direct des collaborateurs</p>
                </div>
                <a href="{{ route('attendances.index') }}"
                    class="inline-flex items-center text-xs font-bold text-amber-600 hover:text-amber-700 hover:underline">
                    Voir tout <i class="fas fa-arrow-right ml-1.5 text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[600px] border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                            <th class="pb-3 px-4">Employé</th>
                            <th class="pb-3 px-4">Service</th>
                            <th class="pb-3 px-4">Heure d’arrivée</th>
                            <th class="pb-3 px-4 text-right">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/80 text-xs font-semibold">
                        @forelse($presences ?? [] as $presence)
                            <tr class="group hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-4 whitespace-nowrap font-bold text-slate-900">
                                    {{ $presence->employee->prenom }} {{ $presence->employee->nom }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-slate-500">
                                    {{ $presence->employee->service ?? '—' }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-slate-600 font-mono">
                                    {{ $presence->heure_arrivee ?? '--:--' }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-right">
                                    <span class="inline-flex items-center px-3 py-1 text-[11px] font-bold rounded-xl 
                                    {{ $presence->statut == 'à l\'heure' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-rose-50 text-rose-700 border border-rose-200/60' }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $presence->statut == 'à l\'heure' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        {{ ucfirst($presence->statut) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-slate-400 py-8 font-medium">
                                    <i class="fas fa-calendar-times text-2xl text-slate-300 block mb-2"></i>
                                    Aucune présence enregistrée aujourd’hui.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Absences et tâches critiques --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Absences en attente --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-extrabold text-slate-900">Absences en attente</h3>
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    </div>
                    @forelse($absencesEnAttente ?? [] as $absence)
                        <div class="border border-slate-100 bg-slate-50/50 rounded-2xl p-4 mb-3 hover:bg-white hover:border-slate-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-extrabold text-slate-900 text-xs">{{ $absence->employee->prenom }} {{ $absence->employee->nom }}</p>
                                    <p class="text-xs font-semibold text-slate-600 mt-0.5">{{ $absence->motif }}</p>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 bg-white border border-slate-200 px-2 py-0.5 rounded-md">
                                    {{ $absence->duree }} Jours
                                </span>
                            </div>
                            <p class="text-[11px] font-semibold text-slate-400 mt-2">
                                <i class="far fa-calendar mr-1"></i> {{ $absence->date_debut }} → {{ $absence->date_fin }}
                            </p>
                            <div class="mt-3 flex items-center space-x-2 pt-2 border-t border-slate-200/40">
                                <form method="POST" action="{{ route('absences.update', $absence) }}" class="inline flex-1">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="statut" value="validee">
                                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                        Valider
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('absences.update', $absence) }}" class="inline flex-1">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="statut" value="refusee">
                                    <button class="w-full bg-rose-50 hover:bg-rose-100 text-rose-700 active:scale-95 px-3 py-1.5 rounded-xl text-xs font-bold transition-all border border-rose-200/60">
                                        Refuser
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-slate-400 py-8 font-medium">
                            <i class="fas fa-check-circle text-2xl text-slate-300 block mb-2"></i>
                            <p class="text-xs">Aucune absence en attente.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tâches critiques --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-extrabold text-slate-900">Tâches critiques à suivre</h3>
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    </div>
                    @forelse($tachesCritiques ?? [] as $task)
                        <div class="border border-slate-100 bg-slate-50/50 rounded-2xl p-4 mb-3 hover:bg-white hover:border-slate-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex justify-between items-start">
                                <p class="font-extrabold text-slate-900 text-xs">{{ $task->description }}</p>
                                <span class="inline-block px-2.5 py-1 text-[10px] font-black rounded-lg uppercase tracking-wider 
                                {{ $task->priorite == 'urgent' ? 'bg-rose-100 text-rose-700 border border-rose-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                                    {{ ucfirst($task->priorite) }}
                                </span>
                            </div>
                            <p class="text-xs font-semibold text-slate-500 mt-1">
                                <i class="far fa-user mr-1 text-slate-400"></i> {{ $task->employee->prenom }} {{ $task->employee->nom }}
                            </p>
                            <p class="text-[11px] font-semibold text-slate-400 mt-2">
                                <i class="far fa-clock mr-1"></i> Échéance :
                                {{ $task->date_limite ? \Carbon\Carbon::parse($task->date_limite)->translatedFormat('d-m-Y') : '—' }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center text-slate-400 py-8 font-medium">
                            <i class="fas fa-tasks text-2xl text-slate-300 block mb-2"></i>
                            <p class="text-xs">Aucune tâche critique à signaler.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Script pour le graphique --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('presenceChart').getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, 250);
            gradient.addColorStop(0, 'rgba(245, 158, 11, 0.35)');
            gradient.addColorStop(1, 'rgba(245, 158, 11, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Taux de présence (%)',
                        data: @json($chartData),
                        borderColor: '#f59e0b',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#f59e0b',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        backgroundColor: gradient,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 12,
                            titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                            cornerRadius: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#94a3b8' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#94a3b8' }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection