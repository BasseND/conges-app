@section('title', 'Détails de l\'Attestation')

<x-app-layout>


    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border-0">
            <!-- En-tête modernisé -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-900 px-6 py-4">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                                Détails de l'Attestation #{{ $attestationRequest->document_number }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">
                                Consultation des informations détaillées
                            </p>
                            
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">

                        @if($attestationRequest->pdf_path && Storage::exists($attestationRequest->pdf_path))
                            <a href="{{ route('admin.hr-attestations.download-pdf', $attestationRequest) }}" 
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-cyan-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                 <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                 </svg>
                                 Télécharger PDF
                             </a>
                         @endif
                        <a href="{{ route('admin.hr-attestations.edit', $attestationRequest) }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </a>
                        
                    </div>
                </div>
            </div>


            {{-- Contentu --}}

            <div class="p-6">
                @if(session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-6 py-4 rounded-xl mb-6 relative shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button type="button" class="absolute top-4 right-4 text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200 transition-colors" onclick="this.parentElement.style.display='none'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-6 py-4 rounded-xl mb-6 relative shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                        <button type="button" class="absolute top-4 right-4 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors" onclick="this.parentElement.style.display='none'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Informations générales -->
                    <div>
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm mb-6 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Informations Générales
                                </h5>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Numéro de document:</span>
                                        <span class="text-gray-900 dark:text-white font-semibold">{{ $attestationRequest->document_number }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Type d'attestation:</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 text-blue-800 dark:text-blue-200">{{ $attestationRequest->attestationType->name }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Statut:</span>
                                        <span>
                                            @php
                                                $statusColors = [
                                                    'generated' => 'bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-800 dark:text-green-200',
                                                    'pending' => 'bg-gradient-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 text-yellow-800 dark:text-yellow-200',
                                                    'archived' => 'bg-gradient-to-r from-gray-100 to-slate-100 dark:from-gray-900/30 dark:to-slate-900/30 text-gray-800 dark:text-gray-200',
                                                    'cancelled' => 'bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 text-red-800 dark:text-red-200'
                                                ];
                                                $statuses = \App\Models\AttestationRequest::getStatuses();
                                                $color = $statusColors[$attestationRequest->status] ?? 'bg-gradient-to-r from-gray-100 to-slate-100 dark:from-gray-900/30 dark:to-slate-900/30 text-gray-800 dark:text-gray-200';
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                                                {{ $statuses[$attestationRequest->status] ?? $attestationRequest->status }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Date de génération:</span>
                                        <span class="text-gray-900 dark:text-white">{{ $attestationRequest->generated_at ? $attestationRequest->generated_at->format('d/m/Y H:i') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-start py-3 border-b border-gray-100 dark:border-gray-700">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Généré par:</span>
                                        <div class="text-right">
                                            <div class="text-gray-900 dark:text-white font-medium">{{ $attestationRequest->generator->first_name }} {{ $attestationRequest->generator->last_name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $attestationRequest->generator->email }}</div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Créé le:</span>
                                        <span class="text-gray-900 dark:text-white">{{ $attestationRequest->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @if($attestationRequest->updated_at != $attestationRequest->created_at)
                                        <div class="flex justify-between items-center py-3">
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Dernière modification:</span>
                                            <span class="text-gray-900 dark:text-white">{{ $attestationRequest->updated_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations de l'employé -->
                    <div>
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm mb-6 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Informations de l'Utilisateur
                                </h5>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Nom complet:</span>
                                        <span class="text-gray-900 dark:text-white font-semibold">{{ $attestationRequest->user->first_name }} {{ $attestationRequest->user->last_name }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Email:</span>
                                        <span class="text-gray-900 dark:text-white">{{ $attestationRequest->user->email }}</span>
                                    </div>
                                    @if($attestationRequest->user->position)
                                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Poste:</span>
                                            <span class="text-gray-900 dark:text-white">{{ $attestationRequest->user->position }}</span>
                                        </div>
                                    @endif
                                    @if($attestationRequest->user->department)
                                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Département:</span>
                                            <span class="text-gray-900 dark:text-white">{{ $attestationRequest->user->department ? $attestationRequest->user->department->name : 'Non assigné' }}</span>
                                        </div>
                                    @endif
                                    @if($attestationRequest->user->hire_date)
                                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Date d'embauche:</span>
                                            <span class="text-gray-900 dark:text-white">{{ $attestationRequest->user->hire_date->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                    @if($attestationRequest->user->contract_type)
                                        <div class="flex justify-between items-center py-3">
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Type de contrat:</span>
                                            <span class="text-gray-900 dark:text-white">{{ $attestationRequest->user->contract_type }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Données spécifiques de l'attestation -->
                @if($attestationRequest->custom_data && count($attestationRequest->custom_data) > 0)
                    <div class="mb-6">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 rounded-t-lg">
                                <h5 class="text-lg font-medium text-gray-900">
                                    <i class="fas fa-database mr-2 text-blue-500"></i>
                                    Données Spécifiques de l'Attestation
                                </h5>
                            </div>
                            <div class="p-4">
                                @if($attestationRequest->attestationType->template_file === 'certificat_travail')
                                    <h6 class="text-blue-600 font-medium mb-4">Informations du Certificat de Travail</h6>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @if(isset($attestationRequest->custom_data['date_fin_contrat']))
                                            <div class="mb-3">
                                                <span class="font-medium text-gray-700">Date de fin de contrat:</span>
                                                <span class="ml-2 text-gray-900">{{ \Carbon\Carbon::parse($attestationRequest->custom_data['date_fin_contrat'])->format('d/m/Y') }}</span>
                                            </div>
                                        @endif
                                        @if(isset($attestationRequest->custom_data['motif_fin_contrat']))
                                            <div class="mb-3">
                                                <span class="font-medium text-gray-700">Motif de fin de contrat:</span>
                                                <span class="ml-2 text-gray-900">{{ ucfirst(str_replace('_', ' ', $attestationRequest->custom_data['motif_fin_contrat'])) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    @if(isset($attestationRequest->custom_data['fonctions_exercees']))
                                        <div class="mb-3">
                                            <span class="font-medium text-gray-700">Fonctions exercées:</span>
                                            <div class="mt-2 p-3 bg-gray-50 rounded-md">
                                                {{ $attestationRequest->custom_data['fonctions_exercees'] }}
                                            </div>
                                        </div>
                                    @endif
                                @elseif($attestationRequest->attestationType->template_file === 'solde_tout_compte')
                                    <h6 class="text-blue-600 font-medium mb-4">Informations Financières - Solde de Tout Compte</h6>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @if(isset($attestationRequest->custom_data['salaire_base']))
                                            <div class="mb-3">
                                                <span class="font-medium text-gray-700">Salaire de base:</span>
                                                <span class="ml-2 text-gray-900">{{ number_format($attestationRequest->custom_data['salaire_base'], 2, ',', ' ') }} €</span>
                                            </div>
                                        @endif
                                        @if(isset($attestationRequest->custom_data['primes']))
                                            <div class="mb-3">
                                                <span class="font-medium text-gray-700">Primes et indemnités:</span>
                                                <span class="ml-2 text-gray-900">{{ number_format($attestationRequest->custom_data['primes'], 2, ',', ' ') }} €</span>
                                            </div>
                                        @endif
                                        @if(isset($attestationRequest->custom_data['conges_payes']))
                                            <div class="mb-3">
                                                <span class="font-medium text-gray-700">Congés payés:</span>
                                                <span class="ml-2 text-gray-900">{{ number_format($attestationRequest->custom_data['conges_payes'], 2, ',', ' ') }} €</span>
                                            </div>
                                        @endif
                                        @if(isset($attestationRequest->custom_data['indemnite_rupture']))
                                            <div class="mb-3">
                                                <span class="font-medium text-gray-700">Indemnité de rupture:</span>
                                                <span class="ml-2 text-gray-900">{{ number_format($attestationRequest->custom_data['indemnite_rupture'], 2, ',', ' ') }} €</span>
                                            </div>
                                        @endif
                                        @if(isset($attestationRequest->custom_data['periode_preavis']))
                                            <div class="mb-3">
                                                <span class="font-medium text-gray-700">Période de préavis:</span>
                                                <span class="ml-2 text-gray-900">{{ $attestationRequest->custom_data['periode_preavis'] }}</span>
                                            </div>
                                        @endif
                                        @if(isset($attestationRequest->custom_data['total_brut']))
                                            <div class="mb-3">
                                                <span class="font-medium text-gray-700">Total brut:</span>
                                                <span class="ml-2 font-bold text-green-600">{{ number_format($attestationRequest->custom_data['total_brut'], 2, ',', ' ') }} €</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($attestationRequest->custom_data as $key => $value)
                                            <div class="mb-3">
                                                <span class="font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                <span class="ml-2 text-gray-900">{{ $value }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Notes -->
                @if($attestationRequest->notes)
                    <div class="mb-6">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 rounded-t-lg">
                                <h5 class="text-lg font-medium text-gray-900">
                                    <i class="fas fa-sticky-note mr-2 text-blue-500"></i>
                                    Notes
                                </h5>
                            </div>
                            <div class="p-4">
                                <div class="p-3 bg-gray-50 rounded-md">
                                    {{ $attestationRequest->notes }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Informations sur le fichier PDF -->
                @if($attestationRequest->pdf_path)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 rounded-t-lg">
                            <h5 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-file-pdf mr-2 text-blue-500"></i>
                                Fichier PDF
                            </h5>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="mb-2">
                                        <span class="font-medium text-gray-700">Fichier:</span> 
                                        <span class="text-gray-900">{{ basename($attestationRequest->pdf_path) }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Statut:</span> 
                                        @if($attestationRequest->pdf_path && Storage::exists($attestationRequest->pdf_path))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Disponible</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Fichier manquant</span>
                                        @endif
                                    </div>
                                </div>
                                @if($attestationRequest->pdf_path && Storage::exists($attestationRequest->pdf_path))
                                    <a href="{{ route('admin.hr-attestations.download-pdf', $attestationRequest) }}" 
                                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-cyan-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Télécharger PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.hr-attestations.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour à la liste
                    </a>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.hr-attestations.edit', $attestationRequest) }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </a>
                        <button type="button" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl" onclick="confirmDelete()">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Supprimer
                        </button>
                    </div>
                </div>
                


            </div>

       
        </div>
        

       
    </div>

     

    

   

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="relative mx-auto p-0 w-full max-w-md">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- En-tête du modal -->
                <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-white">Confirmer la suppression</h3>
                        </div>
                        <button type="button" class="text-white hover:text-gray-200 transition-colors" onclick="closeDeleteModal()">
                            <span class="sr-only">Fermer</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Contenu du modal -->
                <div class="px-6 py-6">
                    <div class="mb-6">
                        <p class="text-gray-600 dark:text-gray-300 mb-3">
                            Êtes-vous sûr de vouloir supprimer cette attestation ?
                        </p>
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                            <p class="text-sm text-red-700 dark:text-red-300 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Cette action est irréversible et supprimera également le fichier PDF associé.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Boutons d'action -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <button type="button" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 font-medium" onclick="closeDeleteModal()">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Annuler
                        </button>
                        <form action="{{ route('admin.hr-attestations.destroy', $attestationRequest) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer définitivement
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <style>
    .info-row {
        padding: 0.5rem 0;
    }
    .info-label {
        font-weight: 600;
        color: #374151;
        width: 30%;
    }
    .info-value {
        color: #111827;
    }
    </style>



    <script>
    function confirmDelete() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    // Fermer la modal en cliquant en dehors
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
    </script>

</x-app-layout>
