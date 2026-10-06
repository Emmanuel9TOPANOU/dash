@extends('layouts.appdash')

@section('content')
    <div class="space-y-8 font-sans max-w-7xl mx-auto px-4 sm:px-6 py-6">
        {{-- En-tête de Section Premium --}}
        <div
            class="relative bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-amber-400 to-amber-600"></div>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="space-y-1">
                  
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Registre des Absences</h2>
                    <p class="text-slate-500 font-medium text-sm">Suivi et historique de vos demandes de congés et absences
                        exceptionnelles.</p>
                </div>

                <a href="{{ route('employe.absences.create') }}"
                    class="group inline-flex items-center space-x-2.5 bg-slate-950  text-white px-6 py-3.5 rounded-2xl font-bold transition-all duration-300 active:scale-95 shrink-0">
                    <div
                        class="w-6 h-6 rounded-lg bg-amber-500/20 flex items-center justify-center text-amber-400 group-hover:scale-110 transition-transform">
                        <i class="fas fa-plus text-xs"></i>
                    </div>
                    <span class="text-sm">Nouvelle Demande</span>
                </a>
            </div>
        </div>

        {{-- Tableau des Absences --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-slate-50/80">
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                Période de l'absence</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                Motif & Raison</th>
                            <th
                                class="px-8 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                Statut Dossier</th>
                            <th
                                class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                Pièces Jointes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($absences as $absence)
                            <tr class="group hover:bg-slate-50/60 transition-colors duration-200">
                                {{-- Période --}}
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-3.5">
                                        <div
                                            class="p-3 bg-slate-50 border border-slate-100 rounded-2xl text-slate-400 group-hover:bg-amber-50 group-hover:text-amber-600 group-hover:border-amber-100 transition-all duration-300">
                                            <i class="far fa-calendar-alt text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900 capitalize">
                                                {{ \Carbon\Carbon::parse($absence->date_debut)->locale('fr')->isoFormat('D MMMM YYYY') }}
                                            </p>
                                            <p
                                                class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5 capitalize">
                                                Jusqu'au
                                                {{ \Carbon\Carbon::parse($absence->date_fin)->locale('fr')->isoFormat('D MMMM YYYY') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Motif --}}
                                <td class="px-8 py-6">
                                    <p
                                        class="text-sm font-semibold text-slate-700 line-clamp-2 group-hover:text-slate-900 transition-colors max-w-md">
                                        {{ $absence->motif }}
                                    </p>
                                </td>

                                {{-- Statut --}}
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $statusClasses = [
                                            'validée' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                            'refusée' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                            'en attente' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                        ];
                                        $currentClass =
                                            $statusClasses[strtolower($absence->statut)] ??
                                            'bg-slate-50 text-slate-600 border-slate-200/60';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-4 py-1.5 rounded-xl border {{ $currentClass }} text-[11px] font-black uppercase tracking-wider shadow-sm gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        {{ $absence->statut }}
                                    </span>
                                </td>

                                {{-- Pièces Jointes --}}
                                <td class="px-8 py-6 text-right">
                                    @if ($absence->justificatif)
                                        <a href="{{ asset('storage/' . $absence->justificatif) }}" target="_blank"
                                            class="inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-amber-500 text-slate-600 hover:text-white transition-all duration-300 shadow-sm border border-slate-200/80 hover:border-amber-500 font-bold text-xs">
                                            <i
                                                class="fas fa-file-pdf text-rose-500 group-hover:text-white transition-colors"></i>
                                            <span>Consulter</span>
                                        </a>
                                    @else
                                        <span
                                            class="text-[11px] font-bold text-slate-300 uppercase tracking-wider italic">Aucun
                                            document</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center">
                                    <div
                                        class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 mb-4 border border-amber-100">
                                        <i class="fas fa-calendar-times text-2xl"></i>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-900">Aucun historique</h3>
                                    <p class="text-slate-400 text-sm font-medium mt-1 max-w-xs mx-auto">Vous n'avez
                                        actuellement aucune demande d'absence enregistrée dans votre dossier.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if (method_exists($absences, 'links'))
            <div class="mt-8 flex justify-center">
                <div class="bg-white px-4 py-2 rounded-2xl border border-slate-100 shadow-sm">
                    {{ $absences->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
