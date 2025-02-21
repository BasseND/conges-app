<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nouvelle note de frais') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 text-lg font-semibold">
                        Créez une nouvelle note de frais en ajoutant vos dépenses une par une.
                    </p>

                    <form action="{{ route('expense-reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="expense-form">
                        @csrf

                        <!-- En-tête de la note de frais -->
                        <div class="bg-white dark:bg-gray-800 border border-[#f8f8fd] dark:border-gray-600 sm:rounded-lg p-6 mb-4">
                            <div class="grid grid-cols-1 gap-6">
                                <div class="col-span-1">
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description générale</label>
                                    <textarea id="description" name="description" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 @error('description') border-red-300 @enderror"
                                        placeholder="Description de la note de frais">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Lignes de frais -->
                        <div class="bg-white dark:bg-gray-800 border border-[#e2e8f0] dark:border-gray-600 sm:rounded-lg p-6 mb-4">
                            <div class="mb-4 flex justify-between items-center">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Lignes de frais</h2>
                                <button type="button" id="add-line" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Ajouter une ligne
                                </button>
                            </div>

                            <div id="expense-lines" class="space-y-4">
                                <!-- Template pour une ligne de frais -->
                                <template id="expense-line-template">
                                    <div class="expense-line bg-[#f8f8fd] dark:bg-gray-700 p-4 pr-16 rounded-md relative">
                                        <button type="button" 
                                                class="remove-line absolute top-10 right-4 bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-700 rounded hover:scale-110 transition duration-300 ease-in-out text-red-500 dark:bg-red-800  text-red-600 dark:text-red-500 hover:text-red-900 dark:hover:text-red-700 p-2">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                                <input type="text" name="lines[INDEX][description]" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Montant (€)</label>
                                                <input type="number" name="lines[INDEX][amount]" step="0.01" min="0" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de la dépense</label>
                                                <input type="date" name="lines[INDEX][spent_on]" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300">
                                            </div>
                                            <div class="md:col-span-3">
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Justificatif</label>
                                                <input type="file" name="lines[INDEX][receipt]" accept="image/*,.pdf"
                                                    class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Message si aucune ligne -->
                            <div id="no-lines-message" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Aucune ligne de frais. Cliquez sur "Ajouter une ligne" pour commencer.
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('expense-reports.index') }}" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Annuler
                            </a>
                            <button type="submit" name="action" value="draft" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Enregistrer comme brouillon
                            </button>
                            <button type="submit" name="action" value="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Soumettre
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
        const max-w-7xl = document.getElementById('expense-lines');
        const template = document.getElementById('expense-line-template');
        const addButton = document.getElementById('add-line');
        const noLinesMessage = document.getElementById('no-lines-message');
        let lineCount = 0;

        function updateNoLinesMessage() {
            noLinesMessage.style.display = lineCount === 0 ? 'block' : 'none';
        }

        function addExpenseLine() {
            const clone = template.content.cloneNode(true);
            const newLine = clone.querySelector('.expense-line');
            
            // Mettre à jour les indices
            newLine.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace('INDEX', lineCount);
            });

            // Ajouter le gestionnaire de suppression
            newLine.querySelector('.remove-line').addEventListener('click', function() {
                newLine.remove();
                lineCount--;
                updateNoLinesMessage();
            });

            max-w-7xl.appendChild(newLine);
            lineCount++;
            updateNoLinesMessage();
        }

        addButton.addEventListener('click', addExpenseLine);
        updateNoLinesMessage();
    });
    </script>
    @endpush
</x-app-layout>