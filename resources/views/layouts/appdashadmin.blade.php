<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Elvirex RH') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Fonts & Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Alpine.js pour la gestion du menu mobile --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        if (localStorage.getItem('admin-theme') === 'dark') document.documentElement.classList.add('dark-mode');
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .admin-loading-bar {
            animation: admin-loading 1s ease-in-out infinite;
            background: linear-gradient(90deg, #d97706, #fbbf24, #fff7ed);
            box-shadow: 0 0 14px rgba(245, 158, 11, .85);
        }

        @keyframes admin-loading {
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
        html.dark-mode main {
            background-color: #3b2b24 !important;
            border-color: #725b2a !important;
        }

        html.dark-mode .bg-gray-50,
        html.dark-mode .bg-gray-100,
        html.dark-mode .bg-white {
            background-color: #2b211d !important;
            border-color: #725b2a !important;
        }

        html.dark-mode .text-gray-800,
        html.dark-mode .text-gray-700,
        html.dark-mode .text-black-600 {
            color: #fff8e8 !important;
        }

        html.dark-mode .text-gray-600,
        html.dark-mode .text-gray-500 {
            color: #eadfc9 !important;
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

<body class="bg-[#f8fafc] font-sans antialiased min-h-screen flex flex-col" x-data="{ openSidebar: false, isLoading: false, darkMode: localStorage.getItem('admin-theme') === 'dark' }"
    x-init="$watch('darkMode', value => {
        document.documentElement.classList.toggle('dark-mode', value);
        localStorage.setItem('admin-theme', value ? 'dark' : 'light');
    })"
    @click="const link = $event.target.closest('a'); if (link && !link.target && link.href && link.origin === window.location.origin && !link.href.includes('#')) { isLoading = true; }">

    <div x-show="isLoading" x-cloak role="status" aria-live="polite"
        class="fixed top-0 left-0 right-0 z-[100] h-1 overflow-hidden bg-amber-100/80">
        <div class="admin-loading-bar h-full w-1/2 rounded-full"></div>
    </div>

    @php
        $employee = \App\Models\Employee::find(session('employee_id'));
        $admin = auth()->user();
    @endphp

    {{-- Header --}}
    <header class="flex items-center justify-between bg-white border-b border-gray-200 px-6 py-4 shadow-sm">
        <div class="flex items-center space-x-3">
            {{-- Bouton burger mobile --}}
            <button @click="openSidebar = !openSidebar" class="md:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Elvirex"
                class="h-9 w-auto rounded-xl shadow-sm border border-slate-100">
            <h1 class="text-sm md:text-base font-black uppercase tracking-widest text-slate-800">Administration <span
                    class="text-amber-600">{{ $employee->role ?? '—' }}</span></h1>
        </div>

        {{-- Profil --}}
        <div class="flex items-center space-x-3 sm:space-x-4">
            <button type="button" @click="darkMode = !darkMode"
                class="theme-toggle inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-amber-300 hover:text-amber-600"
                :aria-label="darkMode ? 'Activer le mode clair' : 'Activer le mode sombre'"
                :title="darkMode ? 'Mode clair' : 'Mode sombre'"><i class="fas"
                    :class="darkMode ? 'fa-sun' : 'fa-moon'"></i></button>
            <div class="hidden sm:block text-right">
                <p class="text-xs font-bold text-slate-500">Espace Administration</p>
                <p class="text-[10px] font-black uppercase tracking-widest text-amber-600">
                    {{ $employee->prenom ?? 'Administrateur' }}</p>
            </div>
            <img src="{{ $admin && $admin->photo ? asset('storage/' . $admin->photo) : ($employee && $employee->photo ? asset('storage/' . $employee->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($admin->name ?? 'A') . '&background=f59e0b&color=fff') }}"
                alt="Profil" class="w-10 h-10 rounded-2xl object-cover border-2 border-slate-100 shadow-sm">
        </div>
    </header>

    {{-- Contenu global --}}
    <div class="flex flex-1 overflow-hidden">

        {{--  Sidebar (responsive) --}}
        <aside
            class="fixed inset-y-0 left-0 bg-white border-r border-gray-200 w-64 transform md:transform-none md:relative p-6 space-y-6 transition-transform duration-300 ease-in-out z-50"
            :class="openSidebar ? 'translate-x-0' : '-translate-x-full'">

            {{-- Bouton fermer (mobile uniquement) --}}
            <div class="flex justify-end md:hidden">
                <button @click="openSidebar = false" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div>
                <nav class="space-y-2">
                    {{-- ========================================================= --}}
                    {{--  Section Administration — selon le rôle du personnel  --}}
                    {{-- ========================================================= --}}
                    @if ($employee && in_array($employee->role, ['rh', 'comptable', 'communication', 'manager']))

                        <h2 class="mt-6 text-gray-700 text-sm font-semibold uppercase tracking-wide">Administration</h2>

                        <a href="{{ route('clients.index') }}"
                            class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('clients.*') ? 'bg-yellow-100 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-2">Clients</span>
                        </a>

                        <a href="{{ route('projects.index') }}"
                            class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('projects.*') ? 'bg-yellow-100 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-2">Projets</span>
                        </a>

                        {{-- Dashboard administration --}}
                        <a href="{{ route('administration.dashboard') }}"
                            class="flex items-center px-3 py-2 rounded-md text-sm font-medium
                                {{ request()->routeIs('administration.dashboard') ? 'bg-yellow-100 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-2">Tableau de bord Admin</span>
                        </a>

                        {{--  Liens RH --}}
                        @if ($employee->role === 'rh')
                            <a href="{{ url('administration/rh/attendances') }}"
                                class="flex items-center px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                                <span class="ml-2">Gestion des présences</span>
                            </a>

                            <a href="{{ url('administration/rh/employees') }}"
                                class="flex items-center px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                                <span class="ml-2">Gestion des employés</span>
                            </a>

                            <a href="{{ url('administration/rh/paie') }}"
                                class="flex items-center px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                                <span class="ml-2">Fiche de paie</span>
                            </a>

                            <a href="{{ route('administration.settings.index') }}"
                                class="flex items-center px-3 py-2 rounded-md text-sm font-medium
                                    {{ request()->routeIs('administration.settings.*') ? 'bg-yellow-100 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <span class="ml-2">Paramètres</span>
                            </a>
                        @endif

                        {{--  Liens Comptable --}}
                        @if ($employee->role === 'comptable')
                            <a href="{{ url('administration/comptable/salaires') }}"
                                class="flex items-center px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                                <span class="ml-2">Gestion des salaires</span>
                            </a>

                            <a href="{{ url('administration/comptable/paiements') }}"
                                class="flex items-center px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                                <span class="ml-2">Historique paiements</span>
                            </a>
                        @endif

                        {{--  Liens Chef Communication --}}
                        @if ($employee->role === 'communication')
                            <a href="{{ route('administration.communication.tasks.index') }}"
                                class="flex items-center px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                                <span class="ml-2">Tâches Employés</span>
                            </a>

                            <a href="{{ url('administration/communication/messages') }}"
                                class="flex items-center px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                                <span class="ml-2">Annonce & Communication</span>
                            </a>

                            <a href="{{ url('administration/communication/documents') }}"
                                class="flex items-center px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                                <span class="ml-2">Documents internes</span>
                            </a>
                        @endif

                        {{--  Manager --}}
                        @if ($employee->role === 'manager')
                            <a href="{{ url('administration/manager/rapport') }}"
                                class="flex items-center px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                                <span class="ml-2">Rapports & Statistiques</span>
                            </a>
                        @endif
                        <a href="{{ url('employe/dashboard') }}"
                            class="flex items-center px-3 py-2 rounded-md text-sm bg-yellow-100 text-yellow-700">
                            <span class="ml-2">Retour </span>
                        </a>
                    @endif
                </nav>
                @auth
                    <nav class="space-y-2 mt-8">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center space-x-3 bg-yellow-400 text-white font-medium rounded-lg px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                            </svg>
                            <span>Tableau de bord</span>
                        </a>

                        <a href="/employees"
                            class="flex items-center space-x-3 text-gray-800 hover:bg-gray-100 rounded-lg px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-4-4h-1V9a4 4 0 10-8 0v5H7a4 4 0 00-4 4v2h5" />
                            </svg>
                            <span>Gestion de personnel</span>
                        </a>

                        <a href="/attendances"
                            class="flex items-center space-x-3 text-gray-800 hover:bg-gray-100 rounded-lg px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3M4 11h16M4 19h16" />
                            </svg>
                            <span>Présences</span>
                        </a>

                        <a href="/absences"
                            class="flex items-center space-x-3 text-gray-800 hover:bg-gray-100 rounded-lg px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l3 3-3 3m5 0h3a2 2 0 002-2V9a2 2 0 00-2-2h-3" />
                            </svg>
                            <span>Absences</span>
                        </a>

                        <a href="/tasks"
                            class="flex items-center space-x-3 text-gray-800 hover:bg-gray-100 rounded-lg px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m2 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Tâches</span>
                        </a>

                        <a href="/reports"
                            class="flex items-center space-x-3 text-gray-800 hover:bg-gray-100 rounded-lg px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 17a4 4 0 100-8 4 4 0 000 8zm0 0v5m0-5H7m4 0h4" />
                            </svg>
                            <span>Rapports & Statistiques</span>
                        </a>

                        <a href="{{ route('administration.settings.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-4 py-3
                                {{ request()->routeIs('administration.settings.*') ? 'bg-yellow-100 text-yellow-700' : 'text-gray-800 hover:bg-gray-100' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-2.21 0-4 1.79-4 4 0 2.21 1.79 4 4 4m0-12v4m0 8v4m8-8h-4m-8 0H4" />
                            </svg>
                            <span>Paramètres</span>
                        </a>

                        <a href="{{ route('messagerie.index') }}"
                            class="flex items-center px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                            <span class="ml-2">Messagerie</span>
                        </a>


                        <a href="/admin/profile"
                            class="flex items-center space-x-3 text-gray-800 hover:bg-gray-100 rounded-lg px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-2.21 0-4 1.79-4 4 0 2.21 1.79 4 4 4m0-12v4m0 8v4m8-8h-4m-8 0H4" />
                            </svg>
                            <span>Profile</span>
                        </a>
                    </nav>
                @endauth
            </div>

        </aside>

        {{--  Overlay noir derrière le menu sur mobile --}}
        <div x-show="openSidebar" @click="openSidebar = false"
            class="fixed inset-0 bg-black bg-opacity-40 z-40 md:hidden transition-opacity duration-300"></div>

        {{-- Contenu principal --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>

</body>

</html>
