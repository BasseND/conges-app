@props(['globalCompanyCurrency' => '€'])

<div x-data="{
    showModal: false,
    isEditing: false,
    contractId: null,
    userId: null,
    submitting: false,
    formData: {
        type: '',
        salaire_brut: '',
        tjm: '',
        date_debut: '',
        date_fin: '',
        statut: 'actif',
        contrat_file: null,
        user_id: '',
        is_active: false
    },
    users: [],
    
    openModal(contractId = null, contractData = null, userId = null) {
        this.resetForm();
        
        if (contractId && contractData) {
            this.isEditing = true;
            this.contractId = contractId;
            if (userId) this.userId = userId;
            this.formData = {
                type: contractData.type || '',
                salaire_brut: contractData.salaire_brut || '',
                tjm: contractData.tjm || '',
                date_debut: contractData.date_debut || '',
                date_fin: contractData.date_fin || '',
                statut: contractData.statut || 'actif',
                contrat_file: null,
                user_id: userId || '',
                is_active: contractData.is_active || false
            };
        } else {
            this.isEditing = false;
            this.contractId = null;
            if (userId) this.userId = userId;
            if (!this.userId) {
                this.loadUsers();
            }
        }
        
        this.showModal = true;
    },
    
    closeModal() {
        this.showModal = false;
        this.resetForm();
    },
    
    resetForm() {
        this.formData = {
            type: '',
            salaire_brut: '',
            tjm: '',
            date_debut: '',
            date_fin: '',
            statut: 'actif',
            contrat_file: null,
            user_id: '',
            is_active: false
        };
        this.submitting = false;
    },
    
    async loadUsers() {
        try {
            const response = await fetch('/admin/users/api');
            if (response.ok) {
                this.users = await response.json();
            } else {
                console.error('Erreur lors du chargement des utilisateurs');
            }
        } catch (error) {
            console.error('Erreur:', error);
        }
    },
    
    async submitForm(event) {
        event.preventDefault();
        this.submitting = true;
        
        try {
            const formData = new FormData();
            
            Object.keys(this.formData).forEach(key => {
                if (key === 'date_fin') {
                    // Pour les CDI, date_fin doit être null, pour les autres types, envoyer la valeur
                    if (this.formData.type === 'CDI') {
                        // Ne pas envoyer date_fin pour les CDI
                    } else {
                        formData.append(key, this.formData[key] || '');
                    }
                } else if (key === 'is_active') {
                    // Toujours envoyer is_active, même si false
                    formData.append(key, this.formData[key] ? '1' : '0');
                } else if (this.formData[key] !== null && this.formData[key] !== '') {
                    formData.append(key, this.formData[key]);
                }
            });
            
            formData.append('_token', document.querySelector('meta[name=csrf-token]').getAttribute('content'));
            
            let url, method;
            if (this.isEditing) {
                url = '/admin/contracts/' + this.contractId;
                method = 'POST';
                formData.append('_method', 'PUT');
            } else {
                const targetUserId = this.userId || this.formData.user_id;
                url = '/admin/users/' + targetUserId + '/contracts';
                method = 'POST';
            }
            
            const response = await fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const result = await response.json();
            
            if (response.ok) {
                this.closeModal();
                // Rediriger vers la page des contrats avec le message de succès
                window.location.href = '/admin/contracts?success=' + encodeURIComponent(result.message || 'Contrat mis à jour avec succès.');
            } else {
                console.error('Erreur:', result.message || 'Une erreur est survenue');
                alert(result.message || 'Une erreur est survenue lors de la sauvegarde');
            }
        } catch (error) {
            console.error('Erreur lors de la soumission:', error);
            alert('Une erreur est survenue lors de la sauvegarde');
        } finally {
            this.submitting = false;
        }
    }
}"
@open-contract-edit-modal.window="openModal($event.detail.contractId, $event.detail.contractData, $event.detail.userId)"
@edit-contract.window="fetch('/admin/users/' + $event.detail.userId + '/contracts/' + $event.detail.contractId + '/edit').then(response => response.json()).then(data => { openModal($event.detail.contractId, data, $event.detail.userId); }).catch(error => console.error('Erreur lors de la récupération du contrat:', error))"
x-show="showModal"
x-cloak
class="fixed z-50 inset-0 overflow-y-auto"
aria-labelledby="modal-title"
role="dialog"
aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="showModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
             aria-hidden="true"
             @click="closeModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="showModal" 
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
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100" id="modal-title">
                        <span x-show="!isEditing">{{ __('Nouveau contrat') }}</span>
                        <span x-show="isEditing">{{ __('Modifier le contrat') }}</span>
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <span x-show="!isEditing">{{ __('Créer un nouveau contrat pour l\'employé') }}</span>
                        <span x-show="isEditing">{{ __('Modifier les informations du contrat') }}</span>
                    </p>
                </div>
                <button @click="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form @submit="submitForm($event)" enctype="multipart/form-data" class="mt-6 space-y-6">
                <!-- Sélection d'utilisateur (uniquement pour la création) -->
                <div x-show="!isEditing && !userId">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Sélectionner un employé') }}</label>
                    <select x-model="formData.user_id" id="user_id" name="user_id" :required="!isEditing && !userId" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="">Choisir un employé</option>
                        <template x-for="user in users" :key="user.id">
                            <option :value="user.id" x-text="user.first_name + ' ' + user.last_name + ' (' + user.email + ')'">
                            </option>
                        </template>
                    </select>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type de contrat -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Type de contrat') }}</label>
                        <select x-model="formData.type" 
                                @change="if (formData.type === 'CDI') formData.date_fin = ''" 
                                id="type" 
                                name="type" 
                                required 
                                :disabled="isEditing"
                                :class="{
                                    'w-full border rounded-lg px-4 py-3 focus:outline-none transition-colors duration-200': true,
                                    'border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500': !isEditing,
                                    'border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 cursor-not-allowed': isEditing
                                }">
                            <option value="">Sélectionner un type</option>
                            <option value="CDI">CDI</option>
                            <option value="CDD">CDD</option>
                            <option value="Stage">Stage</option>
                            <option value="Alternance">Alternance</option>
                            <option value="Freelance">Freelance</option>
                        </select>
                    </div>

                    <!-- Salaire brut annuel (pour tous sauf Freelance) -->
                    <div x-show="formData.type !== 'Freelance'">
                        <label for="salaire_brut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Salaire brut annuel') }}</label>
                        <div class="relative">
                            <input x-model="formData.salaire_brut" 
                                   type="number" 
                                   step="0.01" 
                                   min="0" 
                                   id="salaire_brut" 
                                   name="salaire_brut" 
                                   class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $globalCompanyCurrency }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- TJM (pour Freelance uniquement) -->
                    <div x-show="formData.type === 'Freelance'">
                        <label for="tjm" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Tarif journalier (TJM)') }}</label>
                        <div class="relative">
                            <input x-model="formData.tjm" 
                                   type="number" 
                                   step="0.01" 
                                   min="0" 
                                   id="tjm" 
                                   name="tjm" 
                                   class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $globalCompanyCurrency }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Date de début -->
                    <div>
                        <label for="date_debut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Date de début') }}</label>
                        <input x-model="formData.date_debut" 
                               type="date" 
                               id="date_debut" 
                               name="date_debut" 
                               required 
                               class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>

                    <!-- Date de fin (sauf pour CDI) -->
                    <div x-show="formData.type !== 'CDI'">
                        <label for="date_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Date de fin') }}</label>
                        <input x-model="formData.date_fin" 
                               type="date" 
                               id="date_fin" 
                               name="date_fin" 
                               class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Laissez vide pour un contrat à durée indéterminée') }}
                        </p>
                    </div>
                </div>
                
                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Statut') }}</label>
                    <select x-model="formData.statut" 
                            @change="if (formData.statut !== 'actif') formData.is_active = false"
                            id="statut" 
                            name="statut" 
                            required 
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="actif">Actif</option>
                        <option value="suspendu">Suspendu</option>
                        <option value="termine">Terminé</option>
                    </select>
                    
                    <!-- Message d'avertissement pour statut terminé -->
                    <div x-show="formData.statut === 'termine'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="mt-3 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-amber-800 dark:text-amber-200">{{ __('Attention') }}</h4>
                                <p class="mt-1 text-sm text-amber-700 dark:text-amber-300">
                                    {{ __('Une fois le contrat marqué comme "Terminé" et soumis, il ne sera plus possible de le modifier.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contrat en vigueur -->
                <div x-show="formData.statut === 'actif'">
                    <div class="flex items-center space-x-3">
                        <input x-model="formData.is_active" 
                               id="is_active" 
                               name="is_active" 
                               type="checkbox" 
                               value="1"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded">
                        <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Définir comme contrat en vigueur') }}
                        </label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Un seul contrat peut être en vigueur par employé. Cocher cette case désactivera automatiquement les autres contrats.') }}
                    </p>
                </div>

                <!-- Document du contrat -->
                <div>
                    <label for="contrat_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Document du contrat') }}</label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500 rounded-xl p-6 text-center transition-colors duration-200">
                        <div class="space-y-3">
                            <div class="mx-auto w-12 h-12 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <div>
                                <label for="contrat_file" class="cursor-pointer">
                                    <span class="text-blue-600 dark:text-blue-400 font-medium hover:text-blue-700 dark:hover:text-blue-300">Cliquez pour télécharger</span>
                                    <span class="text-gray-500 dark:text-gray-400"> ou glissez-déposez votre fichier</span>
                                    <input @change="formData.contrat_file = $event.target.files[0]" id="contrat_file" name="contrat_file" type="file" class="sr-only" accept=".pdf,.doc,.docx">
                                </label>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                PDF, DOC, DOCX jusqu'à 10MB
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Button actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" @click="closeModal()" class="px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ __('Annuler') }}
                    </button>
                    <button type="submit" 
                        :disabled="submitting" 
                        class="px-6 py-3 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
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