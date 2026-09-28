@extends('layouts.app')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- En-tête --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-200/80 pb-5">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                Gérez votre profil et consultez votre historique d’activité
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Espace d'administration centralisé pour la gestion de votre compte.
            </p>
        </div>
    </div>

    {{-- Section principale --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Profil + actions --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-8 flex flex-col items-center text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-yellow-400/20 via-amber-400/10 to-transparent"></div>
            
            <div class="relative mb-3 mt-2">
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default-avatar.png') }}"
                    alt="Photo de profil"
                    class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-md ring-1 ring-gray-100">
                <span class="absolute bottom-1 right-1 bg-emerald-500 border-2 border-white w-4 h-4 rounded-full" title="Connecté"></span>
            </div>

            <h3 class="font-bold text-gray-900 text-xl tracking-wide">{{ Auth::user()->name }}</h3>
            <p class="text-gray-500 text-sm mb-3 font-medium">{{ Auth::user()->email }}</p>

            <span class="inline-flex items-center gap-1.5 bg-yellow-50 text-yellow-800 border border-yellow-200/60 px-3.5 py-1 rounded-full text-xs font-semibold tracking-wide mb-6">
                <svg class="w-3.5 h-3.5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Administrateur
            </span>

            {{-- Boutons --}}
            <div class="w-full flex flex-col space-y-3 mt-auto">
                <button id="openEditModal"
                    class="w-full inline-flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 active:scale-[0.99] text-white font-medium py-2.5 px-4 rounded-xl transition-all shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-yellow-500/40">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Modifier le profil
                </button>
                <button id="openPasswordModal"
                    class="w-full inline-flex items-center justify-center gap-2 border border-gray-200 hover:border-gray-300 bg-white hover:bg-gray-50 active:scale-[0.99] text-gray-700 font-medium py-2.5 px-4 rounded-xl transition-all shadow-xs focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Changer le mot de passe
                </button>
            </div>
        </div>

        {{-- Informations du compte --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-8 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2.5 mb-6 border-b border-gray-100 pb-4">
                    <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="text-gray-900 font-bold text-lg">Informations du compte</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-sm">
                    <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-100/80">
                        <p class="text-xs text-gray-400 uppercase font-semibold tracking-wider mb-1">Nom complet</p>
                        <p class="text-gray-900 font-semibold">{{ $admin->name }}</p>
                    </div>
                    <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-100/80">
                        <p class="text-xs text-gray-400 uppercase font-semibold tracking-wider mb-1">Adresse email</p>
                        <p class="text-gray-900 font-semibold truncate" title="{{ $admin->email }}">{{ $admin->email }}</p>
                    </div>
                    <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-100/80">
                        <p class="text-xs text-gray-400 uppercase font-semibold tracking-wider mb-1">Téléphone</p>
                        <p class="text-gray-900 font-semibold">{{ $admin->phone ?? 'Non renseigné' }}</p>
                    </div>
                    <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-100/80">
                        <p class="text-xs text-gray-400 uppercase font-semibold tracking-wider mb-1">Rôle</p>
                        <p class="text-gray-900 font-semibold">Administrateur</p>
                    </div>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-gray-100">
                <button class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 active:scale-[0.99] text-white font-medium px-5 py-2.5 rounded-xl transition-all shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-yellow-500/40">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Enregistrer les modifications
                </button>
            </div>
        </div>
    </div>

    {{-- Statistiques rapides --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 flex items-center justify-between hover:border-yellow-200 transition-all duration-300">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">⚡ Actions ce mois</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-2 tracking-tight">{{ $actionsMois }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-xs">
                ⚡
            </div>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 flex items-center justify-between hover:border-blue-200 transition-all duration-300">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">👥 Employés gérés</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-2 tracking-tight">{{ $employesCount }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-xs">
                👥
            </div>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 flex items-center justify-between hover:border-indigo-200 transition-all duration-300">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">📅 Membre depuis</p>
                <p class="text-xl font-bold text-gray-900 mt-2 tracking-tight">{{ $dateInscription }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-xs">
                📅
            </div>
        </div>
    </div>

    {{-- Historique d’activité --}}
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/40">
            <div>
                <h3 class="text-gray-900 font-bold text-lg">Historique d’activité</h3>
                <p class="text-xs text-gray-500 mt-0.5">Aperçu des dernières actions enregistrées</p>
            </div>
            <a href="#" class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                Voir tout
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50/80 text-gray-400 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Action</th>
                        <th class="px-6 py-3.5">Date & Heure</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach([['Connexion au système', '01-11-2025 à 08:00'],
                            ['Validation absence - WANKOU Warépi', '27-10-2025 à 08:00'],
                            ['Tâche attribuée à TCHIAKPE Marc', '26-10-2025 à 10:00']] as $log)
                        <tr class="hover:bg-yellow-50/30 transition-colors duration-150">
                            <td class="px-6 py-4 flex items-center space-x-3 text-gray-800 font-medium">
                                <span class="w-8 h-8 rounded-lg bg-yellow-100/70 text-yellow-600 flex items-center justify-center text-sm shadow-2xs">⚡</span>
                                <span>{{ $log[0] }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $log[1] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ==================== MODAL MODIFIER PROFIL ==================== --}}
<div id="editModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4 transition-all">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 sm:p-8 transform transition-all border border-gray-100">
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span>✏️</span> Modifier le profil
            </h3>
        </div>
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nom complet</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 rounded-xl text-sm p-3 transition outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 rounded-xl text-sm p-3 transition outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Téléphone</label>
                <input type="text" name="phone" value="{{ Auth::user()->phone }}" class="w-full border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 rounded-xl text-sm p-3 transition outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Photo de profil</label>
                <input type="file" name="photo" class="w-full border border-gray-200 rounded-xl text-sm p-2 text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 transition">
            </div>
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 mt-6">
                <button type="button" id="closeEditModal" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl text-sm transition">Annuler</button>
                <button type="submit" class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-xl text-sm shadow-sm transition">💾 Enregistrer</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL MOT DE PASSE ==================== --}}
<div id="passwordModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4 transition-all">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 sm:p-8 transform transition-all border border-gray-100">
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span>🔒</span> Changer le mot de passe
            </h3>
        </div>
        <form method="POST" action="{{ route('admin.profile.password') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Mot de passe actuel</label>
                <input type="password" name="current_password" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-xl text-sm p-3 transition outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nouveau mot de passe</label>
                <input type="password" name="new_password" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-xl text-sm p-3 transition outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirmer</label>
                <input type="password" name="new_password_confirmation" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-xl text-sm p-3 transition outline-none">
            </div>
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 mt-6">
                <button type="button" id="closePasswordModal" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl text-sm transition">Annuler</button>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl text-sm shadow-sm transition">✅ Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

{{-- Script ouverture / fermeture modals --}}
<script>
    const editModal = document.getElementById('editModal');
    const passwordModal = document.getElementById('passwordModal');
    document.getElementById('openEditModal').addEventListener('click', () => editModal.classList.remove('hidden'));
    document.getElementById('openPasswordModal').addEventListener('click', () => passwordModal.classList.remove('hidden'));
    document.getElementById('closeEditModal').addEventListener('click', () => editModal.classList.add('hidden'));
    document.getElementById('closePasswordModal').addEventListener('click', () => passwordModal.classList.add('hidden'));
</script>
@endsection