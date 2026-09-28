@extends('layouts.appdash')

@section('content')
    <div class="space-y-8">
        {{-- En-tête Institutionnel --}}
        <div class="border-l-4 border-amber-500 pl-6 mb-10">
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Gestion de projet</span>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight mt-1">Mes Missions & Tâches</h2>
            <p class="text-slate-500 font-medium mt-1 text-sm">Suivi opérationnel de vos objectifs et livrables.</p>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                class="flex items-center p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl animate-fade-in transition-all">
                <i class="fas fa-check-circle mr-3 text-emerald-500"></i>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        @if ($tasks->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-300 mb-4">
                    <i class="fas fa-tasks text-2xl"></i>
                </div>
                <p class="text-slate-500 font-bold italic tracking-wide">Aucune mission ne vous est assignée pour le moment.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach ($tasks as $task)
                    <div
                        class="group bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 relative overflow-hidden">
                        {{-- Badge de Priorité --}}
                        <div
                            class="absolute top-0 right-0 px-4 py-1 rounded-bl-2xl text-[9px] font-black uppercase tracking-widest
                        @if ($task->priorite == 'haute') bg-rose-500 text-white
                        @elseif($task->priorite == 'moyenne') bg-amber-500 text-white
                        @else bg-slate-400 text-white @endif">
                            Priorité {{ $task->priorite }}
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-start pt-2">
                                <h3
                                    class="text-lg font-black text-slate-800 leading-tight group-hover:text-amber-600 transition-colors">
                                    {{ Str::limit($task->description, 45) }}
                                </h3>
                            </div>

                            @if ($task->project)
                                <div class="flex items-center gap-2 text-xs font-bold text-amber-700">
                                    <i class="fas fa-briefcase"></i>
                                    <span>{{ $task->project->name }}</span>
                                    <span class="text-slate-400">· {{ $task->project->client->name }}</span>
                                </div>
                            @endif

                            <div class="flex items-center space-x-3">
                                @php
                                    $statusStyle = [
                                        'en attente' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'en cours' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                        'terminée' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    ];
                                    $currentStyle =
                                        $statusStyle[strtolower($task->statut)] ??
                                        'bg-slate-50 text-slate-600 border-slate-100';
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-lg border {{ $currentStyle }} text-[10px] font-black uppercase tracking-widest shadow-sm">
                                    {{ $task->statut }}
                                </span>

                                <button type="button"
                                    onclick="openTaskModal('{{ addslashes($task->description) }}', '{{ $task->priorite }}', '{{ $task->statut }}')"
                                    class="text-slate-400 hover:text-slate-900 text-[11px] font-bold uppercase tracking-tighter flex items-center transition-colors">
                                    <i class="fas fa-plus-circle mr-1 text-[9px]"></i> Détails
                                </button>
                            </div>

                            <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                                <div class="flex items-center text-slate-400">
                                    <i class="far fa-calendar-alt text-xs mr-2"></i>
                                    <span class="text-xs font-bold uppercase tracking-tighter">
                                        Échéance :
                                        {{ $task->date_limite ? \Carbon\Carbon::parse($task->date_limite)->translatedFormat('d M Y') : 'Indéfinie' }}
                                    </span>
                                </div>

                                @if ($task->statut !== 'terminée')
                                    <form method="POST" action="{{ route('employe.taches.done', $task) }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center space-x-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-md shadow-emerald-100 active:scale-95">
                                            <i class="fas fa-check"></i>
                                            <span>Clôturer</span>
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center text-emerald-500 space-x-1">
                                        <i class="fas fa-check-double text-xs"></i>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Complété</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Modale Premium --}}
    <div id="taskModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            {{-- Overlay Blur --}}
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeTaskModal()"></div>

            <div
                class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-all animate-modal-enter">
                <div class="p-8 md:p-10">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Détails de la Mission</h3>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Description
                                Complète</p>
                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 text-slate-700 leading-relaxed font-medium text-sm whitespace-pre-line"
                                id="modal-description"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Urgence</p>
                                <p id="modal-priorite"
                                    class="text-sm font-black text-slate-900 uppercase italic tracking-tighter"></p>
                            </div>
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">État actuel
                                </p>
                                <p id="modal-statut"
                                    class="text-sm font-black text-slate-900 uppercase italic tracking-tighter"></p>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="closeTaskModal()"
                        class="mt-10 w-full py-4 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] transition-all shadow-lg shadow-slate-200">
                        Fermer la fiche
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes modal-enter {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .animate-modal-enter {
            animation: modal-enter 0.3s ease-out;
        }
    </style>

    <script>
        function openTaskModal(description, priorite, statut) {
            document.getElementById('modal-description').innerText = description;
            document.getElementById('modal-priorite').innerText = priorite;
            document.getElementById('modal-statut').innerText = statut;
            document.getElementById('taskModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeTaskModal() {
            document.getElementById('taskModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection
