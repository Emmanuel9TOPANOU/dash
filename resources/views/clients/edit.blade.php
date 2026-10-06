@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-900">Modifier le Client</h1>
                <p class="text-xs font-semibold text-slate-500 mt-1">Mise à jour des coordonnées client.</p>
            </div>
            <a href="{{ route('clients.index') }}"
                class="inline-flex items-center space-x-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-3 rounded-2xl transition">
                <i class="fas fa-arrow-left"></i>
                <span>Retour</span>
            </a>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm">
            <form action="{{ route('clients.update', $client) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Nom / Raison Sociale *</label>
                    <input type="text" name="name" value="{{ old('name', $client->name) }}" required
                        class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Adresse Email</label>
                        <input type="email" name="email" value="{{ old('email', $client->email) }}"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $client->phone) }}"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Adresse physique *</label>
                    <textarea name="address" rows="3" required
                        class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">{{ old('address', $client->address) }}</textarea>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-6 py-3.5 rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
