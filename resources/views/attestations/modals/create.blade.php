<!-- Modal de création d'attestation -->
<div x-data="{ 
        showAttestationModal: false, 
        submitting: false,
        successMessage: '',
        errorMessage: '',
        showSuccess: false,
        showError: false,
        resetForm() {
            this.showSuccess = false;
            this.showError = false;
            document.getElementById('createAttestationForm').reset();
            this.hideConditionalSections();
        },
        hideConditionalSections() {
            document.getElementById('dateRangeSection').classList.add('hidden');
            document.getElementById('customFieldsSection').classList.add('hidden');
            document.getElementById('customFieldsContainer').innerHTML = '';
        },
        openModal() {
            this.resetForm();
            this.showAttestationModal = true;
        },
        init() {
            // Écouter l'événement personnalisé pour ouvrir le modal
            this.$el.addEventListener('open-attestation-modal', () => {
                this.openModal();
            });
            // Écouter l'événement global
            window.addEventListener('open-attestation-modal', () => {
                this.openModal();
            });
        },
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
                    this.successMessage = data.message || 'Demande d\'attestation créée avec succès.';
                    this.showSuccess = true;
                    // Fermer le modal après 2 secondes
                    setTimeout(() => {
                        this.showAttestationModal = false;
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
    @open-attestation-modal.window="showAttestationModal = true; showSuccess = false; showError = false"
    x-show="showAttestationModal" 
    class="fixed z-50 inset-0 overflow-y-auto" 
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
    style="display: none;">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="showAttestationModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
             aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="showAttestationModal" 
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
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100" id="modal-title">
                        Nouvelle demande d'attestation
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Créer une nouvelle demande d'attestation
                    </p>
                </div>
            </div>

            <!-- Formulaire -->
            <form id="createAttestationForm" action="{{ route('attestations.store') }}" method="POST" @submit="submitForm($event)" class="mt-6 space-y-6">
                @csrf
                
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
                
                <!-- Type d'attestation -->
                <div>
                    <label for="attestation_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Type d'attestation <span class="text-red-500">*</span>
                    </label>
                    <select name="attestation_type_id" id="attestation_type_id" required 
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                        <option value="">Sélectionnez un type d'attestation</option>
                        @foreach($attestationTypes as $type)
                            <option value="{{ $type->id }}" 
                                    data-requires-date-range="{{ $type->requires_date_range ? 'true' : 'false' }}"
                                    data-requires-salary-info="{{ $type->requires_salary_info ? 'true' : 'false' }}"
                                    data-requires-custom-fields="{{ $type->requires_custom_fields ? 'true' : 'false' }}"
                                    data-custom-fields-config="{{ $type->custom_fields_config ? json_encode($type->custom_fields_config) : '{}' }}">
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Choisissez le type d'attestation que vous souhaitez demander</p>
                </div>

                <!-- Priorité -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Priorité <span class="text-red-500">*</span>
                    </label>
                    <select name="priority" id="priority" required 
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                        <option value="normal">Normale</option>
                        <option value="high">Élevée</option>
                        <option value="urgent">Urgente</option>
                    </select>
                </div>

                <!-- Plage de dates (conditionnelle) -->
                <div id="dateRangeSection" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date de début
                            </label>
                            <input type="date" name="start_date" id="start_date" 
                                   class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date de fin
                            </label>
                            <input type="date" name="end_date" id="end_date" 
                                   class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                        </div>
                    </div>
                </div>

                <!-- Champs personnalisés (conditionnels) -->
                <div id="customFieldsSection" class="hidden">
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                        <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Informations complémentaires
                        </h4>
                        <div id="customFieldsContainer" class="space-y-4"></div>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Notes ou commentaires
                    </label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                              placeholder="Ajoutez des informations complémentaires si nécessaire..."></textarea>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" @click="showAttestationModal = false" 
                            class="px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Annuler
                    </button>
                    <button type="submit" 
                            :disabled="submitting" 
                            class="px-6 py-3 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!submitting" class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Créer la demande
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const attestationTypeSelect = document.getElementById('attestation_type_id');
        const dateRangeSection = document.getElementById('dateRangeSection');
        const customFieldsSection = document.getElementById('customFieldsSection');
        const customFieldsContainer = document.getElementById('customFieldsContainer');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        // Gérer le changement de type d'attestation
        attestationTypeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                const requiresDateRange = selectedOption.dataset.requiresDateRange === 'true';
                const requiresCustomFields = selectedOption.dataset.requiresCustomFields === 'true';
                const customFieldsConfig = JSON.parse(selectedOption.dataset.customFieldsConfig || '{}');

                // Afficher/masquer la section des dates
                if (requiresDateRange) {
                    dateRangeSection.classList.remove('hidden');
                    startDateInput.required = true;
                } else {
                    dateRangeSection.classList.add('hidden');
                    startDateInput.required = false;
                    startDateInput.value = '';
                    endDateInput.value = '';
                }

                // Afficher/masquer les champs personnalisés
                if (requiresCustomFields && customFieldsConfig.fields) {
                    customFieldsSection.classList.remove('hidden');
                    generateCustomFields(customFieldsConfig.fields);
                } else {
                    customFieldsSection.classList.add('hidden');
                    customFieldsContainer.innerHTML = '';
                }
            } else {
                dateRangeSection.classList.add('hidden');
                customFieldsSection.classList.add('hidden');
                customFieldsContainer.innerHTML = '';
                startDateInput.required = false;
            }
        });

        // Générer les champs personnalisés
        function generateCustomFields(fields) {
            customFieldsContainer.innerHTML = '';
            
            fields.forEach(field => {
                const fieldDiv = document.createElement('div');
                fieldDiv.className = 'mb-4';
                
                const label = document.createElement('label');
                label.className = 'block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2';
                label.textContent = field.label;
                if (field.required) {
                    label.innerHTML += ' <span class="text-red-500">*</span>';
                }
                
                let input;
                switch (field.type) {
                    case 'text':
                        input = document.createElement('input');
                        input.type = 'text';
                        break;
                    case 'number':
                        input = document.createElement('input');
                        input.type = 'number';
                        break;
                    case 'date':
                        input = document.createElement('input');
                        input.type = 'date';
                        break;
                    case 'select':
                        input = document.createElement('select');
                        if (field.options) {
                            field.options.forEach(option => {
                                const optionElement = document.createElement('option');
                                optionElement.value = option.value;
                                optionElement.textContent = option.label;
                                input.appendChild(optionElement);
                            });
                        }
                        break;
                    case 'textarea':
                        input = document.createElement('textarea');
                        input.rows = 3;
                        break;
                    default:
                        input = document.createElement('input');
                        input.type = 'text';
                }
                
                input.name = `custom_data[${field.name}]`;
                input.className = 'w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200';
                
                if (field.required) {
                    input.required = true;
                }
                
                if (field.placeholder) {
                    input.placeholder = field.placeholder;
                }
                
                fieldDiv.appendChild(label);
                fieldDiv.appendChild(input);
                customFieldsContainer.appendChild(fieldDiv);
            });
        }

        // Bouton fermer (géré par Alpine.js maintenant)

        // Validation des dates
        startDateInput.addEventListener('change', function() {
            if (this.value && endDateInput.value && this.value > endDateInput.value) {
                endDateInput.value = this.value;
            }
            endDateInput.min = this.value;
        });

        endDateInput.addEventListener('change', function() {
            if (this.value && startDateInput.value && this.value < startDateInput.value) {
                startDateInput.value = this.value;
            }
        });
    });
        
        // Pour ouvrir le modal depuis l'extérieur, utilisez :
        // window.dispatchEvent(new CustomEvent('open-attestation-modal'));
        
    
</script>

<!-- 
    UTILISATION DU MODAL MODERNISÉ :
    
    1. Pour ouvrir le modal depuis un bouton :
       <button @click="$dispatch('open-attestation-modal')">Nouvelle attestation</button>
    
    2. Ou depuis JavaScript :
       window.dispatchEvent(new CustomEvent('open-attestation-modal'));
    
    3. Le modal utilise maintenant Alpine.js pour :
       - Gestion d'état moderne
       - Animations fluides
       - Soumission AJAX
       - Messages de feedback
       - Design responsive et moderne
-->