@section('title', 'Modifier la demande de congé')
<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- En-tête modernisé avec dégradé et icône -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-4 sm:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg p-2 sm:p-3 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl sm:text-2xl font-bold text-white break-words">
                            {{ __('Modifier la demande de congé') }}
                        </h2>
                        <p class="text-blue-100 mt-1 text-sm sm:text-base">
                            {{ __('Modifiez les détails de votre demande de congé') }}
                        </p>
                    </div>
                </div>
                
                <!-- Fil d'Ariane -->
                <nav class="flex mt-4 text-xs sm:text-sm overflow-x-auto" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 sm:space-x-2 md:space-x-3 whitespace-nowrap">
                        <li class="inline-flex items-center">
                            <a href="{{ route('welcome.index') }}" class="text-blue-100 hover:text-white transition-colors duration-200 truncate flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                {{ __('Accueil') }}
                            </a>
                        </li>
                        <li class="flex-shrink-0">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('leaves.index') }}" class="ml-1 text-blue-100 hover:text-white transition-colors duration-200 sm:ml-2 truncate">
                                    <span class="hidden sm:inline">{{ __('Demandes de congé') }}</span>
                                    <span class="sm:hidden">{{ __('Congés') }}</span>
                                </a>
                            </div>
                        </li>
                        <li class="flex-shrink-0">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-white font-medium sm:ml-2 truncate">
                                    {{ __('Modifier') }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- END HEADER -->


            <!-- Messages d'erreur stylisés -->
            @if (session('error'))
                <div class="mb-6 bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-red-700 dark:text-red-300 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-lg p-4 shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-red-700 dark:text-red-300 font-medium mb-2">{{ __('Veuillez corriger les erreurs suivantes :') }}</h3>
                            <ul class="list-disc list-inside text-red-600 dark:text-red-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="md:bg-white dark:bg-gray-800 overflow-hidden sm:rounded-xl md:border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('leaves.update', ['leave' => $leave->id]) }}" enctype="multipart/form-data" class="md:p-8 space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Section Type de congé -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 dark:bg-blue-900/50 rounded-lg p-2 mr-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Type de congé') }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Sélectionnez le type de congé souhaité') }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <x-input-label for="type" :value="__('Type de congé')" class="sr-only" />
                            <select id="type" name="type" class="block w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors duration-200">
                                @foreach(App\Models\Leave::TYPES as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $leave->type) === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Section Période de congé -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 border border-green-200 dark:border-green-800">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 dark:bg-green-900/50 rounded-lg p-2 mr-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Période de congé') }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Définissez les dates de début et de fin de votre congé') }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="start_date" :value="__('Date de début')" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <x-text-input id="start_date" name="start_date" type="date" class="pl-10 block w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-green-500 focus:ring-green-500 dark:focus:border-green-400 dark:focus:ring-green-400 transition-colors duration-200" 
                                        :value="old('start_date', $leave->start_date ? $leave->start_date->format('Y-m-d') : '')" required />
                                </div>
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_date" :value="__('Date de fin')" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <x-text-input id="end_date" name="end_date" type="date" class="pl-10 block w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-green-500 focus:ring-green-500 dark:focus:border-green-400 dark:focus:ring-green-400 transition-colors duration-200" 
                                        :value="old('end_date', $leave->end_date ? $leave->end_date->format('Y-m-d') : '')" required />
                                </div>
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section Motif -->
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 dark:bg-purple-900/50 rounded-lg p-2 mr-3">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Motif') }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Décrivez la raison de votre demande de congé') }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <x-input-label for="reason" :value="__('Motif')" class="sr-only" />
                            <textarea id="reason" name="reason" rows="4" 
                                class="block w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:focus:border-purple-400 dark:focus:ring-purple-400 transition-colors duration-200" 
                                placeholder="{{ __('Décrivez le motif de votre demande de congé...') }}" 
                                required>{{ old('reason', $leave->reason) }}</textarea>
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Section Pièces jointes -->
                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 rounded-xl p-6 border border-orange-200 dark:border-orange-800">
                        <div class="flex items-center mb-4">
                            <div class="bg-orange-100 dark:bg-orange-900/50 rounded-lg p-2 mr-3">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Pièces jointes') }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Ajoutez des documents justificatifs (optionnel)') }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <x-input-label for="attachments" :value="__('Pièces jointes (optionnel)')" class="sr-only" />
                            <div class="border-2 border-dashed border-orange-300 dark:border-orange-600 rounded-lg p-6 text-center hover:border-orange-400 dark:hover:border-orange-500 transition-colors duration-200">
                                <svg class="mx-auto h-12 w-12 text-orange-400 dark:text-orange-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <input type="file" id="attachments" name="attachments[]" multiple 
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-orange-50 file:text-orange-700
                                        hover:file:bg-orange-100
                                        dark:file:bg-orange-900 dark:file:text-orange-300
                                        dark:hover:file:bg-orange-800
                                        file:transition-colors file:duration-200">
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium">{{ __('Cliquez pour télécharger') }}</span> {{ __('ou glissez-déposez vos fichiers') }}
                                </p>
                                <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                    {{ __('Formats acceptés : PDF, DOC, DOCX, JPG, JPEG, PNG (max 2MB)') }}
                                </p>
                            </div>
                            <x-input-error :messages="$errors->get('attachments.*')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('leaves.show', $leave) }}" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            {{ __('Annuler') }}
                        </a>
                        
                        @if($leave->status === 'draft')
                            <button type="submit" name="action" value="draft"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                {{ __('Sauvegarder en brouillon') }}
                            </button>
                            
                            <button type="submit" name="action" value="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                {{ __('Soumettre la demande') }}
                            </button>
                        @else
                            <button type="submit" 
                                class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                {{ __('Mettre à jour') }}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    

     @push('scripts')
   
        <script>
            document.addEventListener('DOMContentLoaded', function() {

            // Configuration de la date max : 1 an à partir d'aujourd'hui
            const oneYearFromNow = new Date();
            oneYearFromNow.setFullYear(oneYearFromNow.getFullYear() + 1);

            // Fonction qui désactive les week-ends (retourne true si la date doit être bloquée)
            // Documentation Flatpickr: https://flatpickr.js.org/options/#disable
            function disableWeekends(date) {
                // day = 0 (Dimanche), day = 6 (Samedi)
                return (date.getDay() === 0 || date.getDay() === 6);
            }

            // Initialisation pour la date de début
            flatpickr("#start_date", {
                locale: "fr",               // Langue (optionnelle)
                dateFormat: "Y-m-d",         // Format de date (ex: 2025-01-28)
                minDate: false,           // Pas avant aujourd'hui (optionnel)
                maxDate: oneYearFromNow,    // Pas au-delà d'un an
                disable: [ disableWeekends ], // Désactive les week-ends via callback
                onChange: function(selectedDates, dateStr) {
                    // Récupérer l'instance du datepicker de la date de fin
                    const endPicker = document.querySelector('#end_date')._flatpickr;
                    if (endPicker) {
                        // Forcer la "minDate" du champ de fin à la date sélectionnée
                        endPicker.set('minDate', dateStr);
                        // Si la date de fin est avant la nouvelle date de début, on la réinitialise
                        if (endPicker.selectedDates[0] < selectedDates[0]) {
                            endPicker.setDate(dateStr);
                        }
                    }
                }
            });

            // Initialisation pour la date de fin
            flatpickr("#end_date", {
                locale: "fr",
                dateFormat: "Y-m-d",
                minDate: false,
                maxDate: oneYearFromNow,
                disable: [ disableWeekends ],
                onChange: function(selectedDates, dateStr) {
                    // Récupérer l'instance du datepicker de la date de début
                    const startPicker = document.querySelector('#start_date')._flatpickr;
                    if (startPicker && selectedDates[0] < startPicker.selectedDates[0]) {
                        // Si l’utilisateur choisit une date de fin avant la date de début,
                        // on aligne la fin sur la date de début.
                        startPicker.setDate(dateStr);
                    }
                }
            });


        });
        </script>
    @endpush
</x-app-layout>
