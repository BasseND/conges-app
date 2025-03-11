<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier un paramètre de paie') }}
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

                    <form method="POST" action="{{ route('admin.payroll-settings.update', $payrollSetting) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="max-w-xl">
                            <!-- Nom du paramètre -->
                            <div class="mb-6">
                                <x-input-label for="name" :value="__('Nom du paramètre')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $payrollSetting->name)" required autofocus />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Exemple: Cotisation retraite, Prime d'ancienneté, etc.</p>
                            </div>

                            <!-- Type de paramètre -->
                            <div class="mb-6">
                                <x-input-label for="type" :value="__('Type de paramètre')" />
                                <select id="type" name="type" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Sélectionnez un type</option>
                                    <option value="earning" {{ old('type', $payrollSetting->type) == 'earning' ? 'selected' : '' }}>Gain</option>
                                    <option value="deduction" {{ old('type', $payrollSetting->type) == 'deduction' ? 'selected' : '' }}>Déduction</option>
                                    <option value="tax" {{ old('type', $payrollSetting->type) == 'tax' ? 'selected' : '' }}>Taxe</option>
                                </select>
                            </div>

                            <!-- Valeur -->
                            <div class="mb-6">
                                <x-input-label for="value" :value="__('Valeur')" />
                                <div class="flex">
                                    <x-text-input id="value" class="block mt-1 w-full" type="number" name="value" :value="old('value', $payrollSetting->value)" step="0.01" min="0" required />
                                </div>
                            </div>

                            <!-- Est un pourcentage -->
                            <div class="mb-6">
                                <div class="flex items-center">
                                    <input id="is_percentage" name="is_percentage" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" {{ old('is_percentage', $payrollSetting->is_percentage) ? 'checked' : '' }}>
                                    <label for="is_percentage" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                        Cette valeur est un pourcentage
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Si coché, la valeur sera considérée comme un pourcentage (ex: 20 pour 20%).</p>
                            </div>

                            <!-- S'applique à -->
                            <div class="mb-6">
                                <x-input-label for="applies_to" :value="__('S\'applique à')" />
                                <select id="applies_to" name="applies_to" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Sélectionnez une option</option>
                                    <option value="all" {{ old('applies_to', $payrollSetting->applies_to) == 'all' ? 'selected' : '' }}>Tous les employés</option>
                                    <option value="department" {{ old('applies_to', $payrollSetting->applies_to) == 'department' ? 'selected' : '' }}>Département spécifique</option>
                                    <option value="contract_type" {{ old('applies_to', $payrollSetting->applies_to) == 'contract_type' ? 'selected' : '' }}>Type de contrat spécifique</option>
                                </select>
                            </div>

                            <!-- Département (conditionnel) -->
                            <div id="department_section" class="mb-6 {{ old('applies_to', $payrollSetting->applies_to) == 'department' ? '' : 'hidden' }}">
                                <x-input-label for="department_id" :value="__('Département')" />
                                <select id="department_id" name="department_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Sélectionnez un département</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $payrollSetting->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Type de contrat (conditionnel) -->
                            <div id="contract_type_section" class="mb-6 {{ old('applies_to', $payrollSetting->applies_to) == 'contract_type' ? '' : 'hidden' }}">
                                <x-input-label for="contract_type" :value="__('Type de contrat')" />
                                <select id="contract_type" name="contract_type" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Sélectionnez un type de contrat</option>
                                    <option value="CDI" {{ old('contract_type', $payrollSetting->contract_type) == 'CDI' ? 'selected' : '' }}>CDI</option>
                                    <option value="CDD" {{ old('contract_type', $payrollSetting->contract_type) == 'CDD' ? 'selected' : '' }}>CDD</option>
                                    <option value="Freelance" {{ old('contract_type', $payrollSetting->contract_type) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option value="Stage" {{ old('contract_type', $payrollSetting->contract_type) == 'Stage' ? 'selected' : '' }}>Stage</option>
                                    <option value="Alternance" {{ old('contract_type', $payrollSetting->contract_type) == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="mb-6">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('description', $payrollSetting->description) }}</textarea>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Description détaillée du paramètre (optionnel).</p>
                            </div>

                            <!-- Actif -->
                            <div class="mb-6">
                                <div class="flex items-center">
                                    <input id="is_active" name="is_active" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" {{ old('is_active', $payrollSetting->is_active) ? 'checked' : '' }}>
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                        Actif
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Si décoché, ce paramètre ne sera pas appliqué aux calculs de paie.</p>
                            </div>

                            <div class="flex items-center justify-between mt-6">
                                <a href="{{ route('admin.payroll-settings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('Annuler') }}
                                </a>
                                <x-primary-button>
                                    {{ __('Mettre à jour') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const appliesTo = document.getElementById('applies_to');
            const departmentSection = document.getElementById('department_section');
            const contractTypeSection = document.getElementById('contract_type_section');
            
            appliesTo.addEventListener('change', function() {
                if (this.value === 'department') {
                    departmentSection.classList.remove('hidden');
                    contractTypeSection.classList.add('hidden');
                } else if (this.value === 'contract_type') {
                    departmentSection.classList.add('hidden');
                    contractTypeSection.classList.remove('hidden');
                } else {
                    departmentSection.classList.add('hidden');
                    contractTypeSection.classList.add('hidden');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
