@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700">Nom du projet *</label><input
            name="name" required value="{{ old('name', $project->name ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700">Client *</label><select name="client_id" required
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">
            <option value="">Sélectionner</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" @selected((string) old('client_id', $project->client_id ?? '') === (string) $client->id)>{{ $client->name }}</option>
            @endforeach
        </select>
    </div>
    <div><label class="block text-sm font-semibold text-gray-700">Chef de projet</label><select name="manager_id"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">
            <option value="">Non défini</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" @selected((string) old('manager_id', $project->manager_id ?? '') === (string) $employee->id)>{{ $employee->full_name }}</option>
            @endforeach
        </select>
    </div>
    <div><label class="block text-sm font-semibold text-gray-700">Budget</label><input type="number" step="0.01"
            min="0" name="budget" value="{{ old('budget', $project->budget ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700">Avancement (%)</label><input type="number"
            min="0" max="100" name="progress" value="{{ old('progress', $project->progress ?? 0) }}"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700">Date de début</label><input type="date"
            name="starts_at"
            value="{{ old('starts_at', isset($project) && $project->starts_at ? $project->starts_at->format('Y-m-d') : '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700">Date de fin</label><input type="date"
            name="ends_at"
            value="{{ old('ends_at', isset($project) && $project->ends_at ? $project->ends_at->format('Y-m-d') : '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700">Statut</label><select name="status"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">
            @foreach (['planifie' => 'Planifié', 'en_cours' => 'En cours', 'suspendu' => 'Suspendu', 'termine' => 'Terminé'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $project->status ?? 'planifie') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700">Description</label>
        <textarea name="description" rows="4"
            class="mt-1 w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">{{ old('description', $project->description ?? '') }}</textarea>
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
<div class="mt-6 flex justify-end gap-3"><a href="{{ route('projects.index') }}"
        class="rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-700">Annuler</a><button
        class="rounded-lg bg-yellow-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-yellow-700">Enregistrer</button>
</div>
