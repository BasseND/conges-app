<div class="px-4 py-5 sm:p-6">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informations personnelles</h2>
        <a   
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Modifier
        </a>
    </div>
    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
        <div class="sm:col-span-1">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom complet</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->first_name }} {{ $user->last_name }}</dd>
        </div>
        <div class="sm:col-span-1">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</dd>
        </div>
        <div class="sm:col-span-1">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Téléphone</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->phone ?? 'Non renseigné' }}</dd>
        </div>
        <div class="sm:col-span-1">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Département</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->department->name ?? 'Non assigné' }}</dd>
        </div>
        <div class="sm:col-span-1">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Rôle</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($user->role) }}</dd>
        </div>
        <div class="sm:col-span-1">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Solde de congés</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                Annuels: {{ $user->annual_leave_days }} jours<br>
                Maladie: {{ $user->sick_leave_days }} jours
            </dd>
        </div>
    </dl>
</div>

<!-- <x-modals.edit-user-dialog :user="$user" /> -->
