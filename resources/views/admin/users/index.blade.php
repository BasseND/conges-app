<x-app-layout>
    <div class="pb-12 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
       <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-bgray-900 dark:text-white">
                {{ __('Gestion des utilisateurs') }}
            </h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary inline-flex items-center">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                 <span class="hidden sm:block">Nouvel Utilisateur</span>
            </a>
        </div>

       </div>
        <!-- Card -->
        <div class="">
            <div class="p-6">

                <x-alert type="success" :message="session('success')" />
                <x-alert type="error" :message="session('error')" />
                
                <!-- Filtres et recherche -->
                <div class="mb-6">
                    <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-4">

                         <div class="w-full bg-white dark:bg-darkblack-600 p-6 rounded-2xl shadow border border-transparent flex flex-col md:flex-row md:items-center gap-4 md:gap-6 dark:bg-dark-card-two dark:text-white">
                              <!-- Search  -->
                              <div class="relative flex-1 md:max-w-[400]">
                                <span class="absolute left-4 top-3 text-gray-400">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                  </svg>
                                </span>
                                <input
                                  type="text" name="search" id="search" 
                                  value="{{ request('search') }}"
                                  placeholder="Nom ou email..."
                                  class="w-full pl-12 pr-4 py-2.5 rounded-xl bg-gray-50 dark:bg-dark-card-two border border-gray-200 focus:outline-none focus:border-violet-500 text-gray-700 text-base transition"
                                 
                                />
                              </div>
                            
                               <!-- Filters  -->
                              <div class="flex flex-wrap gap-3">
                               
                                <div class="relative">
                                    <select name="role" id="role" class="bg-gray-50 dark:bg-dark-card-two border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-gray-700 dark:text-white focus:border-violet-500 h-11">
                                        <option value="">Tous les rôles</option>
                                        @foreach(App\Models\User::getRoles() as $role => $label)
                                            <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filtre par département -->
                                <div>
                                    <select name="department" id="department" 
                                            class="bg-gray-50 dark:bg-dark-card-two border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-gray-700 dark:text-white focus:border-violet-500 h-11">
                                        <option value="">Tous les départements</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Boutons -->
                                <div class="flex items-end space-x-2">
                                    <button type="submit" 
                                            class="inline-flex justify-center items-center btn btn-vert-extra">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        Filtrer
                                    </button>
                                    @if(request()->hasAny(['search', 'role', 'department']))
                                        <a href="{{ route('admin.users.index') }}" 
                                            class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Réinitialiser
                                        </a>
                                    @endif
                                </div>

                              </div>
                          </div>

                    </form>
                </div>

                <!-- Tableau des utilisateurs -->
                <div class="table-content w-full overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-bgray-300 dark:border-darkblack-400">
                                @php
                                  $columns = [
                                      'name' => 'Nom',
                                      'last_name' => 'Prénom',
                                      'email' => 'Email',
                                      'role' => 'Rôle',
                                      'department_id' => 'Département',
                                      'is_active' => 'Statut'
                                  ];
                                @endphp

                                @foreach($columns as $column => $label)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <a href="{{ route('admin.users.index', array_merge(
                                            request()->except(['sort', 'direction']),
                                            [
                                                'sort' => $column,
                                                'direction' => request('sort') === $column && request('direction') === 'asc' ? 'desc' : 'asc'
                                            ]
                                        )) }}" class="flex items-center space-x-1 group">
                                            <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $label }}</span>
                                            @if(request('sort') === $column)
                                                <svg class="w-4 h-4 {{ request('direction') === 'desc' ? 'transform rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                @endforeach
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                            @foreach($users as $user)
                                <tr class="border-b border-bgray-300 dark:border-darkblack-400">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-300">
                                       <p class="text-base font-semibold text-bgray-900 dark:text-white"> {{ $user->first_name }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-300">
                                        <p class="text-base font-semibold text-bgray-900 dark:text-white">{{ $user->last_name }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                       <span class="text-base font-medium text-bgray-600 dark:text-bgray-50"> {{ $user->email }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <span class="inline-flex {{ 
                                        $user->role === 'admin' ? 'badge badge-role-admim' : 
                                        ($user->role === 'manager' ? 'badge badge-role-manager' : 
                                        ($user->role === 'employee' ? 'badge badge-role-employee' : 
                                        ($user->role === 'department_head' ? 'badge badge-role-head-department' :
                                        ($user->role === 'hr' ? 'badge badge-role-rh' :
                                        'bg-green-100 text-green-800')))) }}">
                                            {{ App\Models\User::getRoles()[$user->role] ?? ucfirst($user->role) }}
                                        </span>
                                        
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        @if($user->department)
                                            <div class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $user->department->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->department->code }}</div>
                                        @else
                                            <span class="text-yellow-600 dark:text-yellow-400">Non assigné</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <!-- <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                        </span> -->

                                      
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            <span class="h-2 w-2 rounded-full mr-1  {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                       
                                        
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Bouton Voir -->
                                            <a href="{{ route('admin.users.show', $user) }}" 
                                               title="Voir les détails"
                                               class="text-indigo-600 dark:text-indigo-500 hover:text-indigo-900 dark:hover:text-indigo-700 p-1 rounded-md hover:bg-indigo-50 dark:hover:bg-indigo-900/20">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>

                                            <!-- Bouton Modifier -->
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               title="Modifier"
                                               class="text-blue-600 dark:text-blue-500 hover:text-blue-900 dark:hover:text-blue-700 p-1 rounded-md hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>

                                            @if($user->id !== auth()->id())
                                                <!-- Bouton Changer le statut -->
                                                <button @click="$dispatch('sensitive-action-dialog', {
                                                            url: '{{ route('admin.users.toggle-status', $user) }}',
                                                            actionType: 'status',
                                                            confirmText: 'CONFIRMER',
                                                            userInfo: {
                                                                first_name: '{{ $user->first_name }}',
                                                                last_name: '{{ $user->last_name }}',
                                                                email: '{{ $user->email }}',
                                                                role: '{{ $user->role }}',
                                                                is_active: {{ $user->is_active ? 'true' : 'false' }}
                                                            }
                                                        })" 
                                                        title="{{ $user->is_active ? 'Désactiver' : 'Activer' }} l'utilisateur"
                                                        type="button" 
                                                        class="{{ $user->is_active ? 'text-orange-600 dark:text-orange-500 hover:text-orange-900 dark:hover:text-orange-700 hover:bg-orange-50 dark:hover:bg-orange-900/20' : 'text-green-600 dark:text-green-500 hover:text-green-900 dark:hover:text-green-700 hover:bg-green-50 dark:hover:bg-green-900/20' }} p-1 rounded-md">
                                                    @if($user->is_active)
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    @endif
                                                </button>

                                                <!-- Bouton Supprimer -->
                                                <button @click="$dispatch('sensitive-action-dialog', {
                                                            url: '{{ route('admin.users.destroy', $user) }}',
                                                            actionType: 'delete',
                                                            confirmText: 'CONFIRMER',
                                                            userInfo: {
                                                                first_name: '{{ $user->first_name }}',
                                                                last_name: '{{ $user->last_name }}',
                                                                email: '{{ $user->email }}',
                                                                role: '{{ $user->role }}',
                                                                is_active: {{ $user->is_active ? 'true' : 'false' }}
                                                            }
                                                        })" 
                                                        title="Supprimer l'utilisateur" 
                                                        type="button" 
                                                        class="text-red-600 dark:text-red-500 hover:text-red-900 dark:hover:text-red-700 p-1 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>


                
            </div>
        </div>
    </div>

   
</x-app-layout>
