<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvelle demande de congé') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('error'))
                        <div class="bg-red-100 dark:bg-red-900 border border-red-400 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    

                    <form method="POST" action="{{ route('leaves.store') }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf

                         <input type="hidden" name="debug" value="1">

                        <div>
                            <x-input-label for="type" :value="__('Type de congé')" />
                            <select id="type" name="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Sélectionner un type de congé</option>
                                <option value="annual" {{ old('type') == 'annual' ? 'selected' : '' }}>Congé annuel</option>
                                <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>Congé maladie</option>
                                <option value="maternity" {{ old('type') == 'maternity' ? 'selected' : '' }}>Congé maternité</option>
                                <option value="paternity" {{ old('type') == 'paternity' ? 'selected' : '' }}>Congé paternité</option>
                                <option value="unpaid" {{ old('type') == 'unpaid' ? 'selected' : '' }}>Congé sans solde</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Autre</option>
                         
                           
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500">
                                Solde disponible : 
                                <span class="font-medium" id="annual_balance">{{ auth()->user()->annual_leave_days }} jours</span> de congés annuels, 
                                <span class="font-medium" id="sick_balance">{{ auth()->user()->sick_leave_days }} jours</span> de congés maladie
                            </p>
                        </div>

                        <div class="space-y-2 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4">
                            {{-- <div>
                                <x-input-label for="start_date" :value="__('Date de début')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                                @error('start_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="end_date" :value="__('Date de fin')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" required />
                                @error('end_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <!-- Date de début -->
                            <div>
                                <x-input-label for="start_date" :value="__('Date de début')" />
                                <x-text-input
                                    id="start_date"
                                    class="block mt-1 w-full"
                                    type="text"
                                    name="start_date"
                                    :value="old('start_date')"
                                    required
                                />
                                @error('start_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date de fin -->
                             <div>
                                <x-input-label for="end_date" :value="__('Date de fin')" />
                                <x-text-input
                                    id="end_date"
                                    class="block mt-1 w-full"
                                    type="text"
                                    name="end_date"
                                    :value="old('end_date')"
                                    required
                                />
                                 @error('end_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <x-input-label for="reason" :value="__('Motif')" />
                            <textarea id="reason" name="reason" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Veuillez fournir un motif détaillé pour votre demande de congé.</p>
                        </div>

                        {{-- <div>
                            <x-input-label for="reason" :value="__('Motif')" />
                            <textarea id="reason" name="reason" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('reason') }}</textarea>
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500">Veuillez fournir un motif détaillé pour votre demande de congé.</p>
                        </div> --}}

                        <div>
                            <x-input-label for="attachments" :value="__('Pièces justificatives')" />
                            <input type="file" id="attachments" name="attachments[]" multiple 
                                class="block w-full text-sm text-gray-500 mt-1
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />
                            <p class="mt-2 text-sm text-gray-500">
                                Vous pouvez sélectionner plusieurs fichiers. Formats acceptés : PDF, JPG, PNG. Taille maximale : 10 MB par fichier.
                            </p>
                            <x-input-error :messages="$errors->get('attachments')" class="mt-2" />
                            <x-input-error :messages="$errors->get('attachments.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-2 mt-4">
                            <a href="{{ route('leaves.index') }}" class="btn btn-secondary">
                                {{ __('Annuler') }}
                            </a>
                            <x-primary-button>
                                {{ __('Soumettre la demande') }}
                            </x-primary-button>
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
