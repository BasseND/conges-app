@props(['user'])

<x-modal name="edit-personal-info" :show="false" class="sm:w-full sm:max-w-3xl sm:mx-auto sm:align-middle">
    <!-- En-tête modernisé -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-5 rounded-t-2xl">
        <div class="flex items-center">
            <div class="flex items-center justify-center w-10 h-10 bg-white/20 rounded-xl mr-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">
                    Modifier les informations personnelles
                </h2>
                <p class="text-blue-100 text-sm mt-1">
                    Mettre à jour les données de l'utilisateur
                </p>
            </div>
        </div>
    </div>
       
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white dark:bg-gray-800">
        @csrf
        @method('PUT')
        
        <div class="p-6">
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
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informations personnelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Prénom -->
                    <div class="space-y-2">
                        <x-input-label for="first_name" value="Prénom" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <x-text-input id="first_name" name="first_name" type="text" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500" :value="$user->first_name" required autofocus />
                        <x-input-error class="mt-1" :messages="$errors->get('first_name')" />
                    </div>

                    <!-- Nom -->
                    <div class="space-y-2">
                        <x-input-label for="last_name" value="Nom" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <x-text-input id="last_name" name="last_name" type="text" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500" :value="$user->last_name" required />
                        <x-input-error class="mt-1" :messages="$errors->get('last_name')" />
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <x-input-label for="email" value="Email" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <x-text-input id="email" name="email" type="email" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500" :value="$user->email" required />
                        <x-input-error class="mt-1" :messages="$errors->get('email')" />
                    </div>

                    <!-- Téléphone -->
                    <div class="space-y-2">
                        <x-input-label for="phone" value="Téléphone" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <x-text-input id="phone" name="phone" type="text" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500" :value="$user->phone" />
                        <x-input-error class="mt-1" :messages="$errors->get('phone')" />
                    </div>

                    <!-- Poste actuel -->
                    <div class="space-y-2">
                        <x-input-label for="position" value="Poste actuel" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <x-text-input id="position" name="position" type="text" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500" :value="$user->position" required />
                        <x-input-error class="mt-1" :messages="$errors->get('position')" />
                    </div>

                    <!-- Genre -->
                     <div class="space-y-2">
                         <x-input-label for="gender" value="Sexe" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                         <select id="gender" name="gender" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                             <option value="">Sélectionner un sexe</option>
                             <option value="M" {{ old('gender', $user->gender) === 'M' ? 'selected' : '' }}>Homme</option>
                             <option value="F" {{ old('gender', $user->gender) === 'F' ? 'selected' : '' }}>Femme</option>
                         </select>
                         <x-input-error class="mt-1" :messages="$errors->get('gender')" />
                     </div>

                     <!-- Is prestataire -->
                     <div class="space-y-2">
                         <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Statut prestataire</label>
                         <div class="flex items-center space-x-3">
                             <input type="checkbox" class="peer sr-only opacity-0" id="is_prestataire" name="is_prestataire" {{ old('is_prestataire', $user->is_prestataire ?? false) ? 'checked' : '' }} />
                             <label for="is_prestataire" class="relative flex h-6 w-11 cursor-pointer items-center rounded-full bg-gray-300 dark:bg-gray-600 px-0.5 outline-gray-400 transition-colors before:h-5 before:w-5 before:rounded-full before:bg-white before:shadow before:transition-transform before:duration-300 peer-checked:bg-blue-500 peer-checked:before:translate-x-full peer-focus-visible:outline peer-focus-visible:outline-offset-2 peer-focus-visible:outline-gray-400 peer-checked:peer-focus-visible:outline-blue-500">
                                 <span class="sr-only">Activer le statut prestataire</span>
                             </label>
                             <span class="text-sm text-gray-600 dark:text-gray-400">L'utilisateur est un prestataire</span>
                         </div>
                     </div>
                </div>
            </div>

            <!-- Carte des informations organisationnelles -->
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Informations organisationnelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Département -->
                    <div class="space-y-2">
                        <x-input-label for="department_id" value="Département" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <select id="department_id" name="department_id" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
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
                    <div class="space-y-2">
                        <x-input-label for="team_id" value="Équipe" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <select id="team_id" name="team_id" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                    <div class="space-y-2">
                        <x-input-label for="role" value="Rôle d'accès" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <select id="role" name="role" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="employee" {{ $user->role === 'employee' ? 'selected' : '' }}>Employé</option>
                            <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
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
        </div>

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
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl font-medium">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </div>
    </form>
    
</x-modal>