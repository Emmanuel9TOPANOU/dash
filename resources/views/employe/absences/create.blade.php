@extends('layouts.appdash')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    {{-- En-tête Institutionnel avec Bouton Raccourci --}}
    <div class="flex flex-col md:flex-row justify-between items-start mb-10">
        <div class="border-l-4 border-amber-500 pl-6">
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Administration RH</span>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight mt-1">Nouvelle Demande</h2>
            <p class="text-slate-500 font-medium mt-1 text-sm">Formulaire de soumission d'absence officielle.</p>
        </div>

        <a href="{{ route('employe.absences.index') }}" 
           class="mt-4 md:mt-0 group flex items-center space-x-2 bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm hover:bg-slate-50 transition-all duration-300">
            <i class="fas fa-list-ul text-amber-500 group-hover:scale-110 transition-transform"></i>
            <span class="text-[11px] font-black uppercase tracking-widest text-slate-600">Voir mes absences</span>
        </a>
    </div>

    {{-- Formulaire Premium --}}
    <form method="POST" action="{{ route('employe.absences.store') }}" enctype="multipart/form-data" 
          class="bg-white rounded-3xl shadow-xl shadow-slate-100/50 border border-slate-100 p-8 md:p-10 space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Date de début --}}
            <div class="space-y-2">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest">Date de début</label>
                <div class="relative">
                    <input type="date" name="date_debut" 
                           class="w-full bg-slate-50 border-none rounded-xl px-4 py-3.5 text-slate-900 font-bold focus:ring-2 focus:ring-amber-500/20 transition-all" 
                           required>
                </div>
            </div>

            {{-- Date de fin --}}
            <div class="space-y-2">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest">Date de fin</label>
                <div class="relative">
                    <input type="date" name="date_fin" 
                           class="w-full bg-slate-50 border-none rounded-xl px-4 py-3.5 text-slate-900 font-bold focus:ring-2 focus:ring-amber-500/20 transition-all" 
                           required>
                </div>
            </div>
        </div>

        {{-- Motif --}}
        <div class="space-y-2">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest">Motif de l'absence</label>
            <input type="text" name="motif" placeholder="Ex: Raison médicale, Congé annuel..."
                   class="w-full bg-slate-50 border-none rounded-xl px-4 py-3.5 text-slate-900 font-semibold focus:ring-2 focus:ring-amber-500/20 transition-all" 
                   required>
        </div>

        {{-- Justificatif --}}
        <div class="space-y-2">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest">Justificatif (PDF ou Image)</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-amber-500">
                    <i class="fas fa-paperclip text-slate-300 text-sm"></i>
                </div>
                <input type="file" name="justificatif" accept=".pdf,.jpg,.jpeg,.png" 
                       class="w-full bg-slate-50 border-none rounded-xl pl-10 pr-4 py-3.5 text-sm text-slate-500 font-medium file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-slate-200 file:text-slate-600 hover:file:bg-slate-300 cursor-pointer">
            </div>
            <p class="text-[10px] text-slate-400 font-medium italic mt-2">Format supporté : PDF, JPG, PNG (Max 2Mo)</p>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between pt-10 border-t border-slate-50">
            <a href="{{ route('employe.absences.index') }}" 
               class="flex items-center space-x-2 text-slate-400 hover:text-slate-900 text-xs font-black uppercase tracking-widest transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Annuler</span>
            </a>
            
            <button type="submit" 
                    class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-4 rounded-2xl font-bold text-sm transition-all duration-300 shadow-lg shadow-slate-200 active:scale-95 flex items-center space-x-3">
                <i class="fas fa-paper-plane text-amber-400 text-xs"></i>
                <span>Soumettre le dossier</span>
            </button>
        </div>
    </form>
</div>
@endsection