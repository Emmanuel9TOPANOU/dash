@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-900">Modifier un Employé</h1>
                <p class="text-xs font-semibold text-slate-500 mt-1">Mettre à jour les informations de
                    {{ $employee->full_name }}</p>
            </div>
            <a href="{{ route('employees.index') }}"
                class="inline-flex items-center space-x-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-3 rounded-2xl transition">
                <i class="fas fa-arrow-left"></i>
                <span>Retour</span>
            </a>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm">
            <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Matricule *</label>
                    <input type="text" name="matricule" value="{{ old('matricule', $employee->matricule) }}" required
                        class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Nom *</label>
                        <input type="text" name="nom" value="{{ old('nom', $employee->nom) }}" required
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Prénom *</label>
                        <input type="text" name="prenom" value="{{ old('prenom', $employee->prenom) }}" required
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Sexe</label>
                        <select name="sexe"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                            <option value="M" {{ old('sexe', $employee->sexe) == 'M' ? 'selected' : '' }}>Masculin
                            </option>
                            <option value="F" {{ old('sexe', $employee->sexe) == 'F' ? 'selected' : '' }}>Féminin
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $employee->email) }}" required
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Contact /
                            Téléphone</label>
                        <input type="text" name="contact" value="{{ old('contact', $employee->contact) }}"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Poste</label>
                        <input type="text" name="poste" value="{{ old('poste', $employee->poste) }}"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Service /
                            Département</label>
                        <input type="text" name="service" value="{{ old('service', $employee->service) }}"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Rôle *</label>
                        <input type="text" name="role" value="{{ old('role', $employee->role) }}" required
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Type de Contrat</label>
                        <input type="text" name="type_contrat"
                            value="{{ old('type_contrat', $employee->type_contrat) }}"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Date d’embauche</label>
                        <input type="date" name="date_embauche"
                            value="{{ old('date_embauche', optional($employee->date_embauche)->format('Y-m-d')) }}"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Photo de profil</label>
                        <input type="file" name="photo"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                        @if ($employee->photo)
                            <small class="text-slate-500 mt-2 block">Une photo est déjà enregistrée.</small>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Salaire de Base</label>
                        <input type="number" step="0.01" name="salaire"
                            value="{{ old('salaire', $employee->salaire) }}"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Prime</label>
                        <input type="number" step="0.01" name="prime" value="{{ old('prime', $employee->prime) }}"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-6 py-3.5 rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
                        Mettre à jour l'employé
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
