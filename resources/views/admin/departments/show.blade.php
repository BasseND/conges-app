<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900">
        <!-- En-tête moderne -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-b border-gray-200/50 dark:border-gray-700/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $department->name }}</h1>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">Gestion du département et des équipes</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.departments.edit', $department) }}" 
                           class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier
                        </a>
                        <a href="{{ route('admin.departments.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Messages de notification -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="text-red-800 dark:text-red-200">{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            
            <!-- Informations du département -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 mb-8">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg mr-4">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Informations du Département</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200/50 dark:border-blue-800/50">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-tag text-blue-500 mr-3"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nom du département</span>
                            </div>
                            <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $department->name }}</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-6 border border-emerald-200/50 dark:border-emerald-800/50">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-user-tie text-emerald-500 mr-3"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Chef du département</span>
                            </div>
                            <p class="text-xl font-semibold text-gray-900 dark:text-white">
                                @if($department->head)
                                    {{ $department->head->name }}
                                @else
                                    <span class="text-amber-600 dark:text-amber-400 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Aucun chef assigné
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Section des équipes -->
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50">
                        <div class="p-8">
                            <!-- En-tête de la section équipes -->
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg mr-4">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Équipes</h2>
                                        <p class="text-gray-600 dark:text-gray-300">{{ $department->teams->count() }} équipe(s) dans ce département</p>
                                    </div>
                                </div>
                                <button onclick="openTeamModal()" 
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter une équipe
                                </button>
                            </div>
                    
                            @if($department->teams->count() > 0)
                                <!-- Tableau moderne des équipes -->
                                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                                    <!-- En-tête du tableau -->
                                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <i class="fas fa-table text-gray-500 dark:text-gray-400 mr-3"></i>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Liste des équipes</h3>
                                        </div>
                                    </div>
                                    
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-800">
                                                <tr>
                                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-tag text-gray-400 mr-2"></i>
                                                            Nom de l'équipe
                                                        </div>
                                                    </th>
                                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-user-tie text-gray-400 mr-2"></i>
                                                            Responsable
                                                        </div>
                                                    </th>
                                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-users text-gray-400 mr-2"></i>
                                                            Membres
                                                        </div>
                                                    </th>
                                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                        <div class="flex items-center justify-end">
                                                            <i class="fas fa-cogs text-gray-400 mr-2"></i>
                                                            Actions
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                                @foreach($department->teams as $team)
                                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg mr-3">
                                                                    <i class="fas fa-users text-white text-sm"></i>
                                                                </div>
                                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $team->name }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full mr-3 text-white text-xs font-semibold">
                                                                    {{ strtoupper(substr($team->manager->name, 0, 2)) }}
                                                                </div>
                                                                <span class="text-sm text-gray-900 dark:text-white">{{ $team->manager->name }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                                    <i class="fas fa-user mr-1"></i>
                                                                    {{ $team->members->count() }} membre(s)
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                                            <div class="flex items-center justify-end space-x-2">
                                                                <button type="button" 
                                                                        onclick="editTeam({{ $team->id }})" 
                                                                        class="inline-flex items-center px-3 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg text-sm hover:bg-blue-200 dark:hover:bg-blue-800 transition-all duration-200">
                                                                        <i class="fas fa-edit mr-1"></i>
                                                                        Modifier
                                                                    </button>
                                                                    <button type="button" 
                                                                            @click="$dispatch('open-delete-modal', { teamId: {{ $team->id }}, teamName: '{{ $team->name }}' })"
                                                                            class="inline-flex items-center px-3 py-2 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg text-sm hover:bg-red-200 dark:hover:bg-red-800 transition-all duration-200">
                                                                        <i class="fas fa-trash-alt mr-1"></i>
                                                                        Supprimer
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <!-- État vide -->
                                    <div class="text-center py-16">
                                        <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-full mx-auto mb-6">
                                            <i class="fas fa-users text-gray-400 dark:text-gray-500 text-2xl"></i>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aucune équipe</h3>
                                        <p class="text-gray-600 dark:text-gray-400 mb-6">Ce département n'a pas encore d'équipes. Commencez par en créer une.</p>
                                        <button onclick="openTeamModal()" 
                                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                            <i class="fas fa-plus mr-2"></i>
                                            Créer la première équipe
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal moderne pour ajouter/modifier une équipe -->
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
                @keydown.escape.window="open = false"
                class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;">
                
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
                     @click.self="open = false">
                    <!-- Fond sombre avec effet de flou -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
                    </div>

                    <!-- Contenu du modal moderne -->
                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border-0">
                        <!-- En-tête du modal -->
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg mr-3">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-white" x-text="isEdit ? 'Modifier l\'équipe' : 'Ajouter une équipe'"></h3>
                                </div>
                                <button type="button" @click="open = false" 
                                        class="text-white/80 hover:text-white transition-colors">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                        </div>
                        
                        <form id="teamForm" x-bind:action="isEdit ? '/admin/departments/{{ $department->id }}/teams/' + teamId : '/admin/departments/{{ $department->id }}/teams'" method="POST" class="p-6">
                            @csrf
                            <input type="hidden" name="_method" x-bind:value="isEdit ? 'PUT' : 'POST'">
                            <input type="hidden" name="department_id" value="{{ $department->id }}">

                            <div class="space-y-6">
                                <!-- Nom de l'équipe -->
                                <div>
                                    <label for="name" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                        <i class="fas fa-tag text-gray-400 mr-2"></i>
                                        Nom de l'équipe
                                    </label>
                                    <input type="text" name="name" id="name" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                           placeholder="Entrez le nom de l'équipe" required>
                                </div>

                                <!-- Responsable -->
                                <div>
                                    <label for="manager_id" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                        <i class="fas fa-user-tie text-gray-400 mr-2"></i>
                                        Responsable
                                    </label>
                                    <select name="manager_id" id="manager_id" 
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" required>
                                        <option value="">Sélectionner un responsable</option>
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Membres de l'équipe -->
                                <div>
                                    <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                        <i class="fas fa-users text-gray-400 mr-2"></i>
                                        Membres de l'équipe
                                    </label>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-300 dark:border-gray-600 p-4 max-h-60 overflow-y-auto">
                                        <div class="space-y-3">
                                            @foreach($users as $user)
                                                <div class="flex items-center p-2 hover:bg-white dark:hover:bg-gray-600 rounded-lg transition-colors">
                                                    <input type="checkbox" 
                                                           name="members[]" 
                                                           id="member-{{ $user->id }}" 
                                                           value="{{ $user->id }}"
                                                           class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                                    <label for="member-{{ $user->id }}" class="ml-3 flex items-center cursor-pointer flex-1">
                                                        <div class="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mr-3 text-white text-xs font-semibold">
                                                            {{ strtoupper(substr($user->first_name, 0, 2)) }}
                                                        </div>
                                                        <span class="text-sm text-gray-900 dark:text-white font-medium">{{ $user->first_name }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Sélectionnez les membres qui feront partie de cette équipe
                                    </p>
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-600">
                                <button type="button" @click="open = false" 
                                        class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                                    <i class="fas fa-times mr-2"></i>
                                    Annuler
                                </button>
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl font-medium">
                                    <i class="fas fa-save mr-2"></i>
                                    <span x-text="isEdit ? 'Mettre à jour' : 'Ajouter'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal moderne de confirmation de suppression -->
            <div x-data="{
                    openDelete: false,
                    teamToDelete: null,
                    teamName: '',
                    isDeleting: false,

                    async confirmDelete() {
                        if (this.isDeleting) return;
                        
                        this.isDeleting = true;
                        try {
                            const response = await fetch(`/admin/departments/{{ $department->id }}/teams/${this.teamToDelete}`, {
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
                        } finally {
                            this.isDeleting = false;
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
                    <!-- Fond sombre avec effet de flou -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
                    </div>

                    <!-- Contenu du modal moderne -->
                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border-0">
                        <!-- En-tête du modal avec icône d'alerte -->
                        <div class="bg-gradient-to-r from-red-500 to-pink-600 px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg mr-3">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white">
                                    Confirmer la suppression
                                </h3>
                            </div>
                        </div>
                        
                        <!-- Contenu du modal -->
                        <div class="p-6">
                            <div class="flex items-start">
                                <div class="flex items-center justify-center w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-xl mr-4 flex-shrink-0">
                                    <i class="fas fa-trash-alt text-red-600 dark:text-red-400 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Supprimer l'équipe
                                    </h4>
                                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-4">
                                        <p class="text-sm text-red-800 dark:text-red-200">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            Vous êtes sur le point de supprimer l'équipe <span x-text="teamName" class="font-bold"></span>.
                                        </p>
                                    </div>
                                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex items-center">
                                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                            <span>Cette action est <strong>irréversible</strong></span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-users text-orange-500 mr-2"></i>
                                            <span>Tous les membres seront retirés de l'équipe</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-database text-purple-500 mr-2"></i>
                                            <span>Les données associées seront supprimées</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Boutons d'action -->
                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-end space-x-3">
                            <button type="button" 
                                    @click="openDelete = false"
                                    :disabled="isDeleting"
                                    class="px-6 py-3 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-500 transition-all duration-200 font-medium disabled:opacity-50">
                                <i class="fas fa-times mr-2"></i>
                                Annuler
                            </button>
                            <button type="button" 
                                    @click="confirmDelete()"
                                    :disabled="isDeleting"
                                    class="px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-xl hover:from-red-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-spinner fa-spin mr-2" x-show="isDeleting"></i>
                                <i class="fas fa-trash-alt mr-2" x-show="!isDeleting"></i>
                                <span x-text="isDeleting ? 'Suppression...' : 'Supprimer définitivement'"></span>
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
                    const departmentId = {{ $department->id }};
                    const url = `/admin/departments/${departmentId}/teams/${teamId}/edit`;
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
                            
                            fetch(`/admin/departments/{{ $department->id }}/teams/${teamId}`, {
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
