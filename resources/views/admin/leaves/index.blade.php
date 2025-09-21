<x-app-layout>
   

    <div class="pb-12">
        

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 mb-8 shadow-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">{{ __('Validation des congés') }}</h1>
                        <p class="text-blue-100">Gérez et validez les demandes de congés</p>
                    </div>
                </div>
            </div>
        </div>

     <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-800">
        <div class="p-6 text-gray-900 dark:text-gray-200">

            <x-alert type="success" :message="session('success')" />
            <x-alert type="error" :message="session('error')" />

            <!-- Formulaire de recherche et filtres -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 mb-8">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-lime-500 to-emerald-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Filtres de recherche</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Affinez votre recherche avec les critères ci-dessous</p>
                    </div>
                </div>

                <form action="{{ route('admin.leaves.index') }}" method="GET" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Recherche par nom -->
                        <div class="space-y-2">
                            <label for="search" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Rechercher un employé
                            </label>
                            <div class="relative">
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 shadow-sm"
                                    placeholder="Nom, email ou ID">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Département -->
                        <div class="space-y-2">
                            <label for="department" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Entité
                            </label>
                            <select name="department" id="department"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-200 shadow-sm">
                                <option value="">Tous les entités</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Statut -->
                        <div class="space-y-2">
                            <label for="status" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Statut
                            </label>
                            <select name="status" id="status"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-200 shadow-sm">
                                <option value="">Tous les statuts</option>
                                @foreach(\App\Models\Leave::STATUSES as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type de congé -->
                        <div class="space-y-2">
                            <label for="type" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Type de congé
                            </label>
                            <select name="type" id="type"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 transition-all duration-200 shadow-sm">
                                <option value="">Tous les types</option>
                                @foreach(\App\Models\SpecialLeaveType::where('is_active', true)->orderBy('name')->get() as $specialLeaveType)
                                    <option value="{{ $specialLeaveType->system_name ?: $specialLeaveType->name }}" {{ request('type') == ($specialLeaveType->system_name ?: $specialLeaveType->name) ? 'selected' : '' }}>
                                        {{ $specialLeaveType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Période -->
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Période
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label for="date_from" class="text-xs font-medium text-gray-600 dark:text-gray-400">Date de début</label>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-200 shadow-sm">
                            </div>
                            <div class="space-y-1">
                                <label for="date_to" class="text-xs font-medium text-gray-600 dark:text-gray-400">Date de fin</label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-200 shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.leaves.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 hover:bg-gray-700 border border-transparent rounded-xl font-semibold text-sm text-white transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Réinitialiser
                        </a>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Filtrer les résultats
                        </button>
                    </div>
                </form>
            </div>


            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <div class="bg-green-100 dark:bg-green-900/30 rounded-xl p-3 mr-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Demandes de congés</h3>
                    </div>

                    <!-- Boutons de basculement vue -->
                    <div class="flex justify-end">
                        <div class="view-toggle-container">
                            <button id="table-view-btn" class="view-toggle-btn active">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18m-9 8h9"/>
                                </svg>
                                <span>Vue Tableau</span>
                            </button>
                            <button id="calendar-view-btn" class="view-toggle-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Vue Calendrier</span>
                            </button>
                        </div>
                    </div>

                </div>


                <!-- Vue Calendrier (cachée par défaut) -->
                <div id="calendar-view" class="hidden calendar-container mb-6">
                    <div class="p-6">
                        <div id="calendar" class="relative"></div>
                    </div>
                </div>

                <!-- Vue Tableau -->
                <div id="table-view" class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Employé
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            Département
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Type
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Période
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Durée
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Motif
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                            </svg>
                                            Pièces jointes
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Statut
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                            </svg>
                                            Actions
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($leaves as $leave)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div class="h-12 w-12 rounded-full border-4 border-gray-400 bg-gray-50 dark:bg-green-700  flex items-center justify-center">
                                                    <span class="text-sm font-bold text-gray-400">
                                                        {{ substr($leave->user->first_name, 0, 1) }}{{ substr($leave->user->last_name, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $leave->user->first_name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $leave->user->email }}</div>
                                                <div class="text-xs text-gray-400 dark:text-gray-500">ID: {{ $leave->user->employee_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            {{ $leave->user->department?->name ?? 'Non assigné' }}
                                        </div>
                                        @if($leave->user->department?->code)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $leave->user->department->code }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap max-w-[205px]">
                                        <x-leave-type-badge :type="$leave->specialLeaveType?->system_name ?: 'unknown'" :specialLeaveType="$leave->specialLeaveType" />
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $leave->start_date->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            au {{ $leave->end_date->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $leave->duration }} jour(s)
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 max-w-[100px]">
                                        <div class="max-w-xs">
                                            <div class="text-sm text-gray-900 dark:text-gray-100 truncate" title="{{ $leave->reason }}">
                                                {{ Str::limit($leave->reason, 50) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @if($leave->attachments->count() > 0)
                                            <div class="flex flex-col space-y-1">
                                                @foreach($leave->attachments as $attachment)
                                                    <a href="{{ route('leaves.attachment.download', $attachment) }}" 
                                                        class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200 hover:bg-pink-200 dark:hover:bg-pink-800 transition-colors duration-200">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                        {{ Str::limit($attachment->original_filename, 15) }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500 text-sm">Aucune pièce jointe</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <x-leave-status :status="$leave->status" />
                                        @if($leave->processed_at)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $leave->processed_at->format('d/m/Y H:i') }}
                                            </div>
                                        @endif
                                    </td>
                                

                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @if($leave->status === 'pending' && Auth::check() && auth()->user()->canManageUserLeaves($leave->user))
                                            <div class="flex space-x-2">
                                                <button title="Approuver" @click="$dispatch('approve-leave', '{{ route('leaves.approve', $leave) }}')" 
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Approuver
                                                </button>
                                                <button title="Rejeter" @click="$dispatch('reject-leave', '{{ route('leaves.reject', $leave) }}')" 
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Rejeter
                                                </button>
                                            </div>
                                        @else
                                            @if($leave->status === 'approved')
                                                <div class="inline-flex items-center px-3 py-2 text-sm text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded-lg">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Approuvé
                                                </div>
                                            @elseif($leave->status === 'rejected')
                                                <div class="inline-flex items-center px-3 py-2 text-sm text-red-700 bg-red-100 dark:bg-red-900/30 dark:text-red-400 rounded-lg">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Rejeté
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Aucune demande de congé</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Il n'y a actuellement aucune demande de congé à afficher.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($leaves instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <!-- Pagination -->
                        <x-pagination :paginator="$leaves" entity-name="congés" />
                    @endif
                </div>



            </div>




            

            

           


        </div>
    </div>

    <x-modals.approve-leave message="Êtes-vous sûr de vouloir approuver cette demande de congé ? Cette action déduira automatiquement les jours du solde de l'employé." />
    <x-modals.reject-leave message="Êtes-vous sûr de vouloir rejeter cette demande de congé ?" />

    @push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <!-- Les styles du calendrier sont maintenant dans le fichier SCSS _calendar.scss -->
    @endpush

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableViewBtn = document.getElementById('table-view-btn');
            const calendarViewBtn = document.getElementById('calendar-view-btn');
            const tableView = document.getElementById('table-view');
            const calendarView = document.getElementById('calendar-view');
            const calendarEl = document.getElementById('calendar');
            
            let calendar;
            let currentView = 'table';

            // Fonction pour basculer entre les vues
            function switchView(view) {
                if (view === 'calendar') {
                    // Transition avec animation
                    tableView.classList.add('view-transition-exit-active');
                    setTimeout(() => {
                        tableView.classList.add('hidden');
                        tableView.classList.remove('view-transition-exit-active');
                        
                        calendarView.classList.remove('hidden');
                        calendarView.classList.add('view-transition-enter-active');
                        
                        setTimeout(() => {
                            calendarView.classList.remove('view-transition-enter-active');
                        }, 300);
                    }, 150);
                    
                    // Mettre à jour les styles des boutons
                    tableViewBtn.classList.remove('active');
                    calendarViewBtn.classList.add('active');
                    
                    // Initialiser le calendrier si ce n'est pas déjà fait
                    if (!calendar) {
                        setTimeout(() => {
                            initializeCalendar();
                        }, 200);
                    }
                    
                    currentView = 'calendar';
                } else {
                    // Transition avec animation
                    calendarView.classList.add('view-transition-exit-active');
                    setTimeout(() => {
                        calendarView.classList.add('hidden');
                        calendarView.classList.remove('view-transition-exit-active');
                        
                        tableView.classList.remove('hidden');
                        tableView.classList.add('view-transition-enter-active');
                        
                        setTimeout(() => {
                            tableView.classList.remove('view-transition-enter-active');
                        }, 300);
                    }, 150);
                    
                    // Mettre à jour les styles des boutons
                    calendarViewBtn.classList.remove('active');
                    tableViewBtn.classList.add('active');
                    
                    currentView = 'table';
                }
            }

            // Variable pour suivre la vue actuelle du calendrier
            let currentCalendarView = 'dayGridMonth';

            // Fonction pour initialiser le calendrier
            function initializeCalendar() {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'fr',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek,listWeek'
                    },
                    views: {
                        dayGridMonth: {
                            buttonText: 'Mois'
                        },
                        dayGridWeek: {
                            buttonText: 'Semaine'
                        },
                        listWeek: {
                            buttonText: 'Liste'
                        }
                    },
                    buttonText: {
                        today: 'Aujourd\'hui',
                        month: 'Mois',
                        week: 'Semaine',
                        list: 'Liste'
                    },
                    viewDidMount: function(info) {
                        // Mettre à jour la vue actuelle quand elle change
                        currentCalendarView = info.view.type;
                    },
                    customButtons: {
                        dayGridMonth: {
                            text: 'Mois',
                            click: function() {
                                if (currentCalendarView === 'dayGridMonth') {
                                    // Si on est déjà en vue mois, ne rien faire (c'est la vue par défaut)
                                    return;
                                }
                                calendar.changeView('dayGridMonth');
                            }
                        },
                        dayGridWeek: {
                            text: 'Semaine',
                            click: function() {
                                if (currentCalendarView === 'dayGridWeek') {
                                    // Si on est déjà en vue semaine, revenir à la vue mois
                                    calendar.changeView('dayGridMonth');
                                } else {
                                    calendar.changeView('dayGridWeek');
                                }
                            }
                        },
                        listWeek: {
                            text: 'Liste',
                            click: function() {
                                if (currentCalendarView === 'listWeek') {
                                    // Si on est déjà en vue liste, revenir à la vue mois
                                    calendar.changeView('dayGridMonth');
                                } else {
                                    calendar.changeView('listWeek');
                                }
                            }
                        }
                    },
                    events: function(fetchInfo, successCallback, failureCallback) {
                        // Récupérer les paramètres de filtrage actuels
                        const urlParams = new URLSearchParams(window.location.search);
                        const filterParams = {
                            search: urlParams.get('search') || '',
                            department: urlParams.get('department') || '',
                            status: urlParams.get('status') || '',
                            type: urlParams.get('type') || '',
                            date_from: urlParams.get('date_from') || '',
                            date_to: urlParams.get('date_to') || ''
                        };

                        fetch('{{ route("admin.leaves.calendar-data") }}?' + new URLSearchParams(filterParams))
                            .then(response => response.json())
                            .then(data => {
                                successCallback(data);
                            })
                            .catch(error => {
                                console.error('Erreur lors du chargement des données:', error);
                                failureCallback(error);
                            });
                    },
                    eventClick: function(info) {
                        // Rediriger vers la page de détail du congé
                        if (info.event.extendedProps.url) {
                            window.location.href = info.event.extendedProps.url;
                        }
                    },
                    eventMouseEnter: function(info) {
                        // Créer un tooltip avec les nouvelles classes CSS
                        const tooltip = document.createElement('div');
                        tooltip.className = 'fc-tooltip';
                        tooltip.style.position = 'absolute';
                        tooltip.style.zIndex = '1000';
                        tooltip.style.pointerEvents = 'none';
                        
                        const props = info.event.extendedProps;
                        tooltip.innerHTML = `
                            <div class="tooltip-header">${props.employee}</div>
                            <div class="tooltip-row">
                                <div class="tooltip-label">Département:</div>
                                <div class="tooltip-value">${props.department}</div>
                            </div>
                            <div class="tooltip-row">
                                <div class="tooltip-label">Type:</div>
                                <div class="tooltip-value">${props.type}</div>
                            </div>
                            <div class="tooltip-row">
                                <div class="tooltip-label">Statut:</div>
                                <div class="tooltip-value">${props.status}</div>
                            </div>
                            <div class="tooltip-row">
                                <div class="tooltip-label">Durée:</div>
                                <div class="tooltip-value">${props.duration} jour(s)</div>
                            </div>
                            ${props.reason ? `
                                <div class="tooltip-row">
                                    <div class="tooltip-label">Motif:</div>
                                    <div class="tooltip-value">${props.reason}</div>
                                </div>
                            ` : ''}
                        `;
                        
                        document.body.appendChild(tooltip);
                        info.el.tooltip = tooltip;
                        
                        // Positionner le tooltip
                        const rect = info.el.getBoundingClientRect();
                        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
                        
                        tooltip.style.left = (rect.left + scrollLeft) + 'px';
                        tooltip.style.top = (rect.bottom + scrollTop + 5) + 'px';
                        
                        // Ajuster la position si le tooltip dépasse de l'écran
                        setTimeout(() => {
                            const tooltipRect = tooltip.getBoundingClientRect();
                            if (tooltipRect.right > window.innerWidth) {
                                tooltip.style.left = (rect.right + scrollLeft - tooltipRect.width) + 'px';
                            }
                            if (tooltipRect.bottom > window.innerHeight) {
                                tooltip.style.top = (rect.top + scrollTop - tooltipRect.height - 5) + 'px';
                            }
                        }, 0);
                    },
                    eventMouseLeave: function(info) {
                        // Supprimer le tooltip
                        if (info.el.tooltip) {
                            document.body.removeChild(info.el.tooltip);
                            info.el.tooltip = null;
                        }
                    }
                });
                
                calendar.render();
            }

            // Gestionnaires d'événements pour les boutons
            tableViewBtn.addEventListener('click', () => switchView('table'));
            calendarViewBtn.addEventListener('click', () => switchView('calendar'));

            // Recharger le calendrier quand les filtres changent
            const form = document.querySelector('form[action="{{ route('admin.leaves.index') }}"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (currentView === 'calendar' && calendar) {
                        e.preventDefault();
                        
                        // Mettre à jour l'URL avec les nouveaux paramètres
                        const formData = new FormData(form);
                        const params = new URLSearchParams();
                        for (let [key, value] of formData.entries()) {
                            if (value) params.append(key, value);
                        }
                        
                        const newUrl = window.location.pathname + '?' + params.toString();
                        window.history.pushState({}, '', newUrl);
                        
                        // Recharger les événements du calendrier
                        calendar.refetchEvents();
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
