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
                                @include('profile.partials.update-password-modal')
                            </div>

                        </div>

                        <!-- Informations de contact -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
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
                    </div>
                </div>

                <!-- Navigation par onglets -->
                <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                        <li class="mr-2">
                            <a href="#" class="inline-block p-4 border-b-2 border-blue-600 uppercase rounded-t-lg active dark:text-blue-500 dark:border-blue-500" aria-current="page">Informations personnelles</a>
                        </li>
                        <li class="mr-2">
                            <a href="#" class="inline-block p-4 border-b-2 border-transparent uppercase rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Documents</a>
                        </li>
                        <li class="mr-2">
                            <a href="#" class="inline-block p-4 border-b-2 border-transparent uppercase rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Congés</a>
                        </li>
                        <li>
                            <a href="#" class="inline-block p-4 border-b-2 border-transparent uppercase rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Présence</a>
                        </li>
                    </ul>
                </div>

                <!-- Informations générales -->
                <div class="border border-gray-200 dark:border-gray-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Informations générales</h2>
                            @include('profile.partials.update-profile-information-modal')
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Date d'embauche</h3>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if(isset($user->contracts) && $user->contracts->count() > 0)
                                        {{ $user->contracts->sortBy('date_debut')->first()->date_debut->format('d M, Y') }}
                                    @else
                                        Non renseigné
                                    @endif
                                </p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Rôle d'accès</h3>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @switch($user->role)
                                        @case(\App\Models\User::ROLE_ADMIN)
                                            Administrateur
                                            @break
                                        @case(\App\Models\User::ROLE_HR)
                                            Ressources Humaines
                                            @break
                                        @case(\App\Models\User::ROLE_MANAGER)
                                            Manager
                                            @break
                                        @case(\App\Models\User::ROLE_DEPARTMENT_HEAD)
                                            Chef de département
                                            @break
                                        @default
                                            Employé
                                    @endswitch
                                </p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Département</h3>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if($user->department)
                                        {{ $user->department->name }}
                                    @else
                                        Non assigné
                                    @endif
                                </p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Horaires de travail</h3>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">8h - 17h</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Type d'emploi</h3>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if(isset($user->contracts) && $user->contracts->count() > 0)
                                        {{ $user->contracts->sortByDesc('date_debut')->first()->type }}
                                    @else
                                        Non renseigné
                                    @endif
                                </p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Manager</h3>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if($user->department && $user->department->head)
                                        {{ $user->department->head->first_name }} {{ $user->department->head->last_name }}
                                    @else
                                        Non assigné
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations de contrat -->
                <div class="border border-gray-200 dark:border-gray-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Informations de contrat</h2>
                        </div>

                        @if(isset($user->contracts) && $user->contracts->count() > 0)
                            @php
                                $latestContract = $user->contracts->sortByDesc('date_debut')->first();
                            @endphp
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Type de contrat</h3>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $latestContract->type }}</p>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Période</h3>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        @if($latestContract->type == \App\Models\Contract::CONTRACT_CDI)
                                            Indéterminée
                                        @else
                                            {{ $latestContract->date_fin->diffInMonths($latestContract->date_debut) }} mois
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de début</h3>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $latestContract->date_debut->format('d M, Y') }}</p>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de fin</h3>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        @if($latestContract->type == \App\Models\Contract::CONTRACT_CDI)
                                            N/A
                                        @else
                                            {{ $latestContract->date_fin->format('d M, Y') }}
                                        @endif
                                    </p>
                                </div>

                                <div class="md:col-span-2">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pièce jointe</h3>
                                    @if($latestContract->contrat_file)
                                        <div class="mt-1 flex items-center">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <a href="{{ asset('storage/' . $latestContract->contrat_file) }}" class="text-blue-600 dark:text-blue-400 hover:underline" target="_blank">
                                                Contrat de travail
                                            </a>
                                        </div>
                                    @else
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Aucun document joint</p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Aucun contrat enregistré</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>