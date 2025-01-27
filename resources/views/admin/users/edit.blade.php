<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier l\'utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                       
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <x-input-label for="name" :value="__('Nom')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        </div>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

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

                        {{-- <div>
                            <x-input-label for="team_id" :value="__('Équipe')" />
                            <select id="team_id" name="team_id" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Sélectionner une équipe</option>
                            </select>
                            <x-input-error :messages="$errors->get('team_id')" class="mt-2" />
                        </div> --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <x-input-label for="annual_leave_days" :value="__('Jours de congés annuels')" />
                                <x-text-input id="annual_leave_days" class="block mt-1 w-full" type="number" name="annual_leave_days" :value="old('annual_leave_days', $user->annual_leave_days)" required />
                                <x-input-error :messages="$errors->get('annual_leave_days')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="sick_leave_days" :value="__('Jours de congés maladie')" />
                                <x-text-input id="sick_leave_days" class="block mt-1 w-full" type="number" name="sick_leave_days" :value="old('sick_leave_days', $user->sick_leave_days)" required />
                                <x-input-error :messages="$errors->get('sick_leave_days')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                {{ __('Annuler') }}
                            </a>
                            <x-primary-button class="bg-green-500 hover:bg-green-700 focus:bg-green-700 focus:ring-green-500">
                                {{ __('Mettre à jour') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
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

    // Attacher l'événement une fois que le DOM est chargé
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page chargée, initialisation des événements');
        
        // Attacher l'événement change au select département
        // const departmentSelect = document.getElementById('department_id');
        // departmentSelect.addEventListener('change', function() {
        //     loadTeams(this.value);
        // });

        // // Charger les équipes si un département est déjà sélectionné
        // if (departmentSelect.value) {
        //     console.log('Département pré-sélectionné:', departmentSelect.value);
        //     // Passer l'ID de l'équipe actuelle pour la sélectionner
        //     loadTeams(departmentSelect.value, {{ $user->team_id ?? 'null' }});
        // }
    });
</script>
