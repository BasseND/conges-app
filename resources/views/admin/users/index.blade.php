<x-app-layout>
    <div class="min-h-screen">
        <!-- En-tête moderne avec dégradé -->
        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-3 rounded-xl shadow-lg mr-2">
                            <svg class="w-8 h-8 text-white dark:text-bgray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ __('Gestion des utilisateurs') }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Gérez les comptes et permissions des utilisateurs</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 border border-transparent rounded-xl font-semibold text-white transition-colors duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Nouvel Utilisateur</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Contenu principal -->

        <div class="bg-white dark:bg-darkblack-600 rounded-lg p-4 mb-8">
            <x-alert type="success" :message="session('success')" />
            <x-alert type="error" :message="session('error')" />
            
            <!-- Filtres et recherche modernisés -->
            <div class="mb-8">
                <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-6">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                        <!-- Recherche modernisée -->
                        <div class="relative flex-1 md:max-w-[400px]">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Rechercher par nom ou email..."
                                   class="w-full pl-12 pr-4 py-3 bg-white/50 dark:bg-gray-700/50 border border-gray-200/50 dark:border-gray-600/50 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 backdrop-blur-sm transition-all duration-200"/>
                        </div>
                            
                        <!-- Filtres modernisés -->
                        <div class="flex flex-wrap gap-4">
                            <!-- Filtre par rôle -->
                            <div class="relative">
                                <select name="role" 
                                        id="role" 
                                        class="appearance-none bg-white/50 dark:bg-gray-700/50 border border-gray-200/50 dark:border-gray-600/50 rounded-xl px-4 py-3 pr-10 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 backdrop-blur-sm transition-all duration-200 min-w-[160px]">
                                    <option value="">Tous les rôles</option>
                                    @foreach(App\Models\User::getRoles() as $role => $label)
                                        <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Filtre par département -->
                            <div class="relative">
                                <select name="department" 
                                        id="department" 
                                        class="appearance-none bg-white/50 dark:bg-gray-700/50 border border-gray-200/50 dark:border-gray-600/50 rounded-xl px-4 py-3 pr-10 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 backdrop-blur-sm transition-all duration-200 min-w-[180px]">
                                    <option value="">Tous les départements</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex items-center space-x-3">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Filtrer
                                </button>
                                @if(request()->hasAny(['search', 'role', 'department']))
                                    <a href="{{ route('admin.users.index') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-gray-500/80 hover:bg-gray-600/80 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Réinitialiser
                                    </a>
                                @endif
                            </div>
                        </div>
                          </div>

                    </form>
                </div>

                <!-- Tableau des utilisateurs modernisé -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- En-tête du tableau -->
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b border-gray-200/50 dark:border-gray-600/50">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-500/10 dark:bg-blue-400/10 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Liste des utilisateurs</h3>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50/50 dark:bg-gray-700/50">
                                @php
                                  $columns = [
                                      'first_name' => 'Prénom',
                                      'last_name' => 'Nom',
                                      'email' => 'Email',
                                      'role' => 'Rôle',
                                      'department_id' => 'Département',
                                      'is_active' => 'Statut'
                                  ];
                                @endphp

                                    @foreach($columns as $column => $label)
                                        <th scope="col" class="px-6 py-4 text-left">
                                            <a href="{{ route('admin.users.index', array_merge(
                                                request()->except(['sort', 'direction']),
                                                [
                                                    'sort' => $column,
                                                    'direction' => request('sort') === $column && request('direction') === 'asc' ? 'desc' : 'asc'
                                                ]
                                            )) }}" class="flex items-center space-x-2 group hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                                @if($column === 'first_name')
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                @elseif($column === 'email')
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                @elseif($column === 'role')
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                    </svg>
                                                @elseif($column === 'department_id')
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                @elseif($column === 'is_active')
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                @endif
                                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ $label }}</span>
                                                @if(request('sort') === $column)
                                                    <svg class="w-4 h-4 text-blue-500 {{ request('direction') === 'desc' ? 'transform rotate-180' : '' }} transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                                    </svg>
                                                @endif
                                            </a>
                                        </th>
                                    @endforeach
                                    <th scope="col" class="relative px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</span>
                                        </div>
                                    </th>
                            </tr>
                        </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->first_name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Prénom</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->last_name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Nom de famille</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $roleConfig = [
                                                    'admin' => ['bg' => 'from-red-500 to-pink-600', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                                                    'manager' => ['bg' => 'from-blue-500 to-indigo-600', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                                                    'employee' => ['bg' => 'from-green-500 to-emerald-600', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                                                    'department_head' => ['bg' => 'from-purple-500 to-violet-600', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                                                    'hr' => ['bg' => 'from-orange-500 to-amber-600', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z']
                                                ];
                                                $config = $roleConfig[$user->role] ?? ['bg' => 'from-gray-500 to-gray-600', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'];
                                            @endphp
                                            <div class="inline-flex items-center px-3 py-1.5 rounded-xl bg-gradient-to-r {{ $config['bg'] }} text-white shadow-lg">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
                                                </svg>
                                                <span class="text-xs font-semibold">{{ App\Models\User::getRoles()[$user->role] ?? ucfirst($user->role) }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($user->department)
                                                <div class="flex items-center space-x-2">
                                                    <div class="p-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->department->name }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->department->code }}</p>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="inline-flex items-center px-3 py-1.5 rounded-xl bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                                    </svg>
                                                    <span class="text-xs font-semibold">Non assigné</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="inline-flex items-center px-3 py-1.5 rounded-xl {{ $user->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' }} shadow-sm">
                                                <div class="w-2 h-2 rounded-full mr-2 {{ $user->is_active ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></div>
                                                <span class="text-xs font-semibold">{{ $user->is_active ? 'Actif' : 'Inactif' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-end space-x-2">
                                                <!-- Bouton Voir -->
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   title="Voir les détails"
                                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-200 dark:hover:bg-indigo-800/50 transition-all duration-200 hover:scale-110">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>

                                                <!-- Bouton Modifier -->
                                                <a href="{{ route('admin.users.edit', $user) }}" 
                                                   title="Modifier"
                                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-all duration-200 hover:scale-110">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg {{ $user->is_active ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 hover:bg-orange-200 dark:hover:bg-orange-800/50' : 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-800/50' }} transition-all duration-200 hover:scale-110">
                                                    @if($user->is_active)
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9v6m-4.5 0V9M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/50 transition-all duration-200 hover:scale-110">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                    @if($users->count() > 0)
                        <!-- Pagination modernisée -->
                        @if($users->hasPages())
                            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-t border-gray-200/50 dark:border-gray-600/50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        <span>Affichage de {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }} résultats</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        {{ $users->appends(request()->query())->links('pagination::tailwind') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- État vide modernisé -->
                        <div class="flex flex-col items-center justify-center py-16 px-6">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-full flex items-center justify-center mb-6 shadow-lg">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aucun utilisateur trouvé</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-center max-w-md leading-relaxed">
                                Il n'y a actuellement aucun utilisateur correspondant à vos critères de recherche. Essayez de modifier vos filtres ou créez un nouvel utilisateur.
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

   
</x-app-layout>
