@section('title', 'Ajustements Manuels des Soldes')

<x-app-layout>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- En-tête moderne -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Ajustements Manuels</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Modifier les soldes de congés individuellement pour l'année {{ $year }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.leave-balances.dashboard') }}"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium rounded-xl hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.leave-balances.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                       
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        Soldes
                    </a>
                    <a href="{{ route('admin.leave-balances.tools') }}"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Outils Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages de statut -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Sélection utilisateur -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filtres de recherche</h3>
                    </div>

                    <form method="GET" action="{{ route('admin.leave-balances.adjustments') }}" class="space-y-4">
                        <div>
                            <label for="search" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Recherche
                            </label>
                            <input type="text" id="search" name="search" value="{{ $search }}" 
                                   placeholder="Nom, email, matricule..."
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="year" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Année
                            </label>
                            <select id="year" name="year" 
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                @for($y = now()->year + 1; $y >= now()->year - 3; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z" />
                                </svg>
                                Rechercher
                            </button>
                            <a href="{{ route('admin.leave-balances.adjustments') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 dark:from-gray-600 dark:to-gray-700 text-white font-medium rounded-xl hover:from-gray-600 hover:to-gray-700 dark:hover:from-gray-700 dark:hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Réinitialiser
                            </a>
                        </div>
                    </form>

                    @if($users->count() > 0)
                        <div class="mt-6 space-y-2 max-h-96 overflow-y-auto">
                            @foreach($users as $user)
                                <a href="{{ route('admin.leave-balances.adjustments', ['user_id' => $user->id, 'year' => $year, 'search' => $search]) }}" 
                                   class="block p-3 rounded-lg border {{ $selectedUser && $selectedUser->id == $user->id ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-all">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-semibold">
                                                {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                {{ $user->matricule }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ajustements -->
            <div class="lg:col-span-2">
                @if($selectedUser)
                    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Soldes de {{ $selectedUser->first_name }} {{ $selectedUser->last_name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $selectedUser->matricule }} • Année {{ $year }}
                                </p>
                            </div>
                        </div>

                        @if($balances->count() > 0)
                            <div class="space-y-6">
                                @foreach($balances as $balance)
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 bg-white/60 dark:bg-gray-800/60">
                                        <div class="flex items-center justify-between mb-4">
                                            <div>
                                                <h4 class="font-medium text-gray-900 dark:text-white">
                                                    {{ $balance->specialLeaveType->name }}
                                                </h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    Solde actuel: {{ $balance->current_balance }} jours
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                                    Initial: {{ $balance->initial_balance }} | Utilisé: {{ $balance->used_balance }}
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('admin.leave-balances.adjust') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            @csrf
                                            <input type="hidden" name="balance_id" value="{{ $balance->id }}">
                                            
                                            <div>
                                                <label for="adjustment_type_{{ $balance->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                    Type d'ajustement
                                                </label>
                                                <select id="adjustment_type_{{ $balance->id }}" name="adjustment_type" required
                                                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                                    <option value="add">Ajouter</option>
                                                    <option value="subtract">Soustraire</option>
                                                    <option value="set">Définir</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label for="amount_{{ $balance->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                    Nombre de jours
                                                </label>
                                                <input type="number" id="amount_{{ $balance->id }}" name="amount" step="0.5" min="0" required
                                                       class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                            </div>

                                            <div class="flex items-end">
                                                <button type="submit" 
                                                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl text-sm">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                    Ajuster
                                                </button>
                                            </div>
                                        </form>

                                        <!-- Historique des ajustements -->
                                        @if($balance->adjustments && $balance->adjustments->count() > 0)
                                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Historique des ajustements
                                                </h5>
                                                <div class="space-y-2 max-h-32 overflow-y-auto">
                                                    @foreach($balance->adjustments->take(5) as $adjustment)
                                                        <div class="flex items-center justify-between text-xs">
                                                            <span class="text-gray-600 dark:text-gray-400">
                                                                {{ $adjustment->created_at->format('d/m/Y H:i') }}
                                                            </span>
                                                            <span class="font-medium {{ $adjustment->amount > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                                {{ $adjustment->amount > 0 ? '+' : '' }}{{ $adjustment->amount }} jours
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Aucun solde trouvé
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Cet utilisateur n'a pas de soldes pour l'année {{ $year }}.
                                </p>
                                <div class="mt-6">
                                    <form action="{{ route('admin.leave-balances.initializeAll') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="year" value="{{ $year }}">
                                        <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                                        <button type="submit" 
                                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Initialiser les soldes
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Ajustement en lot -->
                    @if($balances->count() > 0)
                        <div class="mt-8 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                Ajustement en Lot
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Appliquer le même ajustement à tous les types de congés
                            </p>

                            <form action="{{ route('admin.leave-balances.bulk-adjust') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                                <input type="hidden" name="year" value="{{ $year }}">
                                
                                <div>
                                    <label for="bulk_adjustment_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Type d'ajustement
                                    </label>
                                    <select id="bulk_adjustment_type" name="adjustment_type" required
                                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                        <option value="add">Ajouter</option>
                                        <option value="subtract">Soustraire</option>
                                        <option value="multiply">Multiplier par</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="bulk_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Valeur
                                    </label>
                                    <input type="number" id="bulk_amount" name="amount" step="0.1" min="0" required
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                </div>

                                <div>
                                    <label for="bulk_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Raison
                                    </label>
                                    <input type="text" id="bulk_reason" name="reason" placeholder="Raison de l'ajustement"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                </div>

                                <div class="flex items-end">
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                        Appliquer à Tous
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                                Sélectionnez un utilisateur
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Utilisez le panneau de gauche pour rechercher et sélectionner un utilisateur.
                            </p>
                            <!-- Interface d'ajustement global -->
                            <div class="mt-8 text-left">
                                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <div class="p-2 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600 text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3-3m0 0l3 3h4m-7-3v10" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ajustement Global par Type</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Appliquer un ajustement à tous les salariés d'un département ou à toute l'entreprise.</p>
                                        </div>
                                    </div>

                                    <form action="{{ route('admin.leave-balances.global-adjust') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                        @csrf
                                        <input type="hidden" name="year" value="{{ $year }}">

                                        <div class="md:col-span-2">
                                            <label for="global_special_leave_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type de congé</label>
                                            <select id="global_special_leave_type_id" name="special_leave_type_id" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                                @foreach($leaveTypes as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label for="global_scope" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Portée</label>
                                            <select id="global_scope" name="scope" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                                <option value="department">Par département</option>
                                                <option value="all">Tous les salariés</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="global_department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Département</label>
                                            <select id="global_department_id" name="department_id" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                                <option value="">Tous</option>
                                                @foreach($departments as $dept)
                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                @endforeach
                                            </select>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ignoré si "Tous les salariés" est choisi.</p>
                                        </div>

                                        <div>
                                            <label for="global_adjustment_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Action</label>
                                            <select id="global_adjustment_type" name="adjustment_type" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                                <option value="add">Ajouter</option>
                                                <option value="subtract">Soustraire</option>
                                                <option value="set">Définir</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="global_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre de jours</label>
                                            <input type="number" id="global_amount" name="amount" step="0.5" min="0" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                        </div>

                                        <div class="md:col-span-5">
                                            <label for="global_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Raison</label>
                                            <input type="text" id="global_reason" name="reason" placeholder="Raison de l'ajustement" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                                        </div>

                                        <div class="md:col-span-5 flex items-center justify-end space-x-3">
                                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Appliquer l'ajustement global
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>