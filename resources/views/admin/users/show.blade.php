<x-app-layout>
<x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profil de l\'employé') }}
            </h2>
            <div class="flex items-center space-x-4">
                <button class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ __('Envoyer un email') }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-6">
            <div class=" bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <!-- En-tête du profil -->
                <div class="bg-[#f8f8fd] dark:bg-gray-800 border border-gray-200 dark:border-gray-600 sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-24 h-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-2xl font-bold text-gray-600 dark:text-gray-300">
                                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </h1>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            ID: {{ $user->employee_id }} • Dernière connexion: {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation par onglets -->
                <div x-data="{ activeTab: 'personal' }" class="mb-6">
                    <div class="">
                        <ul class="flex space-x-4 border-b border-gray-200 dark:border-gray-700">
                            <li>
                                <button @click="activeTab = 'personal'" :class="{ 'border-primary-500 text-primary-600 border-blue-500 dark:text-primary-500': activeTab === 'personal' }" class="px-3 py-2 text-sm font-medium border-b-2 border-transparent uppercase hover:border-gray-300">
                                    Informations personnelles
                                </button>
                            </li>
                            <li>
                                <button @click="activeTab = 'contract'" :class="{ 'border-primary-500 text-primary-600 border-blue-500 dark:text-primary-500': activeTab === 'contract' }" class="px-3 py-2 text-sm font-medium border-b-2 border-transparent uppercase hover:border-gray-300">
                                    Contrat
                                </button>
                            </li>
                            <li>
                                <button @click="activeTab = 'payroll'" :class="{ 'border-primary-500 text-primary-600 border-blue-500 dark:text-primary-500': activeTab === 'payroll' }" class="px-3 py-2 text-sm font-medium border-b-2 border-transparent uppercase hover:border-gray-300">
                                    Paie
                                </button>
                            </li>
                            <li>
                                <button @click="activeTab = 'timesheet'" :class="{ 'border-primary-500 text-primary-600 border-blue-500 dark:text-primary-500': activeTab === 'timesheet' }" class="px-3 py-2 text-sm font-medium border-b-2 border-transparent uppercase hover:border-gray-300">
                                    Gestion du temps
                                </button>
                            </li>
                            <li>
                                <button @click="activeTab = 'documents'" :class="{ 'border-primary-500 text-primary-600 border-blue-500 dark:text-primary-500': activeTab === 'documents' }" class="px-3 py-2 text-sm font-medium border-b-2 border-transparent uppercase hover:border-gray-300"> 
                                    Documents
                                </button>
                            </li>
                            <li>
                                <button @click="activeTab = 'training'" :class="{ 'border-primary-500 text-primary-600 border-blue-500 dark:text-primary-500': activeTab === 'training' }" class="px-3 py-2 text-sm font-medium border-b-2 border-transparent uppercase hover:border-gray-300">
                                    Formation
                                </button>
                            </li>
                        </ul>

                    </div>

                    <!-- Contenu des onglets -->
                    <div class="mt-6">
                        <!-- Informations personnelles -->
                        <div x-show="activeTab === 'personal'" >
                            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                @include('admin.users.partials.infos-perso')
                            </div>
                            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg mt-6">
                                @include('admin.users.modals.delete-user-form')
                            </div>
                        </div>

                        <!-- Contrat -->
                        <div x-show="activeTab === 'contract'" class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            @include('admin.users.partials.contracts')
                        </div>

                        <!-- Autres onglets -->
                        <div x-show="activeTab === 'payroll'" class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            @include('admin.users.partials.payroll')
                        </div>

                        <div x-show="activeTab === 'timesheet'" class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            @include('admin.users.partials.timesheet')
                        </div>

                        <div x-show="activeTab === 'documents'" class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            @include('admin.users.partials.documents')
                        </div>

                        <div x-show="activeTab === 'training'" class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            @include('admin.users.partials.training')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>