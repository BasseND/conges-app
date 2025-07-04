<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold pb-5 text-bgray-900 dark:text-white">
            {{ __('Créer un utilisateur') }}
        </h2>
    </x-slot>
    

    <div class="pb-10">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 mt-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                    @csrf

                    <!-- Block erreurs -->

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Erreur!</strong>
                            <span class="block sm:inline">Veuillez corriger les erreurs ci-dessous.</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Informations sur l'utilisateur -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-md px-4 py-6 space-y-4">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Informations sur l\'utilisateur') }}
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="first_name" :value="__('Prénom')" />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="last_name" :value="__('Nom de famille')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required  />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Numéro de téléphone')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="number" name="phone" :value="old('phone')" required />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="password" :value="__('Mot de passe')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Mettre un select -->
                            <div>
                                <x-input-label for="position" :value="__('Poste')" />
                                <select id="position" name="position" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Sélectionnez un poste">
                                    <option value="">Sélectionnez un poste</option>
                                </select>
                                <x-input-error :messages="$errors->get('position')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="role" :value="__('Rôle de l\'utilisateur')" />
                                <select id="role" name="role" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Sélectionner un rôle</option>
                                    <option value="{{ App\Models\User::ROLE_EMPLOYEE }}">Employé</option>
                                    <option value="{{ App\Models\User::ROLE_MANAGER }}">Manager</option>
                                    <option value="{{ App\Models\User::ROLE_DEPARTMENT_HEAD }}">Chef de Département</option>
                                    <option value="{{ App\Models\User::ROLE_HR }}">Ressources Humaines</option>
                                    <option value="{{ App\Models\User::ROLE_ADMIN }}">Administrateur</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>

                            
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="department_id" :value="__('Département')" />
                                <select id="department_id" name="department_id" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Sélectionner un département</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="team_id" :value="__('Équipe')" />
                                <select id="team_id" name="team_id" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Sélectionner une équipe</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="mt-3 mb-3">
                                <p class="block font-medium text-sm text-gray-700 dark:text-gray-200">L'utilisateur est-il un prestataire ?</p>
                            </div>
                            <input type="checkbox" class="peer sr-only opacity-0" id="is_prestataire" name="is_prestataire" {{ old('is_prestataire') ? 'checked' : '' }} />
                            <label for="is_prestataire" class="relative flex h-6 w-11 cursor-pointer items-center rounded-full bg-gray-400 px-0.5 outline-gray-400 transition-colors before:h-5 before:w-5 before:rounded-full before:bg-white before:shadow before:transition-transform before:duration-300 peer-checked:bg-green-500 peer-checked:before:translate-x-full peer-focus-visible:outline peer-focus-visible:outline-offset-2 peer-focus-visible:outline-gray-400 peer-checked:peer-focus-visible:outline-green-500">
                                <span class="sr-only">Enable</span>
                            </label>
                        </div>
                    </div>

                    <!-- Solde de conges -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-md px-4 py-6 space-y-4">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Solde de conges') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="annual_leave_days" :value="__('Jours de congés annuels')" />
                                <x-text-input id="annual_leave_days" class="block mt-1 w-full" type="number" name="annual_leave_days" :value="old('annual_leave_days', 25)" required />
                                <x-input-error :messages="$errors->get('annual_leave_days')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="sick_leave_days" :value="__('Jours de congés maladie')" />
                                <x-text-input id="sick_leave_days" class="block mt-1 w-full" type="number" name="sick_leave_days" :value="old('sick_leave_days', 12)" required />
                                <x-input-error :messages="$errors->get('sick_leave_days')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    
                        <div class="flex items-center justify-end mt-4 gap-2">
                        <a href="{{ route('admin.users.index') }}" class="mr-2 inline-flex items-center btn btn-secondary">
                            {{ __('Annuler') }}
                        </a>
                        <x-primary-button class="btn btn-primary">
                            {{ __('Créer') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        console.log('Script chargé');
        
        function loadTeams(departmentId) {
            console.log('Chargement des équipes pour le département:', departmentId);
            
            if (!departmentId) {
                console.log('Aucun département sélectionné');
                document.getElementById('team_id').innerHTML = '<option value="">Sélectionner une équipe</option>';
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('Token CSRF récupéré');

            const url = `/admin/departments/${departmentId}/teams`;
            console.log('URL de la requête:', url);

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('Réponse reçue:', response.status);
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(teams => {
                console.log('Équipes reçues:', teams);
                const select = document.getElementById('team_id');
                select.innerHTML = '<option value="">Sélectionner une équipe</option>';
                
                if (Array.isArray(teams)) {
                    teams.forEach(team => {
                        const option = document.createElement('option');
                        option.value = team.id;
                        option.textContent = `${team.name} (Responsable: ${team.manager.name})`;
                        select.appendChild(option);
                    });
                    console.log('Liste des équipes mise à jour');
                } else {
                    console.error('Format de données invalide:', teams);
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des équipes:', error);
                alert('Erreur lors du chargement des équipes. Consultez la console pour plus de détails.');
            });
        }

        // Attacher l'événement une fois que le DOM est chargé
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page chargée, initialisation des événements');
            
            // Attacher l'événement change au select département
            const departmentSelect = document.getElementById('department_id');
            // departmentSelect.addEventListener('change', function() {
            //     loadTeams(this.value);
            // });

            // Charger les équipes si un département est déjà sélectionné
            // if (departmentSelect.value) {
            //     console.log('Département pré-sélectionné:', departmentSelect.value);
            //     loadTeams(departmentSelect.value);
            // }

            // Mettre à jour le select position
             fetch('/data/positions.json')
            .then(response => response.json())
            .then(data => {
                // Préparer les options pour Tom Select
                let options = [];
                let optgroups = [];
                
                // Parcourir les catégories et les postes
                Object.entries(data.postes).forEach(([category, positions]) => {
                    // Ajouter la catégorie comme optgroup
                    optgroups.push({
                        value: category,
                        label: category
                    });
                    
                    // Ajouter chaque poste comme option
                    positions.forEach(position => {
                        options.push({
                            value: position,
                            text: position,
                            optgroup: category
                        });
                    });
                });
                
                // Initialiser Tom Select
                new TomSelect('#position', {
                    valueField: 'value',
                    labelField: 'text',
                    searchField: 'text',
                    options: options,
                    optgroups: optgroups,
                    optgroupField: 'optgroup',
                    optgroupLabelField: 'label',
                    optgroupValueField: 'value',
                    placeholder: "Sélectionnez un poste",
                    create: false,
                    render: {
                        optgroup_header: function(data, escape) {
                            return '<div class="optgroup-header">' + escape(data.label) + '</div>';
                        }
                    }
                });
            })
            .catch(error => console.error('Erreur lors du chargement des postes:', error));
            });
    </script>
</x-app-layout>
