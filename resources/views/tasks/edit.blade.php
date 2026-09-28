@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Modifier la tâche</h2>
                <p class="mt-1 text-sm text-gray-500">Modifiez les informations de la tâche sélectionnée</p>
            </div>
            <a href="{{ route('tasks.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200">
                Retour
            </a>
        </div>

        {{-- Formulaire --}}
        <form action="{{ route('tasks.update', $task->id) }}" method="POST"
            class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- En-tête du formulaire avec logo --}}
            <div class="flex items-center gap-4 pb-6 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-bold tracking-tight text-amber-500">ELV</span>
                    <span class="text-2xl font-bold tracking-tight text-yellow-500">REX</span>
                </div>
                <div class="h-8 w-px bg-gray-200"></div>
                <span class="text-xs font-medium text-gray-400 tracking-wide uppercase">NOUS VOUS FAISONS GAGNER DU
                    TEMPS</span>
                <span
                    class="ml-auto text-xs font-medium text-amber-500 bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                    ID #{{ $task->id }}
                </span>
            </div>

            {{-- Champ Employé --}}
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                    Employé <span class="text-rose-500">*</span>
                </label>
                <select name="employee_id"
                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                           focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                           hover:border-amber-300 transition-all duration-200 outline-none appearance-none
                           cursor-pointer"
                    required>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}" {{ $task->employee_id == $emp->id ? 'selected' : '' }}>
                            {{ $emp->prenom }} {{ $emp->nom }} ({{ $emp->matricule ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Champ Projet --}}
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">Projet</label>
                <select name="project_id"
                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white hover:border-amber-300 transition-all duration-200 outline-none appearance-none cursor-pointer">
                    <option value="">— Tâche hors projet —</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @selected((string) old('project_id', $task->project_id) === (string) $project->id)>{{ $project->name }} —
                            {{ $project->client->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Champ Description --}}
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                    Description <span class="text-rose-500">*</span>
                </label>
                <textarea name="description" rows="4"
                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                             focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                             hover:border-amber-300 transition-all duration-200 outline-none resize-y"
                    placeholder="Décrivez la tâche à réaliser..." required>{{ $task->description }}</textarea>
            </div>

            {{-- Grille Date / Priorité --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Date limite --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Date limite
                    </label>
                    <input type="date" name="date_limite" value="{{ $task->date_limite }}"
                        class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                              focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                              hover:border-amber-300 transition-all duration-200 outline-none">
                </div>

                {{-- Priorité --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Priorité
                    </label>
                    <select name="priorite"
                        class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                               focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                               hover:border-amber-300 transition-all duration-200 outline-none appearance-none
                               cursor-pointer">
                        <option value="faible" {{ $task->priorite == 'faible' ? 'selected' : '' }}>Basse</option>
                        <option value="moyenne" {{ $task->priorite == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="haute" {{ $task->priorite == 'haute' ? 'selected' : '' }}>Haute</option>
                    </select>
                </div>
            </div>

            {{-- Grille Statut / Évaluation --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Statut --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Statut
                    </label>
                    <select name="statut"
                        class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                               focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                               hover:border-amber-300 transition-all duration-200 outline-none appearance-none
                               cursor-pointer">
                        <option value="en attente" {{ $task->statut == 'en attente' ? 'selected' : '' }}>En attente
                        </option>
                        <option value="en cours" {{ $task->statut == 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="terminée" {{ $task->statut == 'terminée' ? 'selected' : '' }}>Terminée</option>
                    </select>
                </div>

                {{-- Évaluation --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                        Évaluation
                    </label>
                    <input type="text" name="evaluation" value="{{ $task->evaluation }}"
                        placeholder="Ex : Très bien, À améliorer, 8/10..."
                        class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                              focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                              hover:border-amber-300 transition-all duration-200 outline-none">
                </div>
            </div>

            {{-- Commentaire --}}
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">
                    Commentaire
                </label>
                <textarea name="commentaire" rows="3"
                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm
                             focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 focus:bg-white
                             hover:border-amber-300 transition-all duration-200 outline-none resize-y"
                    placeholder="Ajouter un commentaire sur l'avancement de la tâche...">{{ $task->commentaire }}</textarea>
            </div>

            {{-- Boutons d'action --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-yellow-500 
                           hover:from-amber-600 hover:to-yellow-600 active:scale-[0.98]
                           text-white font-semibold px-8 py-3.5 rounded-xl 
                           shadow-lg shadow-amber-500/25 hover:shadow-amber-500/35 
                           transition-all duration-200 text-sm">
                    Mettre à jour
                </button>

                <a href="{{ route('tasks.index') }}"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 
                      text-gray-700 font-medium px-8 py-3.5 rounded-xl transition-all duration-200 text-sm">
                    Annuler
                </a>

                @if ($task->statut !== 'terminée')
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="flex-1 sm:flex-none">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="statut" value="terminée">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <input type="hidden" name="employee_id" value="{{ $task->employee_id }}">
                        <input type="hidden" name="date_limite" value="{{ $task->date_limite }}">
                        <input type="hidden" name="priorite" value="{{ $task->priorite }}">
                        <input type="hidden" name="commentaire" value="{{ $task->commentaire }}">
                        <input type="hidden" name="evaluation" value="{{ $task->evaluation }}">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 active:scale-[0.98]
                                   text-white font-medium px-6 py-3.5 rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/35
                                   transition-all duration-200 text-sm"
                            onclick="return confirm('Marquer cette tâche comme terminée ?')">
                            Marquer terminée
                        </button>
                    </form>
                @endif
            </div>

            {{-- Informations supplémentaires --}}
            <div class="flex flex-wrap items-center gap-4 pt-2 text-xs text-gray-400">
                <span class="flex items-center gap-1">
                    <span class="text-rose-500">*</span> Champs obligatoires
                </span>
                <span class="w-px h-3 bg-gray-200"></span>
                <span>Créée le {{ \Carbon\Carbon::parse($task->created_at)->format('d/m/Y à H:i') }}</span>
                @if ($task->updated_at != $task->created_at)
                    <span class="w-px h-3 bg-gray-200"></span>
                    <span>Dernière modification le
                        {{ \Carbon\Carbon::parse($task->updated_at)->format('d/m/Y à H:i') }}</span>
                @endif
                <span class="w-px h-3 bg-gray-200"></span>
                <span class="text-amber-500 font-medium">ELV REX</span>
            </div>
        </form>

        {{-- Bouton de suppression --}}
        <div class="mt-6 text-center">
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-xs font-medium text-gray-400 hover:text-rose-500 bg-gray-50 hover:bg-rose-50 px-4 py-2 rounded-xl border border-gray-200 hover:border-rose-200 transition-all duration-200"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ? Cette action est irréversible.')">
                    Supprimer cette tâche
                </button>
            </form>
        </div>

        {{-- Pied de page avec le logo --}}
        <div class="mt-8 text-center">
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-gray-50 rounded-2xl border border-gray-100">
                <div class="flex items-center ">
                    <span class="text-lg font-bold tracking-tight text-amber-500">ELVI</span>
                    <span class="text-lg font-bold tracking-tight text-yellow-500">REX</span>
                </div>
                <span class="text-[10px] font-medium text-gray-400 uppercase tracking-widest">● NOUS VOUS FAISONS GAGNER DU
                    TEMPS</span>
            </div>
        </div>
    </div>
@endsection
