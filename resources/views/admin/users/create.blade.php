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
                            {{ __('Solde de congés') }}
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="leave_balance_id" :value="__('Profil de congés')" />
                                <select id="leave_balance_id" name="leave_balance_id" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Utiliser le solde par défaut de l'entreprise</option>
                                </select>
                                <x-input-error :messages="$errors->get('leave_balance_id')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Laissez vide pour utiliser automatiquement le solde par défaut de l'entreprise de l'utilisateur.
                                </p>
                            </div>
                            
                            <!-- Affichage des détails du solde sélectionné -->
                            <div id="leave_balance_details" class="hidden bg-gray-50 dark:bg-gray-800 p-4 rounded-md">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Détails du solde :</h3>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-2 text-sm">
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Congés annuels :</span>
                                        <span id="detail_annual" class="font-medium">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Congés maladie :</span>
                                        <span id="detail_sick" class="font-medium">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Congés maternité :</span>
                                        <span id="detail_maternity" class="font-medium">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Congés paternité :</span>
                                        <span id="detail_paternity" class="font-medium">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Congés spéciaux :</span>
                                        <span id="detail_special" class="font-medium">-</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Champs individuels (optionnels pour compatibilité) -->
                            <div class="hidden">
                                <input type="hidden" id="annual_leave_days" name="annual_leave_days" value="{{ old('annual_leave_days', 25) }}" />
                                <input type="hidden" id="sick_leave_days" name="sick_leave_days" value="{{ old('sick_leave_days', 12) }}" />
                                <input type="hidden" id="maternity_leave_days" name="maternity_leave_days" value="{{ old('maternity_leave_days', 90) }}" />
                                <input type="hidden" id="paternity_leave_days" name="paternity_leave_days" value="{{ old('paternity_leave_days', 14) }}" />
                                <input type="hidden" id="special_leave_days" name="special_leave_days" value="{{ old('special_leave_days', 5) }}" />
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
        
        function loadLeaveBalances(departmentId) {
            console.log('Chargement des soldes de congés pour le département:', departmentId);
            
            const leaveBalanceSelect = document.getElementById('leave_balance_id');
            const detailsDiv = document.getElementById('leave_balance_details');
            
            // Réinitialiser
            leaveBalanceSelect.innerHTML = '<option value="">Utiliser le solde par défaut de l\'entreprise</option>';
            detailsDiv.classList.add('hidden');
            
            if (!departmentId) {
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = `/admin/departments/${departmentId}/leave-balances`;

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
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(leaveBalances => {
                console.log('Soldes de congés reçus:', leaveBalances);
                
                if (Array.isArray(leaveBalances) && leaveBalances.length > 0) {
                    leaveBalances.forEach(balance => {
                        const option = document.createElement('option');
                        option.value = balance.id;
                        option.textContent = balance.description || `Solde ${balance.is_default ? '(Défaut)' : 'Personnalisé'}`;
                        option.dataset.annual = balance.annual_leave_days;
                        option.dataset.sick = balance.sick_leave_days;
                        option.dataset.maternity = balance.maternity_leave_days;
                        option.dataset.paternity = balance.paternity_leave_days;
                        option.dataset.special = balance.special_leave_days;
                        leaveBalanceSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des soldes de congés:', error);
            });
        }
        
        function showLeaveBalanceDetails(selectElement) {
            const detailsDiv = document.getElementById('leave_balance_details');
            const selectedOption = selectElement.selectedOptions[0];
            
            if (selectedOption && selectedOption.value) {
                // Afficher les détails
                document.getElementById('detail_annual').textContent = selectedOption.dataset.annual + ' jours';
                document.getElementById('detail_sick').textContent = selectedOption.dataset.sick + ' jours';
                document.getElementById('detail_maternity').textContent = selectedOption.dataset.maternity + ' jours';
                document.getElementById('detail_paternity').textContent = selectedOption.dataset.paternity + ' jours';
                document.getElementById('detail_special').textContent = selectedOption.dataset.special + ' jours';
                detailsDiv.classList.remove('hidden');
                
                // Mettre à jour les champs cachés
                document.getElementById('annual_leave_days').value = selectedOption.dataset.annual;
                document.getElementById('sick_leave_days').value = selectedOption.dataset.sick;
            } else {
                detailsDiv.classList.add('hidden');
                // Remettre les valeurs par défaut
                document.getElementById('annual_leave_days').value = 25;
                document.getElementById('sick_leave_days').value = 12;
            }
        }
        


        // Attacher l'événement une fois que le DOM est chargé
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page chargée, initialisation des événements');
            
            // Attacher l'événement change au select département
            const departmentSelect = document.getElementById('department_id');
            departmentSelect.addEventListener('change', function() {
                loadTeams(this.value);
                loadLeaveBalances(this.value);
            });
            
            // Gestionnaire d'événement pour le changement de solde de congés
            document.getElementById('leave_balance_id').addEventListener('change', function() {
                showLeaveBalanceDetails(this);
            });

            // Charger les équipes et soldes si un département est déjà sélectionné
            if (departmentSelect.value) {
                console.log('Département pré-sélectionné:', departmentSelect.value);
                loadTeams(departmentSelect.value);
                loadLeaveBalances(departmentSelect.value);
            }

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
