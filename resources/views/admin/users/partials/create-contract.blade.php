<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <div class="max-w-xl">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Nouveau contrat') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Créer un nouveau contrat pour l\'employé.') }}
            </p>
        </header>

        <form method="post" action="{{ route('admin.users.contracts.store', $user) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf

            <div>
                <x-input-label for="type" :value="__('Type de contrat')" />
                <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Sélectionnez un type</option>
                    <option value="CDI">CDI</option>
                    <option value="CDD">CDD</option>
                    <option value="Stage">Stage</option>
                    <option value="Alternance">Alternance</option>
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="date_debut" :value="__('Date de début')" />
                <x-text-input id="date_debut" name="date_debut" type="date" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('date_debut')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="date_fin" :value="__('Date de fin')" />
                <x-text-input id="date_fin" name="date_fin" type="date" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('date_fin')" class="mt-2" />
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Laissez vide pour un contrat à durée indéterminée') }}
                </p>
            </div>

            <div>
                <x-input-label for="salaire_brut" :value="__('Salaire brut annuel')" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <x-text-input id="salaire_brut" name="salaire_brut" type="number" step="0.01" min="0" class="block w-full pr-12" required />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">€</span>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('salaire_brut')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="statut" :value="__('Statut')" />
                <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="actif">Actif</option>
                    <option value="suspendu">Suspendu</option>
                    <option value="termine">Terminé</option>
                </select>
                <x-input-error :messages="$errors->get('statut')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="contrat_file" :value="__('Document du contrat')" />
                <input type="file" id="contrat_file" name="contrat_file" 
                    class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100
                        dark:file:bg-indigo-900 dark:file:text-indigo-300"
                    accept=".pdf,.doc,.docx" />
                <x-input-error :messages="$errors->get('contrat_file')" class="mt-2" />
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Formats acceptés : PDF, DOC, DOCX (max. 10 Mo)') }}
                </p>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>
            </div>
        </form>
    </div>
</div>