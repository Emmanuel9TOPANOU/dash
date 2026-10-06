@extends('layouts.appdash')


@section('content')
    <div
        class="min-h-screen bg-slate-50/80 text-slate-800 font-sans p-4 sm:p-6 lg:p-10 relative overflow-hidden selection:bg-amber-500 selection:text-white">

        <div class="max-w-7xl mx-auto space-y-8 relative z-10">

            {{-- En-tête de bienvenue --}}
            <div
                class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white border border-slate-100 rounded-3xl p-6 lg:p-8 shadow-xl shadow-slate-200/50 relative overflow-hidden">
                <div class="absolute inset-0  pointer-events-none"></div>

                <div class="flex items-center space-x-5 relative z-10">
                    <div class="relative">
                        @if ($employee->photo)
                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                alt="Photo de profil de {{ $employee->prenom }} {{ $employee->nom }}"
                                class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover ring-4 ring-amber-400/30 shadow-md">
                        @else
                            <div
                                class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-amber-500/20">
                                {{ strtoupper(substr($employee->prenom, 0, 1)) }}{{ strtoupper(substr($employee->nom, 0, 1)) }}
                            </div>
                        @endif
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-4 border-white rounded-full"
                            title="Actif"></span>
                    </div>

                    <div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-100 text-amber-800 border border-amber-200">
                                Bon retour
                            </span>
                        </div>
                        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight mt-1">
                            {{ $employee->prenom }} <span class="text-amber-600">{{ $employee->nom }}</span>
                        </h1>
                        <p class="text-slate-500 text-xs sm:text-sm font-semibold mt-0.5">
                            <i
                                class="fas fa-briefcase text-amber-500 mr-1.5"></i>{{ $employee->service ?? 'Poste non défini' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3 self-end md:self-auto relative z-10">
                    <a href="{{ route('employe.logout') }}"
                        class="group flex items-center space-x-2 px-5 py-3 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 transition-all duration-300 text-sm font-bold shadow-sm">
                        <i class="fas fa-power-off text-rose-600 group-hover:scale-110 transition-transform"></i>
                        <span>Déconnexion</span>
                    </a>
                </div>
            </div>

            {{-- Carte de présence du jour + Stats --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                {{-- Présence du jour --}}
                <div
                    class="xl:col-span-2 bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 flex flex-col justify-between relative overflow-hidden">
                    <div>
                        <div class="flex flex-wrap items-center justify-between border-b border-slate-100 pb-6 mb-6 gap-4">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2.5">
                                    <span class="p-2.5 bg-amber-50 text-amber-600 rounded-xl border border-amber-100">
                                        <i class="fas fa-fingerprint"></i>
                                    </span>
                                    Présence du Jour
                                </h3>
                                <p class="text-slate-500 text-xs sm:text-sm mt-1 capitalize">
                                    Gérez votre pointage pour aujourd'hui, {{ now()->translatedFormat('l') }}
                                </p>
                            </div>

                            {{-- Horloge temps réel --}}
                            <div x-data="{ time: '{{ now()->translatedFormat('H:i:s') }}' }" x-init="setInterval(() => time = new Date().toLocaleTimeString('fr-FR'), 1000)"
                                class="text-right bg-slate-50 border border-slate-200/60 px-4 py-2 rounded-2xl">
                                <p class="text-2xl font-black text-slate-950 font-mono tracking-wider" x-text="time"></p>
                                <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Temps réel</p>
                            </div>
                        </div>

                        @if ($attendance)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                                {{-- Statut --}}
                                <div
                                    class="md:col-span-1 p-5 rounded-2xl border flex items-center space-x-4
                                {{ $attendance->statut == 'à l’heure'
                                    ? 'bg-emerald-50/60 border-emerald-200/80 text-emerald-800'
                                    : ($attendance->statut == 'en retard'
                                        ? 'bg-amber-50/60 border-amber-200/80 text-amber-800'
                                        : 'bg-rose-50/60 border-rose-200/80 text-rose-800') }}">
                                    <div class="p-3 rounded-xl bg-white shadow-sm">
                                        @if ($attendance->statut == 'à l’heure')
                                            <i class="fas fa-check-circle text-2xl text-emerald-600"></i>
                                        @elseif($attendance->statut == 'en retard')
                                            <i class="fas fa-clock text-2xl text-amber-600"></i>
                                        @else
                                            <i class="fas fa-times-circle text-2xl text-rose-600"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold">Statut de pointage</p>
                                        <span class="inline-block mt-0.5 font-bold text-sm capitalize">
                                            {{ ucfirst($attendance->statut) }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Heure d'arrivée --}}
                                <div
                                    class="p-5 bg-slate-50/70 border border-slate-100 rounded-2xl flex items-center space-x-4">
                                    <div class="p-3 rounded-xl bg-white text-amber-600 border border-slate-100 shadow-sm">
                                        <i class="fas fa-sign-in-alt text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium">Heure d'arrivée</p>
                                        <p class="font-extrabold text-slate-950 text-base font-mono mt-0.5">
                                            {{ $attendance->heure_arrivee ?? '--:--' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Heure de départ --}}
                                <div
                                    class="p-5 bg-slate-50/70 border border-slate-100 rounded-2xl flex items-center space-x-4">
                                    <div class="p-3 rounded-xl bg-white text-amber-600 border border-slate-100 shadow-sm">
                                        <i class="fas fa-sign-out-alt text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium">Heure de départ</p>
                                        <p class="font-extrabold text-slate-950 text-base font-mono mt-0.5">
                                            {{ $attendance->heure_depart ?? '--:--' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center space-x-4 bg-rose-50 border border-rose-100 rounded-2xl p-5 mb-8">
                                <div class="p-3 rounded-xl bg-rose-100 text-rose-700 shrink-0">
                                    <i class="fas fa-exclamation-circle text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-rose-900">Vous n'avez pas encore pointé</p>
                                    <p class="text-xs text-rose-700 mt-0.5">Merci de valider votre arrivée pour la journée.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Action Forms --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <form method="POST" action="{{ route('employe.clockin') }}">
                            @csrf
                            <button type="submit"
                                class="w-full group flex items-center justify-center space-x-2 py-4 bg-black text-white rounded-2xl font-bold transition duration-200 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/30 active:scale-[0.98]">
                                <i class="fas fa-sign-in-alt group-hover:-translate-x-1 transition-transform"></i>
                                <span>Confirmer mon arrivée</span>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('employe.clockout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full group flex items-center justify-center space-x-2 py-4 bg-white hover:bg-slate-50 text-slate-700 rounded-2xl font-bold transition duration-200 border border-slate-200 shadow-sm hover:border-slate-300 active:scale-[0.98]">
                                <i
                                    class="fas fa-sign-out-alt text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                                <span>Valider mon départ</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Statistiques du mois --}}
                <div
                    class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2.5">
                            <span class="p-2.5 bg-amber-50 text-amber-600 rounded-xl border border-amber-100">
                                <i class="fas fa-chart-pie"></i>
                            </span>
                            Aperçu Mensuel
                        </h3>

                        <div class="space-y-4">
                            {{-- Présences --}}
                            <div
                                class="flex items-center justify-between p-4 bg-slate-50/80 rounded-2xl border border-slate-100 hover:border-slate-200 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2.5 bg-emerald-100 text-emerald-700 rounded-xl">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <span class="text-slate-700 font-semibold text-sm">Jours de Présence</span>
                                </div>
                                <span
                                    class="text-emerald-700 font-bold text-sm bg-emerald-50 px-3.5 py-1 rounded-full border border-emerald-200">
                                    {{ $presencesCount }} jours
                                </span>
                            </div>

                            {{-- Absences --}}
                            <div
                                class="flex items-center justify-between p-4 bg-slate-50/80 rounded-2xl border border-slate-100 hover:border-slate-200 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2.5 bg-rose-100 text-rose-700 rounded-xl">
                                        <i class="fas fa-user-times"></i>
                                    </div>
                                    <span class="text-slate-700 font-semibold text-sm">Jours d'Absence</span>
                                </div>
                                <span
                                    class="text-rose-700 font-bold text-sm bg-rose-50 px-3.5 py-1 rounded-full border border-rose-200">
                                    {{ $absencesCount }} jours
                                </span>
                            </div>

                            {{-- Tâches --}}
                            <div
                                class="flex items-center justify-between p-4 bg-slate-50/80 rounded-2xl border border-slate-100 hover:border-slate-200 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2.5 bg-amber-100 text-amber-700 rounded-xl">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <span class="text-slate-700 font-semibold text-sm">Tâches Terminées</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-amber-700 font-bold text-base">{{ $tachesTerminees }}</span>
                                    <span class="text-slate-500 font-semibold text-xs"> / {{ $tachesTotal }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Ponctualité --}}
                    <div class="p-5 bg-slate-950 rounded-2xl shadow-xl mt-6 text-white">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-slate-800 text-amber-400 rounded-lg text-xs">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <span class="text-slate-200 font-bold text-xs uppercase tracking-wider">Taux de
                                    Ponctualité</span>
                            </div>
                            <span class="text-amber-400 font-black text-2xl font-mono">{{ $ponctualite }}%</span>
                        </div>
                        <div class="w-full bg-slate-800 rounded-full h-2.5 overflow-hidden p-0.5">
                            <div class="bg-gradient-to-r from-amber-500 to-amber-300 h-full rounded-full transition-all duration-1000 shadow-sm"
                                style="width: {{ $ponctualite }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informations employé - Version Carte Profil Premium --}}
            <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50">
                <div class="flex items-center justify-between border-b border-slate-100 pb-6 mb-6">
                    <div class="flex items-center space-x-4">
                        @if ($employee->photo)
                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                alt="Photo de profil de {{ $employee->prenom }} {{ $employee->nom }}"
                                class="w-16 h-16 rounded-2xl object-cover ring-2 ring-amber-400/50 shadow-md">
                        @else
                            <div
                                class="w-16 h-16 rounded-2xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 text-2xl font-black shadow-inner">
                                {{ strtoupper(substr($employee->prenom, 0, 1)) }}{{ strtoupper(substr($employee->nom, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">{{ $employee->prenom }} {{ $employee->nom }}
                            </h3>
                            <p class="text-slate-500 font-medium text-sm">{{ $employee->service ?? 'Poste non défini' }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('employe.logout') }}"
                        class="flex items-center space-x-2 text-sm text-rose-700 hover:text-rose-900 font-semibold bg-rose-50 hover:bg-rose-100 px-4 py-2.5 rounded-xl transition duration-200 border border-rose-100">
                        <i class="fas fa-power-off"></i>
                        <span>Déconnexion</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/80 p-6 rounded-2xl border border-slate-100">
                    <div class="space-y-2">
                        <p class="text-xs text-slate-400 font-black uppercase tracking-wider">Matricule Employé</p>
                        <div class="flex items-center space-x-3 text-base">
                            <div class="p-2 bg-white rounded-lg border border-slate-200 text-slate-500 shadow-sm">
                                <i class="fas fa-id-badge"></i>
                            </div>
                            <p class="font-bold text-slate-950">{{ $employee->matricule }}</p>
                        </div>
                    </div>
                    <div class="space-y-2 md:border-l md:border-slate-200 md:pl-6">
                        <p class="text-xs text-slate-400 font-black uppercase tracking-wider">Département / Service</p>
                        <div class="flex items-center space-x-3 text-base">
                            <div class="p-2 bg-white rounded-lg border border-slate-200 text-slate-500 shadow-sm">
                                <i class="fas fa-building"></i>
                            </div>
                            <p class="font-bold text-slate-950">{{ $employee->service ?? 'Non assigné' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- FontAwesome, AlpineJS & Google Fonts --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .font-sans {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
@endsection
