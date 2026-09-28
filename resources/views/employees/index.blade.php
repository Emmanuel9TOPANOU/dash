@extends('layouts.app')

@section('content')
    {{-- En-tête avec titre, recherche et actions --}}
    <div class="employees-index flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h2 class="page-title text-2xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                Liste des employés
            </h2>
            <p class="page-subtitle text-xs font-semibold text-slate-400 mt-1">Consultez, recherchez et gérez l'ensemble des
                collaborateurs.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Barre de recherche -->
            <form action="{{ route('employees.index') }}" method="GET" class="flex items-center">
                <div class="relative w-full sm:w-72">
                    <!-- Icône de recherche -->
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <!-- Champ de recherche -->
                    <input type="text" name="search" placeholder="Rechercher un employé..."
                        value="{{ request('search') }}"
                        class="search-input w-full pl-10 pr-12 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 placeholder:text-slate-400 
                                  focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/10 
                                  hover:border-slate-300 hover:shadow-sm
                                  transition-all duration-200 outline-none shadow-sm" />

                    <!-- Bouton de réinitialisation (visible uniquement si une recherche est active) -->
                    @if (request('search'))
                        <a href="{{ route('employees.index') }}"
                            class="search-reset absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @else
                        <!-- Indicateur de raccourci clavier -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <kbd
                                class="search-kbd px-1.5 py-0.5 bg-slate-100 border border-slate-200 rounded-md text-[10px] font-mono text-slate-500">
                                ⌘K
                            </kbd>
                        </div>
                    @endif
                </div>

                <!-- Bouton de recherche -->
                <button type="submit"
                    class="ml-3 inline-flex items-center gap-2 px-5 py-2.5 bg-black text-white text-sm font-medium rounded-xl shadow-sm transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Rechercher
                </button>
            </form>

            <!-- Bouton Ajouter -->
            <a href="{{ route('employees.create') }}"
                class="inline-flex items-center justify-center px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-extrabold rounded-2xl shadow-lg shadow-amber-500/20 transition-all active:scale-95 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </a>
        </div>
    </div>

    {{-- Carte Tableau --}}
    <div
        class="table-card bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-900/5 overflow-hidden transition-colors duration-300">
        {{-- Conteneur scrollable --}}
        <div class="overflow-x-auto">
            <table class="employee-table w-full text-left border-collapse">
                <thead>
                    <tr
                        class="table-head bg-slate-50/80 border-b border-slate-100 text-[11px] font-black uppercase tracking-wider text-slate-400">
                        <th class="px-6 py-4 text-center">Photo</th>
                        <th class="px-6 py-4">Matricule</th>
                        <th class="px-6 py-4">Nom complet</th>
                        <th class="px-6 py-4">Poste</th>
                        <th class="px-6 py-4">Rôle</th>
                        <th class="px-6 py-4">Service</th>
                        <th class="px-6 py-4">Contrat</th>
                        <th class="px-6 py-4">Embauche</th>
                        <th class="px-6 py-4">Salaire base</th>
                        <th class="px-6 py-4">Prime</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                    @forelse($employees as $emp)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            {{-- Photo --}}
                            <td class="px-6 py-4 text-center">
                                @if ($emp->photo)
                                    <img src="{{ asset('storage/' . $emp->photo) }}" alt="Photo de {{ $emp->nom }}"
                                        class="w-10 h-10 rounded-2xl object-cover border-2 border-white shadow-sm mx-auto">
                                @else
                                    <div
                                        class="w-10 h-10 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 mx-auto text-xs font-bold">
                                        –
                                    </div>
                                @endif
                            </td>

                            {{-- Matricule --}}
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-[11px] font-bold text-slate-500">
                                {{ $emp->matricule }}
                            </td>

                            {{-- Nom complet --}}
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900">
                                {{ $emp->prenom }} {{ $emp->nom }}
                                @if ($emp->sexe)
                                    <span class="text-[10px] text-slate-400 font-normal">({{ $emp->sexe }})</span>
                                @endif
                            </td>

                            {{-- Poste --}}
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                {{ $emp->poste ?? '-' }}
                            </td>

                            {{-- Rôle --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($emp->role)
                                    <span
                                        class="role-badge inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-extrabold uppercase tracking-wider bg-amber-500/10 text-amber-700 border border-amber-500/20">
                                        {{ $emp->role }}
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            {{-- Service --}}
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                {{ $emp->service ?? '-' }}
                            </td>

                            {{-- Type de contrat --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="contract-badge inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $emp->type_contrat ?? 'CDI' }}
                                </span>
                            </td>

                            {{-- Date d'embauche --}}
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500 font-normal">
                                {{ $emp->date_embauche ? $emp->date_embauche->format('d/m/Y') : '-' }}
                            </td>

                            {{-- Salaire --}}
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-slate-800 font-bold">
                                {{ number_format($emp->salaire ?? 0, 0, ',', ' ') }} FCFA
                            </td>

                            {{-- Prime --}}
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-emerald-600 font-bold">
                                {{ number_format($emp->prime ?? 0, 0, ',', ' ') }} FCFA
                            </td>

                            {{-- Email --}}
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500 font-normal">
                                {{ $emp->email }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    {{-- Voir --}}
                                    <a href="{{ route('employees.show', $emp) }}"
                                        class="action-btn p-2 bg-slate-100 hover:bg-sky-50 hover:text-sky-600 text-slate-500 rounded-xl transition-all active:scale-95 border border-slate-200/60"
                                        title="Voir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    {{-- Modifier --}}
                                    <a href="{{ route('employees.edit', $emp) }}"
                                        class="action-btn p-2 bg-slate-100 hover:bg-amber-50 hover:text-amber-600 text-slate-500 rounded-xl transition-all active:scale-95 border border-slate-200/60"
                                        title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5h2m2 0h2a2 2 0 012 2v2m0 2v2a2 2 0 01-2 2h-2m-2 0H9a2 2 0 01-2-2v-2m0-2V7a2 2 0 012-2h2z" />
                                        </svg>
                                    </a>

                                    {{-- Supprimer --}}
                                    <form action="{{ route('employees.destroy', $emp) }}" method="POST"
                                        onsubmit="return confirm('Supprimer cet employé ?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="action-btn p-2 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-500 rounded-xl transition-all active:scale-95 border border-slate-200/60"
                                            title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.998-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-12 px-4">
                                <div class="empty-state max-w-xs mx-auto text-center">
                                 
                                    <p class="empty-text text-xs font-bold text-slate-700">
                                        @if (request('search'))
                                            Aucun employé trouvé pour “<span
                                                class="text-amber-600">{{ request('search') }}</span>”
                                        @else
                                            Aucun employé enregistré pour le moment.
                                        @endif
                                    </p>
                                    @if (request('search'))
                                        <a href="{{ route('employees.index') }}"
                                            class="empty-link inline-block mt-3 text-xs font-bold text-amber-600 hover:text-amber-700 underline underline-offset-4">
                                            Réinitialiser la recherche
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if ($employees->hasPages())
        <div class="mt-6">
            {{ $employees->links() }}
        </div>
    @endif

    <style>
        html.admin-dark .employees-index .page-title {
            color: #f8fafc;
        }

        html.admin-dark .employees-index .page-subtitle,
        html.admin-dark .employees-index .text-slate-400,
        html.admin-dark .employees-index .text-slate-500,
        html.admin-dark .employees-index .text-slate-600,
        html.admin-dark .employees-index .text-slate-700,
        html.admin-dark .employees-index .text-slate-800,
        html.admin-dark .employees-index .text-slate-900 {
            color: #e2e8f0;
        }

        html.admin-dark .employees-index .search-input {
            background: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }

        html.admin-dark .employees-index .search-input::placeholder {
            color: #94a3b8;
        }

        html.admin-dark .employees-index .search-reset,
        html.admin-dark .employees-index .search-kbd {
            color: #cbd5e1;
        }

        html.admin-dark .employees-index .search-kbd {
            background: #111827;
            border-color: #334155;
        }

        html.admin-dark .employees-index .table-card {
            background: rgba(15, 23, 42, 0.96);
            border-color: #1f2937;
            box-shadow: 0 18px 45px rgba(2, 6, 23, 0.38);
        }

        html.admin-dark .employees-index .table-head {
            background: rgba(15, 23, 42, 0.9);
            border-color: #1f2937;
            color: #94a3b8;
        }

        html.admin-dark .employees-index .employee-table tbody tr,
        html.admin-dark .employees-index .employee-table tbody {
            border-color: #1f2937;
            color: #e2e8f0;
        }

        html.admin-dark .employees-index .employee-table tbody tr td,
        html.admin-dark .employees-index .employee-table tbody tr th {
            color: #e2e8f0;
        }

        html.admin-dark .employees-index .employee-table tbody tr:hover {
            background: rgba(30, 41, 59, 0.7);
        }

        html.admin-dark .employees-index .employee-table td,
        html.admin-dark .employees-index .employee-table th {
            color: #e2e8f0;
        }

        html.admin-dark .employees-index .role-badge {
            background: rgba(245, 158, 11, 0.12);
            border-color: rgba(245, 158, 11, 0.3);
            color: #fbbf24;
        }

        html.admin-dark .employees-index .contract-badge {
            background: #111827;
            border-color: #334155;
            color: #e2e8f0;
        }

        html.admin-dark .employees-index .action-btn {
            background: #111827;
            border-color: #334155;
            color: #cbd5e1;
        }

        html.admin-dark .employees-index .action-btn:hover {
            background: rgba(30, 41, 59, 0.9);
        }

        html.admin-dark .employees-index .bg-slate-100,
        html.admin-dark .employees-index .bg-slate-50\/80,
        html.admin-dark .employees-index .bg-slate-50 {
            background-color: #111827 !important;
        }

        html.admin-dark .employees-index .empty-state span {
            background: #111827;
            color: #94a3b8;
        }

        html.admin-dark .employees-index .empty-text {
            color: #e2e8f0;
        }

        html.admin-dark .employees-index .empty-link {
            color: #fbbf24;
        }
    </style>
@endsection
