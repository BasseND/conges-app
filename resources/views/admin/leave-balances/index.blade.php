@section('title', 'Administration des Soldes de Congés')
<x-app-layout>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- En-tête -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Administration des Soldes de Congés
                            </h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Gestion complète des soldes de congés pour l'année {{ $year }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.leave-balances.dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium rounded-xl hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.leave-balances.tools') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Outils Admin
                        </a>
                        <a href="{{ route('admin.leave-balances.adjustments') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Ajustements
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Utilisateurs Actifs</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_users']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Avec Soldes</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['users_with_balances']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Jours Utilisés</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_used_days']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 {{ $stats['negative_balances'] > 0 ? 'bg-red-100 dark:bg-red-900' : 'bg-gray-100 dark:bg-gray-700' }} rounded-lg">
                            <svg class="w-6 h-6 {{ $stats['negative_balances'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Soldes Négatifs</p>
                            <p class="text-2xl font-bold {{ $stats['negative_balances'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                                {{ number_format($stats['negative_balances']) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Filtres de recherche</h3>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.leave-balances.index') }}">
                        <div class="flex flex-wrap items-end gap-4">
                            <div class="flex-1 min-w-[250px]">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Recherche
                                </label>
                                <input type="text" name="search" value="{{ $search }}" placeholder="Nom, email, matricule..." class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                            </div>

                            <div class="flex-1 min-w-[200px]">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-1.414.586H7a4 4 0 01-4-4V7a4 4 0 014-4z"/>
                                    </svg>
                                    Département
                                </label>
                                <select name="department_id" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    <option value="">Tous les départements</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $departmentId == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-1 min-w-[150px]">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Année
                                </label>
                                <select name="year" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    @for($y = now()->year + 1; $y >= now()->year - 3; $y--)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="flex gap-3">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                                    </svg>
                                    Filtrer
                                </button>
                                <a href="{{ route('admin.leave-balances.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 dark:from-gray-600 dark:to-gray-700 text-white font-medium rounded-xl hover:from-gray-600 hover:to-gray-700 dark:hover:from-gray-700 dark:hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Réinitialiser
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Liste des utilisateurs -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-700 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01-8 0m8 0a4 4 0 11-8 0m14 7a4 4 0 01-4 4H6a4 4 0 01-4-4V7a4 4 0 014-4h12a4 4 0 014 4v7z" />
                            </svg>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Soldes des Utilisateurs</h3>
                            <div class="flex items-center space-x-2 ml-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Optimisé
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $users->total() }} utilisateur(s)
                                </span>
                            </div>
                        </div>
                        <div class="hidden lg:flex items-center space-x-2 text-xs text-gray-400 dark:text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Eager loading • Pagination • Recherche</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Département
                                </th>
                                @foreach($leaveTypes as $leaveType)
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        {{ $leaveType->name }}
                                    </th>
                                @endforeach
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg">
                                                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $user->matricule }} • {{ $user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $user->department->name ?? 'N/A' }}
                                    </td>
                                    @foreach($leaveTypes as $leaveType)
                                        @php
                                            $balance = $user->leaveBalances->where('special_leave_type_id', $leaveType->id)->first();
                                        @endphp
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($balance)
                                                <div class="text-sm">
                                                    <div class="font-semibold {{ $balance->current_balance < 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                                                        {{ $balance->current_balance }}/{{ $balance->initial_balance }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        Utilisés: {{ $balance->used_balance }}
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-400 dark:text-gray-500">Non initialisé</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('admin.leave-balances.adjustments', ['user_id' => $user->id, 'year' => $year]) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-xs font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Ajuster
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 3 + count($leaveTypes) }}" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        Aucun utilisateur trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <x-pagination :paginator="$users" entity-name="users" />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>