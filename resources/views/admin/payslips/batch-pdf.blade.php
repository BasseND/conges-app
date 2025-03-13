<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Génération en masse des PDF des bulletins de paie') }}
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
                        <p class="mb-4">Cette page vous permet de générer en masse les PDF de tous les bulletins de paie validés ou payés pour une période donnée. Les PDF seront regroupés dans un fichier ZIP.</p>
                        
                        @if($availablePeriods->isEmpty())
                            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 dark:bg-yellow-800 dark:border-yellow-600 dark:text-yellow-100" role="alert">
                                <p>Aucun bulletin validé ou payé n'est disponible pour la génération de PDF.</p>
                            </div>
                        @else
                            <form method="POST" action="{{ route('admin.payslips.batch-pdf') }}" class="mt-6">
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
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Générer les PDF
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
