@section('title', 'Créer un utilisateur')
<x-app-layout>
    <div class="min-h-screen ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

         <!-- En-tête avec dégradé -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-4 sm:p-6 mb-6"> 
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white">
                        {{ __('Créer un utilisateur') }}
                    </h1>
                    <p class="mt-1 text-sm sm:text-base text-blue-100">
                        Ajoutez un nouvel utilisateur au système
                    </p>
                </div>
            </div>
            
            <!-- Fil d'Ariane -->
            <nav class="mt-4 sm:mt-6 overflow-x-auto" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm whitespace-nowrap">
                    <li class="flex-shrink-0">
                        <a href="{{ route('welcome.index') }}" class="text-blue-100 hover:text-white transition-colors duration-200 flex items-center">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="hidden sm:inline">Accueil</span>
                            <span class="sm:hidden">Acc.</span>
                        </a>
                    </li>
                    <li class="text-blue-200 flex-shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li class="flex-shrink-0">
                        <a href="{{ route('admin.users.index') }}" class="text-blue-100 hover:text-white transition-colors duration-200">
                            <span class="hidden sm:inline">Utilisateurs</span>
                            <span class="sm:hidden">Users</span>
                        </a>
                    </li>
                    <li class="text-blue-200 flex-shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li class="text-white font-medium truncate">
                        <span class="hidden sm:inline">Ajouter un utilisateur</span>
                        <span class="sm:hidden">Ajouter</span>
                    </li>
                </ol>
            </nav>
        </div>
        <!-- END Header -->


            <div class="md:bg-white dark:bg-gray-800 rounded-2xl overflow-hidden md:border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('admin.users.store') }}" class="md:p-8 space-y-8">
                        @csrf
                        
                        <!-- Champ caché pour company_id -->
                        @if($company && $company->id)
                            <input type="hidden" name="company_id" value="{{ $company->id }}">
                        @endif

                        <!-- Block erreurs -->
                        <!-- @if ($errors->any())
                            <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 p-6 rounded-lg shadow-sm" role="alert">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h3 class="text-sm font-semibold text-red-800 dark:text-red-200">Erreurs de validation</h3>
                                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif -->

                        <x-alert type="error" :message="session('error')" />

                        <!-- Informations sur l'utilisateur -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10 border border-blue-200 dark:border-blue-800 rounded-xl p-6 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                        {{ __('Informations personnelles') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Renseignez les informations de base de l'utilisateur</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="first_name" :value="__('Prénom')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="first_name" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="first_name" :value="old('first_name')" required autofocus placeholder="Entrez le prénom" />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="last_name" :value="__('Nom de famille')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="last_name" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="last_name" :value="old('last_name')" required placeholder="Entrez le nom de famille" />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                            </svg>
                                        </div>
                                        <x-text-input id="email" class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="email" name="email" :value="old('email')" required placeholder="exemple@email.com" />
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="phone" :value="__('Numéro de téléphone')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <x-text-input id="phone" class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="tel" name="phone" :value="old('phone')" required placeholder="+33 1 23 45 67 89" />
                                    </div>
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <div class="space-y-3">
                                    <x-input-label for="gender" :value="__('Sexe')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="flex space-x-6">
                                        <div class="flex items-center">
                                            <input id="gender_m" name="gender" type="radio" value="M" {{ old('gender') == 'M' ? 'checked' : '' }} class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 transition-all duration-200" required>
                                            <label for="gender_m" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                                Masculin
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="gender_f" name="gender" type="radio" value="F" {{ old('gender') == 'F' ? 'checked' : '' }} class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 transition-all duration-200" required>
                                            <label for="gender_f" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                                Féminin
                                            </label>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="birth_date" :value="__('Date de naissance *')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <x-text-input id="birth_date" class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="date" name="birth_date" :value="old('birth_date')" />
                                    </div>
                                    <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                                </div>

                                <div class="space-y-2 md:col-span-2">
                                    <x-input-label for="address" :value="__('Adresse *')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <textarea id="address" name="address" rows="3" class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 resize-none" placeholder="Entrez l'adresse complète">{{ old('address') }}</textarea>
                                    </div>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                            </div>


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <div></div>
                            </div>

                            
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2" x-data="{ showPassword: false }">
                                    <x-input-label for="password" :value="__('Mot de passe')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <x-text-input id="password" class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" x-bind:type="showPassword ? 'text' : 'password'" name="password" required placeholder="Mot de passe sécurisé" />
                                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="space-y-2" x-data="{ showPasswordConfirmation: false }">
                                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <x-text-input id="password_confirmation" class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" x-bind:type="showPasswordConfirmation ? 'text' : 'password'" name="password_confirmation" required placeholder="Confirmez le mot de passe" />
                                        <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                            <svg x-show="!showPasswordConfirmation" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg x-show="showPasswordConfirmation" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Informations complémentaires -->
                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/10 dark:to-indigo-900/10 border border-purple-200 dark:border-purple-800 rounded-xl p-6 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                        {{ __('Informations complémentaires') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Détails personnels et administratifs</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="marital_status" :value="__('État civil *')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <select id="marital_status" name="marital_status" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                        <option value="">Sélectionner un état civil</option>
                                        @foreach(App\Models\User::getMaritalStatusOptions() as $value => $label)
                                            <option value="{{ $value }}" {{ old('marital_status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="employment_status" :value="__('Statut professionnel')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <select id="employment_status" name="employment_status" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                        <option value="">Sélectionner un statut</option>
                                        @foreach(App\Models\User::getEmploymentStatusOptions() as $value => $label)
                                            <option value="{{ $value }}" {{ old('employment_status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('employment_status')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="children_count" :value="__('Nombre d\'enfants à charge')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="children_count" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="number" name="children_count" :value="old('children_count', 0)" min="0" placeholder="0" />
                                    <x-input-error :messages="$errors->get('children_count')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="matricule" :value="__('Matricule *')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="matricule" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="matricule" :value="old('matricule')" placeholder="Matricule unique" />
                                    <x-input-error :messages="$errors->get('matricule')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="affectation" :value="__('Affectation')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="affectation" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="affectation" :value="old('affectation')" placeholder="Lieu d'affectation" />
                                    <x-input-error :messages="$errors->get('affectation')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="category" :value="__('Catégorie *')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <select id="category" name="category" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                        <option value="">Sélectionner une catégorie</option>
                                        @foreach(App\Models\User::getCategoryOptions() as $value => $label)
                                            <option value="{{ $value }}" {{ old('category') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="section" :value="__('Section')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="section" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="section" :value="old('section')" placeholder="Section" />
                                    <x-input-error :messages="$errors->get('section')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="service" :value="__('Service')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="service" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="service" :value="old('service')" placeholder="Service" />
                                    <x-input-error :messages="$errors->get('service')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Contact d'urgence -->
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/10 dark:to-pink-900/10 border border-red-200 dark:border-red-800 rounded-xl p-6 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-pink-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                        {{ __('Contact d\'urgence') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Personne à contacter en cas d'urgence</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="emergency_contact_name" :value="__('Nom du contact d\'urgence')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="emergency_contact_name" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="emergency_contact_name" :value="old('emergency_contact_name')" placeholder="Nom complet du contact" />
                                    <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="emergency_contact_phone" :value="__('Téléphone du contact d\'urgence')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="emergency_contact_phone" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="tel" name="emergency_contact_phone" :value="old('emergency_contact_phone')" placeholder="Numéro de téléphone" />
                                    <x-input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="emergency_contact_relationship" :value="__('Relation avec le contact')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <select id="emergency_contact_relationship" name="emergency_contact_relationship" 
                                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                        <option value="">{{ __('Sélectionner une relation') }}</option>
                                        <option value="Conjoint(e)" {{ old('emergency_contact_relationship') == 'Conjoint(e)' ? 'selected' : '' }}>{{ __('Conjoint(e)') }}</option>
                                        <option value="Père" {{ old('emergency_contact_relationship') == 'Père' ? 'selected' : '' }}>{{ __('Père') }}</option>
                                        <option value="Mère" {{ old('emergency_contact_relationship') == 'Mère' ? 'selected' : '' }}>{{ __('Mère') }}</option>
                                        <option value="Frère" {{ old('emergency_contact_relationship') == 'Frère' ? 'selected' : '' }}>{{ __('Frère') }}</option>
                                        <option value="Sœur" {{ old('emergency_contact_relationship') == 'Sœur' ? 'selected' : '' }}>{{ __('Sœur') }}</option>
                                        <option value="Enfant" {{ old('emergency_contact_relationship') == 'Enfant' ? 'selected' : '' }}>{{ __('Enfant') }}</option>
                                        <option value="Ami(e)" {{ old('emergency_contact_relationship') == 'Ami(e)' ? 'selected' : '' }}>{{ __('Ami(e)') }}</option>
                                        <option value="Collègue" {{ old('emergency_contact_relationship') == 'Collègue' ? 'selected' : '' }}>{{ __('Collègue') }}</option>
                                        <option value="Autre" {{ old('emergency_contact_relationship') == 'Autre' ? 'selected' : '' }}>{{ __('Autre') }}</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('emergency_contact_relationship')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Informations professionnelles -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/10 dark:to-emerald-900/10 border border-green-200 dark:border-green-800 rounded-xl p-6 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                        {{ __('Informations professionnelles') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Définissez le rôle et l'affectation de l'utilisateur</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="position" :value="__('Poste')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <select id="position" name="position" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" placeholder="Sélectionnez un poste">
                                        <option value="">Sélectionnez un poste</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('position')" class="mt-2" />
                                </div>
                                <div class="space-y-2">
                                    <x-input-label for="role" :value="__('Rôle de l\'utilisateur')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <select id="role" name="role" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" required>
                                        <option value="">Sélectionner un rôle</option>
                                        <option value="{{ App\Models\User::ROLE_EMPLOYEE }}">Employé</option>
                                        <option value="{{ App\Models\User::ROLE_MANAGER }}">Manager</option>
                                        <option value="{{ App\Models\User::ROLE_DEPARTMENT_HEAD }}">Chef de Département</option>
                                        <option value="{{ App\Models\User::ROLE_HR }}">Ressources Humaines</option>
                                        @if(Auth::check() && auth()->user()->role === App\Models\User::ROLE_ADMIN)
                                        <option value="{{ App\Models\User::ROLE_ADMIN }}">Administrateur</option>
                                        <option value="{{ App\Models\User::ROLE_HR_ADMIN }}">DRH</option>
                                        @endif
                                    </select>
                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="department_id" :value="__('Département')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <select id="department_id" name="department_id" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" required>
                                        <option value="">Sélectionner un département</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="team_id" :value="__('Équipe')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <select id="team_id" name="team_id" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                        <option value="">Sélectionner une équipe</option>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="entry_date" :value="__('Date d\'entrée du salarié *')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="entry_date" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="date" name="entry_date" :value="old('entry_date')" />
                                    <x-input-error :messages="$errors->get('entry_date')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="exit_date" :value="__('Date de sortie du salarié')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="exit_date" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="date" name="exit_date" :value="old('exit_date')" />
                                    <x-input-error :messages="$errors->get('exit_date')" class="mt-2" />
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Laisser vide si le salarié est toujours en poste</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-green-300 dark:hover:border-green-600 transition-colors duration-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-sm text-gray-900 dark:text-gray-100">Prestataire</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">L'utilisateur est-il un prestataire externe ?</p>
                                        </div>
                                        <div class="ml-4">
                                            <input type="checkbox" class="peer sr-only opacity-0" id="is_prestataire" name="is_prestataire" {{ old('is_prestataire') ? 'checked' : '' }} />
                                            <label for="is_prestataire" class="relative flex h-7 w-12 cursor-pointer items-center rounded-full bg-gray-300 dark:bg-gray-600 px-0.5 outline-gray-400 transition-all duration-300 before:h-6 before:w-6 before:rounded-full before:bg-white before:shadow-md before:transition-transform before:duration-300 peer-checked:bg-gradient-to-r peer-checked:from-green-500 peer-checked:to-green-600 peer-checked:before:translate-x-5 peer-focus-visible:outline peer-focus-visible:outline-offset-2 peer-focus-visible:outline-green-400 hover:shadow-md">
                                                <span class="sr-only">Toggle prestataire</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-green-300 dark:hover:border-green-600 transition-colors duration-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-sm text-gray-900 dark:text-gray-100">Compte actif</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">L'utilisateur peut-il se connecter ?</p>
                                        </div>
                                        <div class="ml-4">
                                            <input type="checkbox" class="peer sr-only opacity-0" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }} />
                                            <label for="is_active" class="relative flex h-7 w-12 cursor-pointer items-center rounded-full bg-gray-300 dark:bg-gray-600 px-0.5 outline-gray-400 transition-all duration-300 before:h-6 before:w-6 before:rounded-full before:bg-white before:shadow-md before:transition-transform before:duration-300 peer-checked:bg-gradient-to-r peer-checked:from-green-500 peer-checked:to-green-600 peer-checked:before:translate-x-5 peer-focus-visible:outline peer-focus-visible:outline-offset-2 peer-focus-visible:outline-green-400 hover:shadow-md">
                                                <span class="sr-only">Toggle actif</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                {{ __('Annuler') }}
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('Créer l\'utilisateur') }}
                            </button>
                        </div>
                </form>
            </div>
    </div>

    <script>
        console.log('Script chargé');
        
        function loadTeams(departmentId) {
            console.log('Chargement des équipes pour le département:', departmentId);
            
            if (!departmentId) {
                console.log('Aucun département sélectionné');
                document.getElementById('team_id').innerHTML = '<option value="">Sélectionner une équipe</option>';
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('Token CSRF récupéré');

            const url = `/admin/departments/${departmentId}/teams`;
            console.log('URL de la requête:', url);

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('Réponse reçue:', response.status);
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(teams => {
                console.log('Équipes reçues:', teams);
                const select = document.getElementById('team_id');
                select.innerHTML = '<option value="">Sélectionner une équipe</option>';
                
                if (Array.isArray(teams)) {
                    teams.forEach(team => {
                        const option = document.createElement('option');
                        option.value = team.id;
                        const managerName = team.manager ? team.manager.first_name : 'Aucun responsable';
                        option.textContent = `${team.name} (Responsable: ${managerName})`;
                        select.appendChild(option);
                    });
                    console.log('Liste des équipes mise à jour');
                } else {
                    console.error('Format de données invalide:', teams);
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des équipes:', error);
                alert('Erreur lors du chargement des équipes. Consultez la console pour plus de détails.');
            });
        }
        

        


        // Attacher l'événement une fois que le DOM est chargé
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page chargée, initialisation des événements');
            
            // Attacher l'événement change au select département
            const departmentSelect = document.getElementById('department_id');
            departmentSelect.addEventListener('change', function() {
                loadTeams(this.value);
            });

            // Charger les équipes si un département est déjà sélectionné
            if (departmentSelect.value) {
                console.log('Département pré-sélectionné:', departmentSelect.value);
                loadTeams(departmentSelect.value);
            }

            // Mettre à jour le select position
             fetch('/data/positions.json')
            .then(response => response.json())
            .then(data => {
                // Préparer les options pour Tom Select
                let options = [];
                let optgroups = [];
                
                // Parcourir les catégories et les postes
                Object.entries(data.postes).forEach(([category, positions]) => {
                    // Ajouter la catégorie comme optgroup
                    optgroups.push({
                        value: category,
                        label: category
                    });
                    
                    // Ajouter chaque poste comme option
                    positions.forEach(position => {
                        options.push({
                            value: position,
                            text: position,
                            optgroup: category
                        });
                    });
                });
                
                // Initialiser Tom Select
                new TomSelect('#position', {
                    valueField: 'value',
                    labelField: 'text',
                    searchField: 'text',
                    options: options,
                    optgroups: optgroups,
                    optgroupField: 'optgroup',
                    optgroupLabelField: 'label',
                    optgroupValueField: 'value',
                    placeholder: "Sélectionnez un poste",
                    create: false,
                    render: {
                        optgroup_header: function(data, escape) {
                            return '<div class="optgroup-header">' + escape(data.label) + '</div>';
                        }
                    }
                });
            })
            .catch(error => console.error('Erreur lors du chargement des postes:', error));
            });
    </script>
</x-app-layout>
