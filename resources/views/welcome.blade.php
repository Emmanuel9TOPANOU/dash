<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur SmartGest</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /*  Animation douce à l’apparition */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.9s ease-out forwards;
        }

        @keyframes buttonTextIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .button-text {
            display: inline-block;
            animation: buttonTextIn 0.7s ease-out 0.45s both;
            transition: transform 0.3s ease;
        }

        .welcome-title {
            animation: buttonTextIn 0.8s ease-out 0.2s both;
        }

        .welcome-description {
            animation: buttonTextIn 0.8s ease-out 0.35s both;
        }

        .group:hover .button-text {
            transform: translateX(2px);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans relative overflow-hidden min-h-screen">

    {{-- Vidéo de fond --}}
    <div class="absolute inset-0">
        <video autoplay muted loop playsinline poster="{{ asset('images/bg-office.jpg') }}"
            class="w-full h-full object-cover">
            <source src="{{ asset('videos/welcome-background.mp4') }}" type="video/mp4">
            <img src="{{ asset('images/bg-office.jpg') }}" alt="Bureau ELVIREX" class="w-full h-full object-cover">
        </video>
    </div>

    {{-- Superposition floutée --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    {{-- Contenu principal --}}
    <div class="relative flex flex-col items-center justify-center min-h-screen px-6 text-center text-white fade-in-up">

        {{-- Logo --}}
        <div class="mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo ELVIREX" class="h-20 sm:h-24 mx-auto drop-shadow-lg">
        </div>

        {{-- Texte principal --}}
        <h1 class="welcome-title text-3xl sm:text-4xl md:text-5xl font-extrabold mb-2">
            Bienvenue sur <span class="">SmartGest</span>
        </h1>
        <p class="welcome-description text-base sm:text-lg md:text-xl text-gray-200 max-w-2xl mx-auto">
            La plateforme de gestion du personnel et de suivi administratif intelligente et fluide.
        </p>

        {{-- Boutons --}}
        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center w-full sm:w-auto">
            <a href="{{ route('employe.login') }}"
                class="group inline-flex items-center justify-center rounded-xl border border-yellow-300/80 bg-yellow-400 px-8 py-3.5 text-sm font-bold text-gray-950 shadow-lg shadow-yellow-950/25 transition duration-300 hover:-translate-y-1 hover:bg-yellow-300 hover:shadow-xl hover:shadow-yellow-950/35 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 focus:ring-offset-gray-900 active:translate-y-0">
                <span class="button-text">Espace Employé</span>
                <span aria-hidden="true"
                    class="ml-2 transition-transform duration-300 group-hover:translate-x-1">→</span>
            </a>
            <a href="{{ route('login') }}"
                class="group inline-flex items-center justify-center rounded-xl border border-yellow-300/80 bg-gray-950/35 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-black/20 backdrop-blur-md transition duration-300 hover:-translate-y-1 hover:border-yellow-200 hover:bg-gray-950/60 hover:text-white hover:shadow-xl hover:shadow-black/30 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 focus:ring-offset-gray-900 active:translate-y-0">
                <span class="button-text">Espace Administrateur</span>
                <span aria-hidden="true"
                    class="ml-2 transition-transform duration-300 group-hover:translate-x-1">→</span>
            </a>
        </div>

        {{-- Footer --}}
        <p class="absolute bottom-6 text-xs sm:text-sm text-gray-300">
            © {{ date('Y') }} <span class="text-yellow-400 font-semibold">ELVIREX</span> — Système de Gestion du
            Personnel.
        </p>
    </div>

</body>

</html>
