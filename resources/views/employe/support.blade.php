@extends('layouts.appdash')

@section('content')
    <div class="space-y-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">💬 Support & Aide</h2>

        {{-- 📨 Section contact support --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- 📧 Email --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                <h3 class="flex items-center text-gray-800 font-semibold mb-2">
                    <span class="text-yellow-500 mr-2">📧</span> Email de support
                </h3>
                <p class="text-gray-600 mb-2">Contactez-nous par email</p>
                <p class="text-yellow-500 font-semibold text-sm">elvirexadmin@gmail.com</p>
                <p class="text-gray-400 text-xs mt-1">Réponse sous 24h ouvrées</p>
            </div>

            {{-- 📞 Téléphone --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                <h3 class="flex items-center text-gray-800 font-semibold mb-2">
                    <span class="text-green-600 mr-2">📞</span> Support téléphonique
                </h3>
                <p class="text-gray-600 mb-2">Appelez-nous directement</p>
                <p class="text-green-600 font-semibold text-sm">+229 0196454393</p>
                <p class="text-gray-400 text-xs mt-1">Lun - Jeu : 9h à 18h<br>Ven : 9h à 12h</p>
            </div>
        </div>

        {{-- 💌 Formulaire de message --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <h3 class="flex items-center text-yellow-500 font-semibold mb-4">
                💬 Envoyer un message
            </h3>

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                    class="mb-3 rounded shadow-sm border border-emerald-200 bg-emerald-50 p-3 text-green-700 transition-all">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-3 p-3 bg-red-100 text-red-700 rounded shadow-sm">
                    ⚠️ Une erreur est survenue. Vérifiez les champs.
                </div>
            @endif


            <form action="{{ route('employe.support.send') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Sujet</label>
                    <input type="text" name="subject" placeholder="Ex : Problème de pointage"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-yellow-400 focus:border-yellow-400">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Message</label>
                    <textarea name="message" rows="4" placeholder="Décrivez votre problème en détail..."
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-yellow-400 focus:border-yellow-400"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-md font-medium transition">
                    Envoyer le message
                </button>
            </form>
        </div>

        {{-- ❓ FAQ Section --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <h3 class="text-gray-800 font-semibold mb-2">❓ Questions fréquentes (FAQ)</h3>
            <p class="text-gray-500 text-sm mb-4">Trouvez rapidement des réponses à vos questions</p>

            <div x-data="{ open1: false, open2: false }" class="space-y-2">
                {{-- Question 1 --}}
                <div class="border-t border-gray-200 py-2">
                    <button @click="open1 = !open1"
                        class="w-full flex justify-between items-center text-left font-medium text-gray-800">
                        Comment effectuer mon pointage quotidien ?
                        <span x-text="open1 ? '−' : '+'"></span>
                    </button>
                    <div x-show="open1" x-transition class="mt-2 text-gray-600 text-sm">
                        Vous pouvez effectuer votre pointage en cliquant sur le bouton “🕓 Pointer ma présence” dans votre
                        tableau de bord employé.
                    </div>
                </div>

                {{-- Question 2 --}}
                <div class="border-t border-gray-200 py-2">
                    <button @click="open2 = !open2"
                        class="w-full flex justify-between items-center text-left font-medium text-gray-800">
                        Comment signaler une absence ?
                        <span x-text="open2 ? '−' : '+'"></span>
                    </button>
                    <div x-show="open2" x-transition class="mt-2 text-gray-600 text-sm">
                        Rendez-vous dans la section “📅 Mes absences” puis cliquez sur “➕ Nouvelle demande”. Remplissez le
                        formulaire et soumettez.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
