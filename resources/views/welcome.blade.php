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
            <div class="bg-white dark:bg-gray-800 overflow-hidden border border-indigo-100 dark:border-gray-500 rounded-lg hover:shadow-2xl transition duration-300">
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden border border-indigo-100 dark:border-gray-500 rounded-lg hover:shadow-2xl transition duration-300">
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden border border-indigo-100 dark:border-gray-500 rounded-lg hover:shadow-2xl transition duration-300">
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
            <!-- Congés restants -->
            <div class="flex flex-col p-4 space-y-6 transition-all duration-500 bg-white dark:bg-gray-700 border border-indigo-100 dark:border-gray-500 rounded-lg  hover:shadow-xl lg:p-6 lg:flex-row lg:space-y-0 lg:space-x-6">
                <div class="flex items-center justify-center w-16 h-16 bg-gray-100 border border-gray-200 rounded-lg shadow-inner lg:h-20 lg:w-20">
                   

                   

                </div>
                <div class="flex-1">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Congés restants</div>
                    <div class="mt-2 flex items-baseline">
                        <span class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ auth()->user()->remaining_days }}</span>
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">jours</span>
                    </div>
                </div>
            </div>
            <!-- Notes en attente -->
            <div class="flex flex-col p-4 space-y-6 transition-all duration-500 bg-white dark:bg-gray-700 border border-indigo-100 dark:border-gray-500 rounded-lg hover:shadow-xl lg:p-6 lg:flex-row lg:space-y-0 lg:space-x-6">
                <div
                    class="flex items-center justify-center w-16 h-16 bg-gray-100 border border-gray-200 rounded-lg shadow-inner lg:h-20 lg:w-20">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes en attente</div>
                    <div class="mt-2 flex items-baseline">
                        <span class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ auth()->user()->pending_notes }}</span>
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">notes</span>
                    </div>
                </div>
            </div>
            <!-- Prochain congé -->
            <div class="flex flex-col p-4 space-y-6 transition-all duration-500 bg-white dark:bg-gray-700 border border-indigo-100 dark:border-gray-500 rounded-lg hover:shadow-xl lg:p-6 lg:flex-row lg:space-y-0 lg:space-x-6">
                <div class="flex items-center justify-center w-16 h-16 bg-purple-100 border border-gray-200 rounded-lg shadow-inner lg:h-20 lg:w-20">
                    <svg aria-hidden="true" class="w-12 h-12 text-green-500" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 120.05">
                        <defs><style>.cls-1{fill-rule:evenodd;}</style></defs>
                        <title>guest-traveler</title>
                        <path class="cls-1" d="M90.54,38.25c2.23-.75,4.58.44,6.13,2.3h18.46a.51.51,0,0,1,.51.51v4.86a.51.51,0,0,1-.51.51H111.9V62.62h-3.73V46.43H98.11a9.11,9.11,0,0,1-2.36,3.36V62.62H92V52.41a57.27,57.27,0,0,1-8,3.38,84.35,84.35,0,0,1-9,2.79,18,18,0,0,1-15.71-4,41.48,41.48,0,0,1-3.49-3.35l-.34-.36-3,17.75a62.39,62.39,0,0,0,7.2,4.17c7.78,3.63,14.18,6.63,15.55,18.85.25,2.14.14,14.68,0,20.84H86a1.8,1.8,0,0,1-.67-1.43v-1.89a4.77,4.77,0,0,1-4.71-4.76v-36a4.78,4.78,0,0,1,4.76-4.76h1.09a.91.91,0,0,0,0,.23l1.19,4.54a7.4,7.4,0,0,0,1.79,3.38A4.22,4.22,0,0,0,92.58,73h4.77v2.55c0,.41,1.92.73,2.32.73H106a.72.72,0,0,0,.73-.72V73h5a4.36,4.36,0,0,0,3.16-1.32,6.81,6.81,0,0,0,1.72-3.4l1-4.48a1,1,0,0,0,0-.24h.51a4.78,4.78,0,0,1,4.76,4.76v36.05a4.77,4.77,0,0,1-4.71,4.76V111a1.8,1.8,0,0,1-.67,1.43h5.38v7.58H0v-7.58H19.83c1.41-3.79,2.86-7.83,4.28-11.89,2.93-8.39,5.74-17,7.8-23.84a22,22,0,0,1-3.21-5.06A11.33,11.33,0,0,1,27.82,65l4.33-21.82c-1.55-.08-3.34-.54-4.8.1-2.83,1.24-7,6.52-9.47,9l-3.31,3.35c-2.55,2.58-4.25,5.44-8.15,5.13-4.84-.38-8.3-5.76-4.89-9.89l7.63-7.72c3.67-3.73,7.16-8.12,11.69-10.68C24.49,30.41,28.45,29,35,29.28c2.4,0,4.94.27,7.34.5l2.8.24c11,.71,16.12,6.5,20.12,11,1.77,2,3.29,3.7,4.94,4.49.78.37,2-.15,3.39-.73L83.76,41l6.78-2.72ZM61.15,112.47c.14-6.94.29-16.73.18-18.62-.09-1.35-1-4.92-2.42-5.57a59.35,59.35,0,0,0-5.83-2.17c-2.75-.91-5-1.83-7.72-2.58-2,6.58-4.68,14.52-7.57,22.09l-2.73,6.85Zm52.87,0H89.49a1.77,1.77,0,0,0,.67-1.43v-1.89h23.19V111a1.77,1.77,0,0,0,.67,1.43ZM88.91,100.24a.88.88,0,0,1,0-1.76h25.82a.88.88,0,0,1,0,1.76Zm0-8.51a.88.88,0,0,1,0-1.76h25.82a.88.88,0,1,1,0,1.76Zm0-8.51a.88.88,0,0,1,0-1.76h25.82a.88.88,0,1,1,0,1.76Zm26.73-18.75H88.5l.9,3.43a5.63,5.63,0,0,0,1.34,2.58,2.49,2.49,0,0,0,1.83.78h19.17a2.65,2.65,0,0,0,1.92-.81,5.09,5.09,0,0,0,1.24-2.51l.74-3.47ZM44.82.71a13.17,13.17,0,1,1-7.56,6.66A13.13,13.13,0,0,1,44.82.71Z"/>
                    </svg>

                </div>
                <div class="flex-1">
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
</div>

</x-app-layout>
