<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ __('Demande d\'avance sur salaire') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Soumettez votre demande d'avance sur salaire en remplissant le formulaire ci-dessous
                </p>
            </div>
            <div class="hidden sm:flex items-center space-x-2">
                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Affichage des erreurs de validation -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4" role="alert">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">{{ __('Erreurs de validation') }}</h3>
                            <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Informations importantes -->
            <div class="mb-8 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-200 mb-2">Informations importantes</h3>
                        <p class="text-amber-700 dark:text-amber-300 leading-relaxed">
                            Les avances sur salaire sont soumises à approbation. Le montant sera déduit de vos prochains salaires selon les modalités définies par l'entreprise.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <form method="POST" action="{{ route('salary-advances.store') }}">
                        @csrf
                        
                        <!-- Montant -->
                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Montant demandé (' . $globalCompanyCurrency . ')') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <input type="number" 
                                       id="amount" 
                                       name="amount" 
                                       class="w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 focus:ring-green-500" 
                                       placeholder="0.00"
                                       value="{{ old('amount') }}"
                                       step="0.01" 
                                       min="0" 
                                       required 
                                       autofocus>
                            </div>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Le montant maximum autorisé dépend de votre salaire et des avances en cours.</p>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Motif -->
                        <div class="mb-6">
                            <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Motif de la demande') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="reason" 
                                       name="reason" 
                                       class="w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 focus:ring-green-500" 
                                       placeholder="Décrivez le motif de votre demande"
                                       value="{{ old('reason') }}"
                                       required>
                            </div>
                            @error('reason')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date souhaitée -->
                        <div class="mb-6">
                            <label for="request_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Date souhaitée') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" 
                                       id="request_date" 
                                       name="request_date" 
                                       class="w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 focus:ring-green-500" 
                                       value="{{ old('request_date', date('Y-m-d')) }}"
                                       required>
                            </div>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Date à laquelle vous souhaitez recevoir l'avance.</p>
                            @error('request_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-end space-x-4 mt-8">
                            <a href="{{ route('salary-advances.index') }}" 
                               class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                {{ __('Annuler') }}
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 border border-transparent rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            // Initialisation de flatpickr pour le champ de date
            flatpickr("#request_date", {
                dateFormat: "Y-m-d",
                locale: "fr",
                minDate: "today",
                disableMobile: true
            });
        });
    </script>
    @endpush
</x-app-layout>
