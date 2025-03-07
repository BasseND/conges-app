@props(['user'])

<x-modal name="edit-personal-info" :show="false"  class="sm:w-full sm:max-w-2xl sm:mx-auto sm:align-middle">
      
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 p-6">
            Modifier les informations personnelles
        </h2>
       
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="p-6 mt-0">

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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ">
                    <!-- Prénom -->
                    <div>
                        <x-input-label for="first_name" value="Prénom" />
                        <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="$user->first_name" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <!-- Nom -->
                    <div>
                        <x-input-label for="last_name" value="Nom" />
                        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="$user->last_name" required />
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="$user->email" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <x-input-label for="phone" value="Téléphone" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="$user->phone" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <!-- Poste actuel -->
                    <div>
                        <x-input-label for="position" value="Poste actuel" />
                        <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" :value="$user->position" required />
                        <x-input-error class="mt-2" :messages="$errors->get('position')" />
                    </div>

                    <!-- Département -->
                    <div>
                        <x-input-label for="department_id" value="Département" />
                        <select id="department_id" name="department_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                            <option value="">Sélectionner un département</option>
                            @foreach(\App\Models\Department::all() as $department)
                                <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
                    </div>

                    <!-- Équipe (si disponible) -->
                    <div>
                        <x-input-label for="team_id" value="Équipe" />
                        <select id="team_id" name="team_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Sélectionner une équipe</option>
                            @foreach(\App\Models\Team::all() as $team)
                                <option value="{{ $team->id }}" {{ $user->teams->contains($team->id) ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('team_id')" />
                    </div>

                    <!-- Rôle -->
                    <div>
                        <x-input-label for="role" value="Rôle d'accès" />
                        <select id="role" name="role" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                            <option value="employee" {{ $user->role === 'employee' ? 'selected' : '' }}>Employé</option>
                            <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
                            <option value="hr" {{ $user->role === 'hr' ? 'selected' : '' }}>Ressources Humaines</option>
                            <option value="department_head" {{ $user->role === 'department_head' ? 'selected' : '' }}>Chef de département</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                    </div>
                    <!-- Is prestataire -->
                    <div>
                        <div class="mt-3 mb-3">
                            <p class="block font-medium text-sm text-gray-700 dark:text-gray-200">L'utilisateur est-il un prestataire ?</p>
                        </div>
                        <input type="checkbox" class="peer sr-only opacity-0" id="is_prestataire" name="is_prestataire" {{ old('is_prestataire', $user->is_prestataire ?? false) ? 'checked' : '' }} />
                        <label for="is_prestataire" class="relative flex h-6 w-11 cursor-pointer items-center rounded-full bg-gray-400 px-0.5 outline-gray-400 transition-colors before:h-5 before:w-5 before:rounded-full before:bg-white before:shadow before:transition-transform before:duration-300 peer-checked:bg-green-500 peer-checked:before:translate-x-full peer-focus-visible:outline peer-focus-visible:outline-offset-2 peer-focus-visible:outline-gray-400 peer-checked:peer-focus-visible:outline-green-500">
                            <span class="sr-only">Enable</span>
                        </label>
                    </div>

                    <!-- Solde congés annuels -->
                    <div>
                        <x-input-label for="annual_leave_days" value="Solde congés annuels (jours)" />
                        <x-text-input id="annual_leave_days" name="annual_leave_days" type="number" class="mt-1 block w-full" :value="$user->annual_leave_days" min="0" step="0.5" required />
                        <x-input-error class="mt-2" :messages="$errors->get('annual_leave_days')" />
                    </div>

                    <!-- Solde congés maladie -->
                    <div>
                        <x-input-label for="sick_leave_days" value="Solde congés maladie (jours)" />
                        <x-text-input id="sick_leave_days" name="sick_leave_days" type="number" class="mt-1 block w-full" :value="$user->sick_leave_days" min="0" step="0.5" required />
                        <x-input-error class="mt-2" :messages="$errors->get('sick_leave_days')" />
                    </div>
                    
                    <!-- Champs cachés pour la validation du mot de passe -->
                    <input type="hidden" name="password" value="">
                    <input type="hidden" name="password_confirmation" value="">
                </div>
            </div>

           
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit"  class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    {{ __('Enregistrer') }}
                </button>
                <button type="button" x-on:click="$dispatch('close-modal', 'edit-personal-info')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    {{ __('Annuler') }}
                </button> 
            </div>
           
            

        </form>
    
</x-modal>