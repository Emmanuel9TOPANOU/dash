<aside class="w-72 bg-slate-900 h-screen flex flex-col justify-between p-6 shadow-2xl transition-all duration-300 relative z-50">
    
    <div>
        {{-- Branding / Logo --}}
        <div class="flex items-center space-x-3 px-4 mb-10 group">
            <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform">
                <img src="{{ asset('images/logo_white.png') }}" alt="E" class="h-6">
            </div>
            <div>
                <h1 class="text-white font-black tracking-tighter text-lg leading-none">ELVIREX</h1>
                <span class="text-amber-500 text-[10px] font-black uppercase tracking-[0.3em]">Administration</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="space-y-1.5">
            {{-- Menu Item : Actif --}}
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-bold rounded-2xl px-5 py-4 shadow-lg shadow-amber-500/20 transition-all">
                <i class="fas fa-th-large text-sm"></i>
                <span class="text-sm tracking-wide">Tableau de bord</span>
            </a>

            {{-- Menu Item : Standard --}}
            <a href="/employees" 
               class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-2xl px-5 py-4 transition-all group">
                <i class="fas fa-users text-sm group-hover:text-amber-500 transition-colors"></i>
                <span class="text-sm font-semibold">Gestion personnel</span>
            </a>

            <a href="/attendances" 
               class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-2xl px-5 py-4 transition-all group">
                <i class="fas fa-calendar-check text-sm group-hover:text-amber-500 transition-colors"></i>
                <span class="text-sm font-semibold">Présences</span>
            </a>

            <a href="/absences" 
               class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-2xl px-5 py-4 transition-all group">
                <i class="fas fa-user-slash text-sm group-hover:text-amber-500 transition-colors"></i>
                <span class="text-sm font-semibold">Absences</span>
            </a>

            <a href="/tasks" 
               class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-2xl px-5 py-4 transition-all group">
                <i class="fas fa-tasks text-sm group-hover:text-amber-500 transition-colors"></i>
                <span class="text-sm font-semibold">Tâches</span>
            </a>

            <div class="pt-4 pb-2 px-5">
                <span class="text-[10px] font-black text-slate-600 uppercase tracking-[0.3em]">Analytique</span>
            </div>

            <a href="/reports" 
               class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-2xl px-5 py-4 transition-all group">
                <i class="fas fa-chart-pie text-sm group-hover:text-amber-500 transition-colors"></i>
                <span class="text-sm font-semibold">Rapports & Stats</span>
            </a>

            <a href="{{ route('administration.settings.index') }}" 
               class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-2xl px-5 py-4 transition-all group">
                <i class="fas fa-cog text-sm group-hover:text-amber-500 transition-colors"></i>
                <span class="text-sm font-semibold">Paramètres</span>
            </a>
        </nav>
    </div>

    {{-- Footer / Déconnexion --}}
    <div class="border-t border-slate-800 pt-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="group flex items-center justify-between w-full bg-slate-800/40 hover:bg-rose-500/10 border border-slate-800 hover:border-rose-500/20 rounded-2xl px-5 py-4 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-power-off text-slate-500 group-hover:text-rose-500 transition-colors text-sm"></i>
                    <span class="text-sm font-bold text-slate-400 group-hover:text-rose-500 transition-colors">Déconnexion</span>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-slate-700 group-hover:text-rose-500 transition-transform group-hover:translate-x-1"></i>
            </button>
        </form>
    </div>
</aside>
