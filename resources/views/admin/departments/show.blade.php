<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Département') }} : {{ $department->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Section des équipes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Departement Info --}}
                    <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Informations du Département</h2>
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
                        <h3 class="text-lg font-semibold">Équipes</h3>
                        <button onclick="openTeamModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Ajouter une équipe
                        </button>
                    </div>

                    <!-- Liste des équipes -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Membres</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($department->teams as $team)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $team->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $team->manager->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $team->members->count() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <button onclick="editTeam({{ $team->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</button>
                                            <button onclick="deleteTeam({{ $team->id }})" class="text-red-600 hover:text-red-900">Supprimer</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal pour ajouter/modifier une équipe -->
            <div id="teamModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4" id="modalTitle">Ajouter une équipe</h3>
                        <form id="teamForm" class="space-y-4">
                            @csrf
                            <input type="hidden" id="teamId" name="teamId">
                            <input type="hidden" name="department_id" value="{{ $department->id }}">
                            
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'équipe</label>
                                <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="manager_id" class="block text-sm font-medium text-gray-700">Responsable</label>
                                <select name="manager_id" id="manager_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Sélectionner un responsable</option>
                                </select>
                            </div>

                            <div class="flex justify-end mt-4">
                                <button type="button" onclick="closeTeamModal()" class="mr-2 px-4 py-2 text-gray-500 hover:text-gray-700">Annuler</button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let isEditing = false;

        function openTeamModal() {
            isEditing = false;
            document.getElementById('modalTitle').textContent = 'Ajouter une équipe';
            document.getElementById('teamForm').reset();
            document.getElementById('teamId').value = '';
            loadManagers();
            document.getElementById('teamModal').classList.remove('hidden');
        }

        function closeTeamModal() {
            document.getElementById('teamModal').classList.add('hidden');
        }

        function loadManagers() {
            fetch(`/admin/departments/{{ $department->id }}/managers`)
                .then(response => response.json())
                .then(managers => {
                    const select = document.getElementById('manager_id');
                    select.innerHTML = '<option value="">Sélectionner un responsable</option>';
                    managers.forEach(manager => {
                        const option = document.createElement('option');
                        option.value = manager.id;
                        option.textContent = manager.name;
                        select.appendChild(option);
                    });
                });
        }

        function editTeam(teamId) {
            isEditing = true;
            document.getElementById('modalTitle').textContent = 'Modifier l\'équipe';
            document.getElementById('teamId').value = teamId;
            
            // Charger les données de l'équipe
            const team = @json($department->teams);
            const currentTeam = team.find(t => t.id === teamId);
            
            if (currentTeam) {
                document.getElementById('name').value = currentTeam.name;
                loadManagers().then(() => {
                    document.getElementById('manager_id').value = currentTeam.manager_id;
                });
            }
            
            document.getElementById('teamModal').classList.remove('hidden');
        }

        function deleteTeam(teamId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette équipe ?')) {
                fetch(`/admin/teams/${teamId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.reload();
                    }
                });
            }
        }

        document.getElementById('teamForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const teamId = document.getElementById('teamId').value;
            
            const url = isEditing ? `/admin/teams/${teamId}` : '/admin/teams';
            const method = isEditing ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData)),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.reload();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
