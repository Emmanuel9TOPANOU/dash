<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Matricule --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Matricule</label>
        <input type="text" name="matricule" value="{{ old('matricule', $employee->matricule ?? '') }}"
               placeholder="EX: EMP-2026-001"
               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none">
        @error('matricule') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Nom --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nom *</label>
        <input type="text" name="nom" value="{{ old('nom', $employee->nom ?? '') }}" required
               placeholder="Entrez le nom"
               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none">
        @error('nom') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Prénom --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Prénom *</label>
        <input type="text" name="prenom" value="{{ old('prenom', $employee->prenom ?? '') }}" required
               placeholder="Entrez le prénom"
               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none">
        @error('prenom') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Sexe --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sexe</label>
        <div class="relative">
            <select name="sexe" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none appearance-none">
                <option value="M" {{ old('sexe', $employee->sexe ?? '') === 'M' ? 'selected' : '' }}>Masculin (M)</option>
                <option value="F" {{ old('sexe', $employee->sexe ?? '') === 'F' ? 'selected' : '' }}>Féminin (F)</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </div>
        </div>
        @error('sexe') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Rôle / Fonction --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Rôle / Fonction</label>
        <div class="relative">
            <select name="role" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none appearance-none">
                <option value="">-- Sélectionner --</option>
                <option value="Employée" {{ old('role', $employee->role ?? '') === 'Employée' ? 'selected' : '' }}>Employée</option>
                <option value="Secrétaire" {{ old('role', $employee->role ?? '') === 'Secrétaire' ? 'selected' : '' }}>Secrétaire</option>
                <option value="rh" {{ old('role', $employee->role ?? '') === 'rh' ? 'selected' : '' }}>RH</option>
                <option value="comptable" {{ old('role', $employee->role ?? '') === 'comptable' ? 'selected' : '' }}>Comptable</option>
                <option value="communication" {{ old('role', $employee->role ?? '') === 'communication' ? 'selected' : '' }}>Chargé de communication</option>
                <option value="stagiaire" {{ old('role', $employee->role ?? '') === 'stagiaire' ? 'selected' : '' }}>Stagiaire</option>
                <option value="manager" {{ old('role', $employee->role ?? '') === 'manager' ? 'selected' : '' }}>Manager</option>
                <option value="directeur" {{ old('role', $employee->role ?? '') === 'directeur' ? 'selected' : '' }}>Directeur</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </div>
        </div>
        @error('role') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email *</label>
        <input type="email" name="email" value="{{ old('email', $employee->email ?? '') }}" required
               placeholder="exemple@elvirex.com"
               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none">
        @error('email') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Poste --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Poste</label>
        <input type="text" name="poste" value="{{ old('poste', $employee->poste ?? '') }}"
               placeholder="Intitulé du poste"
               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none">
        @error('poste') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Service --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Service</label>
        <input type="text" name="service" value="{{ old('service', $employee->service ?? '') }}"
               placeholder="Département ou service"
               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none">
        @error('service') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Contact --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Contact</label>
        <input type="text" name="contact" value="{{ old('contact', $employee->contact ?? '') }}"
               placeholder="Numéro de téléphone"
               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none">
        @error('contact') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Type de contrat --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Type de Contrat</label>
        <div class="relative">
            <select name="type_contrat" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none appearance-none">
                <option value="CDI" {{ old('type_contrat', $employee->type_contrat ?? '') === 'CDI' ? 'selected' : '' }}>CDI</option>
                <option value="CDD" {{ old('type_contrat', $employee->type_contrat ?? '') === 'CDD' ? 'selected' : '' }}>CDD</option>
                <option value="Stage" {{ old('type_contrat', $employee->type_contrat ?? '') === 'Stage' ? 'selected' : '' }}>Stage</option>
                <option value="Freelance" {{ old('type_contrat', $employee->type_contrat ?? '') === 'Freelance' ? 'selected' : '' }}>Freelance</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </div>
        </div>
        @error('type_contrat') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Date d'embauche --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Date d'embauche</label>
        <input type="date" name="date_embauche" value="{{ old('date_embauche', isset($employee->date_embauche) ? (is_string($employee->date_embauche) ? $employee->date_embauche : $employee->date_embauche->format('Y-m-d')) : '') }}"
               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none">
        @error('date_embauche') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Salaire de base --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Salaire de base (FCFA)</label>
        <input type="number" step="0.01" name="salaire" value="{{ old('salaire', $employee->salaire ?? 0) }}"
               placeholder="0"
               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none">
        @error('salaire') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Primes --}}
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Primes / Indemnités (FCFA)</label>
        <input type="number" step="0.01" name="prime" value="{{ old('prime', $employee->prime ?? 0) }}"
               placeholder="0"
               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none">
        @error('prime') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- Photo de l'employé --}}
    <div class="md:col-span-2">
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Photo de l'employé</label>
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 bg-slate-50 border border-slate-200 rounded-2xl">
            <input type="file" name="photo"
                class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-500/10 file:text-amber-700 hover:file:bg-amber-500/20 transition-all cursor-pointer">
            
            @if(isset($employee) && $employee->photo)
                <div class="flex items-center gap-3 shrink-0 pl-0 sm:pl-4 border-t sm:border-t-0 sm:border-l border-slate-200 pt-3 sm:pt-0 w-full sm:w-auto">
                    <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo de {{ $employee->nom }}"
                        class="w-14 h-14 object-cover rounded-2xl border-2 border-amber-400 shadow-sm">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Photo actuelle</p>
                        <p class="text-xs font-semibold text-slate-700 truncate max-w-[120px]">{{ $employee->nom }}</p>
                    </div>
                </div>
            @endif
        </div>
        @error('photo') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>
</div>