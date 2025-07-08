<section class="space-y-6">
    <div class="p-6">
        <header>
            <div class="flex items-center justify-between mb-4">
                <div class="w-3/4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Suppression du compte') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Une fois le compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de supprimer ce compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
                    </p>
                </div>
                <button 
                    @click="$dispatch('sensitive-action-dialog', {
                        url: '{{ route('admin.users.destroy', $user) }}',
                        actionType: 'delete',
                        confirmText: 'CONFIRMER',
                        userInfo: {
                            first_name: '{{ $user->first_name }}',
                            last_name: '{{ $user->last_name }}',
                            email: '{{ $user->email }}',
                            role: '{{ $user->role }}',
                            is_active: {{ $user->is_active ? 'true' : 'false' }}
                        }
                    })"
                    type="button"
                    class="block w-full sm:w-auto inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Supprimer le compte') }}
                </button>
            </div>
        </header>
    </div>
</section>