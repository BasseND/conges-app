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

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            {{ $department->name }}
                        </h3>
                    </div>

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
                                            <button type="button" onclick="deleteTeam({{ $team->id }})" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md text-sm hover:bg-red-200 ml-2">
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
                                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                        console.log('Valeurs mises à jour dans le formulaire');
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

                function deleteTeam(teamId) {
                    console.log('Début deleteTeam - ID:', teamId);
                    
                    if (confirm('Êtes-vous sûr de vouloir supprimer cette équipe ?')) {
                        console.log('Confirmation acceptée');
                        const url = `/admin/teams/${teamId}`;
                        console.log('URL de la requête:', url);

                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            console.log('Réponse reçue:', response.status);
                            if (!response.ok) {
                                return response.json().then(json => {
                                    console.error('Erreur serveur:', json);
                                    return Promise.reject(json);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Données reçues:', data);
                            if (data.success) {
                                console.log('Suppression réussie, rechargement de la page');
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Erreur détaillée:', error);
                            console.error('Stack trace:', error.stack);
                            alert(error.error || 'Une erreur est survenue lors de la suppression de l\'équipe.');
                        });
                    } else {
                        console.log('Suppression annulée par l\'utilisateur');
                    }
                }

                // Ajouter un log pour vérifier que le script est bien chargé
                console.log('Script de gestion des équipes chargé');
            </script>
            @endpush
        </div>
    </div>
</x-app-layout>
