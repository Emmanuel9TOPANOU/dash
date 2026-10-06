<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Elvirex RH') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- Tailwind & FontAwesome -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        if (localStorage.getItem('admin-main-theme') === 'dark') {
            document.documentElement.classList.add('admin-dark');
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        :root {
            --elvirex-gold: #d4af37;
            --elvirex-gold-dark: #ad8618;
            --elvirex-gold-light: #fff8db;
        }

        .page-loading-bar {
            animation: page-loading 1s ease-in-out infinite;
            background: linear-gradient(90deg, var(--elvirex-gold-dark), var(--elvirex-gold), #fff8db);
            box-shadow: 0 0 14px rgba(212, 175, 55, .85);
        }

        @keyframes page-loading {
            0% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(-10%);
            }
        }

        /* Palette ELVIREX */
        .admin-brand .bg-amber-500 {
            background-color: var(--elvirex-gold) !important;
        }

        .admin-brand .bg-amber-400 {
            background-color: #e2c15b !important;
        }

        .admin-brand .bg-amber-100,
        .admin-brand .bg-amber-50 {
            background-color: var(--elvirex-gold-light) !important;
        }

        .admin-brand .bg-amber-100\/70 {
            background-color: rgb(255 248 219 / .7) !important;
        }

        .admin-brand .bg-amber-500\/10 {
            background-color: rgb(212 175 55 / .1) !important;
        }

        .admin-brand .text-amber-800,
        .admin-brand .text-amber-700,
        .admin-brand .text-amber-600 {
            color: var(--elvirex-gold-dark) !important;
        }

        .admin-brand .text-amber-500,
        .admin-brand .text-amber-400 {
            color: var(--elvirex-gold) !important;
        }

        .admin-brand .border-amber-100,
        .admin-brand .border-amber-200,
        .admin-brand .border-amber-300 {
            border-color: #ead38a !important;
        }

        .admin-brand .border-amber-500\/20 {
            border-color: rgb(212 175 55 / .2) !important;
        }

        .admin-brand .shadow-amber-500\/10,
        .admin-brand .shadow-amber-500\/20,
        .admin-brand .shadow-amber-500\/25,
        .admin-brand .shadow-amber-500\/30 {
            --tw-shadow-color: rgba(212, 175, 55, .25) !important;
        }

        .admin-brand .from-amber-500\/5 {
            --tw-gradient-from: rgb(212 175 55 / .05) var(--tw-gradient-from-position) !important;
            --tw-gradient-to: rgb(212 175 55 / 0) var(--tw-gradient-to-position) !important;
        }

        .admin-brand .to-amber-500\/10 {
            --tw-gradient-to: rgb(212 175 55 / .1) var(--tw-gradient-to-position) !important;
        }

        .admin-brand .hover\:bg-amber-600:hover {
            background-color: var(--elvirex-gold-dark) !important;
        }

        .admin-brand .hover\:border-amber-300:hover,
        .admin-brand .hover\:border-amber-200:hover,
        .admin-brand .hover\:border-amber-400:hover {
            border-color: var(--elvirex-gold) !important;
        }

        .admin-brand .hover\:border-amber-500\/30:hover {
            border-color: rgb(212 175 55 / .3) !important;
        }

        .admin-brand .hover\:text-amber-600:hover,
        .admin-brand .hover\:text-amber-700:hover {
            color: var(--elvirex-gold-dark) !important;
        }

        .admin-brand .bg-indigo-600 {
            background-color: #d97706 !important;
        }

        .admin-brand .bg-indigo-50 {
            background-color: #fffbeb !important;
        }

        .admin-brand .bg-indigo-100 {
            background-color: #fef3c7 !important;
        }

        .admin-brand .bg-indigo-200 {
            background-color: #fde68a !important;
        }

        .admin-brand .bg-indigo-50\/30 {
            background-color: rgb(255 251 235 / .3) !important;
        }

        .admin-brand .bg-indigo-50\/80 {
            background-color: rgb(255 251 235 / .8) !important;
        }

        .admin-brand .text-indigo-800,
        .admin-brand .text-indigo-700,
        .admin-brand .text-indigo-600 {
            color: #b45309 !important;
        }

        .admin-brand .text-indigo-500,
        .admin-brand .text-indigo-400 {
            color: #d97706 !important;
        }

        .admin-brand .border-indigo-100,
        .admin-brand .border-indigo-200 {
            border-color: #fde68a !important;
        }

        .admin-brand .border-indigo-200\/60 {
            border-color: rgb(253 230 138 / .6) !important;
        }

        .admin-brand .from-indigo-50,
        .admin-brand .from-indigo-100 {
            --tw-gradient-from: #fffbeb var(--tw-gradient-from-position) !important;
            --tw-gradient-to: rgb(255 251 235 / 0) var(--tw-gradient-to-position) !important;
        }

        .admin-brand .to-indigo-200 {
            --tw-gradient-to: #fde68a var(--tw-gradient-to-position) !important;
        }

        .admin-brand .hover\:bg-indigo-700:hover {
            background-color: #b45309 !important;
        }

        .admin-brand .active\:bg-indigo-800:active {
            background-color: #92400e !important;
        }

        .admin-brand .hover\:bg-indigo-100:hover {
            background-color: #fef3c7 !important;
        }

        .admin-brand .hover\:text-indigo-700:hover,
        .admin-brand .hover\:text-indigo-800:hover {
            color: #92400e !important;
        }

        .admin-brand .focus\:border-indigo-400:focus,
        .admin-brand .focus\:border-indigo-500:focus {
            border-color: #f59e0b !important;
        }

        .admin-brand .focus\:ring-indigo-500:focus {
            --tw-ring-color: #f59e0b !important;
        }

        .admin-brand .focus\:ring-indigo-500\/10:focus {
            --tw-ring-color: rgb(245 158 11 / .1) !important;
        }

        .admin-brand .focus\:ring-indigo-500\/30:focus {
            --tw-ring-color: rgb(245 158 11 / .3) !important;
        }

        html.admin-dark body {
            background: #0b0f19;
            color: #f1f5f9;
        }

        html.admin-dark header,
        html.admin-dark aside {
            background-color: #111827 !important;
            border-color: #1f293d !important;
        }

        html.admin-dark main {
            background-color: #0b0f19 !important;
        }

        html.admin-dark .text-gray-900,
        html.admin-dark .text-gray-800,
        html.admin-dark .text-gray-700,
        html.admin-dark .text-slate-900,
        html.admin-dark .text-slate-800,
        html.admin-dark .text-slate-700 {
            color: #f8fafc !important;
        }

        html.admin-dark .text-gray-600,
        html.admin-dark .text-gray-500,
        html.admin-dark .text-slate-600,
        html.admin-dark .text-slate-500,
        html.admin-dark .text-slate-400 {
            color: #94a3b8 !important;
        }

        html.admin-dark .border-gray-200,
        html.admin-dark .border-gray-300,
        html.admin-dark .border-slate-200,
        html.admin-dark .border-slate-200\/80,
        html.admin-dark .border-slate-100,
        html.admin-dark .border-slate-300 {
            border-color: #1f293d !important;
        }

        html.admin-dark .hover\:bg-gray-100:hover,
        html.admin-dark .hover\:bg-slate-50:hover,
        html.admin-dark .hover\:bg-slate-100:hover {
            background-color: #1e293b !important;
        }

        html.admin-dark .bg-white,
        html.admin-dark .bg-gray-50,
        html.admin-dark .bg-gray-100,
        html.admin-dark .bg-slate-50,
        html.admin-dark .bg-slate-100,
        html.admin-dark .bg-slate-50\/80,
        html.admin-dark .bg-white\/80,
        html.admin-dark .bg-white\/95 {
            background-color: #0f172a !important;
        }

        html.admin-dark .theme-toggle {
            background-color: #1e293b;
            border-color: #334155;
            color: var(--elvirex-gold);
        }

        html.admin-dark .shadow-slate-200\/40,
        html.admin-dark .shadow-slate-900\/10,
        html.admin-dark .shadow-slate-900\/5,
        html.admin-dark .shadow-slate-200\/20,
        html.admin-dark .shadow-slate-200\/30 {
            box-shadow: 0 0 0 1px rgba(15, 23, 42, 0.4) !important;
        }

        html.admin-dark .sidebar-item-active {
            background-color: var(--elvirex-gold) !important;
            color: #ffffff !important;
        }

        .admin-sidebar-scrollbar-hidden {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .admin-sidebar-scrollbar-hidden::-webkit-scrollbar {
            display: none;
        }

        #sidebar nav a {
            min-height: 3rem;
            transition: all .2s ease;
        }

        #sidebar nav a:hover {
            transform: translateX(4px);
        }

        #sidebar nav a svg,
        #sidebar nav a i {
            width: 2rem;
            height: 2rem;
            padding: .5rem;
            border-radius: .75rem;
            background: #f8fafc;
            color: #94a3b8;
            transition: all .2s ease;
        }

        #sidebar nav a:hover svg,
        #sidebar nav a:hover i {
            background: var(--elvirex-gold-light);
            color: var(--elvirex-gold-dark);
            transform: scale(1.05);
        }

        #sidebar nav a.sidebar-item-active svg,
        #sidebar nav a.sidebar-item-active i {
            background: rgba(255, 255, 255, .2);
            color: #fff;
        }

        html.admin-dark #sidebar nav a svg,
        html.admin-dark #sidebar nav a i {
            background: #1e293b;
            color: #94a3b8;
        }

        html.admin-dark #sidebar nav a:hover svg,
        html.admin-dark #sidebar nav a:hover i {
            background: #422006;
            color: var(--elvirex-gold);
        }
    </style>
</head>

<body
    class="admin-brand bg-slate-50 font-sans antialiased min-h-screen flex flex-col selection:bg-amber-500 selection:text-white">

    {{-- Indicateur de chargement --}}
    <div id="admin-navigation-loading" role="status" aria-live="polite"
        class="pointer-events-none fixed inset-x-0 top-0 z-[100] hidden h-1 overflow-hidden bg-amber-100/80">
        <div class="page-loading-bar h-full w-1/2 rounded-full"></div>
    </div>
    {{-- Header --}}
    <header
        class="sticky top-0 z-40 flex items-center justify-between bg-white/80 backdrop-blur-xl border-b border-slate-200/80 px-6 py-3.5 shadow-sm transition-colors duration-300">
        <div class="flex items-center space-x-4">
            <button id="menu-toggle"
                class="md:hidden focus:outline-none text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Elvirex"
                class="h-9 w-auto rounded-xl border border-slate-100 shadow-sm">
        </div>

        <div class="flex items-center space-x-3 sm:space-x-4">
            <button id="theme-toggle" type="button" aria-label="Changer de thème" title="Mode sombre"
                class="theme-toggle inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200/80 bg-white text-slate-600 shadow-sm transition-all hover:border-amber-300 hover:text-amber-600 active:scale-95">
                <i id="theme-icon" class="fas fa-moon text-sm"></i>
            </button>

            <div class="relative" x-data="{
                openNotifications: false,
                unread: {{ auth()->check()? \App\Models\Notification::forUser(auth()->id())->where('is_read', false)->count(): 0 }},
                notifications: [],
                async loadNotifications() {
                    if (!{{ auth()->check() ? 'true' : 'false' }}) return;
                    const response = await fetch('{{ route('notifications.index') }}');
                    const data = await response.json();
                    this.notifications = data.items || [];
                    this.unread = data.count || 0;
                },
                async markAllAsRead() {
                    if (!{{ auth()->check() ? 'true' : 'false' }}) return;
                    await fetch('{{ route('notifications.mark_all_read') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    });
                    this.notifications = [];
                    this.unread = 0;
                },
                async openNotification(notification) {
                    try {
                        const response = await fetch(`/notifications/${notification.id}/read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        });
                        if (!response.ok) throw new Error('Impossible de marquer la notification comme lue.');
                    } catch (error) {
                        console.error(error);
                    } finally {
                        this.notifications = this.notifications.filter(item => item.id !== notification.id);
                        this.unread = Math.max(0, this.unread - 1);
                        window.location.assign(notification.link || '{{ route('administration.dashboard') }}');
                    }
                }
            }" x-init="loadNotifications(); setInterval(() => loadNotifications(), 10000)"
                @click.outside="openNotifications = false" @keydown.escape.window="openNotifications = false">
                <button type="button" @click="openNotifications = !openNotifications"
                    aria-label="Ouvrir les notifications"
                    class="relative inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200/80 bg-white text-slate-600 shadow-sm hover:border-amber-300 hover:text-amber-600 active:scale-95 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span x-show="unread > 0" x-cloak
                        class="absolute -right-1 -top-1 inline-flex min-h-5 min-w-5 items-center justify-center rounded-full bg-amber-500 px-1 text-[10px] font-black text-white ring-2 ring-white"
                        x-text="unread"></span>
                </button>

                <div x-show="openNotifications" x-cloak x-transition
                    class="absolute right-0 top-12 z-50 w-80 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/10">
                    <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
                        <p class="text-sm font-black text-slate-900">Notifications</p>
                        <button type="button" @click="markAllAsRead()" x-show="unread > 0"
                            class="text-[10px] font-bold text-amber-600 hover:text-amber-700">
                            Tout marquer comme lu
                        </button>
                    </div>

                    <div x-show="notifications.length === 0"
                        class="px-4 py-4 text-center text-[11px] font-semibold text-slate-500">
                        Aucune notification pour le moment.
                    </div>

                    <div x-show="notifications.length > 0" class="max-h-80 overflow-y-auto">
                        <template x-for="notification in notifications" :key="notification.id">
                            <a :href="notification.link || '{{ route('administration.dashboard') }}'"
                                @click.prevent="openNotification(notification)"
                                class="block border-b border-slate-100 px-4 py-3 transition hover:bg-slate-50">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-black text-slate-900" x-text="notification.title"></p>
                                        <p class="mt-1 text-[11px] text-slate-600" x-text="notification.message"></p>
                                    </div>
                                    <span x-show="!notification.is_read"
                                        class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                                </div>
                                <p class="mt-2 text-[10px] uppercase tracking-wide text-slate-400"
                                    x-text="notification.created_at"></p>
                            </a>
                        </template>
                    </div>
                </div>
            </div>

            <div class="h-5 w-[1px] bg-slate-200/80"></div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.profile') }}" class="relative group">
                    <img src="{{ Auth::user()?->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default-avatar.png') }}"
                        alt="Photo administrateur"
                        class="w-10 h-10 rounded-2xl object-cover border-2 border-amber-400 group-hover:scale-105 shadow-sm transition-all duration-300">
                </a>

                <div class="hidden sm:block">
                    <p class="text-xs font-black text-slate-900 leading-tight">
                        {{ Auth::check() ? Auth::user()->name : 'Invité' }}
                    </p>
                    <p class="text-[10px] font-extrabold text-amber-600 uppercase tracking-wider mt-0.5">Administrateur
                    </p>
                </div>
            </div>
        </div>
    </header>

    {{-- Corps principal --}}
    <div class="flex flex-1 relative overflow-hidden">
        {{-- Sidebar --}}
        <aside id="sidebar"
            class="w-72 bg-white border-r border-slate-200/80 p-6 flex flex-col justify-between fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50 shadow-2xl md:shadow-none admin-sidebar-scrollbar-hidden overflow-y-auto">

            <button id="close-sidebar"
                class="absolute top-5 right-5 md:hidden text-slate-400 hover:text-rose-500 p-2 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Navigation Admin</p>

                {{-- Navigation principale avec NOUVEAUX LIENS --}}
                <nav class="space-y-1.5">
                    <a href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-chart-line text-base text-slate-400 w-5"></i>
                        <span>Tableau de bord</span>
                    </a>

                    <a href="/employees"
                        class="{{ request()->is('employees*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-users text-base text-slate-400 w-5"></i>
                        <span>Gestion de personnel</span>
                    </a>

                    <a href="{{ route('clients.index') }}"
                        class="{{ request()->routeIs('clients.*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-user-tie text-base text-slate-400 w-5"></i>
                        <span>Gestion des Clients</span>
                    </a>

                    <a href="{{ route('projects.index') }}"
                        class="{{ request()->routeIs('projects.*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-folder-open text-base text-slate-400 w-5"></i>
                        <span>Projets</span>
                    </a>

                    <a href="{{ route('services.index') }}"
                        class="{{ request()->routeIs('services.*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-concierge-bell text-base text-slate-400 w-5"></i>
                        <span>Services</span>
                    </a>

                    <a href="{{ route('commercial.index') }}"
                        class="{{ request()->routeIs('commercial.*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-chart-pie text-base text-slate-400 w-5"></i>
                        <span>Gestion Commerciale</span>
                    </a>

                    <a href="{{ route('expenses.index') }}"
                        class="{{ request()->routeIs('expenses.*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-wallet text-base text-slate-400 w-5"></i>
                        <span>Gestion des Dépenses</span>
                    </a>

                    <a href="/attendances"
                        class="{{ request()->is('attendances*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-calendar-check text-base text-slate-400 w-5"></i>
                        <span>Présences</span>
                    </a>

                    <a href="/absences"
                        class="{{ request()->is('absences*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-user-clock text-base text-slate-400 w-5"></i>
                        <span>Absences</span>
                    </a>

                    <a href="/tasks"
                        class="{{ request()->is('tasks*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-layer-group text-base text-slate-400 w-5"></i>
                        <span>Tâches</span>
                    </a>

                    <a href="/reports"
                        class="{{ request()->is('reports*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-file-invoice-dollar text-base text-slate-400 w-5"></i>
                        <span>Rapports & Statistiques</span>
                    </a>

                    <a href="{{ route('administration.settings.index') }}"
                        class="{{ request()->routeIs('administration.settings.*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-sliders-h text-base text-slate-400 w-5"></i>
                        <span>Paramètres</span>
                    </a>

                    <a href="{{ route('messagerie.index') }}"
                        class="{{ request()->routeIs('messagerie.*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="far fa-comments text-base text-slate-400 w-5"></i>
                        <span>Messagerie</span>
                    </a>

                    <a href="/admin/profile"
                        class="{{ request()->is('admin/profile*') ? 'sidebar-item-active bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center space-x-3 font-bold rounded-2xl px-4 py-3 text-xs transition-all">
                        <i class="fas fa-user-circle text-base text-slate-400 w-5"></i>
                        <span>Profile</span>
                    </a>
                </nav>
            </div>

            {{-- Déconnexion --}}
            <div class="pt-6 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center space-x-3 text-rose-600 hover:bg-rose-50/80 rounded-2xl px-4 py-3 font-bold text-xs w-full transition-all">
                        <i class="fas fa-sign-out-alt text-base text-rose-500 w-5"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Overlay mobile --}}
        <div id="overlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm hidden md:hidden z-40"></div>

        {{-- Contenu principal --}}
        <main class="flex-1 p-6 sm:p-8 bg-slate-50 overflow-y-auto">
            <x-flash-message />
            @yield('content')
        </main>
    </div>

    {{-- Script Burger Menu & Thème --}}
    <script>
        const loadingIndicator = document.getElementById('admin-navigation-loading');
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');

        const updateThemeButton = () => {
            const isDark = document.documentElement.classList.contains('admin-dark');
            themeIcon.className = isDark ? 'fas fa-sun text-amber-400' : 'fas fa-moon text-slate-600';
            themeToggle.title = isDark ? 'Mode clair' : 'Mode sombre';
            themeToggle.setAttribute('aria-label', isDark ? 'Activer le mode clair' : 'Activer le mode sombre');
        };

        updateThemeButton();
        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('admin-dark');
            localStorage.setItem('admin-main-theme', isDark ? 'dark' : 'light');
            updateThemeButton();
        });

        document.querySelectorAll('a[href]').forEach((link) => {
            if (link.origin === window.location.origin && !link.target && !link.href.includes('#')) {
                link.addEventListener('click', () => {
                    loadingIndicator.classList.remove('hidden');
                });
            }
        });

        window.addEventListener('pageshow', () => {
            loadingIndicator.classList.add('hidden');
        });

        const toggleBtn = document.getElementById('menu-toggle');
        const closeBtn = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>

</html>
