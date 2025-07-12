<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

             <!-- HEADER -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-6 mb-6">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">
                            {{ __('Nouvelle demande de congé') }}
                        </h2>
                        <p class="text-blue-100 mt-1">
                            {{ __('Créez une nouvelle demande de congé') }}
                        </p>
                    </div>
                </div>
                
                <!-- Fil d'Ariane -->
                <nav class="flex mt-4 text-sm" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('welcome.index') }}" class="text-blue-100 hover:text-white transition-colors duration-200">
                               
                                {{ __('Accueil') }}
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('leaves.index') }}" class="ml-1 text-blue-100 hover:text-white transition-colors duration-200 md:ml-2">
                                    {{ __('Demandes de congé') }}
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-white font-medium md:ml-2">
                                    {{ __('Nouvelle demande') }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- END HEADER -->



            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-xl border border-gray-200 dark:border-gray-700">
               
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
            
                <form method="POST" action="{{ route('leaves.store') }}" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf

                    <input type="hidden" name="debug" value="1">

                    <!-- Section Type de congé -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800 mt-0">
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
                            <select id="type" name="type" class="block w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors duration-200" required>
                                <option value="">Sélectionner un type de congé</option>
                                <option value="annual" {{ old('type') == 'annual' ? 'selected' : '' }}>Congé annuel</option>
                                <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>Congé maladie</option>
                                <option value="maternity" {{ old('type') == 'maternity' ? 'selected' : '' }}>Congé maternité</option>
                                <option value="paternity" {{ old('type') == 'paternity' ? 'selected' : '' }}>Congé paternité</option>
                                <option value="unpaid" {{ old('type') == 'unpaid' ? 'selected' : '' }}>Congé sans solde</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            
                            <!-- Solde de congés -->
                            <div class="mt-4 p-4 bg-white/50 dark:bg-gray-800/50 rounded-lg border border-blue-200 dark:border-blue-700">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">{{ __('Solde disponible') }}</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400" id="annual_balance">{{ auth()->user()->annual_leave_days }}</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('Congés annuels') }}</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600 dark:text-green-400" id="sick_balance">{{ auth()->user()->sick_leave_days }}</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('Congés maladie') }}</div>
                                    </div>
                                </div>
                            </div>
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
                                    <x-text-input id="start_date" name="start_date" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-green-500 focus:ring-green-500 dark:focus:border-green-400 dark:focus:ring-green-400 transition-colors duration-200" :value="old('start_date')" required />
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
                                    <x-text-input id="end_date" name="end_date" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-green-500 focus:ring-green-500 dark:focus:border-green-400 dark:focus:ring-green-400 transition-colors duration-200" :value="old('end_date')" required />
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
                                required>{{ old('reason') }}</textarea>
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Veuillez fournir un motif détaillé pour votre demande de congé.') }}</p>
                        </div>
                    </div>

                        {{-- <div>
                            <x-input-label for="reason" :value="__('Motif')" />
                            <textarea id="reason" name="reason" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('reason') }}</textarea>
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500">Veuillez fournir un motif détaillé pour votre demande de congé.</p>
                        </div> --}}

                    <!-- Section Pièces jointes -->
                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 rounded-xl p-6 border border-orange-200 dark:border-orange-800">
                        <div class="flex items-center mb-4">
                            <div class="bg-orange-100 dark:bg-orange-900/50 rounded-lg p-2 mr-3">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Pièces justificatives') }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Ajoutez des documents justificatifs (optionnel)') }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <x-input-label for="attachments" :value="__('Pièces justificatives')" class="sr-only" />
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
                                        file:transition-colors file:duration-200" />
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium">{{ __('Cliquez pour télécharger') }}</span> {{ __('ou glissez-déposez vos fichiers') }}
                                </p>
                                <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                    {{ __('Vous pouvez sélectionner plusieurs fichiers. Formats acceptés : PDF, JPG, PNG. Taille maximale : 10 MB par fichier.') }}
                                </p>
                            </div>
                            <x-input-error :messages="$errors->get('attachments')" class="mt-2" />
                            <x-input-error :messages="$errors->get('attachments.*')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('leaves.index') }}" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            {{ __('Annuler') }}
                        </a>
                        <button type="submit" name="action" value="draft"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            {{ __('Sauvegarder en brouillon') }}
                        </button>
                        <button type="submit" name="action" value="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            {{ __('Soumettre la demande') }}
                        </button>
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


            const form = document.querySelector('form');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            // Définir seulement la date maximale (1 an dans le futur)
            const maxDate = new Date();
            maxDate.setFullYear(maxDate.getFullYear() + 1);
            
            startDateInput.max = maxDate.toISOString().split('T')[0];
            endDateInput.max = maxDate.toISOString().split('T')[0];

            // Fonction pour vérifier si une date est un weekend
            function isWeekend(date) {
                const d = new Date(date);
                return d.getDay() === 0 || d.getDay() === 6;
            }

            // Fonction pour obtenir le prochain jour ouvrable
            function getNextWorkday(date) {
                const d = new Date(date);
                while (isWeekend(d)) {
                    d.setDate(d.getDate() + 1);
                }
                return d.toISOString().split('T')[0];
            }

            // Fonction pour obtenir le jour ouvrable précédent
            function getPreviousWorkday(date) {
                const d = new Date(date);
                while (isWeekend(d)) {
                    d.setDate(d.getDate() - 1);
                }
                return d.toISOString().split('T')[0];
            }

            // Gérer la sélection de dates
            startDateInput.addEventListener('change', function() {
                if (isWeekend(this.value)) {
                    this.value = getNextWorkday(this.value);
                }
                
                // Si la date de fin existe et est avant la date de début, l'ajuster
                if (endDateInput.value && new Date(endDateInput.value) < new Date(this.value)) {
                    endDateInput.value = this.value;
                }
            });

            endDateInput.addEventListener('change', function() {
                if (isWeekend(this.value)) {
                    this.value = getPreviousWorkday(this.value);
                }
                
                // Si la date de fin est avant la date de début, l'ajuster
                if (this.value && new Date(this.value) < new Date(startDateInput.value)) {
                    this.value = startDateInput.value;
                }
            });

            form.addEventListener('submit', function(e) {
                if (!startDateInput.value || !endDateInput.value) {
                    return;
                }

                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (isWeekend(startDate) || isWeekend(endDate)) {
                    e.preventDefault();
                    alert('Les dates de début et de fin ne peuvent pas être des weekends');
                    return;
                }

                if (endDate < startDate) {
                    e.preventDefault();
                    alert('La date de fin doit être après la date de début');
                    return;
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
