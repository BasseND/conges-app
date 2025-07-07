<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold pb-5 text-bgray-900 dark:text-white">
            {{ __('Modifier l\'utilisateur') }}
        </h2>
    </x-slot>

    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <x-input-label for="first_name" :value="__('Nom')" />
                        <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name', $user->first_name)" required autofocus />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="last_name" :value="__('Prénom')" />
                        <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name', $user->last_name)" required autofocus />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('Numéro de téléphone')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $user->phone)" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Nouveau mot de passe (laisser vide pour ne pas changer)')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirmer le nouveau mot de passe')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <x-input-label for="role" :value="__('Rôle')" />
                        <select id="role" name="role" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Sélectionner un rôle</option>
                            <option value="{{ App\Models\User::ROLE_EMPLOYEE }}" {{ $user->role === App\Models\User::ROLE_EMPLOYEE ? 'selected' : '' }}>Employé</option>
                            <option value="{{ App\Models\User::ROLE_MANAGER }}" {{ $user->role === App\Models\User::ROLE_MANAGER ? 'selected' : '' }}>Manager</option>
                            <option value="{{ App\Models\User::ROLE_DEPARTMENT_HEAD }}" {{ $user->role === App\Models\User::ROLE_DEPARTMENT_HEAD ? 'selected' : '' }}>Chef de Département</option>
                            <option value="{{ App\Models\User::ROLE_HR }}" {{ $user->role === App\Models\User::ROLE_HR ? 'selected' : '' }}>Ressources Humaines</option>
                            <option value="{{ App\Models\User::ROLE_ADMIN }}" {{ $user->role === App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Administrateur</option>
                        </select>
                        
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="department_id" :value="__('Département')" />
                        <select id="department_id" name="department_id" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Sélectionner un département</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                    </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <x-input-label for="team_id" :value="__('Équipe')" />
                            <select id="team_id" name="team_id" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Sélectionner une équipe</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ $user->teams->contains($team->id) ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('team_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="leave_balance_id" :value="__('Solde de congés')" />
                            <select id="leave_balance_id" name="leave_balance_id" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Utiliser le solde par défaut de l'entreprise</option>
                            </select>
                            <x-input-error :messages="$errors->get('leave_balance_id')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Affichage des détails du solde de congés sélectionné -->
                    <div id="leave_balance_details" class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg" style="display: none;">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Détails du solde de congés :</h4>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm">
                            <div>
                                <span class="font-medium">Congés annuels :</span>
                                <span id="balance_annual_days" class="text-blue-600 dark:text-blue-400">-</span> jours
                            </div>
                            <div>
                                <span class="font-medium">Congés maladie :</span>
                                <span id="balance_sick_days" class="text-green-600 dark:text-green-400">-</span> jours
                            </div>
                            <div>
                                <span class="font-medium">Congés maternité :</span>
                                <span id="balance_maternity_days" class="text-pink-600 dark:text-pink-400">-</span> jours
                            </div>
                            <div>
                                <span class="font-medium">Congés paternité :</span>
                                <span id="balance_paternity_days" class="text-purple-600 dark:text-purple-400">-</span> jours
                            </div>
                            <div>
                                <span class="font-medium">Congés spéciaux :</span>
                                <span id="balance_special_days" class="text-orange-600 dark:text-orange-400">-</span> jours
                            </div>
                        </div>
                    </div>



                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                    </div>

                    <div class="flex items-center justify-end mt-4 gap-2">
                        <a href="{{ route('admin.users.index') }}" class="mr-2 inline-flex items-center btn btn-secondary">
                            {{ __('Annuler') }}
                        </a>
                        <x-primary-button class="btn btn-primary">
                            {{ __('Mettre à jour') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    console.log('Script chargé');
    
    function loadTeams(departmentId, selectedTeamId = null) {
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
                    if (selectedTeamId && team.id == selectedTeamId) {
                        option.selected = true;
                    }
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

    function loadLeaveBalances(departmentId, selectedLeaveBalanceId = null) {
        console.log('Chargement des soldes de congés pour le département:', departmentId);
        
        const select = document.getElementById('leave_balance_id');
        select.innerHTML = '<option value="">Utiliser le solde par défaut de l\'entreprise</option>';
        
        if (!departmentId) {
            console.log('Aucun département sélectionné');
            hideLeaveBalanceDetails();
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
            
            if (Array.isArray(leaveBalances)) {
                leaveBalances.forEach(balance => {
                    const option = document.createElement('option');
                    option.value = balance.id;
                    option.textContent = balance.description || `Solde ${balance.is_default ? 'par défaut' : 'personnalisé'}`;
                    option.dataset.balance = JSON.stringify(balance);
                    if (selectedLeaveBalanceId && balance.id == selectedLeaveBalanceId) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
                console.log('Liste des soldes de congés mise à jour');
                
                // Afficher les détails si un solde est sélectionné
                if (selectedLeaveBalanceId) {
                    const selectedOption = select.querySelector(`option[value="${selectedLeaveBalanceId}"]`);
                    if (selectedOption && selectedOption.dataset.balance) {
                        showLeaveBalanceDetails(JSON.parse(selectedOption.dataset.balance));
                    }
                }
            } else {
                console.error('Format de données invalide:', leaveBalances);
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des soldes de congés:', error);
        });
    }

    function showLeaveBalanceDetails(balance) {

        document.getElementById('balance_maternity_days').textContent = balance.maternity_leave_days;
        document.getElementById('balance_paternity_days').textContent = balance.paternity_leave_days;
        document.getElementById('balance_special_days').textContent = balance.special_leave_days;
        
        // Mettre à jour les champs cachés
        document.getElementById('maternity_leave_days').value = balance.maternity_leave_days;
        document.getElementById('paternity_leave_days').value = balance.paternity_leave_days;
        document.getElementById('special_leave_days').value = balance.special_leave_days;
        
        document.getElementById('leave_balance_details').style.display = 'block';
    }

    function hideLeaveBalanceDetails() {
        document.getElementById('leave_balance_details').style.display = 'none';
    }

    // Attacher l'événement une fois que le DOM est chargé
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page chargée, initialisation des événements');
        
        const departmentSelect = document.getElementById('department_id');
        const leaveBalanceSelect = document.getElementById('leave_balance_id');
        
        // Événement pour le changement de département
        departmentSelect.addEventListener('change', function() {
            loadTeams(this.value);
            loadLeaveBalances(this.value);
        });
        
        // Événement pour le changement de solde de congés
        leaveBalanceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value && selectedOption.dataset.balance) {
                showLeaveBalanceDetails(JSON.parse(selectedOption.dataset.balance));
            } else {
                hideLeaveBalanceDetails();
            }
        });
        
        // Charger les données initiales si un département est déjà sélectionné
        if (departmentSelect.value) {
            const currentLeaveBalanceId = {{ $user->leave_balance_id ?? 'null' }};
            loadLeaveBalances(departmentSelect.value, currentLeaveBalanceId);
        //     console.log('Département pré-sélectionné:', departmentSelect.value);
        //     // Passer l'ID de l'équipe actuelle pour la sélectionner
        //     loadTeams(departmentSelect.value, {{ $user->team_id ?? 'null' }});
        // }
    });
</script>
