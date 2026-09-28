@extends('layouts.appdash')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 font-sans">
    {{-- En-tête Premium --}}
    <div class="relative bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 mb-10 overflow-hidden">
        <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-amber-400 to-amber-600"></div>
        <div class="flex items-center space-x-3 mb-2">
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-amber-50 text-amber-700 border border-amber-200/60">
                Archives de pointage
            </span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Historique des Présences</h2>
        <p class="text-slate-500 text-sm font-medium mt-1">Registre détaillé de vos cycles d'activité</p>
    </div>

    {{-- Liste des présences --}}
    <div class="relative border-l-2 border-slate-200/80 ml-4 sm:ml-6 space-y-8">
        @forelse($attendances as $presence)
            <div class="relative pl-6 sm:pl-8 group">
                {{-- Indicateur de Timeline --}}
                <div class="absolute -left-[9px] top-4 w-4 h-4 rounded-full bg-white border-4 border-slate-300 group-hover:border-amber-500 group-hover:scale-125 transition-all duration-300 shadow-sm"></div>

                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-md shadow-slate-200/40 group-hover:shadow-xl group-hover:shadow-slate-200/60 group-hover:border-slate-200/80 transition-all duration-300">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        {{-- Date en Français --}}
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-400 group-hover:text-amber-500 group-hover:bg-amber-50/50 transition-colors">
                                <i class="far fa-calendar-alt text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Date d'enregistrement</p>
                                <p class="text-base sm:text-lg font-black text-slate-900 leading-none capitalize">
                                    {{ \Carbon\Carbon::parse($presence->date)->locale('fr')->isoFormat('D MMMM YYYY') }}
                                </p>
                            </div>
                        </div>

                        {{-- Statuts --}}
                        <div class="flex flex-wrap items-center gap-2.5">
                            @php
                                $stat = strtolower($presence->statut ?? '');
                                $config = [
                                    'present' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200/60', 'icon' => 'fa-check-circle', 'label' => 'Présent'],
                                    'retard'  => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200/60', 'icon' => 'fa-clock', 'label' => 'Retard'],
                                    'absent'  => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200/60', 'icon' => 'fa-times-circle', 'label' => 'Absent'],
                                    'default' => ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'border' => 'border-slate-200/60', 'icon' => 'fa-minus-circle', 'label' => '—'],
                                ];

                                if(\Illuminate\Support\Str::contains($stat, ['heure', "à l'heure"])) $c = $config['present'];
                                elseif(\Illuminate\Support\Str::contains($stat, 'retard')) $c = $config['retard'];
                                elseif(\Illuminate\Support\Str::contains($stat, 'abs')) $c = $config['absent'];
                                else $c = $config['default'];
                            @endphp

                            <span class="{{ $c['bg'] }} {{ $c['text'] }} {{ $c['border'] }} border text-[11px] font-black uppercase tracking-wider px-3.5 py-1.5 rounded-xl shadow-sm flex items-center gap-1.5">
                                <i class="fas {{ $c['icon'] }} text-xs"></i>
                                {{ $c['label'] }}
                            </span>

                            @if($presence->retard_signale)
                                <span class="bg-indigo-50 text-indigo-700 border border-indigo-200/60 text-[11px] font-black uppercase tracking-wider px-3.5 py-1.5 rounded-xl shadow-sm flex items-center gap-1.5">
                                    <i class="fas fa-file-signature text-xs"></i>
                                    Justifié
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Horaires --}}
                    <div class="mt-6 pt-5 border-t border-slate-100 grid grid-cols-2 gap-4 sm:gap-8">
                        <div class="bg-slate-50/60 border border-slate-100 p-3.5 rounded-xl">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Arrivée</p>
                            <div class="flex items-center space-x-2">
                                <i class="far fa-clock text-amber-500 text-sm"></i>
                                <p class="text-lg sm:text-xl font-extrabold text-slate-800 font-mono leading-none">{{ $presence->heure_arrivee ?? '--:--' }}</p>
                            </div>
                        </div>
                        <div class="bg-slate-50/60 border border-slate-100 p-3.5 rounded-xl">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Départ</p>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-sign-out-alt text-amber-500 text-sm"></i>
                                <p class="text-lg sm:text-xl font-extrabold text-slate-800 font-mono leading-none">{{ $presence->heure_depart ?? '--:--' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white border border-dashed border-slate-200 rounded-3xl shadow-sm">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 mb-4 border border-amber-100">
                    <i class="fas fa-folder-open text-2xl"></i>
                </div>
                <h3 class="text-slate-800 font-bold text-base">Aucun enregistrement</h3>
                <p class="text-slate-400 text-sm font-medium mt-0.5">Aucune présence n'a été trouvée dans votre historique.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination Premium --}}
    @if($attendances->hasPages())
        <div class="mt-12 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            {{ $attendances->links() }}
        </div>
    @endif
</div>
@endsection