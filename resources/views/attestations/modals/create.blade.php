<!-- Modal de création d'attestation -->
<div id="createAttestationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <!-- En-tête du modal -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nouvelle demande d'attestation</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Formulaire -->
            <form id="createAttestationForm" action="{{ route('attestations.store') }}" method="POST" class="mt-6">
                @csrf
                
                <!-- Type d'attestation -->
                <div class="mb-6">
                    <label for="attestation_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Type d'attestation <span class="text-red-500">*</span>
                    </label>
                    <select name="attestation_type_id" id="attestation_type_id" required 
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                <div class="mb-6">
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Priorité <span class="text-red-500">*</span>
                    </label>
                    <select name="priority" id="priority" required 
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="normal">Normale</option>
                        <option value="high">Élevée</option>
                        <option value="urgent">Urgente</option>
                    </select>
                </div>

                <!-- Plage de dates (conditionnelle) -->
                <div id="dateRangeSection" class="mb-6 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date de début
                            </label>
                            <input type="date" name="start_date" id="start_date" 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date de fin
                            </label>
                            <input type="date" name="end_date" id="end_date" 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Champs personnalisés (conditionnels) -->
                <div id="customFieldsSection" class="mb-6 hidden">
                    <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Informations complémentaires</h4>
                    <div id="customFieldsContainer"></div>
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Notes ou commentaires
                    </label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Ajoutez des informations complémentaires si nécessaire..."></textarea>
                </div>

                <!-- Boutons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" id="cancelBtn" 
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition-colors duration-200">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200">
                        Créer la demande
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
                input.className = 'w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500';
                
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

        // Bouton annuler
        document.getElementById('cancelBtn').addEventListener('click', function() {
            document.getElementById('createAttestationModal').classList.add('hidden');
        });

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
</script>