<!-- Page d'accueil -->
<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Bienvenue sur votre Portail RH</h1>
            <p class="text-lg text-gray-600">Gérez vos congés et notes de frais en toute simplicité</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Carte Congés -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg hover:shadow-2xl transition duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Gestion des Congés</h2>
                    <p class="text-gray-600 mb-4">Demandez et suivez vos congés en quelques clics</p>
                    <a href="{{ route('leaves.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300">
                        Nouvelle demande
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Carte Notes de Frais -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg hover:shadow-2xl transition duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Notes de Frais</h2>
                    <p class="text-gray-600 mb-4">Soumettez et gérez vos notes de frais facilement</p>
                    <a href="{{ route('expense-reports.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-300">
                        Nouvelle note
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Carte Tableau de Bord -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg hover:shadow-2xl transition duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Tableau de Bord</h2>
                    <p class="text-gray-600 mb-4">Visualisez vos statistiques et demandes en cours</p>
                    <a href="{{ route('leaves.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition duration-300">
                        Voir les stats
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Section Statistiques Rapides -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-sm font-medium text-gray-500">Congés restants</div>
                <div class="mt-2 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900">{{ auth()->user()->remaining_days }}</span>
                    <span class="ml-2 text-sm text-gray-600">jours</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-sm font-medium text-gray-500">Notes en attente</div>
                <div class="mt-2 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900">{{ auth()->user()->pending_notes }}</span>
                    <span class="ml-2 text-sm text-gray-600">notes</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-sm font-medium text-gray-500">Prochain congé</div>
                <div class="mt-2 text-gray-900 font-medium">
                    @php
                        $nextLeave = auth()->user()->leaves()
                            ->where('start_date', '>=', now())
                            ->where('status', 'approved')
                            ->orderBy('start_date', 'asc')
                            ->first();

                        $mois = [
                            1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
                            5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
                            9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
                        ];

                        if ($nextLeave) {
                            $date = $nextLeave->start_date->day . ' ' . $mois[$nextLeave->start_date->month] . ' ' . $nextLeave->start_date->year;
                            echo $date;
                        } else {
                            echo 'Aucun congé prévu';
                        }
                    @endphp
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
