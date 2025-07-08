@props(['title' => 'Confirmation requise', 'message', 'confirmText' => 'CONFIRMER', 'actionType' => 'delete', 'userInfo' => null])

<div x-data="{ 
    show: false, 
    url: '', 
    actionType: 'delete',
    userInfo: null,
    confirmInput: '',
    confirmText: 'CONFIRMER',
    get isValid() {
        return this.confirmInput.toUpperCase() === this.confirmText.toUpperCase();
    }
}" 
     x-show="show" 
     @sensitive-action-dialog.window="
        show = true; 
        url = $event.detail.url;
        actionType = $event.detail.actionType || 'delete';
        userInfo = $event.detail.userInfo || null;
        confirmText = $event.detail.confirmText || 'CONFIRMER';
        confirmInput = '';
     "
     @close-sensitive-dialog.window="show = false"
     class="fixed z-50 inset-0 overflow-y-auto" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true"
     style="display: none;">
    
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
             aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal -->
        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            
            <!-- Header avec icône -->
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                     :class="{
                        'bg-red-100 dark:bg-red-900': actionType === 'delete',
                        'bg-orange-100 dark:bg-orange-900': actionType === 'status' || actionType === 'role'
                     }">
                    <!-- Icône de suppression -->
                    <svg x-show="actionType === 'delete'" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <!-- Icône de modification -->
                    <svg x-show="actionType === 'status' || actionType === 'role'" class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                        <span x-show="actionType === 'delete'">Suppression d'utilisateur</span>
                        <span x-show="actionType === 'status'">Mise à jour du statut</span>
                        <span x-show="actionType === 'role'">Modification du rôle</span>
                    </h3>
                    
                    <!-- Informations utilisateur si disponibles -->
                    <div x-show="userInfo" class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                    <span class="text-white font-medium text-sm" x-text="userInfo?.first_name?.charAt(0) + userInfo?.last_name?.charAt(0)"></span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <span x-text="userInfo?.first_name"></span> <span x-text="userInfo?.last_name"></span>
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400" x-text="userInfo?.email"></p>
                                <div class="flex items-center space-x-4 mt-1">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        Statut actuel: <span x-text="userInfo?.is_active ? 'Actif' : 'Inactif'" :class="userInfo?.is_active ? 'text-green-600' : 'text-red-600'"></span>
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        Rôle: <span x-text="userInfo?.role" class="capitalize"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <span x-show="actionType === 'delete'">Vous êtes sur le point de supprimer définitivement cet utilisateur. Toutes ses ressources et données seront définitivement effacées. Cette action est irréversible.</span>
                            <span x-show="actionType === 'status'">Vous êtes sur le point de modifier le statut de cet utilisateur. Désactiver un utilisateur l'empêchera de se connecter à l'application.</span>
                            <span x-show="actionType === 'role'">Vous êtes sur le point de modifier le rôle de cet utilisateur. Cela changera ses permissions dans l'application.</span>
                        </p>
                    </div>
                    
                    <!-- Champ de confirmation -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <span x-show="actionType === 'delete'">Pour confirmer la suppression, tapez "<span class="font-mono font-bold" x-text="confirmText"></span>" dans le champ ci-dessous</span>
                            <span x-show="actionType === 'status'">Pour confirmer le changement de statut, tapez "<span class="font-mono font-bold" x-text="confirmText"></span>" dans le champ ci-dessous</span>
                            <span x-show="actionType === 'role'">Pour confirmer la modification du rôle, tapez "<span class="font-mono font-bold" x-text="confirmText"></span>" dans le champ ci-dessous</span>
                        </label>
                        <input 
                            type="text" 
                            x-model="confirmInput"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100"
                            placeholder="Tapez CONFIRMER"
                            autocomplete="off"
                        >
                    </div>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button 
                    type="button"
                    @click="
                        if (isValid) {
                            window.handleSensitiveAction(url, actionType, confirmInput, userInfo);
                            show = false;
                        }
                    "
                    :disabled="!isValid"
                    :class="{
                        'bg-red-600 hover:bg-red-700 focus:ring-red-500': actionType === 'delete' && isValid,
                        'bg-orange-600 hover:bg-orange-700 focus:ring-orange-500': (actionType === 'status' || actionType === 'role') && isValid,
                        'bg-gray-300 cursor-not-allowed': !isValid
                    }"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto sm:text-sm transition-colors duration-200 sm:ml-3">
                    <span x-show="actionType === 'delete'">Supprimer</span>
                    <span x-show="actionType === 'status'">Activer</span>
                    <span x-show="actionType === 'role'">Modifier le rôle</span>
                </button>
                
                <button 
                    type="button" 
                    @click="show = false; confirmInput = ''"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>