<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-6 px-6 space-y-6 bg-white dark:bg-gray-800">

            <!-- Header -->
             <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg">
                        <svg class="w-8 h-8 text-white dark:text-bgray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-bgray-900 dark:text-white">
                            {{ __('Profil de l\'employé') }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Gestion complète du profil employé
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 border border-transparent rounded-lg font-medium text-sm text-white transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        {{ __('Modifier') }}
                    </a>
                    <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 border border-transparent rounded-lg font-medium text-sm text-white transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ __('Envoyer un email') }}
                    </button>
                </div>
            </div>

            <!-- Carte de profil principale -->
            <div class="bg-gradient-to-br from-white via-blue-50 to-indigo-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-600">
                <div class="relative p-8">
                    <!-- Motif de fond décoratif -->
                    <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
                        <svg viewBox="0 0 100 100" class="w-full h-full text-blue-600">
                            <circle cx="50" cy="50" r="40" fill="currentColor"/>
                            <circle cx="30" cy="30" r="20" fill="currentColor"/>
                            <circle cx="70" cy="70" r="15" fill="currentColor"/>
                        </svg>
                    </div>
                    
                    <div class="relative flex flex-col lg:flex-row items-start lg:items-center space-y-6 lg:space-y-0 lg:space-x-8">
                        <!-- Avatar et informations principales -->
                        <div class="flex items-center space-x-6">
                            <div class="relative">
                                <div class="w-28 h-28 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-3xl font-bold text-white shadow-lg transform hover:scale-105 transition-transform duration-200">
                                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                </div>
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }} border-4 border-white dark:border-gray-800 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        @if($user->is_active)
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </h1>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 118 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0"/>
                                        </svg>
                                        <span>ID: {{ $user->employee_id }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Dernière connexion: {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Statistiques rapides -->
                        <div class="flex-1 lg:ml-auto">
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 text-center border border-white/20">
                                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-3"><x-role-badge :role="$user->role" /></div>
                                    
                                    <div class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide">Rôle</div>
                                </div>
                                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 text-center border border-white/20">
                                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $user->department->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide">Département</div>
                                </div>
                                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 text-center border border-white/20 col-span-2 lg:col-span-1">
                                    <div class="text-2xl font-bold {{ $user->is_active ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide">Statut</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation par onglets moderne -->
            <div x-data="{ activeTab: 'personal' }" class="mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-600 overflow-hidden">
                    <div class="border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50">
                        <nav class="flex overflow-x-auto scrollbar-hide" aria-label="Tabs">
                            <button @click="activeTab = 'personal'" 
                                    :class="activeTab === 'personal' ? 'bg-blue-500 text-white shadow-lg' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-600'"
                                    class="flex-shrink-0 px-6 py-4 text-sm font-medium transition-all duration-200 border-r border-gray-200 dark:border-gray-600 first:rounded-tl-2xl">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Informations personnelles</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'contract'" 
                                    :class="activeTab === 'contract' ? 'bg-blue-500 text-white shadow-lg' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-600'"
                                    class="flex-shrink-0 px-6 py-4 text-sm font-medium transition-all duration-200 border-r border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>Contrat</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'payroll'" 
                                    :class="activeTab === 'payroll' ? 'bg-blue-500 text-white shadow-lg' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-600'"
                                    class="flex-shrink-0 px-6 py-4 text-sm font-medium transition-all duration-200 border-r border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                    <span>Paie</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'timesheet'" 
                                    :class="activeTab === 'timesheet' ? 'bg-blue-500 text-white shadow-lg' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-600'"
                                    class="flex-shrink-0 px-6 py-4 text-sm font-medium transition-all duration-200 border-r border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Gestion du temps</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'documents'" 
                                    :class="activeTab === 'documents' ? 'bg-blue-500 text-white shadow-lg' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-600'"
                                    class="flex-shrink-0 px-6 py-4 text-sm font-medium transition-all duration-200 border-r border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Documents</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'training'" 
                                    :class="activeTab === 'training' ? 'bg-blue-500 text-white shadow-lg' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-600'"
                                    class="flex-shrink-0 px-6 py-4 text-sm font-medium transition-all duration-200 last:rounded-tr-2xl">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span>Formation</span>
                                </div>
                            </button>
                        </nav>
                    </div>

                    <!-- Contenu des onglets -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-b-2xl">

                        <!-- Onglet Informations personnelles -->
                        <div x-show="activeTab === 'personal'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform translate-y-4">
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Informations personnelles</h3>
                                </div>
                                <div class="">
                                    @include('admin.users.partials.infos-perso')
                                </div>
                                <div class="">
                                    @include('admin.users.modals.delete-user-form')
                                </div>
                            </div>
                        </div>

                        <!-- Onglet Contrat -->
                        <div x-show="activeTab === 'contract'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform translate-y-4">
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Informations contractuelles</h3>
                                </div>
                                <div class="">
                                    @include('admin.users.partials.contracts')
                                </div>
                            </div>
                        </div>

                        <!-- Onglet Paie -->
                        <div x-show="activeTab === 'payroll'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform translate-y-4">
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Informations de paie</h3>
                                </div>
                                <div class="">
                                    @include('admin.users.partials.payroll')
                                </div>
                            </div>
                        </div>

                        <!-- Onglet Gestion du temps -->
                        <div x-show="activeTab === 'timesheet'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform translate-y-4">
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Gestion du temps</h3>
                                </div>
                                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                    @include('admin.users.partials.timesheet')
                                </div>
                            </div>
                        </div>

                        <!-- Onglet Documents -->
                        <div x-show="activeTab === 'documents'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform translate-y-4">
                            <div class="space-y-6">
                               
                                <div class="p-6">
                                    @include('admin.users.partials.documents')
                                </div>
                            </div>
                        </div>

                        <!-- Onglet Formation -->
                        <div x-show="activeTab === 'training'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform translate-y-4">
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Formation et développement</h3>
                                </div>
                                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                    @include('admin.users.partials.training')
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Pied de page avec actions rapides -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-600 p-6 mt-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Actions rapides</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Gérez facilement ce profil employé</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('admin.users.edit', $user) }}" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Modifier le profil
                            </a>
                            <a href="mailto:{{ $user->email }}" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Envoyer un email
                            </a>
                            <button type="button" 
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                                Plus d'actions
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>

            
            
            
            
        </div>
    </div>
</x-app-layout>