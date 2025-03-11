<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Demande d\'avance sur salaire') }}
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

                    <form method="POST" action="{{ route('salary-advances.store') }}" class="space-y-6">
                        @csrf

                        <div class="max-w-xl">
                            <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700 dark:text-yellow-200">
                                            Les avances sur salaire sont soumises à approbation. Le montant sera déduit de vos prochains salaires selon les modalités définies par l'entreprise.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Montant -->
                            <div class="mb-6">
                                <x-input-label for="amount" :value="__('Montant demandé (€)')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')" step="0.01" min="0" required autofocus />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Le montant maximum autorisé dépend de votre salaire et des avances en cours.</p>
                            </div>

                            <!-- Motif -->
                            <div class="mb-6">
                                <x-input-label for="reason" :value="__('Motif de la demande')" />
                                <x-text-input id="reason" class="block mt-1 w-full" type="text" name="reason" :value="old('reason')" required />
                            </div>

                            <!-- Date souhaitée -->
                            <div class="mb-6">
                                <x-input-label for="request_date" :value="__('Date souhaitée')" />
                                <x-text-input id="request_date" class="block mt-1 w-full" type="date" name="request_date" :value="old('request_date', date('Y-m-d'))" required />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Date à laquelle vous souhaitez recevoir l'avance.</p>
                            </div>

                            <div class="flex items-center justify-between mt-6">
                                <a href="{{ route('salary-advances.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('Annuler') }}
                                </a>
                                <x-primary-button>
                                    {{ __('Soumettre la demande') }}
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
