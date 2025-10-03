
@section('title', 'Outils d\'Administration des Soldes')

<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- En-tête moderne -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Outils d'Administration</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Initialisation et vérification des soldes de congés</p>
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
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197" />
                            </svg>
                            Soldes
                        </a>
                        <a href="{{ route('admin.leave-balances.adjustments') }}"
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Ajustements
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Initialisation des soldes -->
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-3 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Initialisation des Soldes
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Créer les soldes pour une année donnée
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.leave-balances.initializeAll') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="init_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Année à initialiser
                            </label>
                            <select id="init_year" name="year" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                @for($y = now()->year + 2; $y >= now()->year - 2; $y--)
                                    <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Département (optionnel)
                            </label>
                            <select id="department_id" name="department_id"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                <option value="">Tous les départements</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="force" name="force" value="1"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="force" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Forcer la réinitialisation (écrase les soldes existants)
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Initialiser les Soldes
                        </button>
                    </form>
                </div>

                <!-- Vérification des soldes -->
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-3 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Vérification des Soldes
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Analyser la cohérence des données
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.leave-balances.verify') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="verify_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Année à vérifier
                            </label>
                            <select id="verify_year" name="year" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                                @for($y = now()->year + 1; $y >= now()->year - 3; $y--)
                                    <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Types de vérification
                            </label>
                            
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="check_missing" name="checks[]" value="missing" checked
                                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                    <label for="check_missing" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Soldes manquants
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" id="check_negative" name="checks[]" value="negative" checked
                                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                    <label for="check_negative" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Soldes négatifs
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" id="check_inconsistent" name="checks[]" value="inconsistent" checked
                                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                    <label for="check_inconsistent" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Données incohérentes
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Lancer la Vérification
                        </button>
                    </form>
                </div>

                <!-- Recalcul des soldes -->
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-3 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Recalcul des Soldes
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Recalculer les soldes basés sur les congés
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.leave-balances.recalculate') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="recalc_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Année à recalculer
                            </label>
                            <select id="recalc_year" name="year" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200">
                                @for($y = now()->year + 1; $y >= now()->year - 3; $y--)
                                    <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label for="recalc_user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Utilisateur spécifique (optionnel)
                            </label>
                            <input type="text" id="recalc_user_id" name="user_id" placeholder="ID utilisateur ou matricule"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200">
                        </div>

                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                        <strong>Attention :</strong> Cette opération recalculera les soldes en fonction des congés approuvés. Les ajustements manuels seront conservés.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-yellow-600 text-white font-medium rounded-xl hover:from-amber-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Recalculer les Soldes
                        </button>
                    </form>
                </div>

                <!-- Export des données -->
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-3 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Export des Données
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Exporter les soldes au format Excel
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.leave-balances.export') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="export_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Année à exporter
                            </label>
                            <select id="export_year" name="year" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                                @for($y = now()->year + 1; $y >= now()->year - 3; $y--)
                                    <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label for="export_department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Département (optionnel)
                            </label>
                            <select id="export_department_id" name="department_id"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                                <option value="">Tous les départements</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium rounded-xl hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Exporter en Excel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>