<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Générer des bulletins de paie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Affichage des erreurs de validation -->
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-800 dark:border-red-600 dark:text-red-100" role="alert">
                            <p class="font-bold">{{ __('Erreurs de validation') }}</p>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-800 dark:border-red-600 dark:text-red-100" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.payslips.store') }}" class="space-y-6">
                        @csrf

                        <div class="max-w-xl">
                            <!-- Période -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Période de paie</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="month" :value="__('Mois')" />
                                        <select id="month" name="month" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                            <option value="">Sélectionnez un mois</option>
                                            @foreach ($months as $key => $month)
                                                <option value="{{ $key }}" {{ old('month') == $key ? 'selected' : '' }}>{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="year" :value="__('Année')" />
                                        <select id="year" name="year" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                            <option value="">Sélectionnez une année</option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Employés -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Sélection des employés</h3>
                                
                                <div class="flex items-center mb-2">
                                    <input id="select_all" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <label for="select_all" class="ml-2 text-sm text-gray-900 dark:text-gray-100">Sélectionner tous les employés</label>
                                </div>
                                
                                <div class="mt-4 border border-gray-200 dark:border-gray-700 rounded-md p-4 max-h-96 overflow-y-auto">
                                    @foreach ($users as $user)
                                        <div class="flex items-center mb-3">
                                            <input id="user_{{ $user->id }}" name="users[]" type="checkbox" value="{{ $user->id }}" class="user-checkbox rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" {{ in_array($user->id, old('users', [])) ? 'checked' : '' }}>
                                            <label for="user_{{ $user->id }}" class="ml-2 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $user->last_name }} {{ $user->first_name }} ({{ $user->employee_id ?? 'ID non défini' }})
                                                @if ($user->department)
                                                    - {{ $user->department->name }}
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex items-center justify-between mt-6">
                                <a href="{{ route('admin.payslips.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('Annuler') }}
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('Générer les bulletins') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select_all');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');

            // Fonction pour mettre à jour l'état du checkbox "Sélectionner tous"
            function updateSelectAllCheckbox() {
                const allChecked = Array.from(userCheckboxes).every(checkbox => checkbox.checked);
                const someChecked = Array.from(userCheckboxes).some(checkbox => checkbox.checked);
                
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }

            // Initialiser l'état du checkbox "Sélectionner tous"
            updateSelectAllCheckbox();

            // Événement pour le checkbox "Sélectionner tous"
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });

            // Événements pour les checkboxes des utilisateurs
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectAllCheckbox);
            });
        });
    </script>
</x-app-layout>
