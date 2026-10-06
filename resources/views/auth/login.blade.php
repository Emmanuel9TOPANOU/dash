<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur - ELVIREX</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animation d’apparition fluide */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out forwards;
        }

        .login-card {
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.35);
        }

        .form-field {
            transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
        }

        .form-field:focus {
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans relative overflow-hidden min-h-screen">

    {{--  Image de fond --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/bg-office.jpg') }}" alt="Bureau Elvirex"
            class="w-full h-full object-cover brightness-50">
    </div>

    {{--  Dégradé sombre par-dessus pour plus de lisibilité --}}
    <div class="absolute inset-0 bg-black/45 backdrop-blur-sm"></div>

    {{--  Conteneur principal --}}
    <div class="relative flex items-center justify-center min-h-screen p-4">

        {{--  Carte de connexion --}}
        <div
            class="login-card w-full max-w-md rounded-3xl border border-white/25 bg-white/95 p-6 sm:p-8 backdrop-blur-md fade-in">

            {{-- Logo --}}
            <div class="mb-6 flex justify-center">
                <div class="rounded-2xl border border-yellow-200/70 bg-yellow-50 px-5 py-3 shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo ELVIREX" class="h-14 sm:h-16">
                </div>
            </div>
            <a href="{{ url('/') }}"
                class="mb-5 flex items-center justify-center gap-2 text-sm font-semibold text-gray-500 transition-colors hover:text-yellow-600">
                <span aria-hidden="true">←</span>
                Retour à l'accueil
            </a>

            {{-- Titre --}}
            <h2 class="text-center text-2xl font-extrabold text-gray-900 sm:text-3xl">Connexion Administrateur</h2>

            {{--  Formulaire --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="Entrez votre email"
                        class="form-field w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 outline-none placeholder-gray-400 focus:border-yellow-400 focus:bg-white focus:ring-2 focus:ring-yellow-200">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div x-data="{ showPassword: false }">
                    <label for="password" class="mb-1.5 block text-sm font-semibold text-gray-700">Mot de passe</label>
                    <div class="relative">
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required
                            placeholder="Entrez votre mot de passe"
                            class="form-field w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 pr-11 text-gray-900 outline-none placeholder-gray-400 focus:border-yellow-400 focus:bg-white focus:ring-2 focus:ring-yellow-200">
                        <button type="button" @click="showPassword = !showPassword"
                            :aria-label="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
                            :title="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 transition-colors hover:text-gray-700 focus:outline-none focus:text-yellow-600">
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m3 3 18 18M10.584 10.587A2 2 0 0 0 13.414 13.4M9.88 4.24A9.68 9.68 0 0 1 12 4c4.478 0 8.268 2.943 9.542 7a9.77 9.77 0 0 1-4.132 5.01M6.228 6.228A9.77 9.77 0 0 0 2.458 11c1.274 4.057 5.065 7 9.542 7 1.61 0 3.128-.38 4.47-1.05" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Bouton --}}
                <button type="submit"
                    class="w-full rounded-xl border border-yellow-300 bg-yellow-400 py-3 font-bold text-gray-950 shadow-lg shadow-yellow-900/20 transition duration-300 hover:-translate-y-0.5 hover:bg-yellow-300 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 active:translate-y-0">
                    Se connecter
                </button>
            </form>

            {{-- Lien inscription --}}
            <p class="mt-5 text-center text-sm text-gray-600">
                Pas encore de compte ?
                <a href="{{ route('register') }}"
                    class="font-semibold text-yellow-600 transition-colors hover:text-yellow-700 hover:underline">
                    Créer un compte administrateur
                </a>
            </p>

            
        </div>
    </div>

</body>

</html>
