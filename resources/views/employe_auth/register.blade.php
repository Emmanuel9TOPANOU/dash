<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">
    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-10">

        {{-- Image de fond --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/bg-office.jpg') }}" alt="Bureau ELVIREX"
                class="w-full h-full object-cover brightness-50">
        </div>

        {{-- Overlay sombre --}}
        <div class="absolute inset-0 bg-black/40"></div>

        {{-- Conteneur d'inscription --}}
        <div
            class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur-md shadow-xl rounded-2xl px-6 sm:px-8 py-10">

            {{-- Logo et titre --}}
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo ELVIREX" class="h-16 mb-3">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 text-center">Créer un compte employé</h2>
            </div>

            {{-- Formulaire --}}
            <form method="POST" action="{{ route('employe.register.submit') }}" class="space-y-5">
                @csrf

                {{-- Matricule --}}
                <div class="space-y-1">
                    <label for="matricule" class="block text-gray-700 font-medium">Matricule</label>
                    <div>
                        <input type="text" id="matricule" name="matricule" value="{{ old('matricule') }}" required
                            class="w-full mt-1 px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 text-gray-800"
                            placeholder="EX : EMP-2026">
                    </div>
                    @error('matricule')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Clé de sécurité (Mot de passe) --}}
                <div x-data="{ showPassword: false }">
                    <label for="mot_de_passe" class="block text-gray-700 font-medium">Mot de passe</label>
                    <div class="relative mt-1">
                        <input :type="showPassword ? 'text' : 'password'" id="mot_de_passe" name="mot_de_passe" required
                            minlength="6"
                            class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 text-gray-800"
                            placeholder="••••••••">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 012.122-.063c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21f-3-3m-3-3l-3.875-3.875M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('mot_de_passe')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmation --}}
                <div x-data="{ showConfirmPassword: false }">
                    <label for="mot_de_passe_confirmation" class="block text-gray-700 font-medium">Confirmer le mot de
                        passe</label>
                    <div class="relative mt-1">
                        <input :type="showConfirmPassword ? 'text' : 'password'" id="mot_de_passe_confirmation"
                            name="mot_de_passe_confirmation" required
                            class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 text-gray-800"
                            placeholder="••••••••">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg x-show="!showConfirmPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showConfirmPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 012.122-.063c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21f-3-3m-3-3l-3.875-3.875M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('mot_de_passe_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bouton --}}
                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-black text-white font-semibold py-2.5 rounded-md transition">
                        Créer mon compte
                    </button>
                </div>

                {{-- Retour --}}
                <div class="text-center text-gray-600 text-sm mt-4">
                    <p>
                        Déjà inscrit ?
                        <a href="{{ route('employe.login') }}" class="text-black font-medium hover:underline">
                            Se connecter
                        </a>
                    </p>
                </div>
            </form>

        
        </div>
    </div>
</body>

</html>
