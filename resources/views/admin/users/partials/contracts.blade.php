<div x-data="{ showContractModal: false }" class="">
    
    <!-- En-tête modernisé -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 mb-6 overflow-hidden shadow-sm">
        <div class="bg-indigo-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Contrats de l'employé</h2>
                        <p class="text-indigo-100 text-sm">Gestion des contrats de travail</p>
                    </div>
                </div>
                <button @click="$dispatch('add-contract')" type="button" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 border border-white/30 rounded-lg font-semibold text-sm text-white uppercase tracking-wide transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter un contrat
                </button>
            </div>
        </div>
    </div>
    
    <!-- Modal d'ajout/modification de contrat -->
    <div x-data="{ 
            showContractModal: false, 
            submitting: false,
            isEditing: false,
            contractId: null,
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
            },
            openModal(contractId = null, contractData = null) {
                this.resetForm();
                if (contractId && contractData) {
                    this.isEditing = true;
                    this.contractId = contractId;
                    this.contractData = contractData;
                }
                this.showContractModal = true;
            }
        }" 
            @add-contract.window="openModal()"
            @edit-contract.window="
                fetch(`/admin/users/{{ $user->id }}/contracts/${$event.detail}/edit`)
                .then(response => response.json())
                .then(data => {
                    openModal($event.detail, {
                        type: data.type,
                        date_debut: data.date_debut,
                        date_fin: data.date_fin,
                        salaire_brut: data.salaire_brut,
                        statut: data.statut
                    });
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
                 class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                
                <div class="max-w-xl">
                <header>
                        <!-- Titre avec contenu conditionnel -->
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            <span x-show="!isEditing">{{ __('Nouveau contrat') }}</span>
                            <span x-show="isEditing">{{ __('Modifier le contrat') }}</span>
                        </h2>

                        <!-- Description avec contenu conditionnel -->
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            <span x-show="!isEditing">{{ __('Créer un nouveau contrat pour l\'employé.') }}</span>
                            <span x-show="isEditing">{{ __('Modifier le contrat de l\'employé.') }}</span>
                        </p>
                    </header>

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
                    x-bind:action="isEditing ? `/admin/users/{{ $user->id }}/contracts/${contractId}` : '{{ route('admin.users.contracts.store', $user->id) }}'" 
                    method="POST" 
                    @submit="submitting = true"
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

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Type de contrat -->
                                <div>
                                    <x-input-label for="type" :value="__('Type de contrat')" />
                                    <template x-if="!isEditing">
                                        <select x-model="contractData.type" id="type" name="type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
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
                                            <div class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-md bg-gray-100 dark:bg-gray-700 cursor-not-allowed" x-text="contractData.type"></div>
                                        </div>
                                    </template>
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>

                                 <!--  Salaire brut annuel -->
                                 <div x-show="contractData.type !== 'Freelance'">
                                    <x-input-label  for="salaire_brut" :value="__('Salaire brut annuel')" />
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <x-text-input x-model="contractData.salaire_brut" id="salaire_brut" name="salaire_brut" type="number" step="0.01" min="0" class="block w-full pr-12" x-bind:required="contractData.type !== 'Freelance'" />
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">{{ $globalCompanyCurrency }}</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('salaire_brut')" class="mt-2" />
                                </div>

                                <!-- TJM (Freelance) -->
                                 <div x-show="contractData.type === 'Freelance'">
                                    <x-input-label  for="tjm" :value="__('Tarif journalier (TJM)')" />
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <x-text-input x-model="contractData.tjm" id="tjm" name="tjm" type="number" step="0.01" min="0" class="block w-full pr-12" x-bind:required="contractData.type === 'Freelance'" />
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">{{ $globalCompanyCurrency }}</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('tjm')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="date_debut" :value="__('Date de début')" />
                                    <x-text-input x-model="contractData.date_debut" id="date_debut" name="date_debut" type="date" class="mt-1 block w-full" required />
                                    <x-input-error :messages="$errors->get('date_debut')" class="mt-2" />
                                </div>
                                <!--  Date de fin -->

                                <div>
                                    <x-input-label for="date_fin" :value="__('Date de fin')" />
                                    <x-text-input  x-model="contractData.date_fin" id="date_fin" name="date_fin" type="date" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('date_fin')" class="mt-2" />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('Laissez vide pour un contrat à durée indéterminée') }}
                                    </p>
                                </div>
                            </div>
                             <!--  Statut -->
                             <div>
                                    <x-input-label for="statut" :value="__('Statut')" />
                                    <select  x-model="contractData.statut" id="statut" name="statut" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="actif">Actif</option>
                                        <option value="suspendu">Suspendu</option>
                                        <option value="termine">Terminé</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('statut')" class="mt-2" />
                                </div>
                                <!--  Document du contrat -->
                                <div>
                                    <x-input-label for="contrat_file" :value="__('Document du contrat')" />
                                    <input type="file" id="contrat_file" name="contrat_file" 
                                        class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-md file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-indigo-50 file:text-indigo-700
                                            hover:file:bg-indigo-100
                                            dark:file:bg-indigo-900 dark:file:text-indigo-300"
                                        accept=".pdf,.doc,.docx" />
                                    <x-input-error :messages="$errors->get('contrat_file')" class="mt-2" />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('Formats acceptés : PDF, DOC, DOCX (max. 10 Mo)') }}
                                    </p>
                                </div>
                            <!-- Button actions -->
                            <div class="flex items-center justify-end gap-4 mt-4">
                                <button type="button" @click="showContractModal = false" class="uppercase inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Annuler') }}
                                </button>
                                <button type="submit" 
                                    :disabled="submitting" 
                                    class="bg-indigo-600 hover:bg-indigo-500 uppercase inline-flex justify-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span x-show="!submitting" x-text="isEditing ? 'Mettre à jour' : 'Enregistrer'"></span>
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
    

    <!-- Affichage des contrats existants -->
    @if($user->contracts->count() > 0)
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-1">
            @foreach($user->contracts as $contract)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 overflow-hidden hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200 shadow-sm">
                    <!-- En-tête du contrat -->
                     <div class="bg-blue-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">{{ $contract->type }}</h3>
                                    <p class="text-blue-100 text-sm">Contrat de travail</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $contract->statut === 'actif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : ($contract->statut === 'termine' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200') }}">
                                {{ ucfirst($contract->statut) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Contenu du contrat -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informations financières -->
                            <div class="space-y-4">
                                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                                @if($contract->type !== 'Freelance')
                                                    Salaire brut annuel
                                                @else
                                                    TJM
                                                @endif
                                            </p>
                                            <p class="text-lg font-bold text-green-900 dark:text-green-100">
                                                @if($contract->type !== 'Freelance')
                                                    {{ number_format($contract->salaire_brut, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                                @else
                                                    {{ number_format($contract->tjm, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Informations temporelles -->
                            <div class="space-y-4">
                                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-800 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-purple-800 dark:text-purple-200">Période</p>
                                            <p class="text-sm font-semibold text-purple-900 dark:text-purple-100">
                                                {{ $contract->date_debut->format('d M, Y') }}
                                            </p>
                                            <p class="text-sm text-purple-700 dark:text-purple-300">
                                                @if($contract->type == \App\Models\Contract::CONTRACT_CDI)
                                                    Indéterminée
                                                @else
                                                    {{ $contract->date_fin->format('d M, Y') }}
                                                @endif
                                            </p>
                                            @if($contract->is_expired)
                                                <p class="text-xs text-red-600 dark:text-red-400 font-medium mt-1">Contrat expiré</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($contract->contrat_file)
                        <div class="mt-6 bg-amber-50 dark:bg-amber-900/20 rounded-lg p-4 border border-amber-200 dark:border-amber-800">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-amber-100 dark:bg-amber-800 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-amber-800 dark:text-amber-200">Document contractuel</p>
                                        <p class="text-xs text-amber-600 dark:text-amber-400">Fichier disponible</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.users.contracts.download', [$user->id, $contract->id]) }}" class="inline-flex items-center px-3 py-2 bg-amber-100 hover:bg-amber-200 dark:bg-amber-800 dark:hover:bg-amber-700 border border-amber-300 dark:border-amber-600 rounded-lg text-sm font-medium text-amber-800 dark:text-amber-200 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Télécharger
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Actions -->
                        <div class="mt-6 flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <button @click="$dispatch('edit-contract', {{ $contract->id }})" type="button" class="inline-flex items-center px-4 py-2 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 border border-blue-200 dark:border-blue-800 rounded-lg text-sm font-medium text-blue-700 dark:text-blue-300 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Modifier
                            </button>
                            
                            <button @click="$dispatch('delete-dialog', '{{ route('admin.users.contracts.destroy', [$user->id, $contract->id]) }}')" type="button" class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 border border-red-200 dark:border-red-800 rounded-lg text-sm font-medium text-red-700 dark:text-red-300 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 p-12 text-center">
            <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Aucun contrat</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Commencez par ajouter un contrat pour cet employé.</p>
            <button @click="$dispatch('add-contract')" type="button" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 border border-transparent rounded-lg font-semibold text-sm text-white transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter le premier contrat
            </button>
        </div>
    @endif


</div>
<x-modals.delete-dialog message="Êtes-vous sûr de vouloir supprimer ce contrat ? Cette action est irréversible." />