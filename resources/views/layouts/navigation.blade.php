{{-- Header Premium --}}
<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 px-8 py-4 flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <div class="bg-slate-900 p-2 rounded-xl shadow-lg shadow-slate-200">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
        </div>
        <div class="hidden md:block">
            <h1 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em]">Elvirex <span class="text-amber-600 italic">Group</span></h1>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Management System v2.0</p>
        </div>
    </div>

    <div class="flex items-center space-x-6">
        {{-- Notifications Stylisées --}}
        <button class="relative p-2 text-slate-400 hover:text-amber-600 transition-colors group">
            <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
            <i class="fas fa-bell text-xl"></i>
        </button>

        {{-- Profil Utilisateur --}}
        <div class="flex items-center pl-6 border-l border-slate-100 space-x-4 group cursor-pointer">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-black text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                <p class="text-[10px] font-bold text-amber-600 uppercase tracking-tighter mt-1">Administrateur Principal</p>
            </div>
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0f172a&color=fff" 
                     alt="Avatar" 
                     class="w-10 h-10 rounded-2xl object-cover shadow-md group-hover:scale-105 transition-transform border-2 border-white">
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
            </div>
        </div>
    </div>
</header>

<div class="flex min-h-screen">
    {{-- Sidebar Architecturale --}}
    <aside class="w-72 bg-white border-r border-slate-100 flex flex-col justify-between sticky top-[73px] h-[calc(100vh-73px)]">
        
        <div class="p-6 overflow-y-auto custom-scrollbar">
            <nav class="space-y-1.5">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4 ml-4">Menu Principal</p>

                {{-- Dashboard : Actif --}}
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-4 bg-slate-900 text-white px-5 py-4 rounded-[1.5rem] shadow-xl shadow-slate-200 transition-all group">
                    <i class="fas fa-chart-line text-amber-500"></i>
                    <span class="text-sm font-bold tracking-wide">Tableau de bord</span>
                </a>

                {{-- Autres items --}}
                @php
                    $links = [
                        ['icon' => 'fa-users', 'label' => 'Gestion personnel', 'url' => 'employees'],
                        ['icon' => 'fa-calendar-check', 'label' => 'Présences', 'url' => 'attendances'],
                        ['icon' => 'fa-user-clock', 'label' => 'Absences', 'url' => 'absences'],
                        ['icon' => 'fa-layer-group', 'label' => 'Tâches', 'url' => 'taches'],
                    ];
                @endphp

                @foreach($links as $link)
                <a href="{{ $link['url'] }}" 
                   class="flex items-center space-x-4 text-slate-500 hover:text-slate-900 hover:bg-slate-50 px-5 py-4 rounded-[1.5rem] transition-all group">
                    <div class="w-8 h-8 flex items-center justify-center rounded-xl group-hover:bg-white group-hover:shadow-sm transition-all">
                        <i class="fas {{ $link['icon'] }} text-sm group-hover:text-amber-600"></i>
                    </div>
                    <span class="text-sm font-semibold tracking-tight">{{ $link['label'] }}</span>
                </a>
                @endforeach

                <div class="pt-8 pb-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-4">Rapports & Config</p>
                </div>

                <a href="rapports" class="flex items-center space-x-4 text-slate-500 hover:text-slate-900 hover:bg-slate-50 px-5 py-4 rounded-[1.5rem] transition-all group">
                    <div class="w-8 h-8 flex items-center justify-center rounded-xl group-hover:bg-white group-hover:shadow-sm">
                        <i class="fas fa-file-invoice-dollar text-sm group-hover:text-amber-600"></i>
                    </div>
                    <span class="text-sm font-semibold tracking-tight">Rapports & Stats</span>
                </a>

                <a href="{{ route('administration.settings.index') }}" class="flex items-center space-x-4 text-slate-500 hover:text-slate-900 hover:bg-slate-50 px-5 py-4 rounded-[1.5rem] transition-all group">
                    <div class="w-8 h-8 flex items-center justify-center rounded-xl group-hover:bg-white group-hover:shadow-sm text-sm">
                        <i class="fas fa-sliders-h group-hover:text-amber-600"></i>
                    </div>
                    <span class="text-sm font-semibold tracking-tight">Paramètres</span>
                </a>
            </nav>
        </div>

        {{-- Logout Section --}}
        <div class="p-6 border-t border-slate-50 bg-slate-50/30">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="flex items-center justify-between w-full bg-white border border-slate-200 text-rose-600 px-5 py-4 rounded-2xl shadow-sm hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all duration-300 group">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-sign-out-alt text-sm transition-transform group-hover:-translate-x-1"></i>
                        <span class="text-xs font-black uppercase tracking-widest">Déconnexion</span>
                    </div>
                    <i class="fas fa-chevron-right text-[10px] opacity-30"></i>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content Slot --}}
    <main class="flex-1 bg-slate-50/50 p-8">
        {{-- Votre contenu dynamique ici --}}
    </main>
</div>
