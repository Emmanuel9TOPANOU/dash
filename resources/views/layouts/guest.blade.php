<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Elvirex RH') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .glass-container {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="antialiased bg-slate-950">
    <div class="relative min-h-screen flex flex-col justify-center items-center px-4 py-12">

        {{-- Arrière-plan avec dégradé directionnel --}}
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ asset('images/bg-office.jpg') }}" alt="Fond" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900/95 to-amber-950/30"></div>
        </div>

        {{-- Logo animé --}}
        <div class="relative z-10 mb-8 transform transition-transform hover:scale-105 duration-500">
            <a href="/" class="flex flex-col items-center">
                <div class="bg-white p-5 rounded-[2rem] shadow-2xl shadow-black/50">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo ELVIREX" class="h-14 w-auto">
                </div>
            </a>
        </div>

        {{-- Conteneur de contenu (Slot) --}}
        <div
            class="relative z-10 w-full sm:max-w-[480px] px-8 py-10 glass-container shadow-[0_35px_60px_-15px_rgba(0,0,0,0.6)] overflow-hidden rounded-[3rem]">

            {{-- Décoration interne subtile --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>

            <div class="relative">
                {{ $slot }}
            </div>
        </div>

        {{-- Footer du Layout --}}
        <div class="relative z-10 mt-10 flex flex-col items-center space-y-2">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]">
                &copy; {{ date('Y') }} ELVIREX <span class="text-amber-500">RH</span>
            </p>
            <div class="flex items-center space-x-2">
                <div class="h-[1px] w-8 bg-slate-800"></div>
                <span class="text-[8px] font-bold text-slate-500 uppercase tracking-widest italic">Digital
                    Experience</span>
                <div class="h-[1px] w-8 bg-slate-800"></div>
            </div>
        </div>
    </div>
</body>

</html>
