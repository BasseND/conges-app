@section('title', 'Modifier l\'Attestation')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Modifier l'Attestation
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Document #{{ $attestationRequest->document_number }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.hr-attestations.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            <div class="p-8">
                    @if ($errors->any())
                        <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-xl p-4 mb-6 shadow-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h4 class="text-red-800 font-semibold">Erreurs de validation</h4>
                            </div>
                            <ul class="text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.hr-attestations.update', $attestationRequest) }}" method="POST" id="attestationForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="category" value="{{ $attestationRequest->category ?? 'hr_generated' }}">
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Information de l'utilisateur (lecture seule) -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Utilisateur
                                </label>
                                <div class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300">
                                    {{ $attestationRequest->user->first_name }} {{ $attestationRequest->user->last_name }} ({{ $attestationRequest->user->email }})
                                </div>
                                <input type="hidden" name="user_id" value="{{ $attestationRequest->user->id }}">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    L'utilisateur ne peut pas être modifié lors de l'édition
                                </p>
                            </div>

                            <!-- Information du type d'attestation (lecture seule) -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Type d'Attestation
                                </label>
                                <div class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300">
                                    {{ $attestationRequest->attestationType->name }}
                                </div>
                                <input type="hidden" name="attestation_type_id" value="{{ $attestationRequest->attestation_type_id }}">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Le type d'attestation ne peut pas être modifié lors de l'édition
                                </p>
                            </div>
                        </div>

                        <!-- Informations de l'utilisateur sélectionné -->
                        <div id="user-info" class="mb-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h6 class="flex items-center text-lg font-medium text-gray-900 mb-3">
                                    <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Informations de l'utilisateur
                                </h6>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <strong class="text-gray-700">Nom complet:</strong> 
                                        <span id="user-name" class="text-gray-900">{{ $attestationRequest->user->first_name }} {{ $attestationRequest->user->last_name }}</span>
                                    </div>
                                    <div>
                                        <strong class="text-gray-700">Poste:</strong> 
                                        <span id="user-position" class="text-gray-900">{{ $attestationRequest->user->position ?? 'Non défini' }}</span>
                                    </div>
                                    <div>
                                        <strong class="text-gray-700">Département:</strong> 
                                        <span id="user-department" class="text-gray-900">{{ $attestationRequest->user->department->name ?? 'Non défini' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Champs conditionnels -->
                        <div id="conditional-fields">
                            <!-- Champs pour certificat de travail -->
                            <div id="certificat-fields" class="conditional-group {{ $attestationRequest->attestationType->template_file === 'certificat_travail' ? '' : 'hidden' }}">
                                <h5 class="flex items-center text-lg font-medium text-gray-900 mb-4">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6m8 0H8"/>
                                    </svg>
                                    Informations pour le Certificat de Travail
                                </h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label for="date_fin_contrat" class="block text-sm font-medium text-gray-700 mb-2">
                                            Date de fin de contrat
                                        </label>
                                        <input type="date" name="custom_data[date_fin_contrat]" id="date_fin_contrat" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               value="{{ $attestationRequest->custom_data['date_fin_contrat'] ?? '' }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="motif_fin_contrat" class="block text-sm font-medium text-gray-700 mb-2">
                                            Motif de fin de contrat
                                        </label>
                                        <select name="custom_data[motif_fin_contrat]" id="motif_fin_contrat" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Sélectionner...</option>
                                            <option value="demission" {{ ($attestationRequest->custom_data['motif_fin_contrat'] ?? '') === 'demission' ? 'selected' : '' }}>Démission</option>
                                            <option value="licenciement" {{ ($attestationRequest->custom_data['motif_fin_contrat'] ?? '') === 'licenciement' ? 'selected' : '' }}>Licenciement</option>
                                            <option value="fin_cdd" {{ ($attestationRequest->custom_data['fin_cdd'] ?? '') === 'fin_cdd' ? 'selected' : '' }}>Fin de CDD</option>
                                            <option value="rupture_conventionnelle" {{ ($attestationRequest->custom_data['motif_fin_contrat'] ?? '') === 'rupture_conventionnelle' ? 'selected' : '' }}>Rupture conventionnelle</option>
                                            <option value="retraite" {{ ($attestationRequest->custom_data['motif_fin_contrat'] ?? '') === 'retraite' ? 'selected' : '' }}>Retraite</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="duree_contrat" class="block text-sm font-medium text-gray-700 mb-2">
                                            Durée du contrat
                                        </label>
                                        <input type="text" name="custom_data[duree_contrat]" id="duree_contrat" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                               placeholder="Ex: 2 ans, 6 mois" value="{{ $attestationRequest->custom_data['duree_contrat'] ?? '' }}">
                                        <p class="text-xs text-gray-500 mt-1">Laissez vide pour calcul automatique basé sur les dates</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for="salaire_final" class="block text-sm font-medium text-gray-700 mb-2">
                                            Salaire final (€)
                                        </label>
                                        <input type="number" name="custom_data[salaire_final]" id="salaire_final" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                               step="0.01" placeholder="Salaire final de l'utilisateur" value="{{ $attestationRequest->custom_data['salaire_final'] ?? '' }}">
                                    </div>
                                    <div class="md:col-span-2 mb-4">
                                        <label for="fonctions_exercees" class="block text-sm font-medium text-gray-700 mb-2">
                                            Fonctions exercées
                                        </label>
                                        <textarea name="custom_data[fonctions_exercees]" id="fonctions_exercees" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" 
                                                  placeholder="Décrivez les principales fonctions exercées par l'utilisateur...">{{ $attestationRequest->custom_data['fonctions_exercees'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Champs pour solde de tout compte -->
                            <div id="solde-fields" class="conditional-group {{ $attestationRequest->attestationType->template_file === 'solde_tout_compte' ? '' : 'hidden' }}">
                                <h5 class="flex items-center text-lg font-medium text-gray-900 mb-4">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    Informations Financières - Solde de Tout Compte
                                </h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label for="salaire_base" class="block text-sm font-medium text-gray-700 mb-2">
                                            Salaire de base (€)
                                        </label>
                                        <input type="number" name="custom_data[salaire_base]" id="salaire_base" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" step="0.01"
                                               value="{{ $attestationRequest->custom_data['salaire_base'] ?? '' }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="primes" class="block text-sm font-medium text-gray-700 mb-2">
                                            Primes et indemnités (€)
                                        </label>
                                        <input type="number" name="custom_data[primes]" id="primes" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" step="0.01"
                                               value="{{ $attestationRequest->custom_data['primes'] ?? '' }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="conges_payes" class="block text-sm font-medium text-gray-700 mb-2">
                                            Congés payés (€)
                                        </label>
                                        <input type="number" name="custom_data[conges_payes]" id="conges_payes" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" step="0.01"
                                               value="{{ $attestationRequest->custom_data['conges_payes'] ?? '' }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="indemnite_rupture" class="block text-sm font-medium text-gray-700 mb-2">
                                            Indemnité de rupture (€)
                                        </label>
                                        <input type="number" name="custom_data[indemnite_rupture]" id="indemnite_rupture" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" step="0.01"
                                               value="{{ $attestationRequest->custom_data['indemnite_rupture'] ?? '' }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="periode_preavis" class="block text-sm font-medium text-gray-700 mb-2">
                                            Période de préavis
                                        </label>
                                        <input type="text" name="custom_data[periode_preavis]" id="periode_preavis" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                               placeholder="Ex: 1 mois" value="{{ $attestationRequest->custom_data['periode_preavis'] ?? '' }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="total_brut" class="block text-sm font-medium text-gray-700 mb-2">
                                            Total brut (€)
                                        </label>
                                        <input type="number" name="custom_data[total_brut]" id="total_brut" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50" step="0.01" readonly
                                               value="{{ $attestationRequest->custom_data['total_brut'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                Notes (optionnel)
                            </label>
                            <textarea name="notes" id="notes" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" 
                                      placeholder="Notes internes ou commentaires...">{{ $attestationRequest->notes }}</textarea>
                        </div>

                        <!-- Avertissement -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        <strong>Attention:</strong> La modification de cette attestation supprimera l'ancien fichier PDF et en générera un nouveau.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('admin.hr-attestations.show', $attestationRequest) }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Voir
                                </a>
                                <a href="{{ route('admin.hr-attestations.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                    Liste
                                </a>
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl" id="submitBtn">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Mettre à jour l'Attestation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.required::after {
    content: ' *';
    color: #ef4444;
}

.conditional-group {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    background-color: #f9fafb;
}

#submitBtn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialiser Select2 pour la recherche d'employés
    $('#employee_id').select2({
        placeholder: 'Rechercher un employé...',
        allowClear: true,
        ajax: {
            url: '{{ route("admin.hr-attestations.search-users") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    // Gérer la sélection d'un employé
    $('#employee_id').on('select2:select', function (e) {
        const employeeId = e.params.data.id;
        if (employeeId) {
            loadEmployeeDetails(employeeId);
        }
    });

    // Gérer le changement de type d'attestation
    $('#attestation_type_id').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const template = selectedOption.data('template');
        
        // Masquer tous les champs conditionnels
        $('.conditional-group').addClass('hidden');
        
        // Afficher les champs appropriés selon le template
        if (template === 'certificat_travail') {
            $('#certificat-fields').removeClass('hidden');
        } else if (template === 'solde_tout_compte') {
            $('#solde-fields').removeClass('hidden');
        }
    });

    // Calculer automatiquement le total brut pour le solde de tout compte
    $('#salaire_base, #primes, #conges_payes, #indemnite_rupture').on('input', function() {
        calculateTotal();
    });

    // Calculer le total initial si les champs sont pré-remplis
    calculateTotal();

    function loadEmployeeDetails(employeeId) {
        $.ajax({
            url: `/admin/hr-attestations/user/${employeeId}/details`,
            method: 'GET',
            success: function(data) {
                $('#user-name').text(data.first_name + ' ' + data.last_name);
                $('#user-position').text(data.position || 'Non défini');
                $('#user-department').text(data.department || 'Non défini');
                $('#user-info').removeClass('hidden');
            },
            error: function() {
                alert('Erreur lors du chargement des détails de l\'utilisateur');
            }
        });
    }

    function calculateTotal() {
        const salaireBase = parseFloat($('#salaire_base').val()) || 0;
        const primes = parseFloat($('#primes').val()) || 0;
        const congesPayes = parseFloat($('#conges_payes').val()) || 0;
        const indemniteRupture = parseFloat($('#indemnite_rupture').val()) || 0;
        
        const total = salaireBase + primes + congesPayes + indemniteRupture;
        $('#total_brut').val(total.toFixed(2));
    }

    // Validation du formulaire
    $('#attestationForm').on('submit', function(e) {
        const userId = $('#user_id').val();
        const attestationTypeId = $('#attestation_type_id').val();
        
        if (!userId || !attestationTypeId) {
            e.preventDefault();
            alert('Veuillez sélectionner un utilisateur et un type d\'attestation.');
            return false;
        }
        
        // Désactiver le bouton de soumission pour éviter les doubles clics
        $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Mise à jour en cours...');
    });
});
</script>
</x-app-layout>