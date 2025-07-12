<x-app-layout>
    <div class="min-h-screen">
        <!-- En-tête moderne -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-b border-gray-200/50 dark:border-gray-700/50 rounded-lg p-4 mb-8">
            <div class="">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $department->name }}</h1>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">Gestion du département et des équipes</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.departments.edit', $department) }}" 
                           class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                            Modifier
                        </a>
                        <a href="{{ route('admin.departments.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-8">
            <!-- Messages de notification -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-red-800 dark:text-red-200">{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            
            <!-- Informations du département -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 dark:border-gray-700/50 mb-8">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg mr-4">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Informations du Département</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200/50 dark:border-blue-800/50">
                            <div class="flex items-center mb-3">
                                <svg class="w-4 h-4 text-blue-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nom du département</span>
                            </div>
                            <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $department->name }}</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-6 border border-emerald-200/50 dark:border-emerald-800/50">
                            <div class="flex items-center mb-3">
                                <svg class="w-4 h-4 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Chef du département</span>
                            </div>
                            <p class="text-xl font-semibold text-gray-900 dark:text-white">
                                @if($department->head)
                                    {{ $department->head->first_name }} {{ $department->head->last_name }}
                                @else
                                    <span class="text-amber-600 dark:text-amber-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Aucun chef assigné
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section des utilisateurs -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 dark:border-gray-700/50 mb-8">
                <div class="p-8">
                    <!-- En-tête de la section utilisateurs -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg mr-4">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Utilisateurs</h2>
                                <p class="text-gray-600 dark:text-gray-300">{{ $users->count() }} utilisateur(s) dans ce département</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Ajouter un utilisateur
                        </a>
                    </div>
            
                    @if($users->count() > 0)
                        <!-- Tableau moderne des utilisateurs -->
                        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <!-- En-tête du tableau -->
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 4a1 1 0 00-1 1v10a1 1 0 001 1h10a1 1 0 001-1V5a1 1 0 00-1-1H5zM3 5a3 3 0 013-3h8a3 3 0 013 3v10a3 3 0 01-3 3H6a3 3 0 01-3-3V5z" clip-rule="evenodd"></path>
                                        <path fill-rule="evenodd" d="M9 9a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Liste des utilisateurs</h3>
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                <div class="flex items-center">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Nom complet
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                <div class="flex items-center">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                                    </svg>
                                                    Email
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                <div class="flex items-center">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                        <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                                                    </svg>
                                                    Rôle
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                <div class="flex items-center">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Statut
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                <div class="flex items-center justify-end">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Actions
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($users as $user)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                                {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                                            </div>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                                {{ $user->first_name }} {{ $user->last_name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                {{ $user->position ?? 'Poste non défini' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                                        </svg>
                                                        <span class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $roleConfig = [
                                                            'admin' => ['bg' => 'from-red-500 to-pink-600', 'text' => 'Administrateur'],
                                                            'manager' => ['bg' => 'from-blue-500 to-indigo-600', 'text' => 'Manager'],
                                                            'employee' => ['bg' => 'from-green-500 to-emerald-600', 'text' => 'Employé'],
                                                            'department_head' => ['bg' => 'from-purple-500 to-violet-600', 'text' => 'Chef de département'],
                                                            'hr' => ['bg' => 'from-orange-500 to-amber-600', 'text' => 'RH']
                                                        ];
                                                        $config = $roleConfig[$user->role] ?? ['bg' => 'from-gray-500 to-gray-600', 'text' => ucfirst($user->role)];
                                                    @endphp
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r {{ $config['bg'] }} text-white">
                                                        {{ $config['text'] }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' }}">
                                                        <div class="w-2 h-2 rounded-full mr-2 {{ $user->is_active ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></div>
                                                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <div class="flex items-center justify-end space-x-2">
                                                        <!-- Bouton Voir -->
                                                        <button type="button"
                                                                @click="$dispatch('open-user-drawer', {{ $user->toJson() }})"
                                                                title="Voir les détails"
                                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-200 dark:hover:bg-indigo-800/50 transition-all duration-200 hover:scale-110">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                        </button>
                                                        <!-- Bouton Modifier -->
                                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                                           title="Modifier"
                                                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-all duration-200 hover:scale-110">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                            </svg>
                                                        </a>
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
                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aucun utilisateur</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Ce département n'a pas encore d'utilisateurs. Commencez par en ajouter un.</p>
                            <a href="{{ route('admin.users.create') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Ajouter le premier utilisateur
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section des équipes -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                <div class="p-8">
                    <!-- En-tête de la section équipes -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg mr-4">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                        </svg>
                                    </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Équipes</h2>
                                <p class="text-gray-600 dark:text-gray-300">{{ $department->teams->count() }} équipe(s) dans ce département</p>
                            </div>
                        </div>
                        <button onclick="openTeamModal()" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                            Ajouter une équipe
                        </button>
                    </div>
            
                    @if($department->teams->count() > 0)
                        <!-- Tableau moderne des équipes -->
                        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <!-- En-tête du tableau -->
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                 <path fill-rule="evenodd" d="M5 4a1 1 0 00-1 1v10a1 1 0 001 1h10a1 1 0 001-1V5a1 1 0 00-1-1H5zM3 5a3 3 0 013-3h8a3 3 0 013 3v10a3 3 0 01-3 3H6a3 3 0 01-3-3V5z" clip-rule="evenodd"></path>
                                                 <path fill-rule="evenodd" d="M9 9a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                             </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Liste des équipes</h3>
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                <div class="flex items-center">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                 <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                             </svg>
                                                    Nom de l'équipe
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                <div class="flex items-center">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                 <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                             </svg>
                                                    Responsable
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                <div class="flex items-center">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                 <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                                             </svg>
                                                    Membres
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                <div class="flex items-center justify-end">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                 <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                                             </svg>
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
                                                                     <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                         <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                                                     </svg>
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
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                         <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                                     </svg>
                                                            {{ $team->members->count() }} membre(s)
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <div class="flex items-center justify-end space-x-2">
                                                        <button type="button" 
                                                                @click="$dispatch('open-team-drawer', { teamId: {{ $team->id }}, teamName: '{{ $team->name }}', teamMembers: {{ $team->members->toJson() }}, teamManager: {{ $team->manager->toJson() }} })"
                                                                class="inline-flex items-center px-3 py-2 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-lg text-sm hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-all duration-200">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Voir
                                                        </button>
                                                        <button type="button" 
                                                                onclick="editTeam({{ $team->id }})" 
                                                                class="inline-flex items-center px-3 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg text-sm hover:bg-blue-200 dark:hover:bg-blue-800 transition-all duration-200">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                             <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                                         </svg>
                                                                Modifier
                                                            </button>
                                                            <button type="button" 
                                                                    @click="$dispatch('open-delete-modal', { teamId: {{ $team->id }}, teamName: '{{ $team->name }}' })"
                                                                    class="inline-flex items-center px-3 py-2 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg text-sm hover:bg-red-200 dark:hover:bg-red-800 transition-all duration-200">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                                </svg>
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
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aucune équipe</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">Ce département n'a pas encore d'équipes. Commencez par en créer une.</p>
                                <button onclick="openTeamModal()" 
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Créer la première équipe
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>

   
    <x-team-drawer />
    <x-user-drawer />
                        

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
