<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold pb-5 text-bgray-900 dark:text-white">
            {{ __('Modifier la demande de congé') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('leaves.update', ['leave' => $leave->id]) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @if (session('error'))
                            <div class="bg-red-100 dark:bg-red-900 border border-red-400 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4" role="alert">
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif

                        <div>
                            <x-input-label for="type" :value="__('Type de congé')" />
                            <select id="type" name="type" class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach(App\Models\Leave::TYPES as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $leave->type) === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="start_date" :value="__('Date de début')" />
                                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date', $leave->start_date)" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_date" :value="__('Date de fin')" />
                                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" :value="old('end_date', $leave->end_date)" required />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div> --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="start_date" :value="__('Date de début')" />
                                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" 
                                    :value="old('start_date', $leave->start_date ? $leave->start_date->format('Y-m-d') : '')" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_date" :value="__('Date de fin')" />
                                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" 
                                    :value="old('end_date', $leave->end_date ? $leave->end_date->format('Y-m-d') : '')" required />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="reason" :value="__('Motif')" />
                            <textarea id="reason" name="reason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('reason', $leave->reason) }}</textarea>
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="attachments" :value="__('Pièces jointes (optionnel)')" />
                            <input type="file" id="attachments" name="attachments[]" multiple class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                dark:file:bg-indigo-900 dark:file:text-indigo-300
                                dark:hover:file:bg-indigo-800">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Formats acceptés : PDF, DOC, DOCX, JPG, JPEG, PNG (max 2MB)
                            </p>
                            <x-input-error :messages="$errors->get('attachments.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('leaves.show', $leave) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Annuler') }}
                            </a>
                            <x-primary-button class="bg-green-600 hover:bg-green-700 focus:bg-green-700 focus:ring-green-500">
                                {{ __('Mettre à jour') }}
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


        });
        </script>
    @endpush
</x-app-layout>
