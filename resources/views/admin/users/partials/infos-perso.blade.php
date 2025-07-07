<div class="bg-white dark:bg-gray-700 max-w shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informations personnelles</h2>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-personal-info')" class="inline-flex items-center btn btn-primary tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Modifier
            </button>
        </div>
    </div>
    <div class="border-t border-gray-200 dark:border-gray-600">
        <dl>
            <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Nom complet
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    {{ $user->first_name }} {{ $user->last_name }}
                </dd>
            </div>
            <div class="bg-white dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Email
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    {{ $user->email }}
                </dd>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Téléphone
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    {{ $user->phone ?? 'Non renseigné' }}
                </dd>
            </div>
            <div class="bg-white dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Adresse
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    Non renseigné
                </dd>
            </div>
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
                    Département
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    {{ $user->department->name ?? 'Non assigné' }}
                </dd>
            </div>
            <div class="bg-white dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Rôle d'accès
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    {{ ucfirst($user->role) }}
                </dd>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Solde de congés
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                    @if($user->leaveBalance)
                        <div class="space-y-1">
                            <div>Annuels: <span class="font-semibold">{{ $user->leaveBalance->annual_leave_days }}</span> jours</div>
                            <div>Maladie: <span class="font-semibold">{{ $user->leaveBalance->sick_leave_days }}</span> jours</div>
                            <div>Maternité: <span class="font-semibold">{{ $user->leaveBalance->maternity_leave_days }}</span> jours</div>
                            <div>Paternité: <span class="font-semibold">{{ $user->leaveBalance->paternity_leave_days }}</span> jours</div>
                            <div>Spéciaux: <span class="font-semibold">{{ $user->leaveBalance->special_leave_days }}</span> jours</div>
                            @if($user->leaveBalance->description)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $user->leaveBalance->description }}</div>
                            @endif
                        </div>
                    @elseif($user->company && $user->company->defaultLeaveBalance())
                        <div class="space-y-1">
                            <div>Annuels: <span class="font-semibold">{{ $user->company->defaultLeaveBalance()->annual_leave_days }}</span> jours (défaut)</div>
                            <div>Maladie: <span class="font-semibold">{{ $user->company->defaultLeaveBalance()->sick_leave_days }}</span> jours (défaut)</div>
                            <div>Maternité: <span class="font-semibold">{{ $user->company->defaultLeaveBalance()->maternity_leave_days }}</span> jours (défaut)</div>
                            <div>Paternité: <span class="font-semibold">{{ $user->company->defaultLeaveBalance()->paternity_leave_days }}</span> jours (défaut)</div>
                            <div>Spéciaux: <span class="font-semibold">{{ $user->company->defaultLeaveBalance()->special_leave_days }}</span> jours (défaut)</div>
                        </div>
                    @else
                        <div class="text-gray-500 dark:text-gray-400">Aucun solde de congés configuré</div>
                    @endif
                </dd>
            </div>
           
        </dl>
    </div>
</div>
@include('admin.users.modals.edit-personal-info', ['user' => $user])

