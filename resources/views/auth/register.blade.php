<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte administrateur | ELVIREX</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">
    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">

        {{-- Image de fond --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/bg-office.jpg') }}" 
                 alt="Bureau ELVIREX" 
                 class="w-full h-full object-cover brightness-50">
        </div>

        {{--  Overlay sombre --}}
        <div class="absolute inset-0 bg-black/40"></div>

        {{--  Contenu principal --}}
        <div class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur-md shadow-xl rounded-2xl px-6 sm:px-8 py-10">
            
            {{--  Logo --}}
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo ELVIREX" class="h-16 mb-3">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 text-center">
                    Créer un compte administrateur
                </h2>
                <p class="text-gray-500 text-sm sm:text-base mt-1 text-center">
                    Rejoignez la plateforme de gestion du personnel ELVIREX
                </p>
            </div>

            {{--  Formulaire --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Nom complet --}}
                <div>
                    <label for="name" class="block text-gray-700 font-medium">Nom complet</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                           class="w-full mt-1 px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 text-gray-800">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-gray-700 font-medium">Adresse e-mail</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                           class="w-full mt-1 px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 text-gray-800">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-gray-700 font-medium">Mot de passe</label>
                    <div class="relative mt-1">
                        <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required
                               class="w-full px-4 py-2.5 pr-11 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 text-gray-800">
                        <button type="button" @click="showPassword = !showPassword"
                                :aria-label="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
                                :title="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-yellow-600">
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 3 18 18M10.584 10.587A2 2 0 0 0 13.414 13.4M9.88 4.24A9.68 9.68 0 0 1 12 4c4.478 0 8.268 2.943 9.542 7a9.77 9.77 0 0 1-4.132 5.01M6.228 6.228A9.77 9.77 0 0 0 2.458 11c1.274 4.057 5.065 7 9.542 7 1.61 0 3.128-.38 4.47-1.05" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmation du mot de passe --}}
                <div x-data="{ showPassword: false }">
                    <label for="password_confirmation" class="block text-gray-700 font-medium">Confirmer le mot de passe</label>
                    <div class="relative mt-1">
                        <input id="password_confirmation" name="password_confirmation" :type="showPassword ? 'text' : 'password'" required
                               class="w-full px-4 py-2.5 pr-11 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 text-gray-800">
                        <button type="button" @click="showPassword = !showPassword"
                                :aria-label="showPassword ? 'Masquer la confirmation du mot de passe' : 'Afficher la confirmation du mot de passe'"
                                :title="showPassword ? 'Masquer la confirmation du mot de passe' : 'Afficher la confirmation du mot de passe'"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-yellow-600">
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 3 18 18M10.584 10.587A2 2 0 0 0 13.414 13.4M9.88 4.24A9.68 9.68 0 0 1 12 4c4.478 0 8.268 2.943 9.542 7a9.77 9.77 0 0 1-4.132 5.01M6.228 6.228A9.77 9.77 0 0 0 2.458 11c1.274 4.057 5.065 7 9.542 7 1.61 0 3.128-.38 4.47-1.05" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{--  Bouton --}}
                <div class="pt-2">
                    <button type="submit"
                          class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2.5 rounded-md transition">
                         Créer mon compte
                    </button>
                </div>

                {{--  Lien vers connexion --}}
                <p class="text-center text-gray-600 text-sm mt-4">
                    Déjà inscrit ? 
                    <a href="{{ route('login') }}" class="text-yellow-600 font-medium hover:underline">
                        Se connecter
                    </a>
                </p>
            </form>

            {{--  Footer --}}
            <p class="text-center text-gray-400 text-xs mt-8">
                © {{ date('Y') }} <span class="text-yellow-500 font-semibold">ELVIREX</span> — Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>
