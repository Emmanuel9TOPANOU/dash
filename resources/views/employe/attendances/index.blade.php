@extends('layouts.appdash')

@section('content')
<div class="space-y-8">
    {{-- En-tête Institutionnel --}}
    <div class="border-l-4 border-amber-500 pl-6 mb-10">
        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Pointage & Ponctualité</span>
        <h2 class="text-3xl font-black text-slate-900 tracking-tight mt-1">Historique des Présences</h2>
        <p class="text-slate-500 font-medium mt-1 text-sm">Consultez votre registre de présence quotidien et votre ponctualité.</p>
    </div>

    {{-- Conteneur Principal --}}
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-100/50 border border-slate-100 overflow-hidden">
        <div class="p-8 md:p-10">
            @forelse($attendances as $presence)
                <div class="group flex items-center justify-between py-5 border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-all duration-300 -mx-8 px-8">
                    <div class="flex items-center space-x-6">
                        {{-- Indicateur Date --}}
                        <div class="flex flex-col items-center justify-center w-14 h-14 bg-slate-50 rounded-2xl group-hover:bg-white group-hover:shadow-sm transition-all">
                            <span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">
                                {{ \Carbon\Carbon::parse($presence->date)->translatedFormat('M') }}
                            </span>
                            <span class="text-xl font-black text-slate-900 leading-none">
                                {{ \Carbon\Carbon::parse($presence->date)->format('d') }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm font-black text-slate-800 uppercase tracking-tight">
                                {{ \Carbon\Carbon::parse($presence->date)->translatedFormat('l') }}
                            </p>
                            <div class="flex items-center mt-1 text-[11px] font-bold text-slate-400 space-x-3">
                                <span class="flex items-center">
                                    <i class="far fa-clock mr-1 text-amber-500/70"></i> 
                                    {{ $presence->heure_arrivee ?? '--:--' }}
                                </span>
                                <span class="text-slate-200">|</span>
                                <span class="flex items-center">
                                    <i class="fas fa-sign-out-alt mr-1"></i> 
                                    {{ $presence->heure_depart ?? '--:--' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Badge de Statut Premium --}}
                    <div>
                        @php
                            $statusConfig = [
                                'présent' => ['class' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'icon' => 'fa-check-circle'],
                                'absent'  => ['class' => 'bg-rose-50 text-rose-700 border-rose-100', 'icon' => 'fa-times-circle'],
                                'retard'  => ['class' => 'bg-amber-50 text-amber-700 border-amber-100', 'icon' => 'fa-exclamation-circle'],
                            ];
                            $config = $statusConfig[strtolower($presence->statut)] ?? ['class' => 'bg-slate-50 text-slate-500 border-slate-200', 'icon' => 'fa-question-circle'];
                        @endphp
                        
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full border {{ $config['class'] }} text-[10px] font-black uppercase tracking-[0.1em] shadow-sm">
                            <i class="fas {{ $config['icon'] }} mr-2 opacity-70"></i>
                            {{ $presence->statut }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="py-20 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 text-slate-200 mb-4">
                        <i class="fas fa-calendar-alt text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 tracking-tight">Aucun enregistrement</h3>
                    <p class="text-slate-400 text-sm mt-1">Vos données de présence apparaîtront ici après votre premier pointage.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination Stylisée --}}
    @if(method_exists($attendances, 'links'))
        <div class="mt-10 flex justify-center">
            <div class="bg-white px-6 py-2 rounded-2xl border border-slate-100 shadow-sm shadow-slate-100/50">
                {{ $attendances->links() }}
            </div>
        </div>
    @endif
</div>
@endsection