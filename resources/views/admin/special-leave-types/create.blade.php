<x-app-layout>
    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête modernisé -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-start sm:items-center space-x-3 sm:space-x-4 min-w-0">
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-2 sm:p-3 rounded-xl sm:rounded-2xl shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white truncate">
                                    <span class="hidden sm:inline">{{ __('Créer un Type de Congé Spécial') }}</span>
                                    <span class="sm:hidden">{{ __('Nouveau Type') }}</span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 truncate">
                                    {{ __('Ajoutez un nouveau type de congé paramétrable') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 sm:space-x-3 flex-shrink-0">
                            <a href="{{ route('admin.special-leave-types.index') }}" 
                               class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 hover:bg-blue-700 border border-transparent rounded-lg sm:rounded-xl font-medium sm:font-semibold text-sm sm:text-base text-white transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <span class="hidden sm:inline">Retour</span>
                                <span class="sm:hidden">Retour</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Messages d'erreur -->
                @if ($errors->any())
                    <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h3 class="text-red-800 dark:text-red-200 font-medium mb-2">Erreurs de validation :</h3>
                                <ul class="text-red-700 dark:text-red-300 text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Formulaire modernisé -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 dark:border-gray-700/50 p-8">
                    <form action="{{ route('admin.special-leave-types.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Nom du type de congé -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('Nom du type de congé') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}"
                                       placeholder="Ex: Césarienne, Mariage, Baptême..."
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                       required>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Nom descriptif du type de congé (ex: Césarienne, Mariage, etc.)') }}
                            </p>
                        </div>



                        <!-- Durée en jours -->
                        <div class="space-y-2">
                            <label for="duration_days" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('Nombre de jours') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <input type="number" 
                                       name="duration_days" 
                                       id="duration_days" 
                                       value="{{ old('duration_days', 25) }}"
                                       min="0" 
                                       max="365"
                                       placeholder="Nombre de jours"
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                       required>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Nombre de jours accordés pour ce type de congé (0 à 365 jours)') }}
                            </p>
                        </div>

                        <!-- Entreprise (si admin système) -->
                        @if(auth()->user()->hasRole('admin'))
                        <div class="space-y-2">
                            <label for="company_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('Entreprise') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <select name="company_id" 
                                        id="company_id" 
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                        required>
                                    <option value="">{{ __('Sélectionner une entreprise') }}</option>
                                    @foreach(\App\Models\Company::all() as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', auth()->user()->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Entreprise pour laquelle ce solde de congé sera défini') }}
                            </p>
                        </div>
                        @else
                        <input type="hidden" name="company_id" value="{{ auth()->user()->company_id }}">
                        @endif

                        <!-- Condition d'ancienneté -->
                        <div class="space-y-2">
                            <label for="seniority_months" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('Condition d\'ancienneté (en mois)') }}
                                <span class="text-gray-400 text-xs font-normal">(optionnel)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="number" 
                                       name="seniority_months" 
                                       id="seniority_months" 
                                       value="{{ old('seniority_months', 0) }}"
                                       min="0" 
                                       max="120"
                                       placeholder="Nombre de mois d'ancienneté requis"
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Nombre de mois d\'ancienneté minimum requis (0 = aucune condition, 12 = 1 an, etc.)') }}
                            </p>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('Description') }}
                                <span class="text-gray-400 text-xs font-normal">(optionnel)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                    </svg>
                                </div>
                                <textarea name="description" 
                                          id="description" 
                                          rows="4"
                                          placeholder="Description détaillée du type de congé..."
                                          class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200 resize-none">{{ old('description') }}</textarea>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Description optionnelle pour clarifier les conditions d\'utilisation') }}
                            </p>
                        </div>

                        <!-- Statut actif -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('Statut') }}
                            </label>
                            <div class="flex items-center space-x-3">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Type de congé actif') }}
                                    </span>
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Les types inactifs ne seront pas disponibles lors de la création de congés') }}
                            </p>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" 
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 border border-transparent rounded-xl font-semibold text-sm text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Créer le Type de Congé') }}
                            </button>
                            
                            <a href="{{ route('admin.special-leave-types.index') }}" 
                               class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-600 rounded-xl font-semibold text-sm text-gray-700 dark:text-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                {{ __('Annuler') }}
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Exemples de types de congés -->
                <div class="mt-8 bg-blue-50/80 dark:bg-blue-900/20 backdrop-blur-sm rounded-2xl border border-blue-200/50 dark:border-blue-700/50 p-6">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">
                                {{ __('Exemples de types de congés spéciaux') }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800 dark:text-blue-200">
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span>• Césarienne</span>
                                        <span class="font-medium">84 jours (12 semaines)</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>• Mariage</span>
                                        <span class="font-medium">4 jours</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>• Mariage enfant</span>
                                        <span class="font-medium">2 jours</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>• Mariage fratrie</span>
                                        <span class="font-medium">1 jour</span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span>• Baptême</span>
                                        <span class="font-medium">1 jour</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>• Concours/Examen d'état</span>
                                        <span class="font-medium">7 jours</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>• Permission</span>
                                        <span class="font-medium">0 à 10 jours</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>