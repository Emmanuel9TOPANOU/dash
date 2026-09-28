@extends('layouts.app')

@section('content')
    {{-- En-tête avec bouton retour --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-500/10 text-amber-600 border border-amber-500/20 shadow-sm text-base">
                    👤
                </span>
                Détails de l'employé
            </h2>
            <p class="text-xs font-semibold text-slate-400 mt-1">Fiche d'information complète du collaborateur.</p>
        </div>

        <a href="{{ route('employees.index') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-slate-200/80 hover:bg-slate-50 hover:border-slate-300 text-slate-700 text-xs font-bold rounded-2xl shadow-sm transition-all active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour à la liste
        </a>
    </div>

    {{-- Carte profil principale --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xl shadow-slate-900/5 transition-colors duration-300 space-y-8">
        
        {{-- Bannière Photo + Identité --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 p-6 bg-slate-50 border border-slate-100 rounded-2xl">
            @if($employee->photo)
                <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo de {{ $employee->nom }}" 
                     class="w-24 h-24 rounded-2xl object-cover border-2 border-amber-400 shadow-md shrink-0">
            @else
                <div class="w-24 h-24 rounded-2xl bg-slate-200/80 border border-slate-300/60 flex flex-col items-center justify-center text-slate-400 font-bold text-xs shrink-0 gap-1">
                    <span class="text-xl">📷</span>
                    <span>Aucune photo</span>
                </div>
            @endif

            <div class="space-y-1">
                <div class="flex flex-wrap items-center gap-3">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">
                        {{ $employee->prenom }} {{ $employee->nom }}
                    </h3>
                    @if($employee->role)
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-extrabold uppercase tracking-wider bg-amber-500/10 text-amber-700 border border-amber-500/20">
                            {{ $employee->role }}
                        </span>
                    @endif
                </div>
                <p class="text-xs font-semibold text-slate-500">
                    {{ $employee->poste ?? '—' }} <span class="text-slate-300 mx-1">•</span> {{ $employee->service ?? '—' }}
                </p>
            </div>
        </div>

        {{-- Grille des informations --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            {{-- Matricule --}}
            <div class="p-4 bg-slate-50/60 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Matricule</p>
                <p class="text-xs font-mono font-bold text-slate-800">{{ $employee->matricule }}</p>
            </div>

            {{-- Nom complet --}}
            <div class="p-4 bg-slate-50/60 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Nom complet</p>
                <p class="text-xs font-bold text-slate-800">{{ $employee->prenom }} {{ $employee->nom }}</p>
            </div>

            {{-- Poste --}}
            <div class="p-4 bg-slate-50/60 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Poste</p>
                <p class="text-xs font-bold text-slate-800">{{ $employee->poste ?? '-' }}</p>
            </div>

            {{-- Rôle --}}
            <div class="p-4 bg-slate-50/60 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Rôle</p>
                <p class="text-xs font-bold text-slate-800">{{ $employee->role ?? '-' }}</p>
            </div>

            {{-- Service --}}
            <div class="p-4 bg-slate-50/60 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Service</p>
                <p class="text-xs font-bold text-slate-800">{{ $employee->service ?? '-' }}</p>
            </div>

            {{-- Email --}}
            <div class="p-4 bg-slate-50/60 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Email</p>
                <p class="text-xs font-bold text-slate-800 truncate" title="{{ $employee->email }}">{{ $employee->email }}</p>
            </div>

            {{-- Contact + WhatsApp --}}
            <div class="sm:col-span-2 md:col-span-3 p-4 bg-slate-50/60 rounded-2xl border border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Contact</p>
                    <p class="text-xs font-bold text-slate-800">{{ $employee->contact ?? '-' }}</p>
                </div>

                @if(!empty($employee->contact))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $employee->contact) }}?text=Bonjour%20{{ urlencode($employee->prenom) }}%20!%20👋"
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-500/20 transition-all active:scale-95 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4 mr-2">
                            <path d="M20.52 3.48A11.76 11.76 0 0 0 3.47 20.53l-1.2 4.39 4.51-1.18A11.76 11.76 0 1 0 20.52 3.48Zm-8.4 18a9.57 9.57 0 0 1-4.87-1.34l-.35-.2-2.64.69.71-2.56-.23-.38a9.54 9.54 0 1 1 7.38 3.79Zm5.43-7.21c-.3-.15-1.76-.86-2.03-.96s-.47-.15-.67.15-.76.95-.93 1.15-.34.23-.64.08a7.87 7.87 0 0 1-2.31-1.42 8.64 8.64 0 0 1-1.6-2 2.31 2.31 0 0 1 .14-.7c.15-.15.4-.46.54-.62a2.36 2.36 0 0 0 .36-.61.71.71 0 0 0-.03-.67c-.08-.15-.67-1.62-.91-2.21s-.48-.5-.67-.51h-.57a1.11 1.11 0 0 0-.8.37 3.32 3.32 0 0 0-1.03 2.46 5.77 5.77 0 0 0 1.22 3.09 13.18 13.18 0 0 0 5.06 4.51c.63.27 1.13.43 1.51.55a3.63 3.63 0 0 0 1.66.1 2.71 2.71 0 0 0 1.78-1.26 2.23 2.23 0 0 0 .16-1.26c-.06-.11-.27-.18-.57-.32Z"/>
                        </svg>
                        WhatsApp
                    </a>
                @endif
            </div>
        </div>

    </div>
@endsection