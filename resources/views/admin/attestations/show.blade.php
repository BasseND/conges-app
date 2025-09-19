@section('title', 'Détails de la demande d\'attestation')
<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 pb-12">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl overflow-hidden shadow-xl sm:rounded-3xl border border-white/20 dark:border-gray-700/50">
            <!-- En-tête modernisé -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-900 px-6 py-4">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.attestations.index') }}" 
                           class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg hover:scale-105 transition-transform duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ __('Détails de l\'attestation') }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">
                                Demande #{{ $attestationRequest->id }} - {{ $attestationRequest->user->first_name }} {{ $attestationRequest->user->last_name }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @if($attestationRequest->status === 'pending')
                            <button onclick="approveRequest({{ $attestationRequest->id }})" 
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 border border-transparent rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Approuver') }}
                            </button>
                            <button onclick="rejectRequest({{ $attestationRequest->id }})" 
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-pink-600 border border-transparent rounded-xl hover:from-red-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ __('Rejeter') }}
                            </button>
                        @endif
                        @if($attestationRequest->status === 'approved' && !$attestationRequest->pdf_path)
                            <button onclick="generatePdf({{ $attestationRequest->id }})" 
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-xl hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('Générer PDF') }}
                            </button>
                        @endif
                        @if($attestationRequest->pdf_path)
                            <a href="{{ route('admin.attestations.download', $attestationRequest->id) }}" 
                               class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-cyan-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('Télécharger PDF') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-8">
                @if(session('success'))
                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border border-emerald-200 dark:border-emerald-700 text-emerald-800 dark:text-emerald-300 px-6 py-4 rounded-2xl relative mb-8 shadow-lg backdrop-blur-sm" role="alert">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold text-base">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-300 px-6 py-4 rounded-2xl relative mb-8 shadow-lg backdrop-blur-sm" role="alert">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold text-base">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Informations de l'employé -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Informations employé -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center mb-6">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Informations de l'employé</h2>
                                    <p class="text-gray-600 dark:text-gray-400 mt-1">Détails du demandeur</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-6 mb-8">
                                <div class="flex-shrink-0">
                                    <div class="h-20 w-20 rounded-3xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-xl border-4 border-white dark:border-gray-700">
                                        <span class="text-2xl font-bold text-white">
                                            {{ strtoupper(substr($attestationRequest->user->first_name, 0, 1) . substr($attestationRequest->user->last_name, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ $attestationRequest->user->first_name }} {{ $attestationRequest->user->last_name }}
                                    </h3>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400 mb-1">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                        </svg>
                                        <span class="font-medium">{{ $attestationRequest->user->email }}</span>
                                    </div>
                                    @if($attestationRequest->user->phone)
                                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            <span class="font-medium">{{ $attestationRequest->user->phone }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @if($attestationRequest->user->employee_id)
                                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 p-4 rounded-2xl border border-blue-200/50 dark:border-blue-700/50">
                                        <label class="block text-sm font-semibold text-blue-700 dark:text-blue-300 mb-2">ID Employé</label>
                                        <p class="text-lg font-bold text-blue-900 dark:text-blue-100">{{ $attestationRequest->user->employee_id }}</p>
                                    </div>
                                @endif
                                @if($attestationRequest->user->department)
                                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 p-4 rounded-2xl border border-purple-200/50 dark:border-purple-700/50">
                                        <label class="block text-sm font-semibold text-purple-700 dark:text-purple-300 mb-2">Département</label>
                                        <p class="text-lg font-bold text-purple-900 dark:text-purple-100">{{ $attestationRequest->user->department->name }}</p>
                                    </div>
                                @endif
                                @if($attestationRequest->user->position)
                                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 p-4 rounded-2xl border border-emerald-200/50 dark:border-emerald-700/50">
                                        <label class="block text-sm font-semibold text-emerald-700 dark:text-emerald-300 mb-2">Poste</label>
                                        <p class="text-lg font-bold text-emerald-900 dark:text-emerald-100">{{ $attestationRequest->user->position }}</p>
                                    </div>
                                @endif
                                @if($attestationRequest->user->hire_date)
                                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 p-4 rounded-2xl border border-orange-200/50 dark:border-orange-700/50">
                                        <label class="block text-sm font-semibold text-orange-700 dark:text-orange-300 mb-2">Date d'embauche</label>
                                        <p class="text-lg font-bold text-orange-900 dark:text-orange-100">{{ $attestationRequest->user->hire_date->format('d/m/Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Détails de la demande -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center mb-6">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Détails de la demande</h2>
                                    <p class="text-gray-600 dark:text-gray-400 mt-1">Informations sur l'attestation demandée</p>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 p-6 rounded-2xl border border-indigo-200/50 dark:border-indigo-700/50">
                                        <label class="block text-sm font-semibold text-indigo-700 dark:text-indigo-300 mb-3">Type d'attestation</label>
                                        <p class="text-xl font-bold text-indigo-900 dark:text-indigo-100 mb-2">{{ $attestationRequest->attestationType->name }}</p>
                                        <p class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">{{ $attestationRequest->attestationType->formatted_type }}</p>
                                    </div>
                                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 p-6 rounded-2xl border border-purple-200/50 dark:border-purple-700/50">
                                        <label class="block text-sm font-semibold text-purple-700 dark:text-purple-300 mb-3">Priorité</label>
                                        <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-bold {{ $attestationRequest->priority_class }} shadow-lg">
                                            {{ $attestationRequest->formatted_priority }}
                                        </span>
                                    </div>
                                </div>

                                @if($attestationRequest->start_date || $attestationRequest->end_date)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        @if($attestationRequest->start_date)
                                            <div class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 p-6 rounded-2xl border border-emerald-200/50 dark:border-emerald-700/50">
                                                <div class="flex items-center mb-3">
                                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <label class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">Date de début</label>
                                                </div>
                                                <p class="text-lg font-bold text-emerald-900 dark:text-emerald-100">{{ $attestationRequest->start_date->format('d/m/Y') }}</p>
                                            </div>
                                        @endif
                                        @if($attestationRequest->end_date)
                                            <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 p-6 rounded-2xl border border-red-200/50 dark:border-red-700/50">
                                                <div class="flex items-center mb-3">
                                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <label class="text-sm font-semibold text-red-700 dark:text-red-300">Date de fin</label>
                                                </div>
                                                <p class="text-lg font-bold text-red-900 dark:text-red-100">{{ $attestationRequest->end_date->format('d/m/Y') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if($attestationRequest->notes)
                                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 p-6 rounded-2xl border border-amber-200/50 dark:border-amber-700/50">
                                        <div class="flex items-center mb-4">
                                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <label class="text-sm font-semibold text-amber-700 dark:text-amber-300">Notes de l'employé</label>
                                        </div>
                                        <div class="bg-white/60 dark:bg-gray-800/60 p-4 rounded-xl border border-amber-200/30 dark:border-amber-700/30">
                                            <p class="text-gray-900 dark:text-white whitespace-pre-wrap leading-relaxed">{{ $attestationRequest->notes }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($attestationRequest->custom_data && count($attestationRequest->custom_data) > 0)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Informations complémentaires</label>
                                        <div class="space-y-2">
                                            @foreach($attestationRequest->custom_data as $key => $value)
                                                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-600">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                                    <span class="text-sm text-gray-900 dark:text-white">{{ $value }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Template de l'attestation -->
                        @if($templatePreview)
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center mb-6">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Aperçu du template</h2>
                                        <p class="text-gray-600 dark:text-gray-400 mt-1">Prévisualisation du document final</p>
                                    </div>
                                </div>
                                <div class="p-6 rounded-2xl border-l-4 border-blue-500 shadow-inner">
                                    <div class="text-gray-900 dark:text-white leading-relaxed prose prose-sm max-w-none">
                                        {!! $templatePreview !!}
                                    </div>
                                </div>
                                <div class="mt-6 p-4 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 rounded-2xl border border-emerald-200/50 dark:border-emerald-700/50">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">
                                            Aperçu avec les données de l'employé - Ceci est le contenu qui sera généré dans le PDF
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Statut et actions -->
                    <div class="space-y-8">
                        <!-- Statut actuel -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center mb-6">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-violet-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Statut</h3>
                                    <p class="text-gray-600 dark:text-gray-400 mt-1">État actuel de la demande</p>
                                </div>
                            </div>
                            
                            <div class="text-center mb-6">
                                <span class="inline-flex items-center px-6 py-3 rounded-2xl text-lg font-bold {{ $attestationRequest->status_class }}">
                                    {{ $attestationRequest->formatted_status }}
                                </span>
                            </div>

                            <div class="space-y-4">
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 p-4 rounded-2xl border border-blue-200/50 dark:border-blue-700/50">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <label class="text-sm font-semibold text-blue-700 dark:text-blue-300">Demandé le</label>
                                    </div>
                                    <p class="text-lg font-bold text-blue-900 dark:text-blue-100">{{ $attestationRequest->created_at->format('d/m/Y à H:i') }}</p>
                                </div>

                                @if($attestationRequest->processed_at)
                                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 p-4 rounded-2xl border border-emerald-200/50 dark:border-emerald-700/50">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <label class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">Traité le</label>
                                        </div>
                                        <p class="text-lg font-bold text-emerald-900 dark:text-emerald-100">{{ $attestationRequest->processed_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                @endif

                                @if($attestationRequest->processor)
                                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 p-4 rounded-2xl border border-purple-200/50 dark:border-purple-700/50">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <label class="text-sm font-semibold text-purple-700 dark:text-purple-300">Traité par</label>
                                        </div>
                                        <p class="text-lg font-bold text-purple-900 dark:text-purple-100">{{ $attestationRequest->processor->first_name }} {{ $attestationRequest->processor->last_name }}</p>
                                    </div>
                                @endif

                                @if($attestationRequest->generated_at)
                                    <div class="bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 p-4 rounded-2xl border border-cyan-200/50 dark:border-cyan-700/50">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <label class="text-sm font-semibold text-cyan-700 dark:text-cyan-300">PDF généré le</label>
                                        </div>
                                        <p class="text-lg font-bold text-cyan-900 dark:text-cyan-100">{{ $attestationRequest->generated_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Motif de rejet -->
                        @if($attestationRequest->rejection_reason)
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center mb-6">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Motif de rejet</h3>
                                        <p class="text-gray-600 dark:text-gray-400 mt-1">Raison du refus de la demande</p>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 p-6 rounded-2xl border border-red-200/50 dark:border-red-700/50">
                                    <p class="text-red-800 dark:text-red-300 whitespace-pre-wrap leading-relaxed font-medium">{{ $attestationRequest->rejection_reason }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Actions rapides -->
                        @if($attestationRequest->status === 'pending')
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center mb-6">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Actions</h3>
                                        <p class="text-gray-600 dark:text-gray-400 mt-1">Actions disponibles pour cette demande</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <button onclick="approveRequest({{ $attestationRequest->id }})" 
                                            class="w-full inline-flex justify-center items-center px-6 py-4 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white rounded-2xl transition-all duration-300 transform hover:scale-105 border border-gray-200 dark:border-gray-700 font-bold">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Approuver la demande
                                    </button>
                                    <button onclick="rejectRequest({{ $attestationRequest->id }})" 
                                            class="w-full inline-flex justify-center items-center px-6 py-4 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white rounded-2xl transition-all duration-300 transform hover:scale-105 border border-gray-200 dark:border-gray-700 font-bold">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Rejeter la demande
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if($attestationRequest->status === 'approved' && !$attestationRequest->pdf_path)
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center mb-6">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Génération PDF</h3>
                                        <p class="text-gray-600 dark:text-gray-400 mt-1">Créer le document final</p>
                                    </div>
                                </div>
                                <button onclick="generatePdf({{ $attestationRequest->id }})" 
                                        class="w-full inline-flex justify-center items-center px-6 py-4 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white rounded-2xl transition-all duration-300 transform hover:scale-105 border border-gray-200 dark:border-gray-700 font-bold">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Générer le PDF
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de rejet -->
    <div id="rejectModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="relative mx-auto p-8 border border-gray-200/50 dark:border-gray-700/50 w-full max-w-md shadow-2xl rounded-3xl bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 backdrop-blur-lg">
            <div class="">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-red-500 to-rose-600 p-3 rounded-2xl shadow-lg mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Motif de rejet</h3>
                </div>
                <form id="rejectForm">
                    <div class="mb-6">
                        <label for="rejection_reason" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">Raison du rejet *</label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300/50 dark:border-gray-600/50 rounded-2xl shadow-inner focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700/50 dark:text-white backdrop-blur-sm transition-all duration-300" 
                                  placeholder="Expliquez pourquoi cette demande est rejetée..." required></textarea>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeRejectModal()" 
                                class="px-6 py-3 bg-gradient-to-r from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700 text-gray-700 dark:text-gray-300 rounded-2xl hover:from-gray-400 hover:to-gray-500 dark:hover:from-gray-500 dark:hover:to-gray-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-2xl hover:from-red-600 hover:to-rose-700 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                            Rejeter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function approveRequest(requestId) {
            if (confirm('Êtes-vous sûr de vouloir approuver cette demande ?')) {
                fetch(`/admin/attestations/${requestId}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Une erreur est survenue');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
            }
        }

        function rejectRequest(requestId) {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejection_reason').value = '';
        }

        function generatePdf(requestId) {
            if (confirm('Générer le PDF pour cette attestation ?')) {
                fetch(`/admin/attestations/${requestId}/generate-pdf`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Une erreur est survenue');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
            }
        }

        document.getElementById('rejectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const reason = document.getElementById('rejection_reason').value;
            const requestId = {{ $attestationRequest->id }};
            
            fetch(`/admin/attestations/${requestId}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ rejection_reason: reason })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeRejectModal();
                    location.reload();
                } else {
                    alert(data.message || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            });
        });

        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>