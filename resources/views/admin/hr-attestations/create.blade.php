@section('title', 'Générer une Attestation')


<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Générer une Attestation
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Créez une nouvelle attestation pour un employé
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.hr-attestations.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-xl hover:from-gray-700 hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="">
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

                    <form action="{{ route('admin.hr-attestations.store') }}" method="POST" id="attestationForm">
                        @csrf
                        <input type="hidden" name="category" value="hr_generated">
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Sélection de l'utilisateur -->
                            <div class="space-y-2">
                                <label for="user_search_input" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Utilisateur <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="user-search-container">
                                    <select id="user_select" name="user_id" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                        <option value="">Sélectionner un utilisateur...</option>
                                    </select>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Tapez le nom, prénom ou email pour rechercher
                                </p>
                            </div>

                            <!-- Type d'attestation -->
                            <div class="space-y-2">
                                <label for="attestation_type_id" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Type d'Attestation <span class="text-red-500 ml-1">*</span>
                                </label>
                                <select name="attestation_type_id" id="attestation_type_id" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" required>
                                    <option value="">Sélectionner un type...</option>
                                    @foreach($attestationTypes as $type)
                                        <option value="{{ $type->id }}" 
                                                data-template="{{ $type->template_file }}"
                                                data-requires-date-range="{{ $type->requires_date_range ? 'true' : 'false' }}"
                                                data-requires-salary="{{ $type->requires_salary_info ? 'true' : 'false' }}"
                                                data-requires-end-date="{{ $type->requires_end_date ? 'true' : 'false' }}"
                                                data-requires-financial="{{ $type->requires_financial_info ? 'true' : 'false' }}">
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Informations de l'utilisateur sélectionné -->
                        <div id="user-info" class="mb-8 hidden">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-700 shadow-sm">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <h6 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            Informations de l'utilisateur
                                        </h6>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Nom complet</p>
                                                <p id="user-name" class="text-gray-900 dark:text-gray-100 font-semibold"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Poste</p>
                                                <p id="user-position" class="text-gray-900 dark:text-gray-100 font-semibold"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Département</p>
                                                <p id="user-department" class="text-gray-900 dark:text-gray-100 font-semibold"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Champs conditionnels -->
                        <div id="conditional-fields">
                            <!-- Champs pour certificat de travail -->
                            <div id="certificat-fields" class="conditional-group hidden">
                                <h5 class="flex items-center text-lg font-medium text-gray-900 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6m8 0H8"/>
                                    </svg>
                                    Informations pour le Certificat de Travail
                                </h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="mb-4">
                                        <label for="date_fin_contrat" class="block text-sm font-medium text-gray-700 mb-2">
                                            Date de fin de contrat
                                        </label>
                                        <input type="date" name="custom_data[date_fin_contrat]" id="date_fin_contrat" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="mb-4">
                                        <label for="motif_fin_contrat" class="block text-sm font-medium text-gray-700 mb-2">
                                            Motif de fin de contrat
                                        </label>
                                        <select name="custom_data[motif_fin_contrat]" id="motif_fin_contrat" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Sélectionner...</option>
                                            <option value="demission">Démission</option>
                                            <option value="licenciement">Licenciement</option>
                                            <option value="fin_cdd">Fin de CDD</option>
                                            <option value="rupture_conventionnelle">Rupture conventionnelle</option>
                                            <option value="retraite">Retraite</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="duree_contrat" class="block text-sm font-medium text-gray-700 mb-2">
                                            Durée du contrat
                                        </label>
                                        <input type="text" name="custom_data[duree_contrat]" id="duree_contrat" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Ex: 2 ans, 6 mois">
                                        <p class="text-xs text-gray-500 mt-1">Laissez vide pour calcul automatique basé sur les dates</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for="salaire_final" class="block text-sm font-medium text-gray-700 mb-2">
                                            Salaire final (€)
                                        </label>
                                        <input type="number" name="custom_data[salaire_final]" id="salaire_final" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" step="0.01" placeholder="Salaire final de l'utilisateur">
                                    </div>
                                    <div class="col-span-full mb-4">
                                        <label for="fonctions_exercees" class="block text-sm font-medium text-gray-700 mb-2">
                                            Fonctions exercées
                                        </label>
                                        <textarea name="custom_data[fonctions_exercees]" id="fonctions_exercees" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Décrivez les principales fonctions exercées par l'utilisateur..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Champs pour solde de tout compte -->
                            <div id="solde-fields" class="conditional-group hidden">
                                <h5 class="flex items-center text-lg font-medium text-gray-900 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    Informations Financières - Solde de Tout Compte
                                </h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="mb-4">
                                        <label for="salaire_base" class="block text-sm font-medium text-gray-700 mb-2">
                                            Salaire de base (€)
                                        </label>
                                        <input type="number" name="custom_data[salaire_base]" id="salaire_base" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" step="0.01">
                                    </div>
                                    <div class="mb-4">
                                        <label for="primes" class="block text-sm font-medium text-gray-700 mb-2">
                                            Primes et indemnités (€)
                                        </label>
                                        <input type="number" name="custom_data[primes]" id="primes" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" step="0.01">
                                    </div>
                                    <div class="mb-4">
                                        <label for="conges_payes" class="block text-sm font-medium text-gray-700 mb-2">
                                            Congés payés (€)
                                        </label>
                                        <input type="number" name="custom_data[conges_payes]" id="conges_payes" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" step="0.01">
                                    </div>
                                    <div class="mb-4">
                                        <label for="indemnite_rupture" class="block text-sm font-medium text-gray-700 mb-2">
                                            Indemnité de rupture (€)
                                        </label>
                                        <input type="number" name="custom_data[indemnite_rupture]" id="indemnite_rupture" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" step="0.01">
                                    </div>
                                    <div class="mb-4">
                                        <label for="periode_preavis" class="block text-sm font-medium text-gray-700 mb-2">
                                            Période de préavis
                                        </label>
                                        <input type="text" name="custom_data[periode_preavis]" id="periode_preavis" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Ex: 1 mois">
                                    </div>
                                    <div class="mb-4">
                                        <label for="total_brut" class="block text-sm font-medium text-gray-700 mb-2">
                                            Total brut (€)
                                        </label>
                                        <input type="number" name="custom_data[total_brut]" id="total_brut" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50" step="0.01" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <div class="w-full">
                                <label for="notes" class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                    Notes (optionnel)
                                </label>
                                <textarea name="notes" id="notes" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Notes internes ou commentaires..."></textarea>
                            </div>
                </div>
            </div>

            <!-- Champs conditionnels pour le type stage -->
            <div id="stage-fields" class="conditional-group hidden bg-gray-50 dark:bg-gray-800 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Informations du stage
                </h3>
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

            <!-- Champs conditionnels pour l'attestation de présence -->
            <div id="presence-fields" class="conditional-group hidden bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 border border-green-200 dark:border-green-700">
                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Période de Présence
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="presence_start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Date de début de période <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="presence_start_date" id="presence_start_date" 
                               class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                    </div>
                    <div>
                        <label for="presence_end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Date de fin de période <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="presence_end_date" id="presence_end_date" 
                               class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
                        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.hr-attestations.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Retour
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl" id="submitBtn">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Générer l'Attestation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Choices.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@11.1.0/public/assets/styles/choices.min.css">

<style>
.user-search-container {
    position: relative;
    width: 100%;
}

/* Personnalisation de Choices.js pour correspondre au design */
.choices {
    margin-bottom: 0;
}

.choices__inner {
    background-color: white;
    border: 1px solid #d1d5db;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    min-height: 3rem;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.choices__inner:focus-within {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.choices__list--dropdown {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.choices__item--choice {
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
    border-bottom: 1px solid #f3f4f6;
}

.choices__item--choice:last-child {
    border-bottom: none;
}

.choices__item--choice:hover {
    background-color: #f8fafc;
}

.choices__item--choice.is-highlighted {
    background-color: #3b82f6 !important;
    color: white !important;
    font-weight: 500;
    transform: translateX(2px);
}

.choices__item--choice.is-selected {
    background-color: #1e40af !important;
    color: white !important;
    font-weight: 600;
    position: relative;
}

.choices__item--choice.is-selected::after {
    content: '✓';
    position: absolute;
    right: 1rem;
    font-weight: bold;
}

.choices__placeholder {
    color: #9ca3af;
}

/* Mode sombre */
.dark .choices__inner {
    background-color: #374151;
    border-color: #4b5563;
    color: #f9fafb;
}

.dark .choices__list--dropdown {
    background-color: #374151;
    border-color: #4b5563;
}

.dark .choices__item--choice {
    color: #f9fafb;
    border-bottom-color: #4b5563;
}

.dark .choices__item--choice:hover {
    background-color: #4b5563;
}

.dark .choices__item--choice.is-highlighted {
    background-color: #3b82f6 !important;
    color: white !important;
}

.dark .choices__item--choice.is-selected {
    background-color: #1e40af !important;
    color: white !important;
}

.dark .choices__placeholder {
    color: #6b7280;
}
</style>

<!-- Choices.js JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/choices.js@11.1.0/public/assets/scripts/choices.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    let userChoices;
    let selectedUserId = null;
    
    // Éléments DOM
    const userSelect = document.getElementById('user_select');
    const attestationTypeSelect = document.getElementById('attestation_type_id');
    const attestationForm = document.getElementById('attestationForm');
    
    // Initialiser Choices.js pour la recherche d'utilisateurs
    if (userSelect) {
        userChoices = new Choices(userSelect, {
            searchEnabled: true,
            searchPlaceholderValue: 'Rechercher un utilisateur...',
            noResultsText: 'Aucun utilisateur trouvé',
            noChoicesText: 'Aucun utilisateur disponible',
            itemSelectText: 'Cliquer pour sélectionner',
            loadingText: 'Chargement...',
            shouldSort: false,
            searchResultLimit: 10,
            searchFields: ['label'],
            fuseOptions: {
                threshold: 0.3,
                keys: ['label']
            }
        });
        
        // Charger les utilisateurs au focus (charger une liste initiale)
        userSelect.addEventListener('showDropdown', function() {
            const currentValue = userChoices.getValue();
            if ((!currentValue || currentValue.value === '') && userChoices._store.choices.length === 0) {
                loadUsers('a'); // Charger avec une lettre pour avoir des résultats initiaux
            }
        });
        
        // Recherche en temps réel
        userSelect.addEventListener('search', function(event) {
            const query = event.detail.value;
            if (query && query.length >= 2) {
                loadUsers(query);
            }
        });
        
        // Sélection d'un utilisateur
        userSelect.addEventListener('choice', function(event) {
            const userId = event.detail.choice && event.detail.choice.value ? event.detail.choice.value : '';
            if (userId) {
                selectedUserId = userId;
                loadUserDetails(userId);
            }
        });
    }
    
    // Gérer le changement de type d'attestation
    if (attestationTypeSelect) {
        attestationTypeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const template = selectedOption.dataset.template;
            
            // Masquer tous les champs conditionnels
            document.querySelectorAll('.conditional-group').forEach(group => {
                group.classList.add('hidden');
            });
            
            // Afficher les champs appropriés selon le template
            if (template === 'certificat_travail') {
                const certificatFields = document.getElementById('certificat-fields');
                if (certificatFields) certificatFields.classList.remove('hidden');
            } else if (template === 'solde_tout_compte') {
                const soldeFields = document.getElementById('solde-fields');
                if (soldeFields) soldeFields.classList.remove('hidden');
            } else if (template === 'attestation_stage') {
                const stageFields = document.getElementById('stage-fields');
                if (stageFields) stageFields.classList.remove('hidden');
            } else if (template === 'attestation_presence') {
                const presenceFields = document.getElementById('presence-fields');
                if (presenceFields) presenceFields.classList.remove('hidden');
            }
        });
    }
    
    // Calculer automatiquement le total brut
    const salaryInputs = ['salaire_base', 'primes', 'conges_payes', 'indemnite_rupture'];
    salaryInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', calculateTotal);
        }
    });
    
    // Validation du formulaire
    if (attestationForm) {
        attestationForm.addEventListener('submit', function(e) {
            const currentValue = userChoices ? userChoices.getValue() : null;
            const userId = currentValue && currentValue.value ? currentValue.value : '';
            const attestationTypeId = document.getElementById('attestation_type_id').value;
            
            if (!userId || !attestationTypeId) {
                e.preventDefault();
                alert('Veuillez sélectionner un utilisateur et un type d\'attestation.');
                return false;
            }
            
            // Désactiver le bouton de soumission pour éviter les doubles soumissions
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="w-4 h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Génération en cours...';
            }
            
            // Permettre la soumission normale du formulaire
            return true;
        });
    }
    
    // Fonctions utilitaires
    function loadUsers(query) {
        // Ne pas faire de requête si la query est vide
        if (!query || query.length < 2) {
            return;
        }
        
        fetch(`/admin/hr-attestations/search/users?q=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Vérifier que data est un tableau
            if (!Array.isArray(data)) {
                console.error('La réponse n\'est pas un tableau:', data);
                return;
            }
            
            // Effacer les choix existants
            userChoices.clearChoices();
            
            // Ajouter les nouveaux choix
            const choices = data.map(user => ({
                value: user.id,
                label: `${user.text}`,
                customProperties: {
                    position: user.position || 'Non défini'
                }
            }));
            
            userChoices.setChoices(choices, 'value', 'label', true);
        })
        .catch(error => {
            console.error('Erreur lors de la recherche:', error);
        });
    }
    
    function loadUserDetails(userId) {
        fetch(`/admin/hr-attestations/user/${userId}/details`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const userName = document.getElementById('user-name');
            const userPosition = document.getElementById('user-position');
            const userDepartment = document.getElementById('user-department');
            const userInfo = document.getElementById('user-info');
            
            if (userName) userName.textContent = data.first_name + ' ' + data.last_name;
            if (userPosition) userPosition.textContent = data.position || 'Non défini';
            if (userDepartment) userDepartment.textContent = data.department || 'Non défini';
            if (userInfo) userInfo.classList.remove('hidden');
            
            // Pré-remplir certains champs si disponibles
            if (data.salary) {
                const salaireBase = document.getElementById('salaire_base');
                if (salaireBase) {
                    salaireBase.value = data.salary;
                    calculateTotal();
                }
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des détails:', error);
            alert('Erreur lors du chargement des détails de l\'utilisateur');
        });
    }
    
    function calculateTotal() {
        const salaireBase = parseFloat(document.getElementById('salaire_base')?.value) || 0;
        const primes = parseFloat(document.getElementById('primes')?.value) || 0;
        const congesPayes = parseFloat(document.getElementById('conges_payes')?.value) || 0;
        const indemniteRupture = parseFloat(document.getElementById('indemnite_rupture')?.value) || 0;
        
        const total = salaireBase + primes + congesPayes + indemniteRupture;
        const totalBrut = document.getElementById('total_brut');
        if (totalBrut) {
            totalBrut.value = total.toFixed(2);
        }
    }
    
    // Validation du formulaire avant soumission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const userSelect = document.getElementById('user_select');
            const attestationTypeSelect = document.getElementById('attestation_type_id');
            
            // Vérifier qu'un utilisateur est sélectionné
            if (!userSelect.value || userSelect.value === '') {
                e.preventDefault();
                alert('Veuillez sélectionner un utilisateur.');
                userSelect.focus();
                return false;
            }
            
            // Vérifier qu'un type d'attestation est sélectionné
            if (!attestationTypeSelect.value || attestationTypeSelect.value === '') {
                e.preventDefault();
                alert('Veuillez sélectionner un type d\'attestation.');
                attestationTypeSelect.focus();
                return false;
            }
        });
    }
});
</script>
</x-app-layout>