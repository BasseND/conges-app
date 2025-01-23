<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Département') }} : {{ $department->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Section des équipes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    {{-- Departement Info --}}
                    <div class="bg-blue-50 dark:bg-blue-900 dark:text-blue-200 p-4 rounded-lg mb-6 border border-blue-200 dark:border-blue-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Informations du Département</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nom du département</p>
                                <p class="text-lg font-medium">{{ $department->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Chef du département</p>
                                <p class="text-lg font-medium">
                                    @if($department->head)
                                        {{ $department->head->name }}
                                    @else
                                        <span class="text-yellow-600">Aucun chef assigné</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            {{ $department->name }}
                        </h3>
                    </div> --}}

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Équipes</h3>
                        <button onclick="openTeamModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Ajouter une équipe
                        </button>
                    </div>

                    <!-- Liste des équipes -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Responsable</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Membres</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach($department->teams as $team)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $team->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $team->manager->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $team->members->count() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                           
                                            <button type="button" onclick="editTeam({{ $team->id }})" class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-md text-sm hover:bg-indigo-200">
                                                <i class="fas fa-edit mr-1"></i> Modifier
                                            </button>
                                            {{-- <button type="button" onclick="deleteTeam({{ $team->id }}, '{{ $team->name }}')"  class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md text-sm hover:bg-red-200 ml-2">
                                                <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                            </button> --}}

                                            <button type="button" 
                                                    @click="$dispatch('open-delete-modal', { teamId: {{ $team->id }}, teamName: '{{ $team->name }}' })"
                                                    class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md text-sm hover:bg-red-200 ml-2">
                                                <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal pour ajouter/modifier une équipe -->
            <div x-data="{ 
                    open: false, 
                    teamId: null, 
                    isEdit: false,
                    init() {
                        console.log('Modal initialisé');
                        window.addEventListener('open-team-modal', (event) => {
                            console.log('Événement open-team-modal reçu', event.detail);
                            this.teamId = event.detail?.teamId;
                            this.isEdit = !!event.detail?.teamId;
                            this.open = true;
                        });
                    }
                }"
                x-show="open"
                x-cloak
                class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;">
                
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Fond sombre -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Contenu du modal -->
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form id="teamForm" x-bind:action="isEdit ? '/admin/teams/' + teamId : '/admin/teams'" method="POST" class="p-6">
                            @csrf
                            <template x-if="isEdit">
                                @method('PUT')
                            </template>

                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900" x-text="isEdit ? 'Modifier l\'équipe' : 'Ajouter une équipe'"></h3>
                                </div>

                                <input type="hidden" name="department_id" value="{{ $department->id }}">

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'équipe</label>
                                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>

                                <div>
                                    <label for="manager_id" class="block text-sm font-medium text-gray-700">Responsable</label>
                                    <select name="manager_id" id="manager_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Sélectionner un responsable</option>
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Membres de l'équipe</label>
                                    <div class="mt-1 max-h-60 overflow-y-auto border border-gray-300 rounded-md p-2">
                                        <div class="space-y-2">
                                            @foreach($users as $user)
                                                <div class="flex items-center">
                                                    <input type="checkbox" 
                                                           name="members[]" 
                                                           id="member-{{ $user->id }}" 
                                                           value="{{ $user->id }}"
                                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                    <label for="member-{{ $user->id }}" class="ml-2 block text-sm text-gray-900">
                                                        {{ $user->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                                    <span x-text="isEdit ? 'Mettre à jour' : 'Ajouter'"></span>
                                </button>
                                <button type="button" x-on:click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de confirmation de suppression -->
            <!-- Modal de confirmation de suppression -->
            <div x-data="{
                    openDelete: false,
                    teamToDelete: null,
                    teamName: '',

                    
                    async confirmDelete() {
                        try {
                            const response = await fetch(`/admin/teams/${this.teamToDelete}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });
                            
                            const data = await response.json();
                            
                            if (!response.ok) {
                                throw new Error(data.error || 'Une erreur est survenue');
                            }
                            
                            if (data.success) {
                                this.openDelete = false;
                                window.location.reload();
                            }
                        } catch (error) {
                            console.error('Erreur lors de la suppression:', error);
                            alert(error.message || 'Une erreur est survenue lors de la suppression de l\'équipe.');
                            this.openDelete = false;
                        }
                    }


                }"
                @open-delete-modal.window="
                    teamToDelete = $event.detail.teamId;
                    teamName = $event.detail.teamName;
                    openDelete = true;
                "
                x-show="openDelete"
                x-cloak
                @keydown.escape.window="openDelete = false"
                class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;">
                
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
                     @click.self="openDelete = false">
                    <!-- Fond sombre -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Contenu du modal -->
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Supprimer l'équipe
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Êtes-vous sûr de vouloir supprimer l'équipe <span x-text="teamName" class="font-semibold"></span> ? Cette action est irréversible.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" 
                                    @click="confirmDelete()"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Supprimer
                            </button>
                            <button type="button" 
                                    @click="openDelete = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>

          
                                    

            @push('styles')
            <style>
                [x-cloak] { display: none !important; }
            </style>
            @endpush

            @push('scripts')
            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
            <script>
              
                function openTeamModal() {
                    console.log('Ouverture du modal pour ajout d\'équipe');
                    // Réinitialiser le formulaire
                    document.getElementById('name').value = '';
                    document.getElementById('manager_id').value = '';
                    
                    // Décocher toutes les checkboxes
                    document.querySelectorAll('input[name="members[]"]').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    
                    window.dispatchEvent(new CustomEvent('open-team-modal', {
                        detail: { teamId: null }
                    }));
                }

                function editTeam(teamId) {
                    console.log('Début editTeam - ID:', teamId);
                    const url = `/admin/teams/${teamId}/edit`;
                    console.log('URL de la requête:', url);

                    fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('Réponse reçue:', response.status);
                        if (!response.ok) {
                            throw new Error(`Erreur HTTP: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Données reçues:', data);
                        document.getElementById('name').value = data.name;
                        document.getElementById('manager_id').value = data.manager_id;
                        
                        // Mettre à jour les checkboxes des membres
                        document.querySelectorAll('input[name="members[]"]').forEach(checkbox => {
                            checkbox.checked = data.members.includes(parseInt(checkbox.value));
                        });
                        
                        window.dispatchEvent(new CustomEvent('open-team-modal', {
                            detail: { teamId: teamId }
                        }));
                        console.log('Modal ouvert avec ID:', teamId);
                    })
                    .catch(error => {
                        console.error('Erreur détaillée:', error);
                        console.error('Stack trace:', error.stack);
                        alert('Une erreur est survenue lors du chargement des données de l\'équipe.');
                    });
                }

               // Définition du composant modal de suppression
                function deleteModal() {
                    return {
                        openDelete: false,
                        teamToDelete: null,
                        teamName: '',
                        showModal(detail) {
                            this.teamToDelete = detail.teamId;
                            this.teamName = detail.teamName;
                            this.openDelete = true;
                        },
                        confirmDelete() {
                            const teamId = this.teamToDelete;
                            console.log('Confirmation de suppression - ID:', teamId);
                            
                            fetch(`/admin/teams/${teamId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(json => Promise.reject(json));
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    this.openDelete = false;
                                    window.location.reload();
                                }
                            })
                            .catch(error => {
                                console.error('Erreur lors de la suppression:', error);
                                alert(error.error || 'Une erreur est survenue lors de la suppression de l\'équipe.');
                                this.openDelete = false;
                            });
                        }
                    }
                }

                // Fonction pour ouvrir le modal de suppression
                function deleteTeam(teamId, teamName) {
                    console.log('Ouverture du modal de suppression - ID:', teamId);
                    console.log('Ouverture du modal de suppression - Nom:', teamName);
                    window.dispatchEvent(new CustomEvent('show-delete-modal', {
                        detail: {
                            teamId: teamId,
                            teamName: teamName
                        }
                    }));
                }

                // Ajouter un log pour vérifier que le script est bien chargé
                console.log('Script de gestion des équipes chargé');
            </script>
            @endpush
        </div>
    </div>
</x-app-layout>
