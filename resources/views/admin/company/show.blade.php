@section('title', 'Informations de la structure')
<x-app-layout>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </span>
        </div>
    @endif

    <div class="flex flex-col">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
                        <h2 class="text-gray-900 dark:text-white text-lg sm:text-xl lg:text-2xl font-bold truncate">
                            {{ __('Informations de la société') }}
                        </h2>
                    @if($company)
                            <a href="{{ route('admin.company.edit') }}" class="inline-flex items-center justify-center px-4 lg:px-6 py-2 lg:py-3 bg-green-600 hover:bg-green-700 border border-transparent rounded-xl font-semibold text-white text-sm transition-colors duration-200 shadow-sm">
                                <i class="bx bx-edit-alt mr-1 lg:mr-2"></i> 
                                <span class="hidden sm:inline">Modifier</span>
                                <span class="sm:hidden">Éditer</span>
                            </a>
                        @else
                            <a href="{{ route('admin.company.create') }}" class="inline-flex items-center justify-center px-4 lg:px-6 py-2 lg:py-3 bg-green-600 hover:bg-green-700 border border-transparent rounded-xl font-semibold text-white text-sm transition-colors duration-200 shadow-sm">
                                <i class="bx bx-plus mr-1 lg:mr-2"></i> 
                                <span class="hidden sm:inline">Créer</span>
                                <span class="sm:hidden">Nouveau</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                
                    @if($company)
                        {{-- Company Information --}}
                        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                                <!-- Logo Section -->
                                <div class="lg:col-span-1">
                                    <div class="text-center relative">
                                        @if($company->logo)
                                            <div class="relative inline-block group">
                                                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-300"></div>
                                                <img src="{{ Storage::url($company->logo) }}" alt="Logo de la société" class="relative w-24 h-24 sm:w-32 sm:h-32 object-contain rounded-xl mx-auto shadow-lg bg-white p-2">
                                            </div>
                                        @else
                                            <div class="relative group">
                                                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-300"></div>
                                                <div class="relative w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-blue-100 via-indigo-50 to-purple-100 dark:from-gray-700 dark:via-gray-600 dark:to-gray-500 rounded-xl flex items-center justify-center mx-auto shadow-lg">
                                                    <svg class="w-10 h-10 sm:w-14 sm:h-14 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="mt-4 lg:mt-6">
                                            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent truncate">{{ $company->name }}</h3>
                                            <div class="mt-2 inline-flex items-center px-2 lg:px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Société active
                                            </div>
                                        </div>

                                        
                                    </div>
                                </div>

                                <!-- Information Section -->
                                    <div class="lg:col-span-2">
                                        <div class="space-y-6 lg:space-y-8">
                                            <!-- Contact Information -->
                                            <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl lg:rounded-2xl p-4 lg:p-6 backdrop-blur-sm border border-gray-100 dark:border-gray-700">
                                                <div class="flex items-center mb-3 lg:mb-4">
                                                    <div class="w-6 h-6 lg:w-8 lg:h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-2 lg:mr-3">
                                                        <svg class="w-3 h-3 lg:w-4 lg:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                        </svg>
                                                    </div>
                                                    <h4 class="text-base lg:text-lg font-semibold text-gray-900 dark:text-white">Informations de contact</h4>
                                                </div>
                                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 lg:gap-6">
                                                @if($company->contact_email)
                                                    <div class="group hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl p-3 transition-all duration-200">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $company->contact_email }}</p>
                                                                <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">Email professionnel</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                
                                                @if($company->contact_phone)
                                                    <div class="group hover:bg-green-50 dark:hover:bg-green-900/20 rounded-xl p-3 transition-all duration-200">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $company->contact_phone }}</p>
                                                                <p class="text-xs text-green-600 dark:text-green-400 font-medium">Téléphone principal</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                
                                                @if($company->website_url)
                                                    <div class="group hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-xl p-3 transition-all duration-200">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <a href="{{ $company->website_url }}" target="_blank" class="text-sm font-semibold text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 hover:underline transition-colors duration-200">{{ $company->website_url }}</a>
                                                                <p class="text-xs text-purple-600 dark:text-purple-400 font-medium">Site web officiel</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                @if($company->registration_number)
                                                    <div class="group hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-xl p-3 transition-all duration-200">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $company->registration_number }}</p>
                                                                <p class="text-xs text-yellow-600 dark:text-yellow-400 font-medium">Numéro d'enregistrement</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                @if($company->director_name)
                                                    <div class="group hover:bg-orange-50 dark:hover:bg-orange-900/20 rounded-xl p-3 transition-all duration-200">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $company->director_name }}</p>
                                                                <p class="text-xs text-orange-600 dark:text-orange-400 font-medium">Directeur général</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                @if($company->hr_director_name)
                                                    <div class="group hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-xl p-3 transition-all duration-200">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $company->hr_director_name }}</p>
                                                                <p class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">Directeur des ressources humaines</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                @if($company->hr_signature)
                                                    <div class="group hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl p-3 transition-all duration-200">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="flex-1">
                                                                <p class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Signature du DRH</p>
                                                                <img src="{{ Storage::url($company->hr_signature) }}" alt="Signature du DRH" class="max-w-32 h-auto border border-gray-200 dark:border-gray-600 rounded-lg bg-white p-2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                <!-- Address Information -->
                                                @if($company->address || $company->city || $company->country)
                                                    <div class="group hover:bg-teal-50 dark:hover:bg-teal-900/20 rounded-xl p-4 transition-all duration-200">
                                                        <div class="flex items-start space-x-4">
                                                            <div class="flex-shrink-0 mt-1">
                                                                <div class="w-10 h-10 bg-teal-100 dark:bg-teal-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                                    <svg class="w-5 h-5 text-teal-800 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="flex-1">
                                                                @if($company->address)
                                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ $company->address }}</p>
                                                                @endif
                                                                <div class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                                                    @if($company->city || $company->postal_code)
                                                                        <p class="flex items-center">
                                                                            @if($company->city){{ $company->city }}@endif
                                                                            @if($company->postal_code && $company->city), {{ $company->postal_code }} , @endif
                                                                            @if($company->country)  {{ $company->country }} @endif
                                                                        </p>
                                                                    @endif
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Types de contrats --}}
                        <div class="mt-8">
                            <!-- En-tête moderne -->
                            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 rounded-t-2xl">
                                <div class="px-6 py-4">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-3 rounded-xl shadow-lg mr-2">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                                    {{ __('Types de Contrats') }}
                                                </h2>
                                                <p class="text-gray-600 dark:text-gray-400 mt-1">Gérez les types de contrats personnalisés</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button type="button" 
                                                    onclick="openContractTypesModal()"
                                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 border border-transparent rounded-lg font-medium text-sm text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Gérer les Types
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Carte principale -->
                            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-b-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-xl">
                                <div class="p-8">
                                    @if(isset($contractTypes) && $contractTypes->count() > 0)
                                        <!-- Liste des types de contrats -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach($contractTypes as $contractType)
                                                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-700 hover:shadow-lg transition-all duration-200">
                                                    <div class="flex items-start justify-between">
                                                        <div class="flex-1">
                                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                                                {{ $contractType->name }}
                                                            </h3>
                                                            @if($contractType->system_name)
                                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2 font-mono">
                                                                    Nom système: {{ $contractType->system_name }}
                                                                </p>
                                                            @endif
                                                            @if($contractType->description)
                                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                                    {{ $contractType->description }}
                                                                </p>
                                                            @endif
                                                            <div class="flex items-center justify-between">
                                                                <div>
                                                                    @if($contractType->is_active)
                                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                            </svg>
                                                                            Actif
                                                                        </span>
                                                                    @else
                                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                                            </svg>
                                                                            Inactif
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <button onclick="editContractType({{ $contractType->id }}, '{{ addslashes($contractType->name) }}', '{{ addslashes($contractType->system_name ?? '') }}', '{{ addslashes($contractType->description ?? '') }}', {{ $contractType->is_active ? 'true' : 'false' }})" 
                                                                        class="ml-2 inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-blue-600 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-colors duration-200">
                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                    </svg>
                                                                    Modifier
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <!-- État vide -->
                                        <div class="text-center py-12">
                                            <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500 mb-4">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                                Aucun type de contrat
                                            </h3>
                                            <p class="text-gray-500 dark:text-gray-400 mb-6">
                                                Commencez par créer vos premiers types de contrats personnalisés.
                                            </p>
                                            <button type="button" 
                                                    onclick="openContractTypesModal()"
                                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 border border-transparent rounded-lg font-medium text-sm text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Créer des Types de Contrats
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Types de congés --}}
                        <div class="mt-8">
                            <!-- En-tête moderne -->
                            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 rounded-t-2xl">
                                <div class="px-6 py-4">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-3 rounded-xl shadow-lg mr-2">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                                    {{ __('Types de Congés') }}
                                                </h2>
                                                <p class="text-gray-600 dark:text-gray-400 mt-1">Gérez les types de congés paramétrables</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.special-leave-types.create') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 border border-transparent rounded-lg font-medium text-sm text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Nouveau Type
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Carte principale -->
                            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-b-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-xl">
                                <div class="p-8">
                                    @if(isset($specialLeaveTypes) && $specialLeaveTypes->count() > 0)
                                        <!-- Tableau des types de congés -->
                                        <div class="overflow-hidden">
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                    <thead class="bg-gray-50/80 dark:bg-gray-700/50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                                Nom du Type
                                                            </th>
                                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                                Durée
                                                            </th>
                                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                                Ancienneté
                                                            </th>
                                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                                Description
                                                            </th>
                                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                                Statut
                                                            </th>
                                                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                                Actions
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                        @foreach($specialLeaveTypes as $type)
                                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <div class="flex items-center">
                                                                        <div class="flex-shrink-0 h-10 w-10">
                                                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center">
                                                                                <span class="text-white font-semibold text-sm">{{ substr($type->name, 0, 2) }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="ml-4">
                                                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                                                {{ $type->name }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <div class="flex items-center">
                                                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                        </svg>
                                                                        <span class="text-sm text-gray-900 dark:text-white font-medium">
                                                                            {{ $type->formatted_duration }}
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <div class="flex items-center">
                                                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                        </svg>
                                                                        @if($type->seniority_months == 0)
                                                                            <span class="text-sm text-green-600 dark:text-green-400 font-medium">
                                                                                Aucune
                                                                            </span>
                                                                        @else
                                                                            <span class="text-sm text-gray-900 dark:text-white font-medium">
                                                                                {{ $type->formatted_seniority }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td class="px-6 py-4">
                                                                    <div class="text-sm text-gray-900 dark:text-white max-w-xs truncate" title="{{ $type->description }}">
                                                                        {{ $type->description ?: 'Aucune description' }}
                                                                    </div>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    @if($type->is_active)
                                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                            </svg>
                                                                            Actif
                                                                        </span>
                                                                    @else
                                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                                            </svg>
                                                                            Inactif
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                    <div class="flex items-center justify-end space-x-2">
                                                                        <!-- Bouton Voir -->
                                                                        <a href="{{ route('admin.special-leave-types.show', $type) }}" 
                                                                           title="Voir les détails"
                                                                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-200 dark:hover:bg-indigo-800/50 transition-all duration-200 hover:scale-110">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                            </svg>
                                                                        </a>

                                                                        <!-- Bouton Modifier -->
                                                                        @if($type->type !== 'système')
                                                                            <a href="{{ route('admin.special-leave-types.edit', $type) }}" 
                                                                               title="Modifier"
                                                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-800/50 transition-all duration-200 hover:scale-110">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                                </svg>
                                                                            </a>
                                                                        @else
                                                                            <button type="button" 
                                                                                    title="Type de congé système - Non modifiable"
                                                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 cursor-not-allowed">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                                </svg>
                                                                            </button>
                                                                        @endif

                                                                        <!-- Bouton Supprimer -->
                                                                        @php
                                                                            $canDelete = $type->type !== 'système';
                                                                        @endphp
                                                                        
                                                                        @if($canDelete)
                                                                            <button type="button" 
                                                                                    title="Supprimer"
                                                                                    onclick="openDeleteModal('{{ route('admin.special-leave-types.destroy', $type) }}', 'Êtes-vous sûr de vouloir supprimer ce type de congé ? Cette action ne peut pas être annulée.')"
                                                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/50 transition-all duration-200 hover:scale-110">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                                </svg>
                                                                            </button>
                                                                        @else
                                                                            <button type="button" 
                                                                                    title="Type de congé système - Non supprimable"
                                                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 cursor-not-allowed">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                                </svg>
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <!-- État vide -->
                                        <div class="text-center py-12">
                                            <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500 mb-4">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                                Aucun type de congé spécial
                                            </h3>
                                            <p class="text-gray-500 dark:text-gray-400 mb-6">
                                                Commencez par créer votre premier type de congé spécial.
                                            </p>
                                            <a href="{{ route('admin.special-leave-types.create') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 border border-transparent rounded-lg font-medium text-sm text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Créer un Type de Congé
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="text-center py-12">
                            <i class="bx bx-building text-gray-400 text-6xl"></i>
                            <h5 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Aucune information de société configurée</h5>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Cliquez sur le bouton "Créer" pour ajouter les informations de votre société.</p>
                            <a href="{{ route('admin.company.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                <i class="bx bx-plus mr-1"></i> Créer les informations de la société
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        // JavaScript pour LeaveBalance supprimé - remplacé par SpecialLeaveType

        // Fonction globale pour les notifications
        window.showNotification = function(message, type = 'info') {
            // Créer la notification
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg max-w-sm ${
                type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
                'bg-blue-100 border border-blue-400 text-blue-700'
            }`;
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm font-medium">${message.replace(/\n/g, '<br>')}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Supprimer automatiquement après 5 secondes
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        };
        
        // Alias local pour compatibilité
        function showNotification(message, type = 'info') {
            window.showNotification(message, type);
        }
        
        // Fonction pour ouvrir le modal de suppression
        function openDeleteModal(url, message) {
            // Mettre à jour le message du modal
            const modal = document.querySelector('[x-data="deleteDialog()"]');
            if (modal) {
                const messageElement = modal.querySelector('p');
                if (messageElement) {
                    messageElement.textContent = message;
                }
                // Déclencher l'événement pour ouvrir le modal
                window.dispatchEvent(new CustomEvent('delete-dialog', {
                    detail: url
                }));
            }
        }
        
        // Variables globales pour la gestion des types de contrats
        let contractTypeIndex = 1;
        
        // Fonction pour ouvrir le modal des types de contrats
        function openContractTypesModal() {
            document.getElementById('contractTypesModal').classList.remove('hidden');
            // Reset du formulaire
            resetContractTypesForm();
        }
        
        // Fonction pour fermer le modal des types de contrats
        function closeContractTypesModal() {
            document.getElementById('contractTypesModal').classList.add('hidden');
        }
        
        // Fonction pour réinitialiser le formulaire
        function resetContractTypesForm() {
            const container = document.getElementById('contractTypesContainer');
            // Garder seulement le premier élément
            const firstItem = container.querySelector('.contract-type-item');
            container.innerHTML = '';
            container.appendChild(firstItem.cloneNode(true));
            
            // Réinitialiser les valeurs
            const newItem = container.querySelector('.contract-type-item');
            newItem.querySelector('input[type="text"]').value = '';
            newItem.querySelector('textarea').value = '';
            newItem.querySelector('input[type="checkbox"]').checked = true;
            newItem.querySelector('.remove-btn').classList.add('hidden');
            
            contractTypeIndex = 1;
            updateContractTypeIndexes();
        }
        
        // Fonction pour ajouter un nouveau type de contrat
        function addContractType() {
            const container = document.getElementById('contractTypesContainer');
            const template = container.querySelector('.contract-type-item');
            const newItem = template.cloneNode(true);
            
            // Mettre à jour le titre
            newItem.querySelector('h4').textContent = `Type de contrat #${contractTypeIndex + 1}`;
            
            // Vider les champs
            newItem.querySelector('input[type="text"]').value = '';
            newItem.querySelector('textarea').value = '';
            newItem.querySelector('input[type="checkbox"]').checked = true;
            
            // Afficher le bouton de suppression
            newItem.querySelector('.remove-btn').classList.remove('hidden');
            
            container.appendChild(newItem);
            contractTypeIndex++;
            
            updateContractTypeIndexes();
            updateRemoveButtons();
        }
        
        // Fonction pour supprimer un type de contrat
        function removeContractType(button) {
            const item = button.closest('.contract-type-item');
            item.remove();
            updateContractTypeIndexes();
            updateRemoveButtons();
        }
        
        // Fonction pour mettre à jour les index des champs
        function updateContractTypeIndexes() {
            const items = document.querySelectorAll('.contract-type-item');
            items.forEach((item, index) => {
                // Mettre à jour le titre
                item.querySelector('h4').textContent = `Type de contrat #${index + 1}`;
                
                // Mettre à jour les noms des champs
                const nameInput = item.querySelector('input[type="text"]');
                const descriptionTextarea = item.querySelector('textarea');
                const activeCheckbox = item.querySelector('input[type="checkbox"]');
                
                nameInput.name = `contract_types[${index}][name]`;
                descriptionTextarea.name = `contract_types[${index}][description]`;
                activeCheckbox.name = `contract_types[${index}][is_active]`;
            });
        }
        
        // Fonction pour mettre à jour la visibilité des boutons de suppression
        function updateRemoveButtons() {
            const items = document.querySelectorAll('.contract-type-item');
            items.forEach((item, index) => {
                const removeBtn = item.querySelector('.remove-btn');
                if (items.length === 1) {
                    removeBtn.classList.add('hidden');
                } else {
                    removeBtn.classList.remove('hidden');
                }
            });
        }
        
        // Gestion de la soumission du formulaire
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contractTypesForm');
            if (form) {
                form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validation basique
            const nameInputs = document.querySelectorAll('input[name*="[name]"]');
            let hasError = false;
            
            nameInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('border-red-500');
                    hasError = true;
                } else {
                    input.classList.remove('border-red-500');
                }
            });
            
            if (hasError) {
                showNotification('Veuillez remplir tous les noms de types de contrats.', 'error');
                return;
            }
            
            // Soumission via AJAX
            const formData = new FormData(this);
            
            fetch('{{ route("admin.company.contract-types.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeContractTypesModal();
                    // Optionnel: recharger seulement la section des types de contrats
                    // sans recharger toute la page
                } else {
                    showNotification(data.message || 'Une erreur est survenue.', 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showNotification('Une erreur est survenue lors de l\'enregistrement.', 'error');
            });
                });
            }
        });
    </script>

    <!-- Modal de gestion des types de contrats -->
    <div id="contractTypesModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeContractTypesModal()"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form id="contractTypesForm" method="POST">
                    @csrf
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                    Gérer les Types de Contrats
                                </h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                        Ajoutez les types de contrats personnalisés pour votre entreprise. Vous pouvez ajouter plusieurs types en une seule fois.
                                    </p>
                                    
                                    <!-- Container pour les types de contrats -->
                                    <div id="contractTypesContainer" class="space-y-4">
                                        <!-- Premier type de contrat -->
                                        <div class="contract-type-item bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-start justify-between mb-3">
                                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Type de contrat #1</h4>
                                                <button type="button" onclick="removeContractType(this)" class="text-red-500 hover:text-red-700 hidden remove-btn">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="grid grid-cols-1 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du type *</label>
                                                    <input type="text" name="contract_types[0][name]" required 
                                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                                                           placeholder="Ex: CDI, CDD, Stage...">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                                    <textarea name="contract_types[0][description]" rows="2" 
                                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                                                              placeholder="Description optionnelle du type de contrat"></textarea>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="checkbox" name="contract_types[0][is_active]" value="1" checked 
                                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <label class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Type actif</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Bouton pour ajouter un nouveau type -->
                                    <div class="mt-4">
                                        <button type="button" onclick="addContractType()" 
                                                class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Ajouter un type
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Enregistrer
                        </button>
                        <button type="button" onclick="closeContractTypesModal()" 
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de suppression -->
    <x-modals.delete-dialog message="" />

    <!-- Modal d'édition d'un type de contrat -->
    <div id="editContractTypeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Modifier le type de contrat</h3>
                    <button onclick="closeEditContractTypeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form id="editContractTypeForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editContractTypeId" name="contract_type_id">
                    
                    <div class="mb-4">
                        <label for="editName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom du type</label>
                        <input type="text" id="editName" name="name" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    
                    <div class="mb-4">
                        <label for="editSystemName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom système</label>
                        <input type="text" id="editSystemName" name="system_name" readonly
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed"
                               placeholder="Généré automatiquement">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Le nom système ne peut pas être modifié après création</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="editDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea id="editDescription" name="description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="editIsActive" name="is_active" value="1"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="editIsActive" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Type actif</label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditContractTypeModal()"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Fonction pour ouvrir le modal d'édition
    function editContractType(id, name, systemName, description, isActive) {
        document.getElementById('editContractTypeId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editSystemName').value = systemName || '';
        document.getElementById('editDescription').value = description || '';
        document.getElementById('editIsActive').checked = isActive;
        
        document.getElementById('editContractTypeModal').classList.remove('hidden');
    }

    // Fonction pour fermer le modal d'édition
    function closeEditContractTypeModal() {
        document.getElementById('editContractTypeModal').classList.add('hidden');
    }

    // Gestion de la soumission du formulaire d'édition
    document.addEventListener('DOMContentLoaded', function() {
        const editForm = document.getElementById('editContractTypeForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const contractTypeId = document.getElementById('editContractTypeId').value;
                const formData = new FormData(this);
                
                // Convertir FormData en objet JSON
                 const data = {};
                 formData.forEach((value, key) => {
                     if (key !== '_token' && key !== '_method' && key !== 'contract_type_id' && key !== 'system_name') {
                         data[key] = value;
                     }
                 });
                
                // Gérer la checkbox is_active
                data.is_active = document.getElementById('editIsActive').checked;
                
                fetch(`/admin/company/contract-types/${contractTypeId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        closeEditContractTypeModal();
                        // Recharger la page pour afficher les modifications
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showNotification(data.message || 'Une erreur est survenue', 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Une erreur est survenue lors de la mise à jour', 'error');
                });
            });
        }
    });
    </script>
</x-app-layout>
