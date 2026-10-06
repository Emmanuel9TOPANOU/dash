@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-900">Créer un Document Commercial</h1>
                <p class="text-xs font-semibold text-slate-500 mt-1">Générez une nouvelle facture ou un devis.</p>
            </div>
            <a href="{{ route('commercial.index') }}"
                class="inline-flex items-center space-x-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-3 rounded-2xl transition">
                <i class="fas fa-arrow-left"></i>
                <span>Retour</span>
            </a>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm">
            <form action="{{ route('commercial-documents.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Type de Document </label>
                        <select name="type" required
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                            <option value="devis" @selected(old('type', $type) === 'devis')>Devis</option>
                            <option value="facture" @selected(old('type', $type) === 'facture')>Facture</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Date d'émission </label>
                        <input type="date" name="date_emission" value="{{ old('date_emission', now()->toDateString()) }}"
                            required
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Client </label>
                        <select name="client_id" required
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                            <option value="">Sélectionnez un client</option>
                            @foreach ($clients ?? [] as $client)
                                <option value="{{ $client->id }}" @selected((string) old('client_id') === (string) $client->id)>{{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-2">Date d'échéance</label>
                        <input type="date" name="date_echeance" value="{{ old('date_echeance') }}"
                            class="w-full text-xs font-bold rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-amber-500/20 p-3.5 bg-slate-50/50">
                    </div>
                  
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-sm font-extrabold text-slate-800">Prestations</h2>
                            <p class="text-xs text-slate-500">Le total du document sera calculé à partir des lignes.</p>
                        </div>
                        <button type="button" id="add-item"
                            class="shrink-0 rounded-xl bg-slate-100 px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-200">
                            <i class="fas fa-plus mr-1" aria-hidden="true"></i> Ajouter une ligne
                        </button>
                    </div>
                    <div id="items-container" class="space-y-4"></div>
                </div>

                <template id="item-template">
                    <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 rounded-2xl border border-slate-200 p-4">
                        <div class="md:col-span-4">
                            <label for="service-__INDEX__" class="mb-2 block text-xs font-bold text-slate-700">Service du
                                catalogue</label>
                            <select id="service-__INDEX__" name="items[__INDEX__][service_id]"
                                class="service-select w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-xs font-semibold">
                                <option value="">Saisie manuelle</option>
                                @foreach ($services ?? [] as $service)
                                    <option value="{{ $service->id }}" data-designation="{{ $service->nom }}"
                                        data-price="{{ $service->prix }}">{{ $service->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-5">
                            <label for="designation-__INDEX__"
                                class="mb-2 block text-xs font-bold text-slate-700">Désignation *</label>
                            <input id="designation-__INDEX__" name="items[__INDEX__][designation]" type="text" required
                                value=""
                                class="designation w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-xs font-semibold">
                        </div>
                        <div class="md:col-span-3">
                            <label for="description-__INDEX__"
                                class="mb-2 block text-xs font-bold text-slate-700">Détail</label>
                            <input id="description-__INDEX__" name="items[__INDEX__][description]" type="text"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-xs font-semibold">
                        </div>
                        <div class="md:col-span-3">
                            <label for="quantity-__INDEX__" class="mb-2 block text-xs font-bold text-slate-700">Quantité
                                *</label>
                            <input id="quantity-__INDEX__" name="items[__INDEX__][quantite]" type="number" min="1"
                                step="1" required value="1"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-xs font-semibold">
                        </div>
                        <div class="md:col-span-4">
                            <label for="unit-price-__INDEX__" class="mb-2 block text-xs font-bold text-slate-700">Prix
                                unitaire (FCFA) *</label>
                            <input id="unit-price-__INDEX__" name="items[__INDEX__][prix_unitaire]" type="number"
                                min="0" step="0.01" required value=""
                                class="unit-price w-full rounded-xl border-slate-200 bg-slate-50 p-3 text-xs font-semibold">
                        </div>
                        <div class="md:col-span-5 flex items-end justify-between gap-3">
                            <span class="text-xs text-slate-500">Montant ligne calculé automatiquement</span>
                            <button type="button" class="remove-item rounded-lg p-2 text-rose-600 hover:bg-rose-50"
                                title="Supprimer cette ligne" aria-label="Supprimer cette ligne">
                                <i class="fas fa-trash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </template>

              

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-6 py-3.5 rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
                        Enregistrer le document
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('items-container');
            const template = document.getElementById('item-template');
            let itemIndex = 0;

            const fillFromService = (row, select) => {
                const option = select.selectedOptions[0];
                if (!option || !option.value) return;

                row.querySelector('.designation').value = option.dataset.designation;
                row.querySelector('.unit-price').value = option.dataset.price;
            };

            const addItem = (item = {}) => {
                const markup = template.innerHTML.replaceAll('__INDEX__', itemIndex++);
                container.insertAdjacentHTML('beforeend', markup);
                const row = container.lastElementChild;
                const serviceSelect = row.querySelector('.service-select');

                serviceSelect.value = item.service_id ?? '';
                row.querySelector('.designation').value = item.designation ?? '';
                row.querySelector('[name$="[description]"]').value = item.description ?? '';
                row.querySelector('[name$="[quantite]"]').value = item.quantite ?? 1;
                row.querySelector('.unit-price').value = item.prix_unitaire ?? '';

                if (serviceSelect.value && !item.designation) fillFromService(row, serviceSelect);
            };

            document.getElementById('add-item').addEventListener('click', () => addItem());
            container.addEventListener('change', (event) => {
                if (event.target.matches('.service-select')) {
                    fillFromService(event.target.closest('.item-row'), event.target);
                }
            });
            container.addEventListener('click', (event) => {
                const removeButton = event.target.closest('.remove-item');
                if (removeButton) removeButton.closest('.item-row').remove();
            });

            const previousItems = @json(old('items', []));
            if (previousItems.length) previousItems.forEach(addItem);
            else addItem();
        });
    </script>
@endsection
