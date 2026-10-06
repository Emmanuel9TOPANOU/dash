@extends(session()->has('employee_id') ? 'layouts.appdash' : 'layouts.app')

@section('content')
    <div class="space-y-8 font-sans max-w-7xl mx-auto px-4 sm:px-6 py-6">
        {{-- En-tête de Section Premium --}}
        <div
            class="relative bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-amber-400 to-amber-600"></div>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="space-y-1">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-amber-50 text-amber-700 border border-amber-200/60">
                        Espace d'échange
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Messagerie Globale</h2>
                    <p class="text-slate-500 font-medium text-sm">Discutez en temps réel et partagez des documents avec vos
                        équipes.</p>
                </div>

                <div class="flex items-center space-x-2 bg-slate-50 border border-slate-100 px-4 py-2 rounded-2xl">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-slate-600">Canal actif</span>
                </div>
            </div>
        </div>

        {{-- Fil de Discussion --}}
        <div
            class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 space-y-6 max-h-[600px] overflow-y-auto">
            @forelse($messages as $msg)
                @php
                    $isMine = false;

                    //  Admin connecté
                    if (auth()->check()) {
                        if ($msg->sender_role === 'admin' && $msg->sender_id === auth()->id()) {
                            $isMine = true;
                        }
                    }

                    // 👤 Employé / RH / Communication connecté
                    if (session('employee_id')) {
                        if ($msg->sender_id === session('employee_id') && $msg->sender_role !== 'admin') {
                            $isMine = true;
                        }
                    }
                @endphp

                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xl w-full sm:w-auto">
                        {{-- Informations Expéditeur --}}
                        <div
                            class="flex items-center space-x-2 mb-1.5 px-1 {{ $isMine ? 'justify-end' : 'justify-start' }}">
                            <span class="text-xs font-black text-slate-800">
                                {{ $msg->sender_name }}
                            </span>
                            <span
                                class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md {{ $isMine ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($msg->sender_role) }}
                            </span>
                            <span class="text-[10px] font-medium text-slate-400">
                                • {{ $msg->created_at->diffForHumans() }}
                            </span>
                        </div>

                        {{-- Bulle de Message --}}
                        <div
                            class="p-5 rounded-3xl shadow-sm border text-sm leading-relaxed transition-all duration-200 {{ $isMine
                                ? 'bg-slate-950 text-white rounded-tr-none border-slate-900'
                                : 'bg-slate-50/80 text-slate-800 rounded-tl-none border-slate-100' }}">
                            <p class="whitespace-pre-line font-medium">{{ $msg->message }}</p>

                            {{-- Pièce Jointe --}}
                            @if ($msg->file)
                                <div class="mt-4 pt-3 border-t {{ $isMine ? 'border-slate-800' : 'border-slate-200/60' }}">
                                    <a href="{{ asset('storage/' . $msg->file) }}" target="_blank"
                                        class="inline-flex items-center space-x-2.5 px-3.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 {{ $isMine
                                            ? 'bg-slate-800 hover:bg-slate-700 text-amber-400'
                                            : 'bg-white hover:bg-amber-500 hover:text-white text-slate-700 shadow-sm border border-slate-200/80' }}">
                                        <i class="fas fa-paperclip text-amber-400"></i>
                                        <span>Consulter le fichier joint</span>
                                        <i class="fas fa-external-link-alt text-[10px] opacity-70"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 mb-4 border border-amber-100">
                        <i class="fas fa-comments text-2xl"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Aucun message pour le moment</h3>
                    <p class="text-slate-400 text-sm font-medium mt-1 max-w-xs mx-auto">Soyez le premier à lancer la
                        conversation dans ce canal.</p>
                </div>
            @endforelse
        </div>

        {{-- Formulaire d'Envoi --}}
        <form action="{{ route('messagerie.send') }}" method="POST" enctype="multipart/form-data"
            class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xl shadow-slate-200/50 space-y-4">
            @csrf

            <div class="relative">
                <textarea name="message" rows="3"
                    onkeydown="if (event.key === 'Enter' && !event.shiftKey && !event.isComposing) { event.preventDefault(); this.form.requestSubmit(); }"
                    class="w-full bg-slate-50 border border-slate-200/80 rounded-2xl p-4 text-sm font-medium text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 focus:bg-white transition-all outline-none resize-none"
                    placeholder="Tapez votre message ici..." required></textarea>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-2">
                {{-- Sélection Fichier --}}
                <div class="relative">
                    <label
                        class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 text-slate-600 text-xs font-bold cursor-pointer transition-all">
                        <i class="fas fa-paperclip text-slate-400"></i>
                        <span>Joindre un fichier</span>
                        <input type="file" name="file" class="hidden"
                            onchange="this.nextElementSibling.innerText = this.files[0] ? this.files[0].name : ''">
                        <span class="text-amber-600 font-normal ml-2 truncate max-w-[150px]"></span>
                    </label>
                </div>

                {{-- Bouton Envoyer --}}
                <button type="submit"
                    class="inline-flex items-center justify-center space-x-2.5 bg-slate-950 hover:bg-slate-800 text-white px-8 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 shadow-xl shadow-slate-950/10 hover:shadow-slate-950/20 active:scale-95 shrink-0">
                    <span>Envoyer</span>
                    <i class="fas fa-paper-plane text-xs text-amber-400"></i>
                </button>
            </div>
        </form>
    </div>
@endsection
