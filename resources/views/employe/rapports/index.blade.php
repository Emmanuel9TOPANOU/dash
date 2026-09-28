@extends('layouts.appdash')

@section('content')
    <div class="space-y-8 font-sans max-w-7xl mx-auto px-4 sm:px-6 py-6">
        {{-- En-tête Institutionnel Premium --}}
        <div
            class="relative bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-amber-400 to-amber-600"></div>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="space-y-1">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-amber-50 text-amber-700 border border-amber-200/60">
                        Analyse de performance
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Rapports Mensuels</h2>
                    <p class="text-slate-500 font-medium text-sm">Visualisez vos indicateurs clés et téléchargez vos bilans
                        officiels.</p>
                </div>

                {{-- Filtre Premium --}}
                <form method="GET"
                    class="flex items-center space-x-2 bg-slate-50/80 p-2 rounded-2xl border border-slate-100 shadow-inner w-full md:w-auto">
                    <div class="relative flex-1 md:flex-none">
                        <select name="month"
                            class="w-full bg-white border border-slate-200/80 text-xs font-bold text-slate-800 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 cursor-pointer transition-all appearance-none pr-8">
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                    {{ ucfirst(\Carbon\Carbon::create()->locale('fr')->month($m)->translatedFormat('F')) }}
                                </option>
                            @endforeach
                        </select>
                        <i
                            class="fas fa-chevron-down text-[10px] text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    <div class="relative flex-1 md:flex-none">
                        <select name="year"
                            class="w-full bg-white border border-slate-200/80 text-xs font-bold text-slate-800 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 cursor-pointer transition-all appearance-none pr-8">
                            @foreach (range(now()->year - 3, now()->year) as $y)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}
                                </option>
                            @endforeach
                        </select>
                        <i
                            class="fas fa-chevron-down text-[10px] text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    <button type="submit"
                        class="bg-slate-950 hover:bg-slate-800 text-white p-2.5 rounded-xl transition-all duration-300 shadow-md shadow-slate-950/10 active:scale-95 shrink-0">
                        <i class="fas fa-filter text-xs"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Cartes de Statistiques (Key Results) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Présence --}}
            <div
                class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 flex items-center space-x-5 hover:border-blue-100 hover:shadow-blue-500/5 transition-all duration-300">
                <div
                    class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-sm border border-blue-100 group-hover:scale-110 transition-transform">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Jours Présents</h3>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">
                        {{ $presenceDays }} <span class="text-xs font-bold text-slate-400 uppercase">jours</span>
                    </p>
                </div>
            </div>

            {{-- Absences --}}
            <div
                class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 flex items-center space-x-5 hover:border-rose-100 hover:shadow-rose-500/5 transition-all duration-300">
                <div
                    class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-xl shadow-sm border border-rose-100 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Absences</h3>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">
                        {{ $absenceDays }} <span class="text-xs font-bold text-slate-400 uppercase">jours</span>
                    </p>
                </div>
            </div>

            {{-- Ponctualité --}}
            <div
                class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 flex items-center space-x-5 hover:border-emerald-100 hover:shadow-emerald-500/5 transition-all duration-300">
                <div
                    class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-sm border border-emerald-100 group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Ponctualité</h3>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $punctuality }}%</p>
                </div>
            </div>
        </div>

        {{-- Section Analyse & Rapport --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Résumé des tâches --}}
            <div
                class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 p-8 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-black text-slate-900 tracking-tight">Productivité</h3>
                            <p class="text-slate-400 text-xs font-medium mt-0.5">Avancement global des objectifs</p>
                        </div>
                        <span
                            class="bg-slate-50 border border-slate-100 text-slate-600 text-[10px] font-black px-3 py-1.5 rounded-xl uppercase tracking-widest">
                            Missions
                        </span>
                    </div>

                    <div class="space-y-6">
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tâches
                                    Finalisées</p>
                                <p class="text-3xl font-black text-slate-900 mt-1">
                                    {{ $tasksDone }} <span class="text-lg font-bold text-slate-300">/
                                        {{ $tasksTotal }}</span>
                                </p>
                            </div>
                            @php
                                $progress = $tasksTotal > 0 ? ($tasksDone / $tasksTotal) * 100 : 0;
                            @endphp
                            <div class="text-right">
                                <span class="text-2xl font-black text-amber-500">{{ round($progress) }}%</span>
                            </div>
                        </div>

                        {{-- Barre de progression --}}
                        <div
                            class="w-full bg-slate-100 h-3.5 rounded-full overflow-hidden p-0.5 border border-slate-200/50">
                            <div class="bg-gradient-to-r from-amber-400 to-amber-500 h-full rounded-full transition-all duration-1000 shadow-sm"
                                style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400 font-medium">
                    <span>Statistiques mises à jour en temps réel</span>
                    <i class="fas fa-sync-alt text-[10px]"></i>
                </div>
            </div>

            {{-- Section Action PDF --}}
            <div
                class="bg-slate-950 rounded-3xl p-8 flex flex-col justify-between relative overflow-hidden group shadow-xl shadow-slate-950/20 min-h-[280px]">
                {{-- Filigrane SVG décoratif --}}
                <div
                    class="absolute -right-6 -bottom-6 text-slate-800/40 group-hover:scale-110 group-hover:text-slate-800/60 transition-all duration-500 pointer-events-none">
                    <i class="fas fa-file-pdf text-[180px]"></i>
                </div>

                <div class="relative z-10 space-y-2">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-amber-500/10 text-amber-400 border border-amber-500/20">
                        Exportation Officielle
                    </span>
                    <h3 class="text-2xl font-black text-white tracking-tight">Bilan Officiel</h3>
                    <p class="text-slate-400 text-sm max-w-sm font-medium">
                        Générez un document PDF certifié récapitulant vos présences et vos indicateurs d'activité du mois.
                    </p>
                </div>

                <div class="relative z-10 pt-8">
                    <a href="{{ route('employe.rapports.pdf', ['month' => $month, 'year' => $year]) }}"
                        class="inline-flex items-center space-x-3 bg-amber-500 hover:bg-amber-400 text-slate-950 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-amber-500/20 hover:shadow-amber-500/30 active:scale-95">
                        <i class="fas fa-download text-sm"></i>
                        <span>Télécharger le rapport</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
