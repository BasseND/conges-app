@section('title', 'Modifier la note de frais')
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec dégradé -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white">
                        {{ __('Modifier la note de frais #' . $report->id) }}
                    </h1>
                    <p class="mt-1 text-sm sm:text-base text-blue-100">
                        Modifiez votre note de frais en ajoutant ou modifiant vos dépenses
                    </p>
                </div>
            </div>
                
            <!-- Fil d'Ariane -->
            <nav class="mt-4 sm:mt-6 overflow-x-auto" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm whitespace-nowrap">
                    <li class="flex-shrink-0">
                        <a href="{{ route('welcome.index') }}" class="text-blue-100 hover:text-white transition-colors duration-200 flex items-center">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="hidden sm:inline">Accueil</span>
                            <span class="sm:hidden">Acc.</span>
                        </a>
                    </li>
                    <li class="text-blue-200 flex-shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li class="flex-shrink-0">
                        <a href="{{ route('expense-reports.index') }}" class="text-blue-100 hover:text-white transition-colors duration-200">
                            <span class="hidden sm:inline">Notes de frais</span>
                            <span class="sm:hidden">Notes</span>
                        </a>
                    </li>
                    <li class="text-blue-200 flex-shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li class="text-white font-medium truncate">
                        <span class="hidden sm:inline">Modifier #{{ $report->id }}</span>
                        <span class="sm:hidden">Mod. #{{ $report->id }}</span>
                    </li>
                </ol>
            </nav>
        
        </div>
        <!-- Messages d'erreur -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                            Erreurs de validation
                        </h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire principal -->
        <div class="md:bg-white dark:bg-gray-800 rounded-2xl overflow-hidden">
            <form action="{{ route('expense-reports.update', $report) }}" method="POST" enctype="multipart/form-data" class="md:p-8 space-y-8" id="expense-form">
                @csrf
                @method('PUT')

                <!-- Section Description générale -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 border border-blue-100 dark:border-blue-800">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Description générale
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Décrivez brièvement l'objet de cette note de frais
                            </p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>Description</span>
                                </span>
                            </label>
                            <textarea id="description" name="description" rows="4" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-300 transition-all duration-200 @error('description') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="Ex: Déplacement professionnel à Paris, frais de mission du 15-20 janvier...">{{ old('description', $report->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Lignes de frais -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-6 border border-green-100 dark:border-green-800">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 space-y-4 sm:space-y-0">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 dark:bg-green-800 rounded-xl flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                                    Lignes de frais
                                </h3>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    <span class="hidden sm:inline">Ajoutez et gérez les différents frais de cette note</span>
                                    <span class="sm:hidden">Gérez vos frais</span>
                                </p>
                            </div>
                        </div>
                        <button type="button" id="add-line" 
                            class="inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white text-xs sm:text-sm font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 w-full sm:w-auto">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span class="hidden sm:inline">Ajouter une ligne</span>
                            <span class="sm:hidden">Ajouter</span>
                        </button>
                    </div>

                    <div id="expense-lines" class="space-y-4">
                        @foreach($report->lines as $line)
                            <div class="expense-line bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200 relative">
                                <button type="button" 
                                        class="remove-line absolute top-4 right-4 inline-flex items-center justify-center w-8 h-8 bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-700 rounded-lg hover:scale-110 transition-all duration-200 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                <input type="hidden" name="lines[{{ $loop->index }}][id]" value="{{ $line->id }}">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pr-12">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            <span class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                                </svg>
                                                <span>Description</span>
                                            </span>
                                        </label>
                                        <input type="text" name="lines[{{ $loop->index }}][description]" required
                                            value="{{ old('lines.'.$loop->index.'.description', $line->description) }}"
                                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-300 transition-all duration-200"
                                            placeholder="Ex: Repas client, Transport...">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            <span class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                <span>Catégorie</span>
                                            </span>
                                        </label>
                                        <select name="lines[{{ $loop->index }}][category]" required
                                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-300 transition-all duration-200">
                                            <option value="">Sélectionner une catégorie</option>
                                            <option value="transport" {{ old('lines.'.$loop->index.'.category', $line->category) == 'transport' ? 'selected' : '' }}>Transport</option>
                                            <option value="accommodation" {{ old('lines.'.$loop->index.'.category', $line->category) == 'accommodation' ? 'selected' : '' }}>Hébergement</option>
                                            <option value="meals" {{ old('lines.'.$loop->index.'.category', $line->category) == 'meals' ? 'selected' : '' }}>Repas</option>
                                            <option value="supplies" {{ old('lines.'.$loop->index.'.category', $line->category) == 'supplies' ? 'selected' : '' }}>Fournitures</option>
                                            <option value="communication" {{ old('lines.'.$loop->index.'.category', $line->category) == 'communication' ? 'selected' : '' }}>Communication</option>
                                            <option value="training" {{ old('lines.'.$loop->index.'.category', $line->category) == 'training' ? 'selected' : '' }}>Formation</option>
                                            <option value="other" {{ old('lines.'.$loop->index.'.category', $line->category) == 'other' ? 'selected' : '' }}>Autre</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            <span class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                                </svg>
                                                <span>Montant ({{ $globalCompanyCurrency }})</span>
                                            </span>
                                        </label>
                                        <input type="number" name="lines[{{ $loop->index }}][amount]" step="0.01" min="0" required
                                            value="{{ old('lines.'.$loop->index.'.amount', $line->amount) }}"
                                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-300 transition-all duration-200"
                                            placeholder="0.00">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            <span class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v9a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h3z"/>
                                                </svg>
                                                <span>Date de la dépense</span>
                                            </span>
                                        </label>
                                        <input type="date" name="lines[{{ $loop->index }}][spent_on]" required
                                            value="{{ old('lines.'.$loop->index.'.spent_on', $line->spent_on->format('Y-m-d')) }}"
                                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-300 transition-all duration-200">
                                    </div>
                                    <div class="md:col-span-2 lg:col-span-4 space-y-2">
                                        @if($line->receipt_path)
                                            <div class="mb-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                                <a href="{{ Storage::url($line->receipt_path) }}" target="_blank" 
                                                    class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium transition-colors duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    <span>Voir le justificatif actuel</span>
                                                </a>
                                            </div>
                                        @endif
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            <span class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                <span>{{ $line->receipt_path ? 'Changer le justificatif' : 'Ajouter un justificatif' }}</span>
                                            </span>
                                        </label>
                                        <input type="file" name="lines[{{ $loop->index }}][receipt]" accept="image/*,.pdf"
                                            class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900 dark:file:text-green-300 file:transition-colors file:duration-200">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Template pour une nouvelle ligne -->
                    <template id="expense-line-template">
                        <div class="expense-line bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl p-6 mb-4 shadow-sm hover:shadow-md transition-shadow duration-200 relative">
                            <button type="button" 
                                    class="remove-line absolute top-4 right-4 inline-flex items-center justify-center w-8 h-8 bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-700 rounded-lg hover:scale-110 transition-all duration-200 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pr-12">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                            </svg>
                                            <span>Description</span>
                                        </span>
                                    </label>
                                    <input type="text" name="lines[INDEX][description]" required
                                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-300 transition-all duration-200"
                                        placeholder="Ex: Repas client, Transport...">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            <span>Catégorie</span>
                                        </span>
                                    </label>
                                    <select name="lines[INDEX][category]" required
                                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-300 transition-all duration-200">
                                        <option value="">Sélectionner une catégorie</option>
                                        <option value="transport">Transport</option>
                                        <option value="accommodation">Hébergement</option>
                                        <option value="meals">Repas</option>
                                        <option value="supplies">Fournitures</option>
                                        <option value="communication">Communication</option>
                                        <option value="training">Formation</option>
                                        <option value="other">Autre</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                            </svg>
                                            <span>Montant ({{ $globalCompanyCurrency }})</span>
                                        </span>
                                    </label>
                                    <input type="number" name="lines[INDEX][amount]" step="0.01" min="0" required
                                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-300 transition-all duration-200"
                                        placeholder="0.00">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v9a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h3z"/>
                                            </svg>
                                            <span>Date de la dépense</span>
                                        </span>
                                    </label>
                                    <input type="date" name="lines[INDEX][spent_on]" required
                                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-300 transition-all duration-200">
                                </div>
                                <div class="md:col-span-2 lg:col-span-3 space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                            </svg>
                                            <span>Justificatif</span>
                                        </span>
                                    </label>
                                    <input type="file" name="lines[INDEX][receipt]" accept="image/*,.pdf"
                                        class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900 dark:file:text-green-300 file:transition-colors file:duration-200">
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Message si aucune ligne -->
                    @if($report->lines->isEmpty())
                        <div id="no-lines-message" class="text-center py-12">
                            <div class="max-w-sm mx-auto">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune ligne de frais</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Commencez par ajouter une ligne de frais pour cette note</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Boutons d'action -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-8">
                    <a href="{{ route('expense-reports.index') }}" 
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Annuler
                    </a>
                    <button type="submit" name="action" value="draft" 
                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Enregistrer comme brouillon
                    </button>
                    <button type="submit" name="action" value="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
   

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const expenseLines = document.getElementById('expense-lines');
        const template = document.getElementById('expense-line-template');
        const noLinesMessage = document.getElementById('no-lines-message');
        let lineIndex = {{ $report->lines->count() }};

        // Ajouter une nouvelle ligne
        document.getElementById('add-line').addEventListener('click', function() {
            if (noLinesMessage) noLinesMessage.style.display = 'none';
            
            const clone = template.content.cloneNode(true);
            const newLine = clone.querySelector('.expense-line');
            
            // Mettre à jour les indices
            newLine.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace('INDEX', lineIndex);
            });
            
            expenseLines.appendChild(newLine);
            lineIndex++;
        });

        // Supprimer une ligne
        expenseLines.addEventListener('click', function(e) {
            if (e.target.closest('.remove-line')) {
                const line = e.target.closest('.expense-line');
                line.remove();
                
                // Afficher le message si plus aucune ligne
                if (expenseLines.children.length === 0 && noLinesMessage) {
                    noLinesMessage.style.display = 'block';
                }
            }
        });
    });
    </script>
    @endpush
</x-app-layout>