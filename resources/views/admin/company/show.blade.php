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
                                <a href="{{ route('admin.company.edit') }}" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 border border-transparent rounded-xl font-semibold text-white transition-colors duration-200 shadow-sm">
                                    <i class="bx bx-edit-alt mr-1"></i> Modifier
                                </a>
                            @else
                                <a href="{{ route('admin.company.create') }}" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 border border-transparent rounded-xl font-semibold text-white transition-colors duration-200 shadow-sm">
                                    <i class="bx bx-plus mr-1"></i> Créer
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                    
                        @if($company)
                            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-dark-card-two dark:to-gray-800 rounded-3xl p-8 border border-gray-200 dark:border-gray-600">
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                    <!-- Logo Section -->
                                    <div class="lg:col-span-1">
                                        <div class="text-center relative">
                                            @if($company->logo)
                                                <div class="relative inline-block group">
                                                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-300"></div>
                                                    <img src="{{ Storage::url($company->logo) }}" alt="Logo de la société" class="relative w-32 h-32 object-contain rounded-xl mx-auto shadow-lg bg-white p-2">
                                                </div>
                                            @else
                                                <div class="relative group">
                                                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-300"></div>
                                                    <div class="relative w-32 h-32 bg-gradient-to-br from-blue-100 via-indigo-50 to-purple-100 dark:from-gray-700 dark:via-gray-600 dark:to-gray-500 rounded-xl flex items-center justify-center mx-auto shadow-lg">
                                                        <svg class="w-14 h-14 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="mt-6">
                                                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">{{ $company->name }}</h3>
                                                <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Société active
                                                </div>
                                            </div>

                                            
                                        </div>
                                    </div>

                                    <!-- Information Section -->
                                     <div class="lg:col-span-2">
                                         <div class="space-y-8">
                                             <!-- Contact Information -->
                                             <div class="bg-white/50 dark:bg-gray-800/50 rounded-2xl p-6 backdrop-blur-sm border border-gray-100 dark:border-gray-700">
                                                 <div class="flex items-center mb-4">
                                                     <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                                         <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                         </svg>
                                                     </div>
                                                     <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Informations de contact</h4>
                                                 </div>
                                                 <div class="grid md:grid-cols-2 gap-6">
                                                    @if($company->contact_email)
                                                     <div class="group hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl p-3 transition-all duration-200">
                                                         <div class="flex items-center space-x-3">
                                                             <div class="flex-shrink-0">
                                                                 <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                     <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                                     </svg>
                                                                 </div>
                                                             </div>
                                                             <div>
                                                                 <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $company->contact_email }}</p>
                                                                 <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">Email professionnel</p>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     @endif
                                                    
                                                    @if($company->contact_phone)
                                                     <div class="group hover:bg-green-50 dark:hover:bg-green-900/20 rounded-xl p-3 transition-all duration-200">
                                                         <div class="flex items-center space-x-3">
                                                             <div class="flex-shrink-0">
                                                                 <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                     <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                                     </svg>
                                                                 </div>
                                                             </div>
                                                             <div>
                                                                 <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $company->contact_phone }}</p>
                                                                 <p class="text-xs text-green-600 dark:text-green-400 font-medium">Téléphone principal</p>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     @endif
                                                    
                                                    @if($company->website_url)
                                                     <div class="group hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-xl p-3 transition-all duration-200">
                                                         <div class="flex items-center space-x-3">
                                                             <div class="flex-shrink-0">
                                                                 <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                     <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"></path>
                                                                     </svg>
                                                                 </div>
                                                             </div>
                                                             <div>
                                                                 <a href="{{ $company->website_url }}" target="_blank" class="text-sm font-semibold text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 hover:underline transition-colors duration-200">{{ $company->website_url }}</a>
                                                                 <p class="text-xs text-purple-600 dark:text-purple-400 font-medium">Site web officiel</p>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     @endif

                                                    <!-- Address Information -->
                                                    @if($company->address || $company->city || $company->country)
                                                        <div class="group hover:bg-teal-50 dark:hover:bg-teal-900/20 rounded-xl p-4 transition-all duration-200">
                                                            <div class="flex items-start space-x-4">
                                                                <div class="flex-shrink-0 mt-1">
                                                                    <div class="w-10 h-10 bg-teal-100 dark:bg-teal-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                        <svg class="w-5 h-5 text-teal-800 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-1">
                                                                    @if($company->address)
                                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ $company->address }}</p>
                                                                    @endif
                                                                    <div class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                                                        @if($company->city || $company->postal_code)
                                                                            <p class="flex items-center">
                                                                                @if($company->city){{ $company->city }}@endif
                                                                                @if($company->postal_code && $company->city), {{ $company->postal_code }} , @endif
                                                                                @if($company->country)  {{ $company->country }} @endif
                                                                            </p>
                                                                        @endif
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                 </div>
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
                                    <button type="button" onclick="openLeaveBalanceModal()" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 border border-transparent rounded-xl font-semibold text-white transition-colors duration-200 shadow-sm">
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

                            <!-- Inclusion du composant modal moderne -->
                            <x-leave-balance-modal :company="$company" />


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

        function openLeaveBalanceModal() {
            window.dispatchEvent(new CustomEvent('open-leave-balance-modal', {
                detail: {
                    leaveBalanceId: null
                }
            }));
        }

        function editLeaveBalance(id) {
            const balance = leaveBalances.find(b => b.id === id);
            if (!balance) return;

            window.dispatchEvent(new CustomEvent('open-leave-balance-modal', {
                detail: {
                    leaveBalanceId: id,
                    data: balance
                }
            }));
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

        // Fonction globale pour les notifications
        window.showNotification = function(message, type = 'info') {
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
        };
        
        // Alias local pour compatibilité
        function showNotification(message, type = 'info') {
            window.showNotification(message, type);
        }
    </script>
</x-app-layout>
