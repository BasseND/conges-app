@section('title', 'Validation des congés')
<x-app-layout>
    <div class="pb-8">
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
                        <p class="text-blue-100">Gérez et validez les demandes de congés de votre équipe</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Formulaire de recherche et filtres -->
        <div class="bg-white/80 backdrop-blur-sm overflow-hidden sm:rounded-2xl mb-8 border border-gray-200/50 dark:bg-gray-800/80 dark:border-gray-700/50">
            <div class="p-8 bg-gradient-to-br from-white to-gray-50/50 dark:from-gray-800 dark:to-gray-900/50">
                <div class="flex items-center mb-6">
                    <div class="bg-blue-100 dark:bg-blue-900/30 rounded-xl p-3 mr-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Filtres de recherche</h3>
                </div>
                <form action="{{ route('manager.leaves.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Recherche par nom -->
                    <div class="group">
                        <label for="search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Rechercher un employé
                        </label>
                        <div class="relative">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 pl-10 transition-all duration-200 group-hover:shadow-md"
                                placeholder="Nom, email ou ID">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Statut -->
                    <div class="group">
                        <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Statut
                        </label>
                        <select name="status" id="status"
                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 transition-all duration-200 group-hover:shadow-md">
                            <option value="">Tous les statuts</option>
                            @foreach(\App\Models\Leave::STATUSES as $value => $label)
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type de congé -->
                    <div class="group">
                        <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Type de congé
                        </label>
                        <select name="type" id="type"
                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 transition-all duration-200 group-hover:shadow-md">
                            <option value="">Tous les types</option>
                            @foreach(\App\Models\SpecialLeaveType::where('is_active', true)->get() as $specialType)
                                <option value="{{ $specialType->system_name }}" {{ request('type') == $specialType->system_name ? 'selected' : '' }}>
                                    {{ $specialType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Période -->
                    <div class="md:col-span-2 group">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Période
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 transition-all duration-200 group-hover:shadow-md">
                            </div>
                            <div>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 transition-all duration-200 group-hover:shadow-md">
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="md:col-span-3 flex justify-end space-x-4 pt-4">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Filtrer
                        </button>

                        <a href="{{ route('manager.leaves.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            

            
            
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700">
            <!-- Header -->
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Vue Calendrier</span>
                        </button>
                    </div>
                </div>

            </div>

           

            <!-- Vue Calendrier -->
            <div id="calendar-view" class="hidden calendar-container mb-6">
                <div class="p-6">
                    <div id="calendar" class="relative"></div>
                </div>
            </div>

            <!-- Vue Tableau -->
            <div id="table-view" >
                <div class="bg-gradient-to-br from-white to-gray-50/50 dark:from-gray-800 dark:to-gray-900/50">
                    
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-xl" role="alert">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-green-700 font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-xl" role="alert">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-red-700 font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($leaves->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Aucune demande trouvée</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Aucune demande de congé ne correspond à vos critères de recherche.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                Employé
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                Département
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                Type
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Période
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Durée
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Statut
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                                </svg>
                                                Actions
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach($leaves as $leave)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 group">
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-12 w-12">
                                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                                                            {{ strtoupper(substr($leave->user->first_name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $leave->user->first_name }} {{ $leave->user->last_name }}</div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $leave->user->email }}</div>
                                                        <div class="text-xs text-gray-400 dark:text-gray-500">ID: {{ $leave->user->employee_id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $leave->user->department->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-md inline-block mt-1">{{ $leave->user->department->code }}</div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <x-leave-type-badge :type="$leave->specialLeaveType?->system_name ?: 'unknown'" :specialLeaveType="$leave->specialLeaveType" />
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white font-medium">
                                                    <div class="flex items-center mb-1">
                                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        {{ $leave->start_date->format('d/m/Y') }}
                                                    </div>
                                                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                                                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        {{ $leave->end_date->format('d/m/Y') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $leave->duration }}</span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">jour(s)</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <x-leave-status :status="$leave->status" />
                                                @if($leave->processed_at)
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        {{ $leave->processed_at->format('d/m/Y H:i') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-right">
                                                @if($leave->status === 'pending' && Auth::check() && auth()->user()->canManageUserLeaves($leave->user))
                                                    <div class="flex justify-end space-x-3">
                                                        <button title="Approuver" @click="$dispatch('approve-leave', '{{ route('manager.leaves.approve', $leave) }}')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            Approuver
                                                        </button>
                                                        <button title="Rejeter" @click="$dispatch('reject-leave', '{{ route('manager.leaves.reject', $leave) }}')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            Rejeter
                                                        </button>
                                                    </div>
                                                @elseif($leave->status === 'approved' && Auth::check() && auth()->user()->can('approve-leaves'))
                                                    <div class="flex justify-end">
                                                        <button title="Annuler le congé" 
                                                            x-data="{ showCancelModal: false }"
                                                            @click="showCancelModal = true"
                                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            Annuler
                                                        </button>

                                                        <!-- Modal d'annulation -->
                                                        <div x-show="showCancelModal" 
                                                            x-transition:enter="ease-out duration-300"
                                                            x-transition:enter-start="opacity-0"
                                                            x-transition:enter-end="opacity-100"
                                                            x-transition:leave="ease-in duration-200"
                                                            x-transition:leave-start="opacity-100"
                                                            x-transition:leave-end="opacity-0"
                                                            class="fixed inset-0 z-50 overflow-y-auto" 
                                                            style="display: none;">
                                                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showCancelModal = false"></div>
                                                                
                                                                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                    <form method="POST" action="{{ route('leaves.cancel', $leave) }}">
                                                                        @csrf
                                                                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                            <div class="sm:flex sm:items-start">
                                                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 dark:bg-orange-900 sm:mx-0 sm:h-10 sm:w-10">
                                                                                    <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                                                    </svg>
                                                                                </div>
                                                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                                                                        Annuler le congé
                                                                                    </h3>
                                                                                    <div class="mt-2">
                                                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                                                            Êtes-vous sûr de vouloir annuler ce congé approuvé ? Cette action est irréversible et le solde de congé sera restauré.
                                                                                        </p>
                                                                                        <div class="mt-4">
                                                                                            <label for="cancel_reason_{{ $leave->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                                                Motif d'annulation <span class="text-red-500">*</span>
                                                                                            </label>
                                                                                            <textarea 
                                                                                                id="cancel_reason_{{ $leave->id }}"
                                                                                                name="cancel_reason" 
                                                                                                rows="3" 
                                                                                                required
                                                                                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm"
                                                                                                placeholder="Veuillez indiquer le motif de l'annulation..."></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                            <button type="submit" 
                                                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                Confirmer l'annulation
                                                                            </button>
                                                                            <button type="button" 
                                                                                @click="showCancelModal = false"
                                                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                Annuler
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="flex justify-end">
                                                        @if($leave->status === 'approved')
                                                            <span class="inline-flex items-center px-3 py-2 text-sm text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded-lg">
                                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                Approuvé
                                                            </span>
                                                        @elseif($leave->status === 'rejected')
                                                            <span class="inline-flex items-center px-3 py-2 text-sm text-red-700 bg-red-100 dark:bg-red-900/30 dark:text-red-400 rounded-lg">
                                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                </svg>
                                                                Rejeté
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($leaves instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <!-- Pagination -->
                            <x-pagination :paginator="$leaves" entity-name="congés" />
                        @endif
                    @endif
                </div>
            </div>
        </div>
      
    </div>

    <x-modals.approve-leave message="Êtes-vous sûr de vouloir approuver cette demande de congé ?" />
    <x-modals.reject-leave message="Êtes-vous sûr de vouloir rejeter cette demande de congé ?" />

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/fr.global.min.js'></script>

    <!-- Styles pour le tooltip -->
    <style>
        .tooltip {
            position: absolute;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            line-height: 1.4;
            max-width: 250px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            pointer-events: none;
        }
        
        .tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: rgba(0, 0, 0, 0.9) transparent transparent transparent;
        }
    </style>

   

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableViewBtn = document.getElementById('table-view-btn');
            const calendarViewBtn = document.getElementById('calendar-view-btn');
            const tableView = document.getElementById('table-view');
            const calendarView = document.getElementById('calendar-view');
            const calendarEl = document.getElementById('calendar');
            let calendar;
            let tooltip;
            let currentCalendarView = 'dayGridMonth';

            // Fonction pour basculer entre les vues
            function switchView(viewType) {
                if (viewType === 'table') {
                    tableView.classList.remove('hidden');
                    calendarView.classList.add('hidden');
                    tableViewBtn.classList.add('active');
                    calendarViewBtn.classList.remove('active');
                } else {
                    tableView.classList.add('hidden');
                    calendarView.classList.remove('hidden');
                    tableViewBtn.classList.remove('active');
                    calendarViewBtn.classList.add('active');
                    
                    // Initialiser le calendrier si ce n'est pas déjà fait
                    if (!calendar) {
                        initCalendar();
                    }
                }
            }

            // Gestionnaires d'événements pour les boutons
            tableViewBtn.addEventListener('click', () => switchView('table'));
            calendarViewBtn.addEventListener('click', () => switchView('calendar'));

            // Fonction pour initialiser le calendrier
            function initCalendar() {
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
                                    return;
                                }
                                calendar.changeView('dayGridMonth');
                            }
                        },
                        dayGridWeek: {
                            text: 'Semaine',
                            click: function() {
                                if (currentCalendarView === 'dayGridWeek') {
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
                                    calendar.changeView('dayGridMonth');
                                } else {
                                    calendar.changeView('listWeek');
                                }
                            }
                        }
                    },
                    height: 'auto',
                    events: function(fetchInfo, successCallback, failureCallback) {
                        // Récupérer les paramètres de filtrage actuels
                        const formData = new FormData(document.querySelector('form'));
                        const params = new URLSearchParams();
                        
                        for (let [key, value] of formData.entries()) {
                            if (value) {
                                params.append(key, value);
                            }
                        }
                        
                        params.append('start', fetchInfo.startStr);
                        params.append('end', fetchInfo.endStr);
                        
                        fetch(`{{ route('manager.leaves.calendar-data') }}?${params.toString()}`)
                            .then(response => response.json())
                            .then(data => {
                                successCallback(data);
                            })
                            .catch(error => {
                                console.error('Erreur lors du chargement des événements:', error);
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
                        // Créer et afficher le tooltip
                        tooltip = document.createElement('div');
                        tooltip.className = 'tooltip';
                        tooltip.innerHTML = `
                            <div style="font-weight: 600; margin-bottom: 4px;">${info.event.extendedProps.employee}</div>
                            <div style="font-size: 12px; opacity: 0.9;">
                                <div><strong>Département:</strong> ${info.event.extendedProps.department}</div>
                                <div><strong>Type:</strong> ${info.event.extendedProps.type}</div>
                                <div><strong>Durée:</strong> ${info.event.extendedProps.duration} jour(s)</div>
                                <div><strong>Statut:</strong> ${info.event.extendedProps.status}</div>
                                ${info.event.extendedProps.reason ? `<div><strong>Motif:</strong> ${info.event.extendedProps.reason}</div>` : ''}
                            </div>
                        `;
                        document.body.appendChild(tooltip);
                        
                        // Positionner le tooltip
                        const rect = info.el.getBoundingClientRect();
                        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
                        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        
                        tooltip.style.left = (rect.left + scrollLeft + (rect.width / 2)) + 'px';
                        tooltip.style.top = (rect.top + scrollTop - tooltip.offsetHeight - 10) + 'px';
                        
                        // Ajuster la position si le tooltip dépasse de l'écran
                        setTimeout(() => {
                            const tooltipRect = tooltip.getBoundingClientRect();
                            if (tooltipRect.right > window.innerWidth) {
                                tooltip.style.left = (rect.right + scrollLeft - tooltipRect.width) + 'px';
                            }
                            if (tooltipRect.top < 0) {
                                tooltip.style.top = (rect.bottom + scrollTop + 5) + 'px';
                            }
                        }, 0);
                    },
                    eventMouseLeave: function(info) {
                        // Supprimer le tooltip
                        if (tooltip) {
                            tooltip.remove();
                            tooltip = null;
                        }
                    }
                });
                
                calendar.render();
            }

            // Recharger le calendrier lors des changements de filtres
            const filterInputs = document.querySelectorAll('input[name="start_date"], input[name="end_date"], select[name="status"], select[name="type"], select[name="department_id"]');
            filterInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (calendar && !calendarView.classList.contains('hidden')) {
                        calendar.refetchEvents();
                    }
                });
            });

            // Recharger le calendrier lors du clic sur les boutons de filtre
            document.addEventListener('click', function(e) {
                if (e.target.matches('button[type="submit"]') || e.target.closest('button[type="submit"]')) {
                    setTimeout(() => {
                        if (calendar && !calendarView.classList.contains('hidden')) {
                            calendar.refetchEvents();
                        }
                    }, 100);
                }
            });
        });
    </script>

</x-app-layout>
