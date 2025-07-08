<!-- Page d'accueil -->
<x-app-layout>
<div class="pb-12">
    <div class="bg-lime-50 dark:bg-darkblack-600 border-2 border-lime-200 rounded-2xl mb-10">

        <div class="flex flex-col lg:flex-row justify-between ">
           <div class="lg:w-1/2 px-5 xl:pl-12 flex items-center justify-center">
                <div class="p-20 relative">
                    <!-- <div aria-hidden="true">
                        <img src="{{ asset('images/shapes/square.svg') }}" alt="" />
                        <img src="{{ asset('images/shapes/vline.svg') }}" alt="" />
                        <img src="{{ asset('images/shapes/dotted.svg') }}" alt="" />
                    </div> -->

                    <div class="text-center max-w-lg px-1.5 m-auto">
                    <h1
                        class="text-bgray-900 dark:text-white font-bold font-popins text-4xl mb-4"
                    >
                        Bienvenue sur votre Portail RH
                    </h1>
                    <p class="text-bgray-600 dark:text-darkblack-300 text-lg font-medium">
                        Gérez vos congés et notes de frais en toute simplicité
                    </p>
                    <!-- <p class="text-bgray-600 dark:text-bgray-50 text-sm font-medium">
                        Notre plateforme complète vous aide à gérer vos congés, notes de frais,
                        paie et communications en toute simplicité. Soumettez vos demandes,
                        suivez leur statut et communiquez avec votre équipe grâce à la messagerie
                        intégrée. Profitez d'une <span class="text-success-300 font-bold">solution tout-en-un</span>
                        pour votre gestion RH
                        </p> -->
                    </div>
                </div>
           </div>

           <div class="lg:w-1/2 px-5 xl:pl-12">
                <div class="relative">
                    


                    <div class="w-full lg:block hidden  relative">
                        <ul>
                            <li class="absolute top-10 left-8">
                            <img src="{{ asset('images/shapes/square.svg') }}" alt="" />
                            </li>
                            <li class="absolute right-12 top-14">
                            <img src="{{ asset('images/shapes/vline.svg') }}" alt="" />
                            </li>
                            <li class="absolute bottom-7 left-8">
                            <img src="{{ asset('images/shapes/dotted.svg') }}" alt="" />
                            </li>
                        </ul>
                        <div class="mb-2">
                            <img 
                            class="m-auto max-h-[225px]"
                            style="max-height: 225px;"
                            src="{{ asset('images/illustration/signup.svg') }}"
                            alt=""
                            />
                        </div>
                        
                    </div>

                </div>
           </div>

        </div>
    </div>



    <div class="mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Carte Congés -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 p-1 shadow-xl hover:shadow-2xl transition-all duration-500">
                <div class="relative h-full rounded-xl bg-white dark:bg-gray-900 p-8 transition-all duration-300">
                    <!-- Effet de particules animées -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-6 right-4 w-2 h-2 bg-emerald-400 rounded-full animate-ping animation-delay-200"></div>
                        <div class="absolute top-12 left-6 w-1 h-1 bg-teal-400 rounded-full animate-pulse animation-delay-500"></div>
                        <div class="absolute bottom-8 right-8 w-1.5 h-1.5 bg-cyan-400 rounded-full animate-bounce animation-delay-700"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900 dark:to-teal-900 rounded-2xl mb-6 transition-transform duration-300">
                            <svg class="w-10 h-10 text-emerald-600 dark:text-emerald-400 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-3">Gestion des Congés</h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">Demandez et suivez vos congés en quelques clics ✨</p>
                        <a href="{{ route('leaves.create') }}" class="group/btn relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-teal-600 to-cyan-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></span>
                            <span class="relative z-10">Nouvelle demande</span>
                            <svg class="relative z-10 ml-2 w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carte Notes de Frais -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-sky-500 via-blue-500 to-indigo-500 p-1 shadow-xl hover:shadow-2xl transition-all duration-500">
                <div class="relative h-full rounded-xl bg-white dark:bg-gray-900 p-8 transition-all duration-300">
                    <!-- Effet de particules animées -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-6 right-4 w-2 h-2 bg-sky-400 rounded-full animate-ping animation-delay-200"></div>
                        <div class="absolute top-12 left-6 w-1 h-1 bg-teal-400 rounded-full animate-pulse animation-delay-500"></div>
                        <div class="absolute bottom-8 right-8 w-1.5 h-1.5 bg-cyan-400 rounded-full animate-bounce animation-delay-700"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-100 to-blue-100 dark:from-indigo-900 dark:to-blue-900 rounded-2xl mb-6 transition-transform duration-300">
                            <svg class="w-10 h-10 text-sky-600 dark:text-blue-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent mb-3">Notes de Frais</h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">Soumettez et gérez vos notes de frais facilement 💰</p>
              
                        <a href="{{ route('expense-reports.create') }}" class="group/btn relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-blue-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></span>
                            <span class="relative z-10">Nouvelle note</span>
                            <svg class="relative z-10 ml-2 w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carte Tableau de Bord -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-teal-500 via-emerald-500 to-lime-500 p-1 shadow-xl hover:shadow-2xl transition-all duration-500">
                <div class="relative h-full rounded-xl bg-white dark:bg-gray-900 p-8 transition-all duration-300">
                    <!-- Effet de particules animées -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-8 left-8 w-2 h-2 bg-cyan-400 rounded-full animate-ping animation-delay-300"></div>
                        <div class="absolute top-4 right-8 w-1 h-1 bg-lime-400 rounded-full animate-pulse animation-delay-600"></div>
                        <div class="absolute bottom-4 left-4 w-1.5 h-1.5 bg-lime-400 rounded-full animate-bounce animation-delay-900"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-br from-cyan-100 to-lime-100 dark:from-cyan-900 dark:to-lime-900 rounded-2xl mb-6 transition-transform duration-300">
                            <svg class="w-10 h-10 text-cyan-600 dark:text-cyan-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-lime-600 bg-clip-text text-transparent mb-3">Tableau de Bord</h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">Visualisez vos statistiques et demandes en cours 📊</p>
                        <a href="{{ route('leaves.index') }}" class="group/btn relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500 to-lime-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-lime-600 to-emerald-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></span>
                            <span class="relative z-10">Voir les stats</span>
                            <svg class="relative z-10 ml-2 w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Statistiques Rapides -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Total employés -->
            <div class="group relative bg-gradient-to-br from-emerald-50 to-green-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg transition-all duration-300 transform border border-emerald-200/50 dark:border-emerald-600/30 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-400/20 to-green-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative flex items-center">
                    <div class="flex-shrink-0 p-4 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl shadow-lg group-hover:shadow-emerald-500/25 transition-all duration-300 group-hover:scale-105">
                        <!-- Icon Employés -->
                       
                       

                        <svg class="w-9 h-9 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>

                    </div>
                    <div class="ml-6 flex-1">
                        <h3 class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 tracking-wider uppercase mb-1">Congés restants</h3>
                       <div class="mt-2 flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">{{ auth()->user()->remaining_days }}</span>
                            <span class="ml-2 text-3xl font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">jours</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total congés -->
            <div class="group relative bg-gradient-to-br from-blue-50 to-sky-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg transition-all duration-300 transform border border-blue-200/50 dark:border-blue-600/30 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-sky-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative flex items-center">
                    <div class="flex-shrink-0 p-4 bg-gradient-to-br from-blue-500 to-sky-600 rounded-xl shadow-lg group-hover:shadow-blue-500/25 transition-all duration-300 group-hover:scale-105">
                        <!-- Icon holiday -->
                        <svg aria-hidden="true" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 97.92 122.88" style="enable-background:new 0 0 97.92 122.88" xml:space="preserve" class="h-8 w-8 text-white drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M68.17,0.66C67.73,0.26,67.11,0,66.5,0c-0.13,0-0.26,0-0.4,0.04H5.54c-1.49,0-2.9,0.62-3.91,1.63C0.62,2.68,0,4.04,0,5.58 v111.76c0,1.54,0.62,2.9,1.63,3.91c1.01,1.01,2.37,1.63,3.91,1.63c28.22,0,58.68,0,86.76,0c1.54,0,2.9-0.62,3.91-1.63 c1.01-1.01,1.63-2.37,1.63-3.91V32.3c0.04-0.22,0.09-0.4,0.09-0.62c0-0.75-0.35-1.41-0.84-1.89L68.47,0.84 c-0.09-0.09-0.13-0.13-0.22-0.18H68.17L68.17,0.66z M20.53,19.68c-1.36,0-2.5,1.1-2.5,2.51c0,1.36,1.1,2.5,2.5,2.5h17.15 c1.36,0,2.51-1.1,2.51-2.5c0-1.36-1.1-2.51-2.51-2.51H20.53L20.53,19.68z M39.13,83.35h-8.88v-1.47c0-1.57-0.11-2.59-0.31-3.07 c-0.2-0.49-0.64-0.73-1.31-0.73c-0.54,0-0.95,0.21-1.22,0.62C27.14,79.13,27,79.75,27,80.59c0,1.39,0.28,2.37,0.83,2.92 c0.54,0.56,2.14,1.64,4.79,3.25c2.25,1.37,3.79,2.41,4.61,3.13c0.82,0.73,1.51,1.75,2.07,3.08c0.56,1.33,0.85,2.98,0.85,4.96 c0,3.16-0.76,5.65-2.28,7.45c-1.52,1.8-3.82,2.91-6.86,3.34v3.33h-4.1v-3.42c-2.37-0.23-4.45-1.15-6.22-2.74 c-1.77-1.58-2.66-4.36-2.66-8.32v-1.74h8.88v2.17c0,2.39,0.09,3.87,0.28,4.45c0.18,0.58,0.62,0.86,1.32,0.86 c0.6,0,1.05-0.2,1.34-0.6c0.29-0.41,0.44-1.01,0.44-1.8c0-1.99-0.14-3.42-0.42-4.27c-0.28-0.86-1.22-1.8-2.85-2.8 c-2.71-1.7-4.55-2.95-5.53-3.75c-0.97-0.8-1.82-1.92-2.52-3.38c-0.71-1.45-1.07-3.09-1.07-4.92c0-2.65,0.75-4.73,2.25-6.24 c1.5-1.51,3.76-2.44,6.76-2.79v-2.84h4.1v2.84c2.74,0.35,4.79,1.27,6.16,2.76c1.36,1.49,2.04,3.55,2.04,6.17 C39.22,82.05,39.19,82.61,39.13,83.35L39.13,83.35z M63.99,5.01v21.67c0,2.07,0.84,3.96,2.2,5.32c1.36,1.36,3.25,2.2,5.32,2.2 h21.27v83.15c0,0.13-0.04,0.31-0.18,0.4c-0.09,0.09-0.22,0.18-0.4,0.18c-22.34,0-64.98,0-86.71,0c-0.13,0-0.31-0.04-0.4-0.18 c-0.09-0.09-0.18-0.26-0.18-0.4V5.58c0-0.18,0.04-0.31,0.18-0.4c0.09-0.09,0.22-0.18,0.4-0.18h58.45H63.99L63.99,5.01z M68.96,26.68V8.53l20.44,20.7H71.51c-0.7,0-1.32-0.31-1.8-0.75C69.26,28.04,68.96,27.38,68.96,26.68L68.96,26.68z M20.52,36.96 c-1.36,0-2.5,1.1-2.5,2.51c0,1.36,1.1,2.51,2.5,2.51h43.86c1.36,0,2.51-1.1,2.51-2.51c0-1.36-1.1-2.51-2.51-2.51H20.52L20.52,36.96 z M49,70.36c-1.36,0-2.5,1.1-2.5,2.51c0,1.36,1.1,2.51,2.5,2.51h28.22c1.36,0,2.51-1.1,2.51-2.51c0-1.36-1.1-2.51-2.51-2.51H49 L49,70.36z M20.52,53.66c-1.36,0-2.5,1.1-2.5,2.51c0,1.36,1.1,2.51,2.5,2.51h56.69c1.36,0,2.51-1.10,2.51-2.51 c0-1.36-1.1-2.51-2.51-2.51H20.52L20.52,53.66z"/>
                        </svg>
                    </div>
                    <div class="ml-6 flex-1">
                        <h3 class="text-sm font-semibold text-blue-600 dark:text-blue-400 tracking-wider uppercase mb-1">Notes en attente</h3>
                        
                        <div class="mt-2 flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">{{ auth()->user()->pending_notes }}</span>
                            <span class="ml-2 text-2xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">notes</span>
                        </div>
                   
                    </div>
                </div>
            </div>
            
                <!-- Total note de frais -->
            <div class="group relative bg-gradient-to-br from-teal-50 to-cyan-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg transition-all duration-300 transform border border-teal-200/50 dark:border-teal-600/30 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-teal-400/20 to-cyan-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative flex items-center">
                    <div class="flex-shrink-0 p-4 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl shadow-lg group-hover:shadow-teal-500/25 transition-all duration-300 group-hover:scale-105">
                        <!-- Icon expense -->
                         <svg aria-hidden="true" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 94.46" style="enable-background:new 0 0 122.88 94.46" xml:space="preserve" class="h-8 w-8 text-white drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path class="st0" d="M16.12,57.81c1.18-13.83,3.59-25.21,13.49-29.72c4.51,13.63,2.48,26.79-1.88,41.21 C13.95,71.23,1.47,75.67,1.47,84.48c6.65,1.81,11.38-0.71,15.35-5.96c8.88,7.71,14.54,10.06,23.47-0.45 c5.83,10.17,17.37,7.79,23.48,0.32c6.75,8.76,18.41,9.44,23.32-1.44c7.1,10.93,18.15,9.32,23.37,0.67 c3.32,4.15,5.05,6.84,10.66,7.27c-3.69-11.94-16.91-17.53-33.9-18.17c-2.58-8.69-3.73-16.65-1-24.89c6.11,2.78,7.59,9.8,8.32,18.34 l-0.01,0.01c2.4-5.92,3.88-11.32,0.51-17.43c3.21,0.34,6.24,2.25,9.45,5.19c-2.65-5.68-6.95-10-14.63-9.03 c4.28-2.87,9.35-2.38,14.24-1.24c-5.09-5.37-10.63-7.62-17.27-1.53c-0.23-3.7,1.3-6.91,3.33-9.99c-4.3,1.71-7.51,3.58-6.51,11.37 c-7.35-6.21-15.57-3.58-18.45,7.29c5.39-4.77,11.13-7.19,17.25-5.3c-10.7,4.01-13.57,10.19-9.06,18.6 c3.21-8.12,6.57-13.23,10.33-15.6c-2.05,5.17-3.82,10.9-1.77,24.15C75.35,66.8,68.3,67.6,61.11,69c-4.46-0.87-14.23-1.33-24.6-0.61 c3.33-21.5,0.47-30.78-2.86-39.17C39.76,33.06,45.2,41.34,50.4,54.5c7.31-13.62,2.66-23.64-14.69-30.14 c9.92-3.08,19.22,0.86,27.97,8.58c-4.67-17.63-18-21.88-29.91-11.82C35.39,8.5,30.19,5.47,23.22,2.69c3.28,5,5.76,10.2,5.39,16.19 C17.86,9.01,8.88,12.66,0.62,21.36c7.93-1.85,16.15-2.64,23.08,2.01C11.26,21.8,4.3,28.81,0,38.01c5.2-4.77,10.11-7.86,15.31-8.42 c-5.46,9.9-3.05,18.64,0.83,28.24L16.12,57.81L16.12,57.81z M65.51,21.46c-0.21,0.36-0.66,0.48-1.02,0.28 c-0.36-0.21-0.48-0.66-0.28-1.02l0.96-1.67c0.21-0.36,0.66-0.48,1.02-0.28c0.36,0.21,0.48,0.66,0.28,1.02L65.51,21.46L65.51,21.46 L65.51,21.46z M70.46,4.99c1.85,0,3.53,0.75,4.74,1.96c1.21,1.21,1.96,2.89,1.96,4.74c0,1.85-0.75,3.53-1.96,4.74 c-1.21,1.21-2.89,1.96-4.74,1.96c-1.85,0-3.53-0.75-4.74-1.96c-1.21-1.21-1.96-2.89-1.96-4.74c0-1.85,0.75-3.53,1.96-4.74 C66.94,5.74,68.61,4.99,70.46,4.99L70.46,4.99z M79.64,5.71C80,5.5,80.46,5.62,80.67,5.98C80.87,6.34,80.75,6.8,80.39,7l-1.67,0.96 c-0.36,0.21-0.82,0.09-1.02-0.27c-0.21-0.36-0.09-0.82,0.27-1.02L79.64,5.71L79.64,5.71z M81.41,11.1c0.41,0,0.75,0.34,0.75,0.75 c0,0.41-0.34,0.75-0.75,0.75h-1.92c-0.41,0-0.75-0.34-0.75-0.75c0-0.41,0.34-0.75,0.75-0.75H81.41L81.41,11.1z M64.48,2.52 c-0.21-0.36-0.09-0.82,0.27-1.02c0.36-0.21,0.82-0.09,1.02,0.27l0.96,1.67c0.21,0.36,0.09,0.82-0.27,1.02 c-0.36,0.21-0.82,0.09-1.02-0.27L64.48,2.52L64.48,2.52z M69.87,0.75C69.87,0.34,70.2,0,70.62,0c0.41,0,0.75,0.34,0.75,0.75v1.92 c0,0.41-0.34,0.75-0.75,0.75c-0.41,0-0.75-0.34-0.75-0.75V0.75L69.87,0.75z M75.42,1.92c0.21-0.36,0.66-0.48,1.02-0.28 c0.36,0.21,0.48,0.66,0.28,1.02l-0.96,1.67c-0.21,0.36-0.66,0.48-1.02,0.28c-0.36-0.21-0.48-0.66-0.28-1.02L75.42,1.92L75.42,1.92 L75.42,1.92z M80.24,16.65c0.36,0.21,0.48,0.66,0.28,1.02c-0.21,0.36-0.66,0.48-1.02,0.28l-1.67-0.96 c-0.36-0.21-0.48-0.66-0.28-1.02c0.21-0.36,0.66-0.48,1.02-0.28L80.24,16.65L80.24,16.65L80.24,16.65z M61.29,17.68 c-0.36,0.21-0.82,0.09-1.02-0.27c-0.21-0.36-0.09-0.82,0.27-1.02l1.67-0.96c0.36-0.21,0.82-0.09,1.02,0.27 c0.21,0.36,0.09,0.82-0.27,1.02L61.29,17.68L61.29,17.68z M59.52,12.29c-0.41,0-0.75-0.34-0.75-0.75c0-0.41,0.34-0.75,0.75-0.75 h1.92c0.41,0,0.75,0.34,0.75,0.75c0,0.41-0.34,0.75-0.75,0.75H59.52L59.52,12.29z M60.69,6.74c-0.36-0.21-0.48-0.66-0.28-1.02 c0.21-0.36,0.66-0.48,1.02-0.28l1.67,0.96c0.36,0.21,0.48,0.66,0.28,1.02c-0.21,0.36-0.66,0.48-1.02,0.28L60.69,6.74L60.69,6.74 L60.69,6.74z M76.45,20.87c0.21,0.36,0.09,0.82-0.27,1.02c-0.36,0.21-0.82,0.09-1.02-0.27l-0.96-1.67 c-0.21-0.36-0.09-0.82,0.27-1.02c0.36-0.21,0.82-0.09,1.02,0.27L76.45,20.87L76.45,20.87z M71.06,22.63c0,0.41-0.34,0.75-0.75,0.75 c-0.41,0-0.75-0.34-0.75-0.75v-1.92c0-0.41,0.34-0.75,0.75-0.75c0.41,0,0.75,0.34,0.75,0.75V22.63L71.06,22.63z M0.93,89.61 C2.43,89.95,4,90.1,5.56,90.06c2.17-0.06,4.31-0.48,6.17-1.25c2.18-0.9,4.19-2.35,5.04-4.6c0.78,2.16,2.92,3.74,5.01,4.6 c1.86,0.77,4.01,1.2,6.17,1.25c2.17,0.06,4.37-0.25,6.34-0.95c3.16-1.11,3.83-2.56,5.91-5.01h0c1.2,2.57,3.3,4.09,5.91,5.01 c1.97,0.69,4.17,1,6.34,0.95c2.17-0.06,4.31-0.48,6.17-1.25c2.09-0.86,4.23-2.45,5.01-4.6c0.85,2.25,2.88,3.7,5.04,4.6 c1.86,0.77,4.01,1.2,6.17,1.25c2.17,0.06,4.37-0.25,6.34-0.95c3.15-1.11,3.83-2.57,5.91-5.01c2.08,2.43,2.77,3.9,5.92,5.01 c1.97,0.69,4.17,1,6.34,0.95c2.17-0.06,4.31-0.48,6.17-1.25c2.17-0.9,4.19-2.34,5.04-4.6c0.78,2.15,2.92,3.73,5.01,4.6 c1.86,0.77,4.01,1.2,6.17,1.25c0.38,0.01,0.76,0.01,1.13,0v4.4c-3.12,0.08-6.28-0.45-9.02-1.58c-1.42-0.59-2.53-1.16-3.53-1.88 c-1.35,0.92-2.69,1.71-3.1,1.88c-4.78,1.98-10.85,2.11-15.72,0.39c-1.61-0.57-3.1-1.33-4.41-2.31c-1.31,0.98-2.81,1.74-4.41,2.31 c-4.88,1.72-10.95,1.58-15.73-0.39c-0.41-0.17-1.74-0.97-3.1-1.88c-1,0.72-2.11,1.3-3.53,1.88c-4.78,1.98-10.85,2.11-15.73,0.39 c-1.42-0.5-2.81-1.13-4.04-1.94c-1.64,0.8-3.53,1.5-4.77,1.94c-4.87,1.72-10.95,1.58-15.72-0.39c-1.42-0.59-2.53-1.16-3.53-1.88 c-1.35,0.92-2.69,1.71-3.1,1.88c-3.77,1.56-8.35,1.97-12.51,1.23V89.61L0.93,89.61z"/>
                        </svg>
                    </div>
                    <div class="ml-6 flex-1">
                        <h3 class="text-sm font-semibold text-teal-600 dark:text-teal-400 tracking-wider uppercase mb-1">Prochain congé</h3>
                     
                    <div class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors duration-300">
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
    
</div>

</x-app-layout>
