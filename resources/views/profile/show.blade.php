<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <x-alert type="success" :message="session('success')" />
                <x-alert type="error" :message="session('error')" />

                <!-- En-tête du profil avec photo et informations principales -->
                <div class="bg-[#f8f8fd] dark:bg-gray-800 border border-gray-200 dark:border-gray-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex justify-between items-start md:items-center">
                            
                            <div class="flex justify-between mr-6 mb-4 md:mb-0">
                                <!-- Photo de profil -->
                                <div class="w-24 h-24 md:mr-6 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <!-- Informations principales -->
                                <div class="flex flex-col md:flex-row md:items-center justify-between">
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->first_name }} {{ $user->last_name }}</h1>
                                        <p class="text-gray-600 dark:text-gray-400">{{ $user->position }}</p>
                                        <p class="text-gray-500 dark:text-gray-500">ID: {{ $user->employee_id }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 md:mt-0">
                                @include('profile.modals.update-password')
                            </div>

                        </div>

                        <!-- Informations de contact -->
                        <div class="flex justify-between items-start border-t border-gray-200 dark:border-gray-700 mt-6  pt-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $user->phone ?: 'Non renseigné' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300">
                                        @if($user->department)
                                            {{ $user->department->name }}
                                        @else
                                            Non assigné
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300">
                                        Actif: {{ $user->is_active ? 'Oui' : 'Non' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-2">
                            @include('profile.modals.update-profile-information')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation par onglets -->
                <div  x-data="{ activeTab: 'user_personal' }"  class="mb-6 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                        <li class="mr-2">
                            <button @click="activeTab = 'user_personal'" :class="{ 'border-primary-500 text-primary-600 border-blue-500 dark:text-primary-500': activeTab === 'personal' }" class="px-3 py-2 text-sm font-medium border-b-2 border-transparent uppercase hover:border-gray-300">
                                Informations personnelles
                            </button>
                        </li>
                        <li class="mr-2">
                            <button @click="activeTab = 'user_documents'" :class="{ 'border-primary-500 text-primary-600 border-blue-500 dark:text-primary-500': activeTab === 'documents' }" class="px-3 py-2 text-sm font-medium border-b-2 border-transparent uppercase hover:border-gray-300">
                                Documents
                            </button>
                        </li>
                        <li class="mr-2">
                            <button @click="activeTab = 'user_presence'" :class="{ 'border-primary-500 text-primary-600 border-blue-500 dark:text-primary-500': activeTab === 'presence' }" class="px-3 py-2 text-sm font-medium border-b-2 border-transparent uppercase hover:border-gray-300">
                                Présence
                            </button>
                        </li>
                    </ul>
                

                    <!-- Contenu des onglets -->
                    <div class="mt-6">
                        <!-- Informations personnelles -->
                        <div x-show="activeTab === 'user_personal'" >
                        @include('profile.partials.user-infos-perso') 
                        </div>
                        <!-- Documents -->
                        <div x-show="activeTab === 'user_documents'" >
                            @include('profile.partials.user-documents')
                        </div>

                        <!-- Présence -->
                        <div x-show="activeTab === 'user_presence'" >
                            @include('profile.partials.user-presence')
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>