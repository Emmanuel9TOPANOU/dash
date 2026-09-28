@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Créer un Document Commercial</h1>
            <p class="text-xs font-semibold text-slate-500 mt-1">Générez une nouvelle facture ou un devis.</p>
        </div>
        <a href="{{ route('commercial.index') }}" class="inline-flex items-center space-x-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-3 rounded-2xl transition">
            <i class="fas fa-arrow-left"></i>
            <span>Retour</span>
        </a>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('commercial-documents.store') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Type de Document *</label>
                    <select name="type" required class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                        <option value="facture">Facture</option>
                        <option value="devis">Devis</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Référence / N° *</label>
                    <input type="text" name="reference" placeholder="FAC-2026-001" required class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Client *</label>
                    <select name="client_id" required class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                        <option value="">Sélectionnez un client</option>
                        @foreach($clients ?? [] as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Montant Total TTC (FCFA) *</label>
                    <input type="number" step="0.01" name="total_amount" required class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Statut</label>
                    <select name="status" class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                        <option value="Brouillon">Brouillon</option>
                        <option value="Envoyé">Envoyé</option>
                        <option value="Payé">Payé</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-6 py-3.5 rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
                    Enregistrer le document
                </button>
            </div>
        </form>
    </div>
</div>
@endsection