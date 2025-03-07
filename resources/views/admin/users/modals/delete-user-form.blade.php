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
            <x-danger-button class="block w-full sm:w-auto "
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            >{{ __('Supprimer le compte') }}
            </x-danger-button>
        </div>
    </header>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" maxWidth="md" focusable>
        <form method="post" action="{{ route('admin.users.destroy', $user) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Supprimer le compte') }}  <strong>( {{  $user->first_name }} {{  $user->last_name }} )</strong>  
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Une fois le compte supprimé, toutes ses ressources et données seront définitivement effacées. Pour confirmer la suppression, veuillez saisir le prénom et le nom de l\'utilisateur exactement comme indiqué ci-dessus.') }}
            </p>

            <div class="mt-6">
                @if(session('error'))
                    <div class="mb-4 text-sm text-red-600">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mt-4">
                    <x-input-label for="confirm_first_name" value="{{ __('Pour confirmer la suppression, veuillez saisir le prénom') }}" />
                    <x-text-input
                        id="confirm_first_name"
                        name="confirm_first_name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="{{ __('Prénom') }}"
                        required
                    />
                    <x-input-error :messages="$errors->userDeletion->get('confirm_first_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="confirm_last_name" value="{{ __('Pour confirmer la suppression, veuillez saisir le nom') }}" />
                    <x-text-input
                        id="confirm_last_name"
                        name="confirm_last_name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="{{ __('Nom') }}"
                        required
                    />
                    <x-input-error :messages="$errors->userDeletion->get('confirm_last_name')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Supprimer le compte') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    </div>
</section>