@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Gestion Commerciale</h1>
            <p class="text-xs font-semibold text-slate-500 mt-1">Suivi de vos devis, factures et documents commerciaux.</p>
        </div>
        <a href="{{ route('commercial-documents.create') }}" class="inline-flex items-center justify-center space-x-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-4 py-3 rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
            <i class="fas fa-plus"></i>
            <span>Nouveau Document</span>
        </a>
    </div>

    <!-- Cartes Résumé -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Factures payées</p>
            <p class="text-2xl font-black text-emerald-600 mt-2">0 FCFA</p>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Factures en attente</p>
            <p class="text-2xl font-black text-amber-500 mt-2">0 FCFA</p>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Devis envoyés</p>
            <p class="text-2xl font-black text-slate-900 mt-2">0</p>
        </div>
    </div>

    <!-- Tableau des documents -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                        <th class="py-4 px-6">N° Document</th>
                        <th class="py-4 px-6">Type</th>
                        <th class="py-4 px-6">Client</th>
                        <th class="py-4 px-6">Montant TTC</th>
                        <th class="py-4 px-6">Statut</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                    @forelse($documents ?? [] as $doc)
                        <tr class="hover:bg-amber-50/40 transition">
                            <td class="py-4 px-6 font-bold text-slate-900">{{ $doc->reference }}</td>
                            <td class="py-4 px-6 uppercase">{{ $doc->type }}</td>
                            <td class="py-4 px-6">{{ $doc->client->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6 font-bold">{{ number_format($doc->total_amount ?? 0, 0, ',', ' ') }} FCFA</td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-slate-100 text-slate-600">
                                    {{ $doc->status ?? 'Brouillon' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('commercial-documents.show', $doc) }}" class="p-2 text-slate-400 hover:text-amber-600 transition"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('commercial-documents.pdf', $doc) }}" class="p-2 text-slate-400 hover:text-rose-600 transition"><i class="fas fa-file-pdf"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fas fa-file-invoice-dollar text-4xl mb-3 opacity-40"></i>
                                <p class="text-xs font-bold">Aucun document commercial enregistré.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection