@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Document : {{ $document->reference ?? 'FAC-000' }}</h1>
            <p class="text-xs font-semibold text-slate-500 mt-1">Détail du document commercial.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('commercial.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-3 rounded-2xl transition">
                <i class="fas fa-arrow-left mr-1"></i> Retour
            </a>
            @if(isset($document))
                <a href="{{ route('commercial-documents.pdf', $document) }}" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold px-4 py-3 rounded-2xl shadow-lg shadow-rose-500/20 transition">
                    <i class="fas fa-file-pdf mr-1"></i> Télécharger PDF
                </a>
            @endif
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex justify-between items-start border-b border-slate-100 pb-6">
            <div>
                <p class="text-xs uppercase font-extrabold text-slate-400">Client</p>
                <p class="text-lg font-black text-slate-900 mt-1">{{ $document->client->name ?? 'N/A' }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs uppercase font-extrabold text-slate-400">Type</p>
                <p class="text-lg font-black text-amber-600 uppercase mt-1">{{ $document->type ?? 'Facture' }}</p>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <p class="text-xs font-bold text-slate-500">Montant total</p>
            <p class="text-2xl font-black text-slate-900">{{ number_format($document->total_amount ?? 0, 0, ',', ' ') }} FCFA</p>
        </div>
    </div>
</div>
@endsection