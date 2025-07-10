<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ __('Créer un utilisateur') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Nouveau compte utilisateur</span>
            </div>
        </div>
    </x-slot>
    
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-8">
                        @csrf

                        <!-- Block erreurs -->
                        @if ($errors->any())
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
                        @endif

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
                                <div></div>
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
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="password" :value="__('Mot de passe')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <x-text-input id="password" class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="password" name="password" required placeholder="Mot de passe sécurisé" />
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <x-text-input id="password_confirmation" class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="password" name="password_confirmation" required placeholder="Confirmez le mot de passe" />
                                    </div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Informations professionnelles -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/10 dark:to-emerald-900/10 border border-green-200 dark:border-green-800 rounded-xl p-6 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
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
                                        <option value="{{ App\Models\User::ROLE_ADMIN }}">Administrateur</option>
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

                        <!-- Solde de congés -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/10 dark:to-pink-900/10 border border-purple-200 dark:border-purple-800 rounded-xl p-6 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0v-1h8v1z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                        {{ __('Solde de congés') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Configurez les droits aux congés de l'utilisateur</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <x-input-label for="leave_balance_id" :value="__('Profil de congés')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <select id="leave_balance_id" name="leave_balance_id" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                        <option value="">Utiliser le solde par défaut de l'entreprise</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('leave_balance_id')" class="mt-2" />
                                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                        <div class="flex items-start">
                                            <svg class="w-4 h-4 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                            </svg>
                                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                                Laissez vide pour utiliser automatiquement le solde par défaut de l'entreprise de l'utilisateur.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Affichage des détails du solde sélectionné -->
                                <div id="leave_balance_details" class="hidden bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                        <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Détails du solde
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                                        <div class="bg-white dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Congés annuels</div>
                                            <div id="detail_annual" class="text-lg font-bold text-blue-600 dark:text-blue-400">-</div>
                                        </div>
                                        <div class="bg-white dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Congés maladie</div>
                                            <div id="detail_sick" class="text-lg font-bold text-red-600 dark:text-red-400">-</div>
                                        </div>
                                        <div class="bg-white dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Congés maternité</div>
                                            <div id="detail_maternity" class="text-lg font-bold text-pink-600 dark:text-pink-400">-</div>
                                        </div>
                                        <div class="bg-white dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Congés paternité</div>
                                            <div id="detail_paternity" class="text-lg font-bold text-green-600 dark:text-green-400">-</div>
                                        </div>
                                        <div class="bg-white dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Congés spéciaux</div>
                                            <div id="detail_special" class="text-lg font-bold text-purple-600 dark:text-purple-400">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="flex items-center justify-end mt-8 gap-4">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                {{ __('Annuler') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('Créer l\'utilisateur') }}
                            </button>
                        </div>
                </form>
            </div>
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
                        option.textContent = `${team.name} (Responsable: ${team.manager.name})`;
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
        
        function loadLeaveBalances(departmentId) {
            console.log('Chargement des soldes de congés pour le département:', departmentId);
            
            const leaveBalanceSelect = document.getElementById('leave_balance_id');
            const detailsDiv = document.getElementById('leave_balance_details');
            
            // Réinitialiser
            leaveBalanceSelect.innerHTML = '<option value="">Utiliser le solde par défaut de l\'entreprise</option>';
            detailsDiv.classList.add('hidden');
            
            if (!departmentId) {
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = `/admin/departments/${departmentId}/leave-balances`;

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
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(leaveBalances => {
                console.log('Soldes de congés reçus:', leaveBalances);
                
                if (Array.isArray(leaveBalances) && leaveBalances.length > 0) {
                    leaveBalances.forEach(balance => {
                        const option = document.createElement('option');
                        option.value = balance.id;
                        option.textContent = balance.description || `Solde ${balance.is_default ? '(Défaut)' : 'Personnalisé'}`;

                        option.dataset.maternity = balance.maternity_leave_days;
                        option.dataset.paternity = balance.paternity_leave_days;
                        option.dataset.special = balance.special_leave_days;
                        leaveBalanceSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des soldes de congés:', error);
            });
        }
        
        function showLeaveBalanceDetails(selectElement) {
            const detailsDiv = document.getElementById('leave_balance_details');
            const selectedOption = selectElement.selectedOptions[0];
            
            if (selectedOption && selectedOption.value) {
                // Afficher les détails
                document.getElementById('detail_annual').textContent = selectedOption.dataset.annual + ' jours';
                document.getElementById('detail_sick').textContent = selectedOption.dataset.sick + ' jours';
                document.getElementById('detail_maternity').textContent = selectedOption.dataset.maternity + ' jours';
                document.getElementById('detail_paternity').textContent = selectedOption.dataset.paternity + ' jours';
                document.getElementById('detail_special').textContent = selectedOption.dataset.special + ' jours';
                detailsDiv.classList.remove('hidden');
                

            } else {
                detailsDiv.classList.add('hidden');

            }
        }
        


        // Attacher l'événement une fois que le DOM est chargé
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page chargée, initialisation des événements');
            
            // Attacher l'événement change au select département
            const departmentSelect = document.getElementById('department_id');
            departmentSelect.addEventListener('change', function() {
                loadTeams(this.value);
                loadLeaveBalances(this.value);
            });
            
            // Gestionnaire d'événement pour le changement de solde de congés
            document.getElementById('leave_balance_id').addEventListener('change', function() {
                showLeaveBalanceDetails(this);
            });

            // Charger les équipes et soldes si un département est déjà sélectionné
            if (departmentSelect.value) {
                console.log('Département pré-sélectionné:', departmentSelect.value);
                loadTeams(departmentSelect.value);
                loadLeaveBalances(departmentSelect.value);
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
