<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold pb-5 text-bgray-900 dark:text-white">
            {{ __('Validation en masse des bulletins de paie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-800 dark:border-green-600 dark:text-green-100" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-800 dark:border-red-600 dark:text-red-100" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-800 dark:border-red-600 dark:text-red-100" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-6">
                        <p class="mb-4">Cette page vous permet de valider en masse tous les bulletins de paie en brouillon pour une période donnée.</p>
                        
                        @if($availablePeriods->isEmpty())
                            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 dark:bg-yellow-800 dark:border-yellow-600 dark:text-yellow-100" role="alert">
                                <p>Aucun bulletin en brouillon n'est disponible pour validation.</p>
                            </div>
                        @else
                            <form method="POST" action="{{ route('admin.payslips.batch-validate') }}" class="mt-6">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="period" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Période</label>
                                    <select id="period" name="period" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                        <option value="">Sélectionnez une période</option>
                                        @foreach($availablePeriods as $period)
                                            <option value="{{ $period['year'] }}-{{ $period['month'] }}">{{ $period['label'] }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="period_year" name="period_year">
                                    <input type="hidden" id="period_month" name="period_month">
                                </div>
                                
                                <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('admin.payslips.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mr-2">
                                        Annuler
                                    </a>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Valider les bulletins
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periodSelect = document.getElementById('period');
            const periodYearInput = document.getElementById('period_year');
            const periodMonthInput = document.getElementById('period_month');
            const form = document.querySelector('form');

            // Fonction pour mettre à jour les champs cachés
            function updateHiddenFields() {
                if (periodSelect.value) {
                    const [year, month] = periodSelect.value.split('-');
                    periodYearInput.value = year;
                    periodMonthInput.value = month;
                    return true;
                } else {
                    periodYearInput.value = '';
                    periodMonthInput.value = '';
                    return false;
                }
            }

            // Mettre à jour les champs cachés lors du changement de sélection
            periodSelect.addEventListener('change', updateHiddenFields);

            // Mettre à jour les champs cachés avant la soumission du formulaire
            form.addEventListener('submit', function(event) {
                if (!updateHiddenFields()) {
                    event.preventDefault();
                    alert('Veuillez sélectionner une période.');
                }
            });
        });
    </script>
</x-app-layout>
