@section('title', 'Dashboard des Soldes de Congés')

<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- En-tête -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            Dashboard des Soldes de Congés
                        </h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Gestion et supervision des soldes de congés pour l'année {{ $year }}
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.leave-balances.tools') }}" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Outils Admin
                        </a>
                        <a href="{{ route('admin.leave-balances.adjustments') }}" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-8">
                <form method="GET" action="{{ route('admin.leave-balances.dashboard') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-64">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rechercher</label>
                        <input type="text" id="search" name="search" value="{{ $search }}" 
                            placeholder="Nom, email, matricule..."
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="min-w-48">
                        <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Département</label>
                        <select id="department_id" name="department_id" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Tous les départements</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ $departmentId == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="min-w-32">
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Année</label>
                        <select id="year" name="year" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @for($y = now()->year + 1; $y >= now()->year - 3; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>

            <!-- Liste des utilisateurs -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Soldes des Utilisateurs ({{ $users->total() }} utilisateurs)
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Département
                                </th>
                                @foreach($leaveTypes as $leaveType)
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ $leaveType->name }}
                                    </th>
                                @endforeach
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                                                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
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
                                                    <div class="font-medium {{ $balance->current_balance < 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('admin.leave-balances.adjustments', ['user_id' => $user->id, 'year' => $year]) }}" 
                                        class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-medium rounded-full transition-colors">
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

                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>