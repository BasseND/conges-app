<div x-data="{ showContractModal: false }" class="px-4 py-5 sm:p-6">
    
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Contrats de l'employé</h2>
        <!-- Add contract button -->
        <button @click="$dispatch('add-contract')" type="button" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter un contrat
        </button>
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
            },
            resetForm() {
                this.contractData = {
                    type: '',
                    date_debut: '',
                    date_fin: '',
                    salaire_brut: '',
                    statut: 'actif',
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
                 class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Nouveau contrat') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Créer un nouveau contrat pour l\'employé.') }}
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
                                <!--  Type de contrat -->
                                <div>
                                    <x-input-label for="type" :value="__('Type de contrat')" />
                                    <select  x-model="contractData.type" id="type" name="type" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Sélectionner un type de contrat</option>
                                        <option value="{{ App\Models\Contract::CONTRACT_CDI }}">CDI</option>
                                        <option value="{{ App\Models\Contract::CONTRACT_CDD }}">CDD</option>
                                        <option value="{{ App\Models\Contract::CONTRACT_INTERIM }}">Interim</option>
                                        <option value="{{ App\Models\Contract::CONTRACT_STAGE }}">Stage</option>
                                        <option value="{{ App\Models\Contract::CONTRACT_ALTERNANCE }}">Alternance</option>
                                        <option value="{{ App\Models\Contract::CONTRACT_FREELANCE }}">Freelance</option>
                                    </select>

                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>

                                 <!--  Salaire brut annuel -->
                                 <div>
                                    <x-input-label  for="salaire_brut" :value="__('Salaire brut annuel')" />
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <x-text-input x-model="contractData.salaire_brut" id="salaire_brut" name="salaire_brut" type="number" step="0.01" min="0" class="block w-full pr-12" required />
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">€</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('salaire_brut')" class="mt-2" />
                                </div>
                                <!--  Date de début -->

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
                                <button type="button" @click="showContractModal = false" class="uppercase inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Annuler') }}
                                </button>
                                <button type="submit" 
                                    :disabled="submitting" 
                                    class="bg-indigo-600 hover:bg-indigo-500 uppercase inline-flex justify-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
    

    <!-- Nouveau affichage : Tableau -->
    @if($user->contracts->count() > 0)
        <div class="space-y-6">
            @foreach($user->contracts as $contract)
            <div class="bg-white dark:bg-gray-600 max-w-2xl shadow overflow-hidden sm:rounded-lg">
                <div class="flex justify-between items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                        {{ $contract->type }}
                        </h2>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $contract->statut === 'actif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($contract->statut) }}
                            </span>
                        </p>
                    </div>
                    <div class="mt-3 flex justify-end space-x-2 mr-4">
                        
                        <!-- Modifier -->
                        <button @click="$dispatch('edit-contract', {{ $contract->id }})" type="button" class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded hover:bg-indigo-200">
                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </button>

                        <button @click="$dispatch('delete-dialog', '{{ route('admin.users.contracts.destroy', [$user->id, $contract->id]) }}')" type="button" class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded hover:bg-red-200 mr-4"
                        >
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer
                        </button>
                    </div>
                </div>

                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Salaire brut annuel
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                                {{ number_format($contract->salaire_brut, 2, ',', ' ') }} €
                            </dd>
                        </div>
                        <div class="bg-white dark:bg-gray-600 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Période
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                            @if($contract->type == \App\Models\Contract::CONTRACT_CDI)
                                    Indéterminée
                                @else
                                    {{ $contract->date_fin->diffInMonths($contract->date_debut) }} mois
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Date de début
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                            {{ $contract->date_debut->format('d M, Y') }}
                            </dd>
                        </div>
                        <div class="bg-white dark:bg-gray-600 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Date de fin
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                                @if($contract->type == \App\Models\Contract::CONTRACT_CDI)
                                    N/A
                                @else
                                    {{ $contract->date_fin->format('d M, Y') }}
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Pièce jointe
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 sm:mt-0 sm:col-span-2">
                                
                                @if($contract->contrat_file)
                                    <div class="flex items-center justify-between">
                                        <div class="mt-1 flex items-center">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-blue-600 dark:text-blue-400 ">Contrat de travail</span>
                                        </div>
                                        <a href="{{ route('admin.users.contracts.download', [$user->id, $contract->id]) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded hover:bg-indigo-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Télécharger
                                        </a>
                                    </div>
                                @else
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Aucun document joint</p>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 text-center">
            <p class="text-gray-500 dark:text-gray-400">Aucun contrat disponible pour cet employé.</p>
        </div>
    @endif


</div>
<x-modals.delete-dialog message="Êtes-vous sûr de vouloir supprimer ce contrat ? Cette action est irréversible." />