<x-app-layout>
    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête modernisé -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-start sm:items-center space-x-3 sm:space-x-4 min-w-0">
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-orange-600 to-red-600 p-2 sm:p-3 rounded-xl sm:rounded-2xl shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white truncate">
                                    <span class="hidden sm:inline">{{ __('Modifier l\'Entité') }}</span>
                                    <span class="sm:hidden">{{ __('Modifier') }}</span>
                                </h1>
                                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                                    <span class="hidden sm:inline">Modifiez les informations de l'Entité {{ $department->name }}</span>
                                    <span class="sm:hidden">Modifier {{ $department->name }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex-shrink-0 flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                            <a href="{{ route('admin.departments.show', $department) }}" 
                               class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-gray-600 hover:bg-gray-700 border border-transparent rounded-lg sm:rounded-xl font-medium sm:font-semibold text-sm sm:text-base text-white transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span class="hidden sm:inline">Voir</span>
                                <span class="sm:hidden">Voir</span>
                            </a>
                            <a href="{{ route('admin.departments.index') }}" 
                               class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 hover:bg-blue-700 border border-transparent rounded-lg sm:rounded-xl font-medium sm:font-semibold text-sm sm:text-base text-white transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <span class="hidden sm:inline">Retour</span>
                                <span class="sm:hidden">Retour</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Formulaire modernisé -->
                    <div class="md:rounded-xl md:shadow-sm md:border border-gray-200 dark:border-gray-700 overflow-hidden">
                        
                        <form method="POST" action="{{ route('admin.departments.update', $department) }}" class="md:p-8 space-y-8">
                            @csrf
                            @method('PUT')
                            
                            <!-- Champ caché pour le code du département -->
                            <input type="hidden" name="code" value="{{ $department->code }}">

                            <!-- Nom du département -->
                            <div class="space-y-2">
                                <label for="name" class="flex items-center space-x-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span>{{ __('Nom de l\'Entité') }}</span>
                                </label>
                                <input id="name" type="text" name="name" value="{{ old('name', $department->name) }}" required autofocus
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Code du département (lecture seule) -->
                            <div class="space-y-2">
                                <label for="code_display" class="flex items-center space-x-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <span>{{ __('Code de l\'Entité') }}</span>
                                </label>
                                <input id="code_display" type="text" value="{{ $department->code }}" readonly
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span>Le code ne peut pas être modifié après la création.</span>
                                </p>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label for="description" class="flex items-center space-x-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                    </svg>
                                    <span>{{ __('Description') }}</span>
                                </label>
                                <textarea id="description" name="description" rows="4"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200 resize-none">{{ old('description', $department->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>



                            <!-- Chef de département -->
                            <div class="space-y-2">
                                <label for="head_id" class="flex items-center space-x-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>{{ __('Chef de l\'Entité') }}</span>
                                </label>
                                <select id="head_id" name="head_id"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                    <option value="">Sélectionner un chef de l'Entité</option>
                                    @foreach($departmentHeads as $user)
                                        <option value="{{ $user->id }}" {{ old('head_id', $department->head_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('head_id')" class="mt-2" />
                            </div>

                           

                            <!-- Boutons d'action -->
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 sm:gap-4 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('admin.departments.show', $department) }}" 
                                    class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-600 rounded-lg sm:rounded-xl font-medium sm:font-semibold text-sm sm:text-base text-gray-700 dark:text-gray-300 transition-colors duration-200 order-2 sm:order-1">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span class="hidden sm:inline">{{ __('Annuler') }}</span>
                                    <span class="sm:hidden">{{ __('Annuler') }}</span>
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-green-600 hover:bg-green-700 border border-transparent rounded-lg sm:rounded-xl font-medium sm:font-semibold text-sm sm:text-base text-white transition-colors duration-200 shadow-sm order-1 sm:order-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <span class="hidden sm:inline">{{ __('Mettre à jour') }}</span>
                                    <span class="sm:hidden">{{ __('Modifier') }}</span>
                                </button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
