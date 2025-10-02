@section('title', 'Ajustements Manuels des Soldes')

<x-app-layout>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Ajustements Manuels
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Modifier les soldes de congés individuellement
                    </p>
                </div>
                <a href="{{ route('admin.leave-balances.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour au Dashboard
                </a>
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
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Sélectionner un Utilisateur
                    </h3>

                    <form method="GET" action="{{ route('admin.leave-balances.adjustments') }}" class="space-y-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Rechercher
                            </label>
                            <input type="text" id="search" name="search" value="{{ $search }}" 
                                   placeholder="Nom, email, matricule..."
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Année
                            </label>
                            <select id="year" name="year" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @for($y = now()->year + 1; $y >= now()->year - 3; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" 
                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            Rechercher
                        </button>
                    </form>

                    @if($users->count() > 0)
                        <div class="mt-6 space-y-2 max-h-96 overflow-y-auto">
                            @foreach($users as $user)
                                <a href="{{ route('admin.leave-balances.adjustments', ['user_id' => $user->id, 'year' => $year, 'search' => $search]) }}" 
                                   class="block p-3 rounded-lg border {{ $selectedUser && $selectedUser->id == $user->id ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors">
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
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
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
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
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
                                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
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
                                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                            </div>

                                            <div class="flex items-end">
                                                <button type="submit" 
                                                        class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors text-sm">
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
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
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
                        <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
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
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
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
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>

                                <div>
                                    <label for="bulk_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Raison
                                    </label>
                                    <input type="text" id="bulk_reason" name="reason" placeholder="Raison de l'ajustement"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>

                                <div class="flex items-end">
                                    <button type="submit" 
                                            class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors text-sm">
                                        Appliquer à Tous
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
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
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>