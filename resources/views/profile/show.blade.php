@section('title', 'Mon Profil')
<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400 rounded-2xl p-6">
            <h2 class="text-3xl font-bold text-white flex items-center">
                <div class="bg-white/20 rounded-full p-2 mr-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                {{ __('Mon Profil') }}
            </h2>
            <p class="text-white/80 mt-2">{{ __('Gérez vos informations personnelles et professionnelles') }}</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto">
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl mb-6 p-6">
                <x-alert type="success" :message="session('success')" />
                <x-alert type="error" :message="session('error')" />

                <!-- En-tête du profil avec photo et informations principales -->
                <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 border-2 border-blue-200 dark:border-gray-600 overflow-hidden rounded-2xl mb-6">
                    <div class="p-8">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                            
                            <div class="flex flex-col sm:flex-row items-center sm:items-start mb-6 lg:mb-0">
                                <!-- Photo de profil -->
                                <div class="w-32 h-32 sm:mr-8 mb-4 sm:mb-0 rounded-full bg-gradient-to-br from-pink-400 via-purple-500 to-indigo-600 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <!-- Informations principales -->
                                <div class="text-center sm:text-left">
                                    <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">{{ $user->first_name }} {{ $user->last_name }}</h1>
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-400 to-blue-500 text-white">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V8m8 0V6a2 2 0 00-2-2H10a2 2 0 00-2 2v2"></path>
                                            </svg>
                                            {{ $user->position ?: 'Poste non défini' }}
                                        </span>
                                    </div>
                                    <div class="mt-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            ID: {{ $user->employee_id }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full lg:w-auto">
                                @include('profile.modals.update-password')
                            </div>

                        </div>

                        <!-- Informations de contact -->
                        <div class="border-t-2 border-gradient-to-r from-blue-200 to-purple-200 dark:border-gray-600 mt-8 pt-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-pink-400">
                                    <div class="flex items-center">
                                        <div class="bg-pink-100 dark:bg-pink-900/50 rounded-lg p-2 mr-3">
                                            <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Téléphone</p>
                                            <p class="text-gray-900 dark:text-white font-medium">{{ $user->phone ?: 'Non renseigné' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-blue-400">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 dark:bg-blue-900/50 rounded-lg p-2 mr-3">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Email</p>
                                            <p class="text-gray-900 dark:text-white font-medium">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-yellow-400">
                                    <div class="flex items-center">
                                        <div class="bg-yellow-100 dark:bg-yellow-900/50 rounded-lg p-2 mr-3">
                                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 012 0v4m0 0V3a1 1 0 112 0v4m0 0h4m-4 0H8m0 0v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2H10a2 2 0 00-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Date de naissance</p>
                                            <p class="text-gray-900 dark:text-white font-medium">{{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'Non renseigné' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-indigo-400 md:col-span-2">
                                    <div class="flex items-center">
                                        <div class="bg-indigo-100 dark:bg-indigo-900/50 rounded-lg p-2 mr-3">
                                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Adresse</p>
                                            <p class="text-gray-900 dark:text-white font-medium">{{ $user->address ?: 'Non renseigné' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-green-400">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 dark:bg-green-900/50 rounded-lg p-2 mr-3">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Département</p>
                                            <p class="text-gray-900 dark:text-white font-medium">
                                                @if($user->department)
                                                    {{ $user->department->name }}
                                                @else
                                                    Non assigné
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-purple-400">
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 dark:bg-purple-900/50 rounded-lg p-2 mr-3">
                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Statut</p>
                                            <p class="text-gray-900 dark:text-white font-medium">
                                                @if($user->is_active)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                                        Actif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                        <span class="w-2 h-2 bg-red-400 rounded-full mr-1"></span>
                                                        Inactif
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                @include('profile.modals.update-profile-information')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation par onglets -->
                <div x-data="{ activeTab: 'user_personal' }" class="mb-8">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl p-2">
                        <nav class="flex space-x-2" aria-label="Tabs">
                            <button @click="activeTab = 'user_personal'" 
                                   :class="{ 'bg-white text-purple-600 border-2 border-purple-200 shadow-sm': activeTab === 'user_personal', 'text-gray-600 dark:text-gray-300 hover:text-purple-600': activeTab !== 'user_personal' }" 
                                   class="flex-1 text-center py-3 px-4 rounded-xl font-medium text-sm transition-all duration-200">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Informations personnelles
                                </div>
                            </button>
                            <button @click="activeTab = 'user_documents'" 
                                   :class="{ 'bg-white text-purple-600 border-2 border-purple-200 shadow-sm': activeTab === 'user_documents', 'text-gray-600 dark:text-gray-300 hover:text-purple-600': activeTab !== 'user_documents' }" 
                                   class="flex-1 text-center py-3 px-4 rounded-xl font-medium text-sm transition-all duration-200">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Documents
                                </div>
                            </button>
                        </nav>
                    </div>
                

                    <!-- Contenu des onglets -->
                    <div class="mt-6">
                        <!-- Informations personnelles -->
                        <div x-show="activeTab === 'user_personal'">
                            <div class="bg-gradient-to-br from-white via-blue-50 to-purple-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 overflow-hidden rounded-2xl border-2 border-blue-100 dark:border-gray-600">
                                <div class="p-8">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-full p-3 mr-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">{{ __('Informations personnelles détaillées') }}</h3>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-blue-400">
                                            <label class="block text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wide mb-2">{{ __('Prénom') }}</label>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->first_name }}</p>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-purple-400">
                                            <label class="block text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wide mb-2">{{ __('Nom') }}</label>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->last_name }}</p>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-green-400">
                                            <label class="block text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wide mb-2">{{ __('Email') }}</label>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->email }}</p>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-pink-400">
                                            <label class="block text-xs font-bold text-pink-600 dark:text-pink-400 uppercase tracking-wide mb-2">{{ __('Téléphone') }}</label>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->phone ?: 'Non renseigné' }}</p>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-indigo-400">
                                            <label class="block text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wide mb-2">{{ __('Poste') }}</label>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->position ?: 'Non renseigné' }}</p>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-teal-400">
                                            <label class="block text-xs font-bold text-teal-600 dark:text-teal-400 uppercase tracking-wide mb-2">{{ __('Département') }}</label>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium">
                                                @if($user->department)
                                                    {{ $user->department->name }}
                                                @else
                                                    Non assigné
                                                @endif
                                            </p>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-orange-400">
                                            <label class="block text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wide mb-2">{{ __('ID Employé') }}</label>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->employee_id }}</p>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-cyan-400">
                                            <label class="block text-xs font-bold text-cyan-600 dark:text-cyan-400 uppercase tracking-wide mb-2">{{ __('Date d\'embauche') }}</label>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium">
                                                @if($user->hire_date)
                                                    {{ \Carbon\Carbon::parse($user->hire_date)->format('d/m/Y') }}
                                                @else
                                                    Non renseigné
                                                @endif
                                            </p>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-emerald-400">
                                            <label class="block text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wide mb-2">{{ __('Salaire') }}</label>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium">
                                                @if($user->salary)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gradient-to-r from-green-400 to-emerald-500 text-white">
                                                        {{ number_format($user->salary, 0, ',', ' ') }} {{ $globalCompanyCurrency }}
                                                    </span>
                                                @else
                                                    Non renseigné
                                                @endif
                                            </p>
                                        </div>
                                        
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-red-400">
                                            <label class="block text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-wide mb-2">{{ __('Statut') }}</label>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium">
                                                @if($user->is_active)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gradient-to-r from-green-400 to-emerald-500 text-white">
                                                        <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                                                        Actif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gradient-to-r from-red-400 to-pink-500 text-white">
                                                        <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                                                        Inactif
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Section Contact d'urgence -->
                                    <div class="mt-8">
                                        <div class="flex items-center justify-between mb-6">
                                            <div class="flex items-center">
                                                <div class="bg-gradient-to-r from-red-500 to-orange-600 rounded-full p-3 mr-4">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                    </svg>
                                                </div>
                                                <h4 class="text-xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">{{ __('Contact d\'urgence') }}</h4>
                                            </div>
                                            <button onclick="openEmergencyContactModal()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                {{ __('Modifier') }}
                                            </button>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-red-400">
                                                <label class="block text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-wide mb-2">{{ __('Nom du contact') }}</label>
                                                <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->emergency_contact_name ?: 'Non renseigné' }}</p>
                                            </div>
                                            
                                            <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-orange-400">
                                                <label class="block text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wide mb-2">{{ __('Téléphone') }}</label>
                                                <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->emergency_contact_phone ?: 'Non renseigné' }}</p>
                                            </div>
                                            
                                            <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-4 border-yellow-400">
                                                <label class="block text-xs font-bold text-yellow-600 dark:text-yellow-400 uppercase tracking-wide mb-2">{{ __('Relation') }}</label>
                                                <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->emergency_contact_relationship ?: 'Non renseigné' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Documents -->
                        <div x-show="activeTab === 'user_documents'">
                            <div class="bg-gradient-to-br from-white via-green-50 to-blue-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 overflow-hidden rounded-2xl border-2 border-green-100 dark:border-gray-600">
                                <div class="p-8">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-r from-green-500 to-blue-600 rounded-full p-3 mr-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">{{ __('Documents') }}</h3>
                                    </div>
                                    @include('profile.partials.user-documents')
                                </div>
                            </div>
                        </div>

                       
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Modal Contact d'urgence -->
    <div id="emergencyContactModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-2xl bg-white dark:bg-gray-800">
            <div class="mt-3">
                <!-- En-tête du modal -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-r from-red-500 to-orange-600 rounded-full p-3 mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">{{ __('Modifier le contact d\'urgence') }}</h3>
                    </div>
                    <button onclick="closeEmergencyContactModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Formulaire -->
                <form id="emergencyContactForm" method="POST" action="{{ route('profile.update-emergency-contact') }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-6">
                        <!-- Nom du contact -->
                        <div>
                            <label for="emergency_contact_name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('Nom du contact') }}
                            </label>
                            <input type="text" id="emergency_contact_name" name="emergency_contact_name" 
                                   value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                   placeholder="Nom complet du contact d'urgence">
                            @error('emergency_contact_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Téléphone -->
                        <div>
                            <label for="emergency_contact_phone" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ __('Téléphone') }}
                            </label>
                            <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" 
                                   value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                   placeholder="Numéro de téléphone">
                            @error('emergency_contact_phone')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Relation -->
                        <div>
                            <label for="emergency_contact_relationship" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ __('Relation') }}
                            </label>
                            <select id="emergency_contact_relationship" name="emergency_contact_relationship" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
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
                            @error('emergency_contact_relationship')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Boutons -->
                    <div class="flex justify-end space-x-4 mt-8">
                        <button type="button" onclick="closeEmergencyContactModal()" 
                                class="px-6 py-3 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-all duration-200 font-medium">
                            {{ __('Annuler') }}
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Enregistrer') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function openEmergencyContactModal() {
            document.getElementById('emergencyContactModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeEmergencyContactModal() {
            document.getElementById('emergencyContactModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('emergencyContactModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEmergencyContactModal();
            }
        });
        
        // Fermer le modal avec la touche Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEmergencyContactModal();
            }
        });
    </script>
</x-app-layout>