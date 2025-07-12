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
            <div class="bg-gradient-to-r from-green-500 to-green-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white" x-text="isEdit ? 'Modifier l\'équipe' : 'Ajouter une équipe'"></h3>
                    </div>
                    <button type="button" @click="open = false" 
                            class="text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
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
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                            Nom de l'équipe
                        </label>
                        <input type="text" name="name" id="name" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                placeholder="Entrez le nom de l'équipe" required>
                    </div>

                    <!-- Responsable -->
                    <div>
                        <label for="manager_id" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
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
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
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
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Sélectionnez les membres qui feront partie de cette équipe
                        </p>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" @click="open = false" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Annuler
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"></path>
                        </svg>
                        <span x-text="isEdit ? 'Mettre à jour' : 'Ajouter'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>