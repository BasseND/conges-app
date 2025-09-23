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
    <x-contract-modal :user="$user" :globalCompanyCurrency="$globalCompanyCurrency" :contractTypes="$contractTypes" />
    

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
                            <div class="space-y-4" x-data="{ showSalary: false }">
                                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                                    <div class="flex items-center justify-between">
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
                                                    <span x-show="!showSalary">•••••</span>
                                                    <span x-show="showSalary">
                                                        @if($contract->type !== 'Freelance')
                                                            {{ number_format($contract->salaire_brut, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                                        @else
                                                            {{ number_format($contract->tjm, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                                        @endif
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <button @click="showSalary = !showSalary" 
                                                class="inline-flex items-center p-2 rounded-md text-green-400 hover:text-green-600 dark:hover:text-green-300 transition-colors duration-200">
                                            <svg x-show="!showSalary" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg x-show="showSalary" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                            </svg>
                                        </button>
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
                            @if($contract->statut !== 'termine')
                                <button @click="$dispatch('edit-contract', { contractId: {{ $contract->id }}, userId: {{ $user->id }} })" type="button" class="inline-flex items-center px-4 py-2 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 border border-blue-200 dark:border-blue-800 rounded-lg text-sm font-medium text-blue-700 dark:text-blue-300 transition-colors duration-200">
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
                            @else
                                <!-- Message pour contrat terminé -->
                                <div class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                    </svg>
                                    Contrat terminé - Non modifiable
                                </div>
                            @endif
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