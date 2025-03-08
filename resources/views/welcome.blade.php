<!-- Page d'accueil -->
<x-app-layout>
<div class="py-12">
    <div class="relative py-16">
        <div aria-hidden="true"
            class="absolute inset-0 h-max w-full m-auto grid grid-cols-2 -space-x-52 opacity-40 dark:opacity-20">
            <div class="blur-[106px] h-56 bg-gradient-to-br from-blue-500 to-indigo-400 dark:from-indigo-700"></div>
            <div class="blur-[106px] h-32 bg-gradient-to-r from-blue-400 to-sky-300 dark:to-indigo-600"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
            <div class="relative">
                
                <div class="flex items-center justify-center -space-x-2">
                    <img loading="lazy" width="400" height="400" src="https://randomuser.me/api/portraits/women/12.jpg" alt="member photo" class="h-8 w-8 rounded-full object-cover">
                    <img loading="lazy" width="200" height="200" src="https://randomuser.me/api/portraits/women/45.jpg" alt="member photo" class="h-12 w-12 rounded-full object-cover">
                    <img loading="lazy" width="200" height="200" src="https://randomuser.me/api/portraits/women/60.jpg" alt="member photo" class="z-10 h-16 w-16 rounded-full object-cover">
                    <img loading="lazy" width="200" height="200" src="https://randomuser.me/api/portraits/women/4.jpg" alt="member photo" class="relative h-12 w-12 rounded-full object-cover">
                    <img loading="lazy" width="200" height="200" src="https://randomuser.me/api/portraits/women/34.jpg" alt="member photo" class="h-8 w-8 rounded-full object-cover">
                </div>

                <div class="mt-6 m-auto space-y-6 md:w-8/12 lg:w-7/12">
                    <h1 class="text-center text-4xl font-bold text-gray-800 dark:text-white md:text-5xl">Bienvenue sur votre Portail RH
                    </h1>
                    <p class="text-center text-xl text-gray-600 dark:text-gray-300">
                        Gérez vos congés et notes de frais en toute simplicité
                    </p>
                    <!-- <div class="flex flex-wrap justify-center gap-6">
                        <a href="#"
                            class="relative flex h-12 w-full items-center justify-center px-8 before:absolute before:inset-0 before:rounded-full before:bg-indigo-500 before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max">
                            <span class="relative text-base font-semibold text-white dark:text-dark">Get Started</span>
                        </a>
                        <a href="#"
                            class="relative flex h-12 w-full items-center justify-center px-8 before:absolute before:inset-0 before:rounded-full before:border before:border-transparent before:bg-indigo-500/10 before:bg-gradient-to-b before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 dark:before:border-gray-700 dark:before:bg-gray-800 sm:w-max">
                            <span class="relative text-base font-semibold text-indigo-500 dark:text-white">More about</span>
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>



    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">Bienvenue sur votre Portail RH</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">Gérez vos congés et notes de frais en toute simplicité</p>
        </div> -->

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Carte Congés -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg hover:shadow-2xl transition duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Gestion des Congés</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Demandez et suivez vos congés en quelques clics</p>
                    <a href="{{ route('leaves.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300">
                        Nouvelle demande
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Carte Notes de Frais -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg hover:shadow-2xl transition duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Notes de Frais</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Soumettez et gérez vos notes de frais facilement</p>
                    <a href="{{ route('expense-reports.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-300">
                        Nouvelle note
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Carte Tableau de Bord -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg hover:shadow-2xl transition duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Tableau de Bord</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Visualisez vos statistiques et demandes en cours</p>
                    <a href="{{ route('leaves.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 dark:bg-purple-500 hover:bg-purple-700 text-white font-semibold rounded-lg transition duration-300">
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
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Congés restants</div>
                <div class="mt-2 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ auth()->user()->remaining_days }}</span>
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">jours</span>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes en attente</div>
                <div class="mt-2 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ auth()->user()->pending_notes }}</span>
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">notes</span>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Prochain congé</div>
                <div class="mt-2 text-gray-900 dark:text-gray-100 font-medium">
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
