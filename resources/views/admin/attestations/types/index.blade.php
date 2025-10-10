<x-app-layout>
    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.attestations.index') }}" 
                               class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-3 rounded-2xl shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Types d'attestations</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Gérer les types d'attestations disponibles</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button onclick="openCreateModal()" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Nouveau type
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="font-semibold text-base block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 dark:bg-red-900 border border-red-400 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="font-semibold text-base block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Filtres -->
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Filtres de recherche</h3>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('admin.attestations.types.index') }}">
                            <div class="flex flex-wrap items-end gap-4">
                                <div class="flex-1 min-w-[200px]">
                                    <label for="type" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Type
                                    </label>
                                    <select name="type" id="type" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                        <option value="">Tous les types</option>
                                        <option value="salary" {{ request('type') === 'salary' ? 'selected' : '' }}>Salaire</option>
                                        <option value="presence" {{ request('type') === 'presence' ? 'selected' : '' }}>Présence</option>
                                        <option value="employment" {{ request('type') === 'employment' ? 'selected' : '' }}>Emploi</option>
                                        <option value="custom" {{ request('type') === 'custom' ? 'selected' : '' }}>Personnalisé</option>
                                    </select>
                                </div>

                                <div class="flex-1 min-w-[200px]">
                                    <label for="status" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Statut
                                    </label>
                                    <select name="status" id="status" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                        <option value="">Tous les statuts</option>
                                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                                    </select>
                                </div>

                                <div class="flex-1 min-w-[200px]">
                                    <label for="search" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        Recherche
                                    </label>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nom du type..." class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                </div>

                                <div class="flex items-end gap-2">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors duration-200 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        Filtrer
                                    </button>
                                    <a href="{{ route('admin.attestations.types.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-colors duration-200 shadow-sm">Réinitialiser</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Liste des types -->
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    @if($attestationTypes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nom
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Demandes
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Créé le
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($attestationTypes as $type)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $type->name }}</div>
                                                    @if($type->description)
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($type->description, 50) }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($type->type === 'salary') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                    @elseif($type->type === 'presence') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                    @elseif($type->type === 'employment') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                                    @endif">
                                                    {{ $type->formatted_type }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($type->isActive())
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Actif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Inactif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $type->attestation_requests_count ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $type->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <!-- Bouton Voir -->
                                                    <button type="button"
                                                            onclick="viewType({{ $type->id }})"
                                                            title="Voir"
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-200 dark:hover:bg-indigo-800/50 transition-all duration-200 hover:scale-110">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                    </button>
                                                    <!-- Bouton Modifier -->
                                                    <button type="button"
                                                            onclick="editType({{ $type->id }})"
                                                            title="Modifier"
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-all duration-200 hover:scale-110">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </button>
                                                    {{-- Suppression désactivée --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($attestationTypes->hasPages())
                            <x-pagination :paginator="$attestationTypes" entity-name="types d'attestations" />
                        @endif
                    @else
                        <div class="px-6 py-16 text-center">
                            <div class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Aucun type d'attestation</h3>
                            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">Commencez par créer un nouveau type d'attestation.</p>
                            <div class="mt-6">
                                <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Nouveau type
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de création/édition -->
    <div id="typeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900 dark:text-white mb-4">Nouveau type d'attestation</h3>
                <form id="typeForm">
                    <input type="hidden" id="typeId" name="id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom *</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   placeholder="Ex: Attestation de salaire">
                        </div>
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type *</label>
                            <select id="typeSelect" name="type" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Sélectionner un type</option>
                                <option value="salary">Salaire</option>
                                <option value="presence">Présence</option>
                                <option value="employment">Emploi</option>
                                <option value="custom">Personnalisé</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                  placeholder="Description du type d'attestation..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="template_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Template HTML <span class="text-red-500">*</span></label>
                        <select id="template_file" name="template_file" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sélectionnez un template HTML</option>
                            <option value="attestation_travail">Template Attestation de Travail</option>
                            <option value="attestation_stage">Template Attestation de Stage</option>
                            <option value="attestation_presence">Template Attestation de Présence / Assiduité</option>
                        </select>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Sélectionnez un template HTML prédéfini pour ce type d'attestation.
                        </p>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" checked
                                   class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Type actif</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeTypeModal()" 
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors duration-200">
                            <span id="submitText">Créer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de visualisation -->
    <div id="viewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Détails du type d'attestation</h3>
                    <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div id="viewContent" class="space-y-4">
                    <!-- Le contenu sera injecté ici -->
                </div>
            </div>
        </div>
    </div>

    <script>
        let isEditing = false;

        function openCreateModal() {
            isEditing = false;
            document.getElementById('modalTitle').textContent = 'Nouveau type d\'attestation';
            document.getElementById('submitText').textContent = 'Créer';
            document.getElementById('typeForm').reset();
            document.getElementById('typeId').value = '';
            document.getElementById('is_active').checked = true;
            // Réactiver les champs non modifiables pour la création
            const typeSelectEl = document.getElementById('typeSelect');
            const templateFileEl = document.getElementById('template_file');
            if (typeSelectEl) typeSelectEl.removeAttribute('disabled');
            if (templateFileEl) templateFileEl.removeAttribute('disabled');
            document.getElementById('typeModal').classList.remove('hidden');
        }

        function editType(typeId) {
            isEditing = true;
            document.getElementById('modalTitle').textContent = 'Modifier le type d\'attestation';
            document.getElementById('submitText').textContent = 'Modifier';
            
            // Récupérer les données du type (forcer JSON)
            fetch(`/admin/attestations/types/${typeId}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const type = data.type;
                        // S'assurer que l'option du template existant est présente
                        if (type.template_file) {
                            const tplSelect = document.getElementById('template_file');
                            const exists = Array.from(tplSelect.options).some(opt => opt.value === type.template_file);
                            if (!exists) {
                                const opt = document.createElement('option');
                                opt.value = type.template_file;
                                opt.textContent = type.template_file;
                                tplSelect.appendChild(opt);
                            }
                        }
                        document.getElementById('typeId').value = type.id;
                        document.getElementById('name').value = type.name;
                        document.getElementById('typeSelect').value = type.type;
                        document.getElementById('description').value = type.description || '';
                        document.getElementById('template_file').value = type.template_file || '';
                        document.getElementById('is_active').checked = type.status === 'active';
                        // Désactiver les champs non modifiables en mode édition
                        const typeSelectEl = document.getElementById('typeSelect');
                        const templateFileEl = document.getElementById('template_file');
                        if (typeSelectEl) typeSelectEl.setAttribute('disabled', 'disabled');
                        if (templateFileEl) templateFileEl.setAttribute('disabled', 'disabled');
                        document.getElementById('typeModal').classList.remove('hidden');
                    } else {
                        alert(data.message || 'Erreur lors du chargement des données');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
        }

        function viewType(typeId) {
            // Charger les détails (forcer JSON)
            fetch(`/admin/attestations/types/${typeId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const type = data.type;
                        const content = `
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">${type.name}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">${type.formatted_type}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">${type.formatted_status}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Demandes</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">${type.attestation_requests_count || 0}</p>
                                </div>
                            </div>
                            ${type.description ? `
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">${type.description}</p>
                                </div>
                            ` : ''}
                            ${type.template_file ? `
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Template HTML</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">${type.template_file}</p>
                                </div>
                            ` : `
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Template HTML</label>
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">Aucun template défini</p>
                                </div>
                            `}
                        `;
                        document.getElementById('viewContent').innerHTML = content;
                        document.getElementById('viewModal').classList.remove('hidden');
                    } else {
                        alert(data.message || 'Erreur lors du chargement des données');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
        }

        function deleteType(typeId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce type d\'attestation ?')) {
                fetch(`/admin/attestations/types/${typeId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Une erreur est survenue');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
            }
        }

        function closeTypeModal() {
            document.getElementById('typeModal').classList.add('hidden');
            document.getElementById('typeForm').reset();
            // Réactiver les champs pour la prochaine création
            const typeSelectEl = document.getElementById('typeSelect');
            const templateFileEl = document.getElementById('template_file');
            if (typeSelectEl) typeSelectEl.removeAttribute('disabled');
            if (templateFileEl) templateFileEl.removeAttribute('disabled');
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        document.getElementById('typeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            // Payload conditionnelle: en édition uniquement Nom, Statut et Description
            const data = isEditing ? {
                name: formData.get('name'),
                description: formData.get('description'),
                status: formData.get('is_active') ? 'active' : 'inactive'
            } : {
                name: formData.get('name'),
                type: formData.get('type'),
                description: formData.get('description'),
                template_file: formData.get('template_file'),
                status: formData.get('is_active') ? 'active' : 'inactive'
            };
            
            const url = isEditing ? `/admin/attestations/types/${formData.get('id')}` : '/admin/attestations/types';
            const method = isEditing ? 'PUT' : 'POST';
            
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeTypeModal();
                    location.reload();
                } else {
                    alert(data.message || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            });
        });

        // Fermer les modals en cliquant à l'extérieur
        document.getElementById('typeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTypeModal();
            }
        });

        document.getElementById('viewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeViewModal();
            }
        });
    </script>
</x-app-layout>