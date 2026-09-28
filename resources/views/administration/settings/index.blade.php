@extends(auth()->check() ? 'layouts.app' : 'layouts.appdashadmin')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Informations de l’entreprise</h2>
            <p class="mt-1 text-sm text-gray-500">Gérez les détails officiels et l'identité visuelle de votre structure.</p>
        </div>

        <!-- Notification de succès -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                class="mb-6 flex items-center p-4 rounded-r-lg border-l-4 border-emerald-500 bg-emerald-50 shadow-sm transition-all">
                <svg class="mr-3 h-5 w-5 flex-shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-medium text-emerald-800">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Formulaire principal -->
        <form action="{{ route('administration.settings.update') }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-200">
            @csrf

            <div class="p-6 sm:p-8 space-y-6">
                <!-- Nom & Slogan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'entreprise</label>
                        <input type="text" name="name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-600 outline-none transition"
                            placeholder="Ex: ACME Corp" value="{{ $settings->name ?? '' }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Slogan</label>
                        <input type="text" name="tagline"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-600 outline-none transition"
                            placeholder="Ex: L'innovation au quotidien" value="{{ $settings->tagline ?? '' }}">
                    </div>
                </div>

                <!-- Adresse -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse siège social</label>
                    <textarea name="address" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-600 outline-none transition resize-none"
                        placeholder="Ex: 123 Avenue des Affaires, Cotonou">{{ $settings->address ?? '' }}</textarea>
                </div>

                <!-- Contact : Téléphone & Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                        <input type="text" name="phone"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-600 outline-none transition"
                            placeholder="+229 00 00 00 00" value="{{ $settings->phone ?? '' }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse Email</label>
                        <input type="email" name="email"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-600 outline-none transition"
                            placeholder="contact@entreprise.com" value="{{ $settings->email ?? '' }}">
                    </div>
                </div>

                <!-- Identifiants légaux : RCCM & IFU -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-gray-100">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Numéro RCCM</label>
                        <input type="text" name="rccm"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-600 outline-none transition"
                            value="{{ $settings->rccm ?? '' }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Numéro IFU</label>
                        <input type="text" name="ifu"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-600 outline-none transition"
                            value="{{ $settings->ifu ?? '' }}">
                    </div>
                </div>

                <!-- Logo de l'entreprise -->
                <div class="pt-2 border-t border-gray-100">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Logo de l'entreprise</label>
                    <div class="flex items-center gap-6">
                        @if (!empty($settings->logo))
                            <div class="relative group p-2 bg-gray-50 border border-gray-200 rounded-xl flex-shrink-0">
                                <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo"
                                    class="h-16 w-16 object-contain">
                            </div>
                        @endif

                        <div class="flex-1">
                            <input type="file" name="logo"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 cursor-pointer transition">
                            <p class="mt-1 text-xs text-gray-400">Formats acceptés : PNG, JPG, SVG (Max. 2MB)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pied du formulaire / Actions -->
            <div class="bg-gray-50 px-6 py-4 sm:px-8 border-t border-gray-100 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent font-medium rounded-lg text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 shadow-sm transition">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
@endsection
