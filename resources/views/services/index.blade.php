@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Services</h1>
            <p class="text-xs font-semibold text-slate-500 mt-1">Catalogue des prestations et services de l'entreprise.</p>
        </div>
        <a href="{{ route('services.create') }}" class="inline-flex items-center justify-center space-x-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-4 py-3 rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
            <i class="fas fa-plus"></i>
            <span>Nouveau Service</span>
        </a>
    </div>

    <!-- Tableau des services -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                        <th class="py-4 px-6">Intitulé du service</th>
                        <th class="py-4 px-6">Description</th>
                        <th class="py-4 px-6">Tarif par défaut</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                    @forelse($services ?? [] as $service)
                        <tr class="hover:bg-amber-50/40 transition">
                            <td class="py-4 px-6 font-bold text-slate-900">{{ $service->name }}</td>
                            <td class="py-4 px-6 text-slate-500">{{ $service->description ?? 'N/A' }}</td>
                            <td class="py-4 px-6 font-bold text-amber-600">{{ number_format($service->price ?? 0, 0, ',', ' ') }} FCFA</td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('services.edit', $service) }}" class="p-2 text-slate-400 hover:text-amber-600 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer ce service ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400">
                                <i class="fas fa-concierge-bell text-4xl mb-3 opacity-40"></i>
                                <p class="text-xs font-bold">Aucun service disponible pour le moment.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection