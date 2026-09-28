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
        .premium-shadow {
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.08);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased flex items-center justify-center min-h-screen p-4">

    {{-- Décoration de fond minimale --}}
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-amber-500/5 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-slate-200/50 rounded-full blur-[100px]">
        </div>
    </div>

    <div class="relative z-10 w-full max-w-[500px]">

        {{-- Header du Card --}}
        <div class="text-center mb-10 group">
            <div
                class="inline-block bg-white p-4 rounded-3xl premium-shadow mb-6 transition-transform duration-500 group-hover:scale-105">
                <img src="{{ asset('images/logo.png') }}" alt="Logo ELVIREX" class="h-10 w-auto">
            </div>

            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-amber-600 block">Espace
                    Collaborateur</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight italic">
                    ELVIREX <span class="text-slate-400 font-light">SYSTEMS</span>
                </h1>
            </div>
        </div>

        {{-- Conteneur Blanc Premium --}}
        <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-100 overflow-hidden">
            <div class="p-8 sm:p-10">
                @yield('content')
            </div>

            {{-- Footer interne discret --}}
            <div class="bg-slate-50/50 border-t border-slate-50 py-4 px-10">
                <div class="flex items-center justify-between">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest italic">Sécurité Niveau
                        1</span>
                    <div class="flex space-x-1">
                        <div class="w-1 h-1 bg-slate-200 rounded-full"></div>
                        <div class="w-1 h-1 bg-slate-200 rounded-full"></div>
                        <div class="w-1 h-1 bg-slate-200 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer externe --}}
        <div class="mt-12 text-center">
            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.5em]">
                &copy; {{ date('Y') }} Elvirex Group
            </p>
            <p class="text-[8px] font-bold text-slate-400/60 uppercase tracking-widest mt-2">
                Plateforme de Gestion RH Intégrée
            </p>
        </div>
    </div>

</body>

</html>
