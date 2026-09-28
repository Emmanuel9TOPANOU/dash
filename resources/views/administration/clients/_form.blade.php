@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700">Nom du client *</label><input
            name="name" required value="{{ old('name', $client->name ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700">Personne à contacter</label><input name="contact_name"
            value="{{ old('contact_name', $client->contact_name ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700">Email</label><input type="email" name="email"
            value="{{ old('email', $client->email ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700">Téléphone</label><input name="phone"
            value="{{ old('phone', $client->phone ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700">Statut</label><select name="status"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">
            <option value="actif" @selected(old('status', $client->status ?? 'actif') === 'actif')>Actif</option>
            <option value="inactif" @selected(old('status', $client->status ?? '') === 'inactif')>Inactif</option>
        </select></div>
    <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700">Adresse</label>
        <textarea name="address" rows="2"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">{{ old('address', $client->address ?? '') }}</textarea>
    </div>
    <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700">Notes</label>
        <textarea name="notes" rows="3"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">{{ old('notes', $client->notes ?? '') }}</textarea>
    </div>
</div>
@if ($errors->any())
    <div class="mt-5 rounded-lg bg-red-50 p-4 text-sm text-red-700">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="mt-6 flex justify-end gap-3"><a href="{{ route('clients.index') }}"
        class="rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-700">Annuler</a><button
        class="rounded-lg bg-yellow-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-yellow-700">Enregistrer</button>
</div>
