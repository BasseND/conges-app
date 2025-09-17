<!-- Section Informations de base -->
<div class="bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl border border-gray-200 dark:border-gray-600 mb-6 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white">Informations personnelles</h2>
            </div>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-personal-info')" 
                    class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-medium rounded-lg transition-all duration-200 backdrop-blur-sm border border-white/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Modifier
            </button>
        </div>
    </div>
    <!-- Grille d'informations personnelles -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Carte Nom complet -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Nom complet</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->first_name }} {{ $user->last_name }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Email -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Email</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white break-all">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Téléphone -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Téléphone</p>
                        <p class="text-sm font-semibold {{ $user->phone ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->phone ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Date de naissance -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 012 0v4m0 0V3a1 1 0 112 0v4m0 0h4m-4 0H8m0 0v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2H10a2 2 0 00-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Date de naissance</p>
                        <p class="text-sm font-semibold {{ $user->birth_date ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Adresse -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Adresse</p>
                        <p class="text-sm font-semibold {{ $user->address ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->address ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Poste actuel -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 002 2h2a2 2 0 002-2V6zM8 6H6a2 2 0 00-2 2v6a2 2 0 002 2h2m0-10v10m0-10V4a2 2 0 012-2h4a2 2 0 012 2v2M8 16h8"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Poste actuel</p>
                        <p class="text-sm font-semibold {{ isset($user->position) ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">
                            @if(isset($user->position))
                                {{ $user->position }}
                            @else
                                Non renseigné
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Carte Département -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Département</p>
                        <p class="text-sm font-semibold {{ $user->department ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->department->name ?? 'Non assigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Rôle d'accès -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Rôle d'accès</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            <x-role-badge :role="$user->role" />
                        </p>
                    </div>
                </div>
            </div>

            <!-- Carte Civilité -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-teal-100 dark:bg-teal-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Civilité</p>
                        <p class="text-sm font-semibold {{ $user->marital_status ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->getMaritalStatusLabel() ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Statut professionnel -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-cyan-100 dark:bg-cyan-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V8m8 0V6a2 2 0 00-2-2H10a2 2 0 00-2 2v2"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Statut professionnel</p>
                        <p class="text-sm font-semibold {{ $user->employment_status ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->getEmploymentStatusLabel() ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Nombre d'enfants -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Nombre d'enfants</p>
                        <p class="text-sm font-semibold {{ isset($user->children_count) ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->children_count ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Matricule -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Matricule</p>
                        <p class="text-sm font-semibold {{ $user->matricule ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->matricule ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Affectation -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Affectation</p>
                        <p class="text-sm font-semibold {{ $user->affectation ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->affectation ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Catégorie -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-violet-100 dark:bg-violet-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Catégorie</p>
                        <p class="text-sm font-semibold {{ $user->category ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->getCategoryLabel() ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Section -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2m-2 0v6a2 2 0 002 2h6a2 2 0 002-2v-6a2 2 0 00-2-2h-2m0 0V9a2 2 0 00-2-2H9m0 0V5a2 2 0 012-2h2a2 2 0 012 2v2M9 5a2 2 0 012 2v2a2 2 0 01-2 2M9 5a2 2 0 00-2 2v2a2 2 0 002 2m6 0a2 2 0 002-2V9a2 2 0 00-2-2m0 0a2 2 0 00-2 2v2a2 2 0 002 2"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Section</p>
                        <p class="text-sm font-semibold {{ $user->section ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->section ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Service -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-rose-100 dark:bg-rose-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V8m8 0V6a2 2 0 00-2-2H10a2 2 0 00-2 2v2"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Service</p>
                        <p class="text-sm font-semibold {{ $user->service ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->service ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Contact d'urgence -->
<div class="bg-gradient-to-br from-white to-red-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl border border-gray-200 dark:border-gray-600 mb-6 overflow-hidden">
    <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-white">Contact d'urgence</h2>
        </div>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Carte Nom du contact -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Nom du contact</p>
                        <p class="text-sm font-semibold {{ $user->emergency_contact_name ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->emergency_contact_name ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Téléphone du contact -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Téléphone</p>
                        <p class="text-sm font-semibold {{ $user->emergency_contact_phone ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->emergency_contact_phone ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Relation -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Relation</p>
                        <p class="text-sm font-semibold {{ $user->emergency_contact_relationship ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 italic' }}">{{ $user->emergency_contact_relationship ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Solde de congés -->
<div class="bg-gradient-to-br from-white to-green-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl border border-gray-200 dark:border-gray-600 mb-6 overflow-hidden">
    <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white">Solde de congés</h3>
        </div>
    </div>
    <div class="p-6">
        @php
            // Récupération des types de congés actifs
            $specialLeaveTypes = \App\Models\SpecialLeaveType::where('is_active', true)->get();
        @endphp
        
        @if($specialLeaveTypes->count() > 0)
            @php
                // Calcul des jours utilisés par type de congé
                $usedDaysByType = [];
                foreach($specialLeaveTypes as $type) {
                    $usedDaysByType[$type->system_name] = $user->leaves()
                        ->whereHas('specialLeaveType', function($q) use ($type) {
                            $q->where('system_name', $type->system_name);
                        })
                        ->where('status', 'approved')
                        ->sum('duration');
                }
            @endphp
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($specialLeaveTypes as $leaveType)
                    @php
                        $usedDays = $usedDaysByType[$leaveType->system_name] ?? 0;
                        $remainingDays = max(0, $leaveType->duration_days - $usedDays);
                        
                        // Couleurs selon le type
                        $colorMap = [
                            'annual' => ['bg' => 'bg-blue-100 dark:bg-blue-900', 'text' => 'text-blue-600 dark:text-blue-400'],
                            'sick' => ['bg' => 'bg-red-100 dark:bg-red-900', 'text' => 'text-red-600 dark:text-red-400'],
                            'maternity' => ['bg' => 'bg-pink-100 dark:bg-pink-900', 'text' => 'text-pink-600 dark:text-pink-400'],
                            'paternity' => ['bg' => 'bg-cyan-100 dark:bg-cyan-900', 'text' => 'text-cyan-600 dark:text-cyan-400']
                        ];
                        
                        $colors = $colorMap[$leaveType->system_name] ?? ['bg' => 'bg-purple-100 dark:bg-purple-900', 'text' => 'text-purple-600 dark:text-purple-400'];
                    @endphp
                    
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ $leaveType->name }}</p>
                                <p class="text-2xl font-bold {{ $colors['text'] }}">{{ $remainingDays }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">restants / {{ $leaveType->duration_days }}</p>
                            </div>
                            <div class="w-12 h-12 {{ $colors['bg'] }} rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Code LeaveBalance supprimé - remplacé par SpecialLeaveType --}}
            {{-- @if($user->company && $user->company->defaultLeaveBalance()) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Affichage basé sur les attributs du modèle User utilisant SpecialLeaveType -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Annuels</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $user->annual_leave_days }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">jours</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Maternité</p>
                            <p class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ $user->maternity_leave_days }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">jours</p>
                        </div>
                        <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Paternité</p>
                            <p class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">{{ $user->paternity_leave_days }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">jours</p>
                        </div>
                        <div class="w-12 h-12 bg-cyan-100 dark:bg-cyan-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Spéciaux</p>
                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">Voir types spéciaux</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">selon entreprise</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Section Historique des congés -->
<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200/50 dark:border-gray-600/50 mb-6 overflow-hidden">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-4 sm:px-6 py-3 sm:py-4">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-white">Historique des congés</h3>
        </div>
        <p class="text-indigo-100 text-xs sm:text-sm mt-1">Vos demandes de congés récentes</p>
    </div>
    <div class="p-4 sm:p-6">
        @if($user->leaves->count() > 0)
            <div class="space-y-3">
                @foreach($user->leaves->take(5) as $leave)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                @if($leave->status === 'approved') bg-green-100 dark:bg-green-900
                                @elseif($leave->status === 'rejected') bg-red-100 dark:bg-red-900
                                @else bg-yellow-100 dark:bg-yellow-900 @endif">
                                @if($leave->status === 'approved')
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @elseif($leave->status === 'rejected')
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white"><x-leave-type-badge :leave="$leave" :specialLeaveType="$leave->specialLeaveType" /></div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $leave->start_date->format('d/m/Y') }} - {{ $leave->end_date->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $leave->duration }} jour(s)</p>
                            <p class="text-sm
                                @if($leave->status === 'approved') text-green-600 dark:text-green-400
                                @elseif($leave->status === 'rejected') text-red-600 dark:text-red-400
                                @else text-yellow-600 dark:text-yellow-400 @endif">
                                {{ ucfirst($leave->status) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucun congé enregistré</h3>
                <p class="text-gray-500 dark:text-gray-400">Vous n'avez pas encore de demandes de congés.</p>
            </div>
        @endif
    </div>
</div>

@include('admin.users.modals.edit-personal-info', ['user' => $user])

