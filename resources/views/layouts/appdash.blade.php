<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Elvirex RH') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        if (localStorage.getItem('employee-theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .employee-brand .bg-amber-500 {
            background-color: #d4af37 !important;
        }

        .employee-brand .bg-amber-400 {
            background-color: #e2c15b !important;
        }

        .employee-brand .bg-amber-100,
        .employee-brand .bg-amber-50 {
            background-color: #fff8db !important;
        }

        .employee-brand .bg-amber-200\/40 {
            background-color: rgb(255 248 219 / 0.4) !important;
        }

        .employee-brand .bg-amber-100\/60 {
            background-color: rgb(255 248 219 / 0.6) !important;
        }

        .employee-brand .bg-amber-50\/50 {
            background-color: rgb(255 248 219 / 0.5) !important;
        }

        .employee-brand .bg-amber-500\/10 {
            background-color: rgb(212 175 55 / 0.1) !important;
        }

        .employee-brand .bg-amber-500\/20 {
            background-color: rgb(212 175 55 / 0.2) !important;
        }

        .employee-brand .text-amber-800,
        .employee-brand .text-amber-700,
        .employee-brand .text-amber-600 {
            color: #ad8618 !important;
        }

        .employee-brand .text-amber-500,
        .employee-brand .text-amber-400 {
            color: #d4af37 !important;
        }

        .employee-brand .border-amber-100,
        .employee-brand .border-amber-200,
        .employee-brand .border-amber-300,
        .employee-brand .border-amber-400,
        .employee-brand .border-amber-200\/60,
        .employee-brand .border-amber-200\/80,
        .employee-brand .border-amber-500\/20 {
            border-color: #ead38a !important;
        }

        .employee-brand .ring-amber-400\/30,
        .employee-brand .ring-amber-400\/50 {
            --tw-ring-color: rgb(212 175 55 / 0.35) !important;
        }

        .employee-brand .shadow-amber-500\/20,
        .employee-brand .shadow-amber-500\/30 {
            --tw-shadow-color: rgba(212, 175, 55, 0.25) !important;
        }

        .employee-brand .from-amber-400 {
            --tw-gradient-from: #e2c15b var(--tw-gradient-from-position) !important;
            --tw-gradient-to: rgb(226 193 91 / 0) var(--tw-gradient-to-position) !important;
        }

        .employee-brand .to-amber-600 {
            --tw-gradient-to: #ad8618 var(--tw-gradient-to-position) !important;
        }

        .employee-brand .from-amber-500 {
            --tw-gradient-from: #d4af37 var(--tw-gradient-from-position) !important;
            --tw-gradient-to: rgb(212 175 55 / 0) var(--tw-gradient-to-position) !important;
        }

        .employee-brand .to-amber-500 {
            --tw-gradient-to: #d4af37 var(--tw-gradient-to-position) !important;
        }

        .employee-brand .to-amber-300 {
            --tw-gradient-to: #ead38a var(--tw-gradient-to-position) !important;
        }

        .employee-brand .hover\:bg-amber-500:hover {
            background-color: #d4af37 !important;
        }

        .employee-brand .hover\:bg-amber-400:hover {
            background-color: #e2c15b !important;
        }

        .employee-brand .hover\:text-amber-600:hover,
        .employee-brand .hover\:text-amber-700:hover {
            color: #ad8618 !important;
        }

        .employee-brand .hover\:border-amber-100:hover,
        .employee-brand .hover\:border-amber-200:hover,
        .employee-brand .hover\:border-amber-500:hover {
            border-color: #d4af37 !important;
        }

        .sidebar-link-active {
            background: linear-gradient(100deg, rgba(212, 175, 55, 0.16), rgba(212, 175, 55, 0.03));
            border-left: 3px solid #d4af37;
            color: #ad8618 !important;
            box-shadow: inset 0 0 24px rgba(212, 175, 55, 0.04);
        }

        .sidebar-scrollbar-hidden {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar-scrollbar-hidden::-webkit-scrollbar {
            display: none;
        }

        .page-loading-bar {
            animation: page-loading 1s ease-in-out infinite;
            background: linear-gradient(90deg, #ad8618, #d4af37, #fff8db);
            box-shadow: 0 0 14px rgba(212, 175, 55, 0.85);
        }

        @keyframes page-loading {
            0% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(-10%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        html.dark-mode body {
            background: #2b211d;
            color: #fff8e8;
        }

        html.dark-mode header,
        html.dark-mode aside,
        html.dark-mode footer,
        html.dark-mode .bg-white {
            background-color: #3b2b24 !important;
            border-color: #725b2a !important;
        }

        html.dark-mode main,
        html.dark-mode .bg-\[\#f8fafc\],
        html.dark-mode .bg-slate-50,
        html.dark-mode .bg-slate-50\/50,
        html.dark-mode .bg-slate-50\/70,
        html.dark-mode .bg-slate-50\/80 {
            background-color: #2b211d !important;
        }

        html.dark-mode .text-slate-900,
        html.dark-mode .text-slate-950,
        html.dark-mode .text-slate-800 {
            color: #fff8e8 !important;
        }

        html.dark-mode .text-slate-700,
        html.dark-mode .text-slate-600,
        html.dark-mode .text-slate-500 {
            color: #eadfc9 !important;
        }

        html.dark-mode .text-slate-400,
        html.dark-mode .text-slate-300 {
            color: #c9bda9 !important;
        }

        html.dark-mode .border-slate-100,
        html.dark-mode .border-slate-200,
        html.dark-mode .border-slate-200\/80 {
            border-color: #725b2a !important;
        }

        html.dark-mode .bg-white\/70,
        html.dark-mode .bg-white\/80 {
            background-color: rgba(59, 43, 36, 0.92) !important;
        }

        html.dark-mode .theme-toggle {
            background-color: #3b2b24;
            border-color: var(--elvirex-gold);
            color: var(--elvirex-gold);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="employee-brand bg-white antialiased h-full flex flex-col selection:bg-white selection:text-white"
    x-data="{ openSidebar: false, isLoading: false, darkMode: localStorage.getItem('employee-theme') === 'dark' }" x-init="$watch('darkMode', value => {
        document.documentElement.classList.toggle('dark-mode', value);
        localStorage.setItem('employee-theme', value ? 'dark' : 'light');
    })"
    @click="const link = $event.target.closest('a'); if (link && !link.target && link.href && link.origin === window.location.origin && !link.href.includes('#')) { isLoading = true; }">

    <div x-show="isLoading" x-cloak role="status" aria-live="polite"
        class="fixed top-0 left-0 right-0 z-[100] h-1 overflow-hidden bg-amber-100/80">
        <div class="page-loading-bar h-full w-1/2 rounded-full"></div>
    </div>

    {{-- 1. Récupération de l'employé --}}
    @php
        $employee = \App\Models\Employee::find(session('employee_id'));
    @endphp

    {{-- Header Premium --}}
    <header
        class="sticky top-0 z-40 flex items-center justify-between bg-white/80 backdrop-blur-xl border-b border-slate-200/80 px-6 sm:px-8 py-3.5 shadow-sm">
        <div class="flex items-center space-x-6">
            {{-- Mobile Toggle --}}
            <button @click="openSidebar = !openSidebar"
                class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100/80 active:scale-95 transition">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo"
                    class="h-9 w-auto rounded-xl shadow-sm border border-slate-100">
                <div class="hidden lg:block h-5 w-[1px] bg-slate-200"></div>
                <h1 class="hidden lg:block text-xs font-black text-slate-400 uppercase tracking-[0.2em]">
                    Portail <span class="text-amber-600 font-extrabold">{{ $employee->role ?? 'Membre' }}</span>
                </h1>
            </div>
        </div>

        {{-- Profil Section --}}
        <div class="flex items-center space-x-3 sm:space-x-4">
            <button type="button" @click="darkMode = !darkMode"
                class="theme-toggle inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200/80 bg-white/70 text-slate-500 shadow-sm transition-all hover:border-amber-300 hover:text-amber-600 hover:shadow-md"
                :aria-label="darkMode ? 'Activer le mode clair' : 'Activer le mode sombre'"
                :title="darkMode ? 'Mode clair' : 'Mode sombre'">
                <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
            </button>
            <div class="hidden sm:flex flex-col text-right">
                <span class="text-sm font-black text-slate-900 leading-tight">
                    {{ $employee ? $employee->prenom . ' ' . $employee->nom : 'Utilisateur' }}
                </span>
                <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest mt-0.5">
                    Membre Elvirex
                </span>
            </div>

            <a href="{{ route('employe.profile') }}" aria-label="Ouvrir mon profil"
                class="relative group flex items-center gap-3 rounded-2xl border border-slate-200/80 bg-white/70 p-1.5 pl-3 shadow-sm transition-all hover:border-amber-300 hover:shadow-md">
                <span
                    class="hidden sm:block text-[10px] font-extrabold uppercase tracking-widest text-slate-400 group-hover:text-amber-600 transition-colors">Mon
                    profil</span>
                <img src="{{ $employee && $employee->photo ? asset('storage/' . $employee->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->prenom ?? 'U') . '&background=d4af37&color=fff' }}"
                    alt="Profil"
                    class="w-10 h-10 rounded-2xl object-cover border-2 border-slate-100 group-hover:border-amber-400 shadow-sm transition-all duration-300">
                <div
                    class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full shadow-sm">
                </div>
            </a>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">

        {{-- Sidebar Institutionnelle --}}
        <aside
            class="fixed inset-y-0 left-0 bg-white border-r border-slate-200/80 w-72 transform md:transform-none md:relative transition-all duration-300 ease-in-out z-50 flex flex-col shadow-2xl md:shadow-none"
            :class="openSidebar ? 'translate-x-0' : '-translate-x-full'">

            <div class="p-6 sm:p-8 flex-1 overflow-y-auto sidebar-scrollbar-hidden">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Menu Principal</p>

                <nav class="space-y-1.5">
                    @php
                        $navItems = [
                            ['route' => 'employe.dashboard', 'icon' => 'fa-th-large', 'label' => 'Dashboard'],
                            ['route' => 'employe.presences', 'icon' => 'fa-clock', 'label' => 'Présences'],
                            [
                                'route' => 'employe.absences.index',
                                'icon' => 'fa-calendar-day',
                                'label' => 'Congés & Absences',
                            ],
                            [
                                'route' => 'employe.taches.index',
                                'icon' => 'fa-list-check',
                                'label' => 'Projets & Tâches',
                            ],
                            [
                                'route' => 'employe.rapports.index',
                                'icon' => 'fa-chart-line',
                                'label' => 'Rapports d\'activité',
                            ],
                            ['route' => 'messagerie.index', 'icon' => 'fa-paper-plane', 'label' => 'Messagerie'],
                            ['route' => 'employe.support', 'icon' => 'fa-headset', 'label' => 'Assistance'],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                            class="group flex items-center px-4 py-3 rounded-2xl text-xs font-bold transition-all duration-200 hover:translate-x-1 {{ request()->routeIs($item['route']) ? 'sidebar-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <span
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl {{ request()->routeIs($item['route']) ? 'bg-amber-100 text-amber-600' : 'bg-slate-50 text-slate-400 group-hover:bg-amber-50 group-hover:text-amber-500' }} transition-all group-hover:scale-105">
                                <i class="fas {{ $item['icon'] }} text-sm"></i>
                            </span>
                            <span class="ml-3">{{ $item['label'] }}</span>
                        </a>
                    @endforeach

                    @if ($employee && in_array($employee->role, ['rh', 'comptable', 'communication', 'manager']))
                        <div class="pt-6 mt-6 border-t border-slate-100">
                            <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.2em] mb-4">Espace
                                Direction</p>
                            <a href="{{ route('administration.dashboard') }}"
                                class="flex items-center px-4 py-3.5 rounded-2xl text-xs font-bold bg-slate-950 text-white shadow-xl shadow-slate-950/10 hover:bg-slate-800 active:scale-95 transition-all">
                                <i class="fas fa-user-shield w-6 text-amber-400 text-sm"></i>
                                <span class="ml-3">Administration</span>
                            </a>
                        </div>
                    @endif
                </nav>
            </div>

            {{-- Footer Sidebar --}}
            <div class="p-6 border-t border-slate-100 bg-slate-50/50 space-y-2">
                <a href="{{ route('employe.profile') }}"
                    class="group flex items-center text-xs font-bold text-slate-600 hover:text-slate-900 transition p-2 rounded-xl hover:bg-white">
                    <div
                        class="p-2 bg-white rounded-lg shadow-sm border border-slate-200/80 group-hover:border-amber-200 mr-3">
                        <i
                            class="fas fa-cog text-slate-400 group-hover:rotate-90 transition-transform duration-500"></i>
                    </div>
                    Paramètres
                </a>
                <a href="{{ route('employe.logout') }}"
                    class="group flex items-center text-xs font-bold text-rose-600 hover:text-rose-700 transition p-2 rounded-xl hover:bg-rose-50/50">
                    <div class="p-2 bg-rose-50 rounded-lg mr-3 border border-rose-100">
                        <i class="fas fa-power-off text-rose-500"></i>
                    </div>
                    Déconnexion
                </a>
            </div>
        </aside>

        {{-- Overlay Mobile --}}
        <div x-show="openSidebar" x-transition:enter="transition opacity-ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition opacity-ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="openSidebar = false" x-cloak
            class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 md:hidden"></div>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto overflow-x-hidden relative flex flex-col justify-between">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 w-full">
                @yield('content')
            </div>

            {{-- Footer discret --}}
            <footer class="py-8 px-6 border-t border-slate-100 text-center bg-white/50">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                    &copy; {{ date('Y') }} Elvirex RH <span class="mx-2 text-slate-300">|</span> Solutions de
                    Gestion Intégrée
                </p>
            </footer>
        </main>
    </div>

</body>

</html>
