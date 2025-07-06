<div x-data="{ open: false }" @keydown.escape.window="open = false">
    <!-- Bouton pour ouvrir le modal -->
    <button type="button" @click="open = true"  class="inline-flex items-center  btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        {{ __('Modifier le mot de passe') }}
    </button>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Fond semi-transparent -->
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="open = false"></div>

            <!-- Centre le modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Contenu du modal -->
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                {{ __('Modifier le mot de passe') }}
                            </h3>
                            <div class="mt-4">
                                <!-- Formulaire de modification du mot de passe -->
                                <form method="post" action="{{ route('profile.update') }}" class="space-y-6" id="password-form">
                                    @csrf
                                    @method('patch')

                                    <div>
                                        <x-input-label for="current_password" :value="__('Mot de passe actuel')" />
                                        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="password" :value="__('Nouveau mot de passe')" />
                                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                    </div>
                                    
                                    <!-- Champ caché pour indiquer qu'il s'agit d'une mise à jour de mot de passe -->
                                    <input type="hidden" name="updatePassword" value="true">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="document.getElementById('password-form').submit()" class="w-full inline-flex justify-center btn btn-primary">
                        {{ __('Enregistrer') }}
                    </button>
                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center  btn btn-secondary">
                        {{ __('Annuler') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>