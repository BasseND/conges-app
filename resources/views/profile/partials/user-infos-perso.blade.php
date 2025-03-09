<!-- Informations générales -->
<div class="border border-gray-200 dark:border-gray-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Informations générales</h2>
                           
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Poste actuel</h3>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if(isset($user->position))
                                        {{ $user->position  }}
                                    @else
                                        Non renseigné
                                    @endif
                                </p>
                            </div>

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