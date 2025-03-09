<!-- Informations générales -->
<div class="bg-white dark:bg-gray-700 max-w shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6">
        <h2 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
            Informations générales
        </h2>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
            Informations générales de l'employé.
        </p>
    </div>
    <div class="border-t border-gray-200 dark:border-gray-600">
        <dl>
            <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Poste actuel
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    @if(isset($user->position))
                        {{ $user->position  }}
                    @else
                        Non renseigné
                    @endif
                </dd>
            </div>
            <div class="bg-white dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Date d'émbauche
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    @if(isset($user->contracts) && $user->contracts->count() > 0)
                        {{ $user->contracts->sortBy('date_debut')->first()->date_debut->format('d M, Y') }}
                    @else
                        Non renseigné
                    @endif
                </dd>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Rôle d'accès
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
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
                </dd>
            </div>
            <div class="bg-white dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Département
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    @if($user->department)
                        {{ $user->department->name }}
                    @else
                        Non assigné
                    @endif
                </dd>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Horaires de travail
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                8h - 17h
                </dd>
            </div>
            <div class="bg-white dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Manager
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    @if($user->department && $user->department->head)
                        {{ $user->department->head->first_name }} {{ $user->department->head->last_name }}
                    @else
                        Non assigné
                    @endif
                </dd>
            </div>
        </dl>
    </div>
</div>

<!-- Informations de contrat -->
<div class="bg-white dark:bg-gray-700 max-w shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6">
        <h2 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
            Informations de contrat
        </h2>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
            Informations de contrat de l'employé.
        </p>
    </div>

    @if(isset($user->contracts) && $user->contracts->count() > 0)
        @php
            $latestContract = $user->contracts->sortByDesc('date_debut')->first();
        @endphp
        <div class="border-t border-gray-200 dark:border-gray-600">
            <dl>
                <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Type de contrat
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                        {{ $latestContract->type }}
                    </dd>
                </div>
                <div class="bg-white dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Période
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    @if($latestContract->type == \App\Models\Contract::CONTRACT_CDI)
                            Indéterminée
                        @else
                            {{ $latestContract->date_fin->diffInMonths($latestContract->date_debut) }} mois
                        @endif
                    </dd>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Date de début
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                        {{ $latestContract->date_debut->format('d M, Y') }}
                    </dd>
                </div>
                <div class="bg-white dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Date de fin
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                        @if($latestContract->type == \App\Models\Contract::CONTRACT_CDI)
                            N/A
                        @else
                            {{ $latestContract->date_fin->format('d M, Y') }}
                        @endif
                    </dd>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Pièce jointe
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
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
                    </dd>
                </div>
                <div class="bg-white dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Statut
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                        {{ $latestContract->statut }}
                    </dd>
                </div>
            </dl>
        </div>
    @else
        <p class="text-gray-500 dark:text-gray-400">Aucun contrat enregistré</p>
    @endif
</div>