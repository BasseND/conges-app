<x-app-layout>

    <div class="w-full px-4">
        <!-- <div class="flex flex-col">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 sm:mb-0">Informations de la société</h4>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('welcome.index') }}" class="text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">Accueil</a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="text-gray-500 dark:text-gray-400">Société</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div> -->
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
            </div>
        @endif

        <div class="flex flex-col">
            <div class="w-full">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <h2 class="text-bgray-900 dark:text-white sm:text-2xl text-xl font-bold">
                                {{ __('Informations de la société') }}
                            </h2>
                            @if($company)
                                <a href="{{ route('admin.company.edit') }}" class="inline-flex items-center btn btn-primary">
                                    <i class="bx bx-edit-alt mr-1"></i> Modifier
                                </a>
                            @else
                                <a href="{{ route('admin.company.create') }}" class="inline-flex items-center btn btn-primary">
                                    <i class="bx bx-plus mr-1"></i> Créer
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                    
                        @if($company)
                            <div class="bg-gray-50 dark:bg-dark-card-two rounded-xl p-7 border border-gray-100">
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                    <div class="lg:col-span-4">
                                        <div class="text-center">
                                            @if($company->logo)
                                                <img src="{{ Storage::url($company->logo) }}" alt="Logo de la société" class="max-w-full h-auto rounded-lg max-h-48 mx-auto">
                                            @else
                                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center h-48">
                                                    <i class="bx bx-building text-gray-400 text-6xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="lg:col-span-8">
                                        <div class="grid md:grid-cols-2 gap-x-12 gap-y-4">
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Nom :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->name }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Adresse :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->address }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Ville :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->city }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Code postal :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->postal_code }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Pays :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->country }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Email :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->contact_email }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Téléphone :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->contact_phone }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Site web :</span>
                                                @if($company->website_url)
                                                    <a href="{{ $company->website_url }}" target="_blank" class="text-base font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">{{ $company->website_url }}</a>
                                                @else
                                                    <span class="text-base font-medium text-gray-400 dark:text-gray-500">Non renseigné</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bloc congés -->
                            <div class="bg-white dark:bg-dark-card-two rounded-xl  border border-gray-100 mt-6">
                                <div class="bg-gray-50 flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        <i class="bx bx-calendar mr-2"></i>Soldes de congés définis
                                    </h3>
                                    <button type="button" onclick="openLeaveBalanceModal()" class="inline-flex items-center btn btn-primary">
                                        <i class="bx bx-plus mr-1"></i> Ajouter un solde
                                    </button>
                                </div>
                                
                                @if($leaveBalances->count() > 0)
                                    <div class="grid gap-4">
                                        @foreach($leaveBalances as $balance)
                                            <div class="group relative bg-white dark:bg-gray-900 p-6 border-b border-gray-200 dark:border-gray-700 overflow-hidden">
                                                <!-- Decorative background element -->
                                                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/10 to-purple-500/10 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                                                
                                                <div class="flex justify-between items-start relative z-10">
                                                    <div class="flex-1">
                                                        <!-- Header -->
                                                        <div class="flex items-center mb-6">
                                                            <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-3 rounded-xl shadow-lg mr-4">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $balance->description }}</h4>
                                                                @if($balance->is_default)
                                                                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium bg-gradient-to-r from-green-400 to-emerald-500 text-white rounded-full shadow-sm">
                                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                                        </svg>
                                                                        Par défaut
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Leave types grid -->
                                                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                                                            <!-- Congés annuels -->
                                                            <div class="group/card relative bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-4 rounded-xl border border-blue-200/50 dark:border-blue-700/50">
                                                                <div class="flex items-center">
                                                                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-lg shadow-lg mr-4 group-hover/card:scale-110 transition-transform duration-300">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">Congés annuels</p>
                                                                        <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $balance->annual_leave_days }}</p>
                                                                        <p class="text-xs text-blue-600 dark:text-blue-400">jours</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Congés maladie -->
                                                            <div class="group/card relative bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 p-4 rounded-xl border border-red-200/50 dark:border-red-700/50">
                                                                <div class="flex items-center">
                                                                    <div class="bg-gradient-to-br from-red-500 to-red-600 p-3 rounded-lg shadow-lg mr-4 group-hover/card:scale-110 transition-transform duration-300">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm font-medium text-red-700 dark:text-red-300 mb-1">Congés maladie</p>
                                                                        <p class="text-2xl font-bold text-red-900 dark:text-red-100">{{ $balance->sick_leave_days }}</p>
                                                                        <p class="text-xs text-red-600 dark:text-red-400">jours</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @if($balance->maternity_leave_days)
                                                            <!-- Congés maternité -->
                                                            <div class="group/card relative bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 p-4 rounded-xl border border-pink-200/50 dark:border-pink-700/50">
                                                                <div class="flex items-center">
                                                                    <div class="bg-gradient-to-br from-pink-500 to-pink-600 p-3 rounded-lg shadow-lg mr-4 group-hover/card:scale-110 transition-transform duration-300">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm font-medium text-pink-700 dark:text-pink-300 mb-1">Congés maternité</p>
                                                                        <p class="text-2xl font-bold text-pink-900 dark:text-pink-100">{{ $balance->maternity_leave_days }}</p>
                                                                        <p class="text-xs text-pink-600 dark:text-pink-400">jours</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif

                                                            @if($balance->paternity_leave_days)
                                                            <!-- Congés paternité -->
                                                            <div class="group/card relative bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 p-4 rounded-xl border border-indigo-200/50 dark:border-indigo-700/50">
                                                                <div class="flex items-center">
                                                                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-3 rounded-lg shadow-lg mr-4 group-hover/card:scale-110 transition-transform duration-300">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm font-medium text-indigo-700 dark:text-indigo-300 mb-1">Congés paternité</p>
                                                                        <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-100">{{ $balance->paternity_leave_days }}</p>
                                                                        <p class="text-xs text-indigo-600 dark:text-indigo-400">jours</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif

                                                            @if($balance->special_leave_days)
                                                            <!-- Congés spéciaux -->
                                                            <div class="group/card relative bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 p-4 rounded-xl border border-teal-200/50 dark:border-teal-700/50">
                                                                <div class="flex items-center">
                                                                    <div class="bg-gradient-to-br from-teal-500 to-teal-600 p-3 rounded-lg shadow-lg mr-4 group-hover/card:scale-110 transition-transform duration-300">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm font-medium text-teal-700 dark:text-teal-300 mb-1">Congés spéciaux</p>
                                                                        <p class="text-2xl font-bold text-teal-900 dark:text-teal-100">{{ $balance->special_leave_days }}</p>
                                                                        <p class="text-xs text-teal-600 dark:text-teal-400">jours</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        
                                                        <!-- Total summary -->
                                                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800/50 dark:to-gray-700/50 p-4 rounded-xl border border-gray-200/50 dark:border-gray-600/50">
                                                            <div class="flex items-center justify-center">
                                                                <div class="bg-gradient-to-br from-gray-600 to-gray-700 p-3 rounded-lg shadow-lg mr-4">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l-1-3m1 3l-1-3m-16.5-3h9.75" />
                                                                    </svg>
                                                                </div>
                                                                <div class="text-center">
                                                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total des congés</p>
                                                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $balance->total_leave_days }}</p>
                                                                    <p class="text-sm text-gray-500 dark:text-gray-400">jours par an</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Action buttons -->
                                                    <div class="flex flex-col space-y-2 ml-6">
                                                        <button type="button" onclick="editLeaveBalance({{ $balance->id }})" class="group/btn flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 group-hover/btn:scale-110 transition-transform duration-300">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                            </svg>
                                                        </button>
                                                        <button type="button" onclick="deleteLeaveBalance({{ $balance->id }})" class="group/btn flex items-center justify-center w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 group-hover/btn:scale-110 transition-transform duration-300">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <i class="bx bx-calendar-x text-gray-400 text-4xl mb-2"></i>
                                        <p class="text-gray-500 dark:text-gray-400">Aucun solde de congés défini</p>
                                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Cliquez sur "Ajouter un solde" pour commencer</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Modal pour définir les congés  -->
                            <div id="leaveBalanceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
                                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                                    <div class="mt-3">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalTitle">Ajouter un solde de congés</h3>
                                            <button type="button" onclick="closeLeaveBalanceModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                <i class="bx bx-x text-2xl"></i>
                                            </button>
                                        </div>
                                        
                                        <form id="leaveBalanceForm">
                                            @csrf
                                            <input type="hidden" id="leaveBalanceId" name="leave_balance_id">
                                            <input type="hidden" id="formMethod" name="_method">
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div class="md:col-span-2">
                                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                                    <input type="text" id="description" name="description" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="annual_leave_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Congés annuels (jours)</label>
                                                    <input type="number" id="annual_leave_days" name="annual_leave_days" min="0" max="365" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="sick_leave_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Congés maladie (jours)</label>
                                                    <input type="number" id="sick_leave_days" name="sick_leave_days" min="0" max="365" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="maternity_leave_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Congés maternité (jours)</label>
                                                    <input type="number" id="maternity_leave_days" name="maternity_leave_days" min="0" max="365" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="paternity_leave_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Congés paternité (jours)</label>
                                                    <input type="number" id="paternity_leave_days" name="paternity_leave_days" min="0" max="365" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="special_leave_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Congés spéciaux (jours)</label>
                                                    <input type="number" id="special_leave_days" name="special_leave_days" min="0" max="365" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div class="md:col-span-2">
                                                    <label class="flex items-center">
                                                        <input type="checkbox" id="is_default" name="is_default" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Définir comme solde par défaut</span>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-end space-x-3">
                                                <button type="button" onclick="closeLeaveBalanceModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-700">
                                                    Annuler
                                                </button>
                                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <span id="submitButtonText">Ajouter</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        @else
                            <div class="text-center py-12">
                                <i class="bx bx-building text-gray-400 text-6xl"></i>
                                <h5 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Aucune information de société configurée</h5>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Cliquez sur le bouton "Créer" pour ajouter les informations de votre société.</p>
                                <a href="{{ route('admin.company.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                    <i class="bx bx-plus mr-1"></i> Créer les informations de la société
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let leaveBalances = @json($leaveBalances);
        let isEditing = false;
        let editingId = null;

        function openLeaveBalanceModal() {
            isEditing = false;
            editingId = null;
            document.getElementById('modalTitle').textContent = 'Ajouter un solde de congés';
            document.getElementById('submitButtonText').textContent = 'Ajouter';
            document.getElementById('leaveBalanceForm').reset();
            document.getElementById('leaveBalanceId').value = '';
            document.getElementById('formMethod').value = '';
            document.getElementById('leaveBalanceModal').classList.remove('hidden');
        }

        function closeLeaveBalanceModal() {
            document.getElementById('leaveBalanceModal').classList.add('hidden');
        }

        function editLeaveBalance(id) {
            const balance = leaveBalances.find(b => b.id === id);
            if (!balance) return;

            isEditing = true;
            editingId = id;
            document.getElementById('modalTitle').textContent = 'Modifier le solde de congés';
            document.getElementById('submitButtonText').textContent = 'Modifier';
            
            // Remplir le formulaire
            document.getElementById('leaveBalanceId').value = balance.id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('description').value = balance.description;
            document.getElementById('annual_leave_days').value = balance.annual_leave_days;
            document.getElementById('sick_leave_days').value = balance.sick_leave_days;
            document.getElementById('maternity_leave_days').value = balance.maternity_leave_days || '';
            document.getElementById('paternity_leave_days').value = balance.paternity_leave_days || '';
            document.getElementById('special_leave_days').value = balance.special_leave_days || '';
            document.getElementById('is_default').checked = balance.is_default;
            
            document.getElementById('leaveBalanceModal').classList.remove('hidden');
        }

        function deleteLeaveBalance(id) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer ce solde de congés ?')) {
                return;
            }

            fetch(`{{ route('admin.company.leave-balances.destroy', '') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.error || 'Erreur lors de la suppression', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Erreur lors de la suppression', 'error');
            });
        }

        document.getElementById('leaveBalanceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            // Convertir les valeurs numériques
            ['annual_leave_days', 'sick_leave_days', 'maternity_leave_days', 'paternity_leave_days', 'special_leave_days'].forEach(field => {
                if (data[field] === '') {
                    delete data[field];
                } else {
                    data[field] = parseInt(data[field]) || 0;
                }
            });
            
            // Gérer la checkbox
            data.is_default = document.getElementById('is_default').checked;
            
            let url, method;
            if (isEditing) {
                url = `{{ route('admin.company.leave-balances.update', '') }}/${editingId}`;
                method = 'PUT';
            } else {
                url = '{{ route('admin.company.leave-balances.store') }}';
                method = 'POST';
            }
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeLeaveBalanceModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else if (data.errors) {
                    // Afficher les erreurs de validation
                    let errorMessage = 'Erreurs de validation:\n';
                    Object.values(data.errors).forEach(errors => {
                        errors.forEach(error => {
                            errorMessage += '- ' + error + '\n';
                        });
                    });
                    showNotification(errorMessage, 'error');
                } else {
                    showNotification(data.error || 'Erreur lors de la sauvegarde', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Erreur lors de la sauvegarde', 'error');
            });
        });

        function showNotification(message, type = 'info') {
            // Créer la notification
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg max-w-sm ${
                type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
                'bg-blue-100 border border-blue-400 text-blue-700'
            }`;
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm font-medium">${message.replace(/\n/g, '<br>')}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Supprimer automatiquement après 5 secondes
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('leaveBalanceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLeaveBalanceModal();
            }
        });
    </script>
</x-app-layout>
