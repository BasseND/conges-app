@props(['user' => null, 'globalCompanyCurrency' => '€'])

<!-- Modal d'ajout/modification de contrat -->
<div x-data="{ 
        showContractModal: false, 
        submitting: false,
        isEditing: false,
        contractId: null,
        userId: {{ $user ? $user->id : 'null' }},
        contractData: {
            type: '',
            date_debut: '',
            date_fin: '',
            salaire_brut: '',
            statut: 'actif',
            tjm: '',
        },
        resetForm() {
            this.contractData = {
                type: '',
                date_debut: '',
                date_fin: '',
                salaire_brut: '',
                statut: 'actif',
                tjm: '',
            };
            this.isEditing = false;
            this.contractId = null;
            // Ne pas réinitialiser userId car il vient des props
        },
        openModal(contractId = null, contractData = null, userId = null) {
            this.resetForm();
            if (contractId && contractData) {
                this.isEditing = true;
                this.contractId = contractId;
                if (userId) this.userId = userId;
                this.contractData = contractData;
            }
            this.showContractModal = true;
        }
    }" 
        @open-contract-modal.window="openModal()"
        @add-contract.window="openModal()"
        @edit-contract.window="
                    fetch(`/admin/users/${$event.detail.userId}/contracts/${$event.detail.contractId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        openModal($event.detail.contractId, {
                            type: data.type,
                            date_debut: data.date_debut,
                            date_fin: data.date_fin,
                            salaire_brut: data.salaire_brut,
                            tjm: data.tjm,
                            statut: data.statut
                        }, $event.detail.userId);
                    })
                    .catch(error => console.error('Erreur lors de la récupération du contrat:', error))
                "
        x-show="showContractModal" 
        class="fixed z-50 inset-0 overflow-y-auto" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
        style="display: none;">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="showContractModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
             aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="showContractModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl px-6 pt-6 pb-6 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            
            <!-- En-tête modernisé -->
            <div class="flex items-center space-x-3 mb-6">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100" id="modal-title">
                        <span x-show="!isEditing">{{ __('Nouveau contrat') }}</span>
                        <span x-show="isEditing">{{ __('Modifier le contrat') }}</span>
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <span x-show="!isEditing">{{ __('Créer un nouveau contrat pour l\'employé') }}</span>
                        <span x-show="isEditing">{{ __('Modifier les informations du contrat') }}</span>
                    </p>
                </div>
            </div>

                <form x-data="{ 
                    submitting: false,
                    successMessage: '',
                    errorMessage: '',
                    showSuccess: false,
                    showError: false,
                    submitForm(event) {
                        event.preventDefault();
                        this.submitting = true;
                        this.showSuccess = false;
                        this.showError = false;
                        
                        const form = event.target;
                        const formData = new FormData(form);
                        
                        fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.submitting = false;
                            if (data.success) {
                                this.successMessage = data.message;
                                this.showSuccess = true;
                                form.reset();
                                // Fermer le modal après 2 secondes
                                setTimeout(() => {
                                    showContractModal = false;
                                    // Recharger la page pour afficher le nouveau contrat
                                    window.location.reload();
                                }, 2000);
                            } else {
                                this.errorMessage = data.message || 'Une erreur est survenue.';
                                this.showError = true;
                            }
                        })
                        .catch(error => {
                            this.submitting = false;
                            this.errorMessage = 'Une erreur est survenue lors de la communication avec le serveur.';
                            this.showError = true;
                            console.error('Error:', error);
                        });
                    }
                }" 
                x-bind:action="isEditing ? `/admin/users/${userId}/contracts/${contractId}` : `/admin/users/${userId}/contracts`"
                method="POST" 
                @submit="submitForm($event)"
                class="mt-6 space-y-6" 
                enctype="multipart/form-data">
                    @csrf
                    <template x-if="isEditing">
                        @method('PUT')
                    </template>

                    <!-- Message de succès -->
                    <div x-show="showSuccess" x-cloak class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700" x-text="successMessage"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Message d'erreur -->
                    <div x-show="showError" x-cloak class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700" x-text="errorMessage"></p>
                            </div>
                        </div>
                    </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Type de contrat -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Type de contrat') }}</label>
                                <template x-if="!isEditing">
                                    <select x-model="contractData.type" id="type" name="type" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                                        <option value="">Sélectionner un type</option>
                                        <option value="CDI">CDI</option>
                                        <option value="CDD">CDD</option>
                                        <option value="Stage">Stage</option>
                                        <option value="Alternance">Alternance</option>
                                        <option value="Freelance">Freelance</option>
                                    </select>
                                </template>
                                <template x-if="isEditing">
                                    <div>
                                        <input type="hidden" name="type" x-model="contractData.type">
                                        <div class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 bg-gray-100 dark:bg-gray-600 cursor-not-allowed text-gray-600 dark:text-gray-300" x-text="contractData.type"></div>
                                    </div>
                                </template>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                             <!--  Salaire brut annuel -->
                             <div x-show="contractData.type !== 'Freelance'">
                                <label for="salaire_brut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Salaire brut annuel') }}</label>
                                <div class="relative">
                                    <input x-model="contractData.salaire_brut" id="salaire_brut" name="salaire_brut" type="number" step="0.01" min="0" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" x-bind:required="contractData.type !== 'Freelance'" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $globalCompanyCurrency }}</span>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('salaire_brut')" class="mt-2" />
                            </div>

                            <!-- TJM (Freelance) -->
                             <div x-show="contractData.type === 'Freelance'">
                                <label for="tjm" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Tarif journalier (TJM)') }}</label>
                                <div class="relative">
                                    <input x-model="contractData.tjm" id="tjm" name="tjm" type="number" step="0.01" min="0" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" x-bind:required="contractData.type === 'Freelance'" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $globalCompanyCurrency }}</span>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('tjm')" class="mt-2" />
                            </div>

                            <div>
                                <label for="date_debut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Date de début') }}</label>
                                <input x-model="contractData.date_debut" id="date_debut" name="date_debut" type="date" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required />
                                <x-input-error :messages="$errors->get('date_debut')" class="mt-2" />
                            </div>
                            <!--  Date de fin -->

                            <div>
                                <label for="date_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Date de fin') }}</label>
                                <input x-model="contractData.date_fin" id="date_fin" name="date_fin" type="date" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" />
                                <x-input-error :messages="$errors->get('date_fin')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Laissez vide pour un contrat à durée indéterminée') }}
                                </p>
                            </div>
                        </div>
                        
                        
                         <!--  Statut -->
                         <div>
                                <label for="statut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Statut') }}</label>
                                <select x-model="contractData.statut" id="statut" name="statut" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="actif">Actif</option>
                                    <option value="suspendu">Suspendu</option>
                                    <option value="termine">Terminé</option>
                                </select>
                                <x-input-error :messages="$errors->get('statut')" class="mt-2" />
                            </div>
                            <!--  Document du contrat -->
                            <div>
                                <label for="contrat_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Document du contrat') }}</label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-colors duration-200">
                                    <div class="space-y-3">
                                        <div class="mx-auto w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                        </div>
                                        <div>
                                            <label for="contrat_file" class="cursor-pointer">
                                                <span class="text-blue-600 dark:text-blue-400 font-medium hover:text-blue-700 dark:hover:text-blue-300">Cliquez pour télécharger</span>
                                                <span class="text-gray-500 dark:text-gray-400"> ou glissez-déposez votre fichier</span>
                                                <input id="contrat_file" name="contrat_file" type="file" class="sr-only" accept=".pdf,.doc,.docx">
                                            </label>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            PDF, DOC, DOCX jusqu'à 10MB
                                        </p>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('contrat_file')" class="mt-2" />
                            </div>
                       
                        <!-- Button actions -->
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <button type="button" @click="showContractModal = false" class="px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                {{ __('Annuler') }}
                            </button>
                            <button type="submit" 
                                :disabled="submitting" 
                                class="px-6 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!submitting" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span x-text="isEditing ? 'Mettre à jour' : 'Enregistrer'"></span>
                                </span>
                                <span x-show="submitting" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Traitement...
                                </span>
                            </button>
                        </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>