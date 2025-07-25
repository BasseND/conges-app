@props(['user'])

<x-modal name="edit-personal-info" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <div class="bg-white dark:bg-gray-800 rounded-xl px-6 pt-6 pb-6 text-left overflow-hidden transform transition-all sm:align-middle sm:max-w-4xl sm:w-full">
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100" id="modal-title">
                            Modifier les informations personnelles
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Mettre à jour les données de l'utilisateur
                        </p>
                    </div>
                </div>
            </div>
       
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white dark:bg-gray-800">
        @csrf
        @method('PUT')
        <input type="hidden" name="source" value="modal">
        
            <!-- Block erreurs modernisé -->
            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                Erreurs de validation
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Carte des informations personnelles -->
            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-6 border border-green-200 dark:border-green-800 mb-6">
                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informations personnelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Prénom -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prénom</label>
                        <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required autofocus>
                        <x-input-error class="mt-1" :messages="$errors->get('first_name')" />
                    </div>

                    <!-- Nom -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom</label>
                        <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required>
                        <x-input-error class="mt-1" :messages="$errors->get('last_name')" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required>
                        <x-input-error class="mt-1" :messages="$errors->get('email')" />
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Téléphone</label>
                        <input type="text" id="phone" name="phone" value="{{ $user->phone }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                        <x-input-error class="mt-1" :messages="$errors->get('phone')" />
                    </div>

                    <!-- Poste actuel -->
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Poste actuel</label>
                        <input type="text" id="position" name="position" value="{{ $user->position }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required>
                        <x-input-error class="mt-1" :messages="$errors->get('position')" />
                    </div>

                    <!-- Genre -->
                     <div>
                         <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sexe</label>
                         <select id="gender" name="gender" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required>
                             <option value="">Sélectionner un sexe</option>
                             <option value="M" {{ old('gender', $user->gender) === 'M' ? 'selected' : '' }}>Homme</option>
                             <option value="F" {{ old('gender', $user->gender) === 'F' ? 'selected' : '' }}>Femme</option>
                         </select>
                         <x-input-error class="mt-1" :messages="$errors->get('gender')" />
                     </div>

                     <!-- Is prestataire -->
                     <div>
                         <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Statut prestataire</label>
                         <div class="flex items-center space-x-3">
                             <input type="checkbox" class="peer sr-only opacity-0" id="is_prestataire" name="is_prestataire" {{ old('is_prestataire', $user->is_prestataire ?? false) ? 'checked' : '' }} />
                             <label for="is_prestataire" class="relative flex h-6 w-11 cursor-pointer items-center rounded-full bg-gray-300 dark:bg-gray-600 px-0.5 outline-gray-400 transition-colors before:h-5 before:w-5 before:rounded-full before:bg-white before:shadow before:transition-transform before:duration-300 peer-checked:bg-green-500 peer-checked:before:translate-x-full peer-focus-visible:outline peer-focus-visible:outline-offset-2 peer-focus-visible:outline-gray-400 peer-checked:peer-focus-visible:outline-green-500">
                                 <span class="sr-only">Activer le statut prestataire</span>
                             </label>
                             <span class="text-sm text-gray-600 dark:text-gray-400">L'utilisateur est un prestataire</span>
                         </div>
                     </div>
                </div>
            </div>

            <!-- Carte des informations organisationnelles -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800 mb-6">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Informations organisationnelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Département -->
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Département</label>
                        <select id="department_id" name="department_id" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required>
                            <option value="">Sélectionner un département</option>
                            @foreach(\App\Models\Department::all() as $department)
                                <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-1" :messages="$errors->get('department_id')" />
                    </div>

                    <!-- Équipe (si disponible) -->
                    <div>
                        <label for="team_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Équipe</label>
                        <select id="team_id" name="team_id" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                            <option value="">Sélectionner une équipe</option>
                            @foreach(\App\Models\Team::all() as $team)
                                <option value="{{ $team->id }}" {{ $user->teams->contains($team->id) ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-1" :messages="$errors->get('team_id')" />
                    </div>

                    <!-- Rôle -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rôle d'accès</label>
                        <select id="role" name="role" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required>
                            <option value="employee" {{ $user->role === 'employee' ? 'selected' : '' }}>Employé</option>
                            <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                            @if(Auth::check() && auth()->user()->role === App\Models\User::ROLE_ADMIN)         
                               <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
                            @endif
                            <option value="hr" {{ $user->role === 'hr' ? 'selected' : '' }}>Ressources Humaines</option>
                            <option value="department_head" {{ $user->role === 'department_head' ? 'selected' : '' }}>Chef de département</option>
                        </select>
                        <x-input-error class="mt-1" :messages="$errors->get('role')" />
                    </div>
                </div>
            </div>

            <!-- Champs cachés pour la validation du mot de passe -->
            <input type="hidden" name="password" value="">
            <input type="hidden" name="password_confirmation" value="">
      

            <!-- Actions du modal -->
            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-t border-gray-200 dark:border-gray-600 rounded-b-2xl">
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            x-on:click="$dispatch('close-modal', 'edit-personal-info')" 
                            class="px-6 py-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 font-medium shadow-sm">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg hover:shadow-xl font-medium">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-modal>