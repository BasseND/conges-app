@section('title', 'Modifier l\'utilisateur')
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- HEDARE  -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg  class="w-5 h-5 sm:w-6 sm:h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white">
                        {{ __('Modifier l\'utilisateur') }}
                    </h2>
                    <p class="text-sm sm:text-base text-blue-100 mt-1 sm:mt-2">Modifiez les informations de {{ $user->first_name }} {{ $user->last_name }}</p>
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
                        <span class="hidden sm:inline">Modifier #{{ $user->id }}</span>
                        <span class="sm:hidden">Mod. #{{ $user->id }}</span>
                    </li>
                </ol>
            </nav>
        </div>
        <!-- END HEDARE  -->


        <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-2xl md:border border-gray-200 dark:border-gray-700">
         
        <div class="md:p-8 text-gray-900 dark:text-gray-100">
                <!-- Messages d'erreur globaux -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Erreurs de validation</h3>
                                <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                     <!-- Informations personnelles -->
                     <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/10 dark:to-emerald-900/10 border border-green-200 dark:border-green-800 rounded-xl p-6 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                         <div class="flex items-center space-x-3">
                             <div class="flex-shrink-0">
                                 <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                     <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                     </svg>
                                 </div>
                             </div>
                             <div>
                                 <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                     {{ __('Informations personnelles') }}
                                 </h2>
                                 <p class="text-sm text-gray-600 dark:text-gray-400">Modifiez les informations de base de l'utilisateur</p>
                             </div>
                         </div>
                         
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div class="space-y-2">
                                 <x-input-label for="first_name" :value="__('Prénom')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                 <div class="relative">
                                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                         <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                         </svg>
                                     </div>
                                     <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}" required autofocus class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" placeholder="Entrez le prénom">
                                 </div>
                                 <p class="text-xs text-gray-500 dark:text-gray-400">Le prénom de l'utilisateur</p>
                                 <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                             </div>

                             <div class="space-y-2">
                                 <x-input-label for="last_name" :value="__('Nom de famille')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                 <div class="relative">
                                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                         <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                         </svg>
                                     </div>
                                     <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}" required class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" placeholder="Entrez le nom de famille">
                                 </div>
                                 <p class="text-xs text-gray-500 dark:text-gray-400">Le nom de famille de l'utilisateur</p>
                                 <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                             </div>
                             
                             <div class="space-y-2">
                                 <x-input-label for="gender" :value="__('Sexe')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                 <div class="flex space-x-4">
                                     <label class="flex items-center cursor-pointer group">
                                         <input type="radio" name="gender" value="M" {{ old('gender', $user->gender) == 'M' ? 'checked' : '' }} required class="sr-only peer">
                                         <div class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded-full flex items-center justify-center peer-checked:border-green-500 peer-checked:bg-green-500 transition-all duration-200 group-hover:border-green-400">
                                             <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></div>
                                         </div>
                                         <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors duration-200">Masculin</span>
                                     </label>
                                     <label class="flex items-center cursor-pointer group">
                                         <input type="radio" name="gender" value="F" {{ old('gender', $user->gender) == 'F' ? 'checked' : '' }} required class="sr-only peer">
                                         <div class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded-full flex items-center justify-center peer-checked:border-green-500 peer-checked:bg-green-500 transition-all duration-200 group-hover:border-green-400">
                                             <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></div>
                                         </div>
                                         <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors duration-200">Féminin</span>
                                     </label>
                                 </div>
                                 <p class="text-xs text-gray-500 dark:text-gray-400">Sélectionnez le sexe de l'utilisateur</p>
                                 <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                             </div>

                             <div class="space-y-2">
                                 <x-input-label for="email" :value="__('Adresse email')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                 <div class="relative">
                                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                         <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                         </svg>
                                     </div>
                                     <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" placeholder="exemple@entreprise.com">
                                 </div>
                                 <p class="text-xs text-gray-500 dark:text-gray-400">Adresse email professionnelle</p>
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
                                     <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" required class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" placeholder="+33 1 23 45 67 89">
                                 </div>
                                 <p class="text-xs text-gray-500 dark:text-gray-400">Numéro de téléphone professionnel</p>
                                 <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                             </div>
                         </div>
                     </div>

                             <!-- Mot de passe -->
                             <div class="bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/10 dark:to-amber-900/10 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                                 <div class="flex items-center space-x-3">
                                     <div class="flex-shrink-0">
                                         <div class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-amber-600 rounded-lg flex items-center justify-center">
                                             <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                             </svg>
                                         </div>
                                     </div>
                                     <div>
                                         <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                             {{ __('Mot de passe') }}
                                         </h2>
                                         <p class="text-sm text-gray-600 dark:text-gray-400">Modifiez le mot de passe de l'utilisateur (optionnel)</p>
                                     </div>
                                 </div>
                                 
                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                     <div class="space-y-2">
                                         <x-input-label for="password" :value="__('Nouveau mot de passe')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <div class="relative">
                                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                 <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                 </svg>
                                             </div>
                                             <input id="password" name="password" type="password" class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" placeholder="Nouveau mot de passe">
                                         </div>
                                         <p class="text-xs text-gray-500 dark:text-gray-400">Laissez vide pour ne pas changer</p>
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
                                             <input id="password_confirmation" name="password_confirmation" type="password" class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" placeholder="Confirmer le mot de passe">
                                         </div>
                                         <p class="text-xs text-gray-500 dark:text-gray-400">Répétez le nouveau mot de passe</p>
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
                                         <x-input-label for="marital_status" :value="__('État civil')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <select id="marital_status" name="marital_status" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                             <option value="">Sélectionner un état civil</option>
                                             @foreach(App\Models\User::getMaritalStatusOptions() as $value => $label)
                                                 <option value="{{ $value }}" {{ old('marital_status', $user->marital_status) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                             @endforeach
                                         </select>
                                         <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
                                     </div>

                                     <div class="space-y-2">
                                         <x-input-label for="employment_status" :value="__('Statut professionnel')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <select id="employment_status" name="employment_status" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                             <option value="">Sélectionner un statut</option>
                                             @foreach(App\Models\User::getEmploymentStatusOptions() as $value => $label)
                                                 <option value="{{ $value }}" {{ old('employment_status', $user->employment_status) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                             @endforeach
                                         </select>
                                         <x-input-error :messages="$errors->get('employment_status')" class="mt-2" />
                                     </div>
                                 </div>

                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                     <div class="space-y-2">
                                         <x-input-label for="children_count" :value="__('Nombre d\'enfants à charge')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <input id="children_count" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="number" name="children_count" value="{{ old('children_count', $user->children_count ?? 0) }}" min="0" placeholder="0" />
                                         <x-input-error :messages="$errors->get('children_count')" class="mt-2" />
                                     </div>

                                     <div class="space-y-2">
                                         <x-input-label for="matricule" :value="__('Matricule')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <input id="matricule" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="matricule" value="{{ old('matricule', $user->matricule) }}" placeholder="Matricule unique" />
                                         <x-input-error :messages="$errors->get('matricule')" class="mt-2" />
                                     </div>
                                 </div>

                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                     <div class="space-y-2">
                                         <x-input-label for="affectation" :value="__('Affectation')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <input id="affectation" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="affectation" value="{{ old('affectation', $user->affectation) }}" placeholder="Lieu d'affectation" />
                                         <x-input-error :messages="$errors->get('affectation')" class="mt-2" />
                                     </div>

                                     <div class="space-y-2">
                                         <x-input-label for="category" :value="__('Catégorie')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <select id="category" name="category" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                             <option value="">Sélectionner une catégorie</option>
                                             @foreach(App\Models\User::getCategoryOptions() as $value => $label)
                                                 <option value="{{ $value }}" {{ old('category', $user->category) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                             @endforeach
                                         </select>
                                         <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                     </div>
                                 </div>

                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                     <div class="space-y-2">
                                         <x-input-label for="section" :value="__('Section')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <input id="section" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="section" value="{{ old('section', $user->section) }}" placeholder="Section" />
                                         <x-input-error :messages="$errors->get('section')" class="mt-2" />
                                     </div>

                                     <div class="space-y-2">
                                         <x-input-label for="service" :value="__('Service')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <input id="service" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="service" value="{{ old('service', $user->service) }}" placeholder="Service" />
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
                                         <input id="emergency_contact_name" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}" placeholder="Nom complet du contact" />
                                         <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
                                     </div>

                                     <div class="space-y-2">
                                         <x-input-label for="emergency_contact_phone" :value="__('Téléphone du contact d\'urgence')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <input id="emergency_contact_phone" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="tel" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}" placeholder="Numéro de téléphone" />
                                         <x-input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
                                     </div>
                                 </div>

                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                     <div class="space-y-2">
                                         <x-input-label for="emergency_contact_relationship" :value="__('Relation avec le contact')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <select id="emergency_contact_relationship" name="emergency_contact_relationship" 
                                                 class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                             <option value="">{{ __('Sélectionner une relation') }}</option>
                                             <option value="Conjoint(e)" {{ old('emergency_contact_relationship', $user->emergency_contact_relationship) == 'Conjoint(e)' ? 'selected' : '' }}>{{ __('Conjoint(e)') }}</option>
                                             <option value="Père" {{ old('emergency_contact_relationship', $user->emergency_contact_relationship) == 'Père' ? 'selected' : '' }}>{{ __('Père') }}</option>
                                             <option value="Mère" {{ old('emergency_contact_relationship', $user->emergency_contact_relationship) == 'Mère' ? 'selected' : '' }}>{{ __('Mère') }}</option>
                                             <option value="Frère" {{ old('emergency_contact_relationship', $user->emergency_contact_relationship) == 'Frère' ? 'selected' : '' }}>{{ __('Frère') }}</option>
                                             <option value="Sœur" {{ old('emergency_contact_relationship', $user->emergency_contact_relationship) == 'Sœur' ? 'selected' : '' }}>{{ __('Sœur') }}</option>
                                             <option value="Enfant" {{ old('emergency_contact_relationship', $user->emergency_contact_relationship) == 'Enfant' ? 'selected' : '' }}>{{ __('Enfant') }}</option>
                                             <option value="Ami(e)" {{ old('emergency_contact_relationship', $user->emergency_contact_relationship) == 'Ami(e)' ? 'selected' : '' }}>{{ __('Ami(e)') }}</option>
                                             <option value="Collègue" {{ old('emergency_contact_relationship', $user->emergency_contact_relationship) == 'Collègue' ? 'selected' : '' }}>{{ __('Collègue') }}</option>
                                             <option value="Autre" {{ old('emergency_contact_relationship', $user->emergency_contact_relationship) == 'Autre' ? 'selected' : '' }}>{{ __('Autre') }}</option>
                                         </select>
                                         <x-input-error :messages="$errors->get('emergency_contact_relationship')" class="mt-2" />
                                     </div>
                                 </div>
                             </div>

                             <!-- Informations professionnelles -->
                             <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/10 dark:to-red-900/10 border border-orange-200 dark:border-orange-800 rounded-xl p-6 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                                 <div class="flex items-center space-x-3">
                                     <div class="flex-shrink-0">
                                         <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center"> 
                                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                            </svg>
                                         </div>
                                     </div>
                                     <div>
                                         <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                             {{ __('Informations professionnelles') }}
                                         </h2>
                                         <p class="text-sm text-gray-600 dark:text-gray-400">Poste, rôle et affectation de l'utilisateur</p>
                                     </div>
                                 </div>
                                 
                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                     <div class="space-y-2">
                                         <x-input-label for="position" :value="__('Poste')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <select id="position" name="position" required class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                             <option value="">Sélectionnez un poste</option>
                                         </select>
                                         <p class="text-xs text-gray-500 dark:text-gray-400">Fonction occupée par l'utilisateur</p>
                                         <x-input-error :messages="$errors->get('position')" class="mt-2" />
                                     </div>

                                     <div class="space-y-2">
                                         <x-input-label for="role" :value="__('Rôle système')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <select id="role" name="role" required class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                             <option value="">Sélectionner un rôle</option>
                                             <option value="{{ App\Models\User::ROLE_EMPLOYEE }}" {{ old('role', $user->role) == App\Models\User::ROLE_EMPLOYEE ? 'selected' : '' }}>Employé</option>
                                             <option value="{{ App\Models\User::ROLE_MANAGER }}" {{ old('role', $user->role) == App\Models\User::ROLE_MANAGER ? 'selected' : '' }}>Manager</option>
                                             <option value="{{ App\Models\User::ROLE_DEPARTMENT_HEAD }}" {{ old('role', $user->role) == App\Models\User::ROLE_DEPARTMENT_HEAD ? 'selected' : '' }}>Chef de Département</option>
                                             <option value="{{ App\Models\User::ROLE_HR }}" {{ old('role', $user->role) == App\Models\User::ROLE_HR ? 'selected' : '' }}>Ressources Humaines</option>
                                             @if(Auth::check() && auth()->user()->role === App\Models\User::ROLE_ADMIN)
                                               <option value="{{ App\Models\User::ROLE_ADMIN }}" {{ old('role', $user->role) == App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Administrateur</option>
                                             @endif
                                             
                                         </select>
                                         <p class="text-xs text-gray-500 dark:text-gray-400">Niveau d'accès dans l'application</p>
                                         <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                     </div>

                                     <div class="space-y-2">
                                         <x-input-label for="department_id" :value="__('Département')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <select id="department_id" name="department_id" required class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                             <option value="">Sélectionner un département</option>
                                             @foreach($departments as $department)
                                                 <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                                     {{ $department->name }}
                                                 </option>
                                             @endforeach
                                         </select>
                                         <p class="text-xs text-gray-500 dark:text-gray-400">Département d'affectation</p>
                                         <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                                     </div>

                                     <div class="space-y-2">
                                         <x-input-label for="team_id" :value="__('Équipe')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <select id="team_id" name="team_id" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                             <option value="">Sélectionner une équipe</option>
                                             @foreach($teams as $team)
                                                 <option value="{{ $team->id }}" {{ $user->teams->contains($team->id) ? 'selected' : '' }}>
                                                     {{ $team->name }}
                                                 </option>
                                             @endforeach
                                         </select>
                                         <p class="text-xs text-gray-500 dark:text-gray-400">Équipe de travail (optionnel)</p>
                                         <x-input-error :messages="$errors->get('team_id')" class="mt-2" />
                                     </div>
                                 </div>

                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                     <div class="space-y-2">
                                         <x-input-label for="entry_date" :value="__('Date d\'entrée du salarié')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <x-text-input id="entry_date" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="date" name="entry_date" :value="old('entry_date', $user->entry_date)" />
                                         <x-input-error :messages="$errors->get('entry_date')" class="mt-2" />
                                     </div>

                                     <div class="space-y-2">
                                         <x-input-label for="exit_date" :value="__('Date de sortie du salarié')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                                         <x-text-input id="exit_date" class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500" type="date" name="exit_date" :value="old('exit_date', $user->exit_date)" />
                                         <x-input-error :messages="$errors->get('exit_date')" class="mt-2" />
                                         <p class="text-xs text-gray-500 dark:text-gray-400">Laisser vide si le salarié est toujours en poste</p>
                                     </div>
                                 </div>
                             </div>



                             <!-- Prestataire et Statut -->
                             <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/10 dark:to-pink-900/10 border border-purple-200 dark:border-purple-800 rounded-xl p-6 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                                 <div class="flex items-center space-x-3">
                                     <div class="flex-shrink-0">
                                         <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                             <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                             </svg>
                                         </div>
                                     </div>
                                     <div>
                                         <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                             {{ __('Statut et Type') }}
                                         </h2>
                                         <p class="text-sm text-gray-600 dark:text-gray-400">Configuration du statut de l'utilisateur</p>
                                     </div>
                                 </div>
                                 
                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                     <div class="space-y-3">
                                         <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-purple-300 dark:hover:border-purple-600 transition-colors duration-200">
                                             <div class="flex items-center space-x-3">
                                                 <div class="flex-shrink-0">
                                                     <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                                     </svg>
                                                 </div>
                                                 <div>
                                                     <label for="is_contractor" class="text-sm font-medium text-gray-900 dark:text-gray-100 cursor-pointer">
                                                         {{ __('Prestataire') }}
                                                     </label>
                                                     <p class="text-xs text-gray-500 dark:text-gray-400">Utilisateur externe</p>
                                                 </div>
                                             </div>
                                             <label class="relative inline-flex items-center cursor-pointer">
                                                 <input type="checkbox" id="is_contractor" name="is_contractor" value="1" {{ old('is_contractor', $user->is_contractor) ? 'checked' : '' }} class="sr-only peer">
                                                 <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600"></div>
                                             </label>
                                         </div>
                                     </div>

                                     <div class="space-y-3">
                                         <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-purple-300 dark:hover:border-purple-600 transition-colors duration-200">
                                             <div class="flex items-center space-x-3">
                                                 <div class="flex-shrink-0">
                                                     <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                     </svg>
                                                 </div>
                                                 <div>
                                                     <label for="is_active" class="text-sm font-medium text-gray-900 dark:text-gray-100 cursor-pointer">
                                                         {{ __('Compte actif') }}
                                                     </label>
                                                     <p class="text-xs text-gray-500 dark:text-gray-400">Autoriser la connexion</p>
                                                 </div>
                                             </div>
                                             <label class="relative inline-flex items-center cursor-pointer">
                                                 <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="sr-only peer">
                                                 <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                             </label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!-- Boutons d'action -->
                             <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                                 <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-900 transition-all duration-200 shadow-sm hover:shadow-md">
                                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                     </svg>
                                     {{ __('Annuler') }}
                                 </a>
                                 <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                     <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>

                                     {{ __('Mettre à jour l\'utilisateur') }}
                                 </button>
                             </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    console.log('Script chargé');
    
    function loadPositions(selectedPosition = null) {
        console.log('Chargement des postes');
        
        fetch('/data/positions.json')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Postes reçus:', data);
            const select = document.getElementById('position');
            select.innerHTML = '<option value="">Sélectionnez un poste</option>';
            
            if (data.postes) {
                // Parcourir les catégories et les postes
                Object.entries(data.postes).forEach(([category, positions]) => {
                    // Créer un optgroup pour la catégorie
                    const optgroup = document.createElement('optgroup');
                    optgroup.label = category;
                    
                    // Ajouter chaque poste comme option dans le groupe
                    positions.forEach(position => {
                        const option = document.createElement('option');
                        option.value = position;
                        option.textContent = position;
                        if (selectedPosition && position === selectedPosition) {
                            option.selected = true;
                        }
                        optgroup.appendChild(option);
                    });
                    
                    select.appendChild(optgroup);
                });
                console.log('Liste des postes mise à jour');
            } else {
                console.error('Format de données invalide:', data);
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des postes:', error);
        });
    }
    
    function loadTeams(departmentId, selectedTeamId = null) {
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
                    option.textContent = `${team.name} (Responsable: ${team.manager.first_name} ${team.manager.last_name})`;
                    if (selectedTeamId && team.id == selectedTeamId) {
                        option.selected = true;
                    }
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
        
        const departmentSelect = document.getElementById('department_id');
        
        // Événement pour le changement de département
        departmentSelect.addEventListener('change', function() {
            loadTeams(this.value);
        });
        
        // Charger les postes au chargement de la page
        loadPositions('{{ old('position', $user->position) }}');
        
        // Charger les données initiales si un département est déjà sélectionné
        if (departmentSelect.value) {
            console.log('Département pré-sélectionné:', departmentSelect.value);
            // Passer l'ID de l'équipe actuelle pour la sélectionner
            loadTeams(departmentSelect.value, {{ $user->team_id ?? 'null' }});
        }
    });
 </script>
