<x-app-layout>
    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête modernisé -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-2xl shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Nouveau département') }}</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Créez un nouveau département pour organiser votre équipe</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.departments.index') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 border border-transparent rounded-xl font-semibold text-white transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Formulaire modernisé -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-8">
                            <form method="POST" action="{{ route('admin.departments.store') }}" class="space-y-8">
                                @csrf

                                <!-- Nom du département -->
                                <div class="space-y-2">
                                    <label for="name" class="flex items-center space-x-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span>{{ __('Nom du département') }}</span>
                                    </label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Code du département -->
                                <div class="space-y-2">
                                    <label for="code" class="flex items-center space-x-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <span>{{ __('Code du département') }}</span>
                                    </label>
                                    <input id="code" type="text" name="code" value="{{ old('code') }}" required
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Le code doit être unique et sera utilisé comme identifiant.</span>
                                    </p>
                                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
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
                                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200 resize-none">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <!-- Chef de département -->
                                <div class="space-y-2">
                                    <label for="head_id" class="flex items-center space-x-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>{{ __('Chef de département') }}</span>
                                    </label>
                                    <select id="head_id" name="head_id"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                        <option value="">Sélectionner un chef de département</option>
                                        @foreach($departmentHeads as $head)
                                            <option value="{{ $head->id }}" {{ old('head_id') == $head->id ? 'selected' : '' }}>
                                                {{ $head->name }} ({{ $head->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Seuls les utilisateurs avec le rôle "Chef de département" qui ne sont pas déjà assignés à un département sont listés ici.</span>
                                    </p>
                                    <x-input-error :messages="$errors->get('head_id')" class="mt-2" />
                                </div>

                        {{-- <div>
                            <x-input-label for="manager_id" :value="__('Manager')" />
                            <select id="manager_id" name="manager_id" class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Sélectionner un manager</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }} ({{ $manager->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('manager_id')" class="mt-2" />
                        </div> --}}

                                <!-- Boutons d'action -->
                                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('admin.departments.index') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-600 rounded-xl font-semibold text-gray-700 dark:text-gray-300 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        {{ __('Annuler') }}
                                    </a>
                                    <button type="submit" 
                                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 border border-transparent rounded-xl font-semibold text-white transition-colors duration-200 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        {{ __('Créer le département') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
