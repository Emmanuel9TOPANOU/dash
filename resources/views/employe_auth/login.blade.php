<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Employé - ELVIREX</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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

    {{-- Image de fond --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/bg-office.jpg') }}" alt="Bureau Elvirex"
            class="w-full h-full object-cover brightness-50">
    </div>

    {{-- Dégradé sombre par-dessus pour plus de lisibilité --}}
    <div class="absolute inset-0 bg-black/45 backdrop-blur-sm"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div
            class="login-card w-full max-w-md rounded-3xl border border-white/25 bg-white/95 p-6 sm:p-8 backdrop-blur-md fade-in">

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

            <h2 class="text-center text-2xl font-extrabold text-gray-900 sm:text-3xl">Connexion Employé</h2>

            <x-flash-message />

            <form method="POST" action="{{ route('employe.login.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="Entrez votre email"
                        class="form-field w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 outline-none placeholder-gray-400 focus:border-yellow-400 focus:bg-white focus:ring-2 focus:ring-yellow-200">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ showPassword: false }">
                    <label for="mot_de_passe" class="mb-1.5 block text-sm font-semibold text-gray-700">Mot de
                        passe</label>
                    <div class="relative">
                        <input id="mot_de_passe" :type="showPassword ? 'text' : 'password'" name="mot_de_passe" required
                            placeholder="Entrez votre mot de passe"
                            class="form-field w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 pr-11 text-gray-900 outline-none placeholder-gray-400 focus:border-yellow-400 focus:bg-white focus:ring-2 focus:ring-yellow-200">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 transition-colors hover:text-gray-700 focus:outline-none focus:text-yellow-600">
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
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            

                <button type="submit"
                    class="w-full rounded-xl border border-yellow-300 bg-yellow-400 py-3 font-bold text-gray-950 shadow-lg shadow-yellow-900/20 transition duration-300 hover:-translate-y-0.5 hover:bg-yellow-300 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 active:translate-y-0">
                    Se connecter
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-5">
                Pas encore de compte ?
                <a href="{{ route('employe.register') }}"
                    class="font-semibold text-yellow-600 transition-colors hover:text-yellow-700 hover:underline">
                    Créer un compte employé
                </a>
            </p>

          
        </div>
    </div>

</body>

</html>
