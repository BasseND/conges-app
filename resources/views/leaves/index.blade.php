@section('title', 'Mes demandes de congés')
<x-app-layout>
    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête modernisé -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-green-600 to-lime-600 p-3 rounded-2xl shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Mes demandes de congés') }}</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Gérez vos demandes de congés et consultez vos soldes</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('leaves.create') }}" 
                               class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 border border-transparent rounded-xl font-semibold text-white transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Nouvelle demande
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="font-semibold text-base block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Section des soldes de congés modernisée -->
                <div class="mb-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Solde de congés</h3>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
                        @if(isset($balanceSummary) && isset($balanceSummary['balances']))
                            @foreach($balanceSummary['balances'] as $balance)
                                @php
                                    // Définir les couleurs selon le type de congé
                                    $colors = [
                                        'annual' => ['from' => 'blue', 'to' => 'purple'],
                                        'maternity' => ['from' => 'pink', 'to' => 'rose'],
                                        'paternity' => ['from' => 'cyan', 'to' => 'blue'],
                                        'sick' => ['from' => 'red', 'to' => 'orange'],
                                        'default' => ['from' => 'green', 'to' => 'emerald']
                                    ];
                                    
                                    // leave_type est une chaîne venant du service -> normaliser vers une clé
                                    $leaveTypeName = strtolower(is_array($balance['leave_type']) ? ($balance['leave_type']['name'] ?? '') : ($balance['leave_type'] ?? ''));
                                    // Mapper quelques noms usuels vers clés connues
                                    if (str_contains($leaveTypeName, 'annuel') || str_contains($leaveTypeName, 'annual')) {
                                        $leaveTypeKey = 'annual';
                                    } elseif (str_contains($leaveTypeName, 'matern') || str_contains($leaveTypeName, 'maternity')) {
                                        $leaveTypeKey = 'maternity';
                                    } elseif (str_contains($leaveTypeName, 'patern') || str_contains($leaveTypeName, 'paternity')) {
                                        $leaveTypeKey = 'paternity';
                                    } elseif (str_contains($leaveTypeName, 'maladie') || str_contains($leaveTypeName, 'sick')) {
                                        $leaveTypeKey = 'sick';
                                    } else {
                                        $leaveTypeKey = 'default';
                                    }
                                    $color = $colors[$leaveTypeKey] ?? $colors['default'];
                                    
                                    $usagePercentage = $balance['initial'] > 0 ? ($balance['used'] / $balance['initial']) * 100 : 0;
                                    $circumference = 2 * 3.14159 * 45;
                                    $offset = $circumference - ($usagePercentage / 100) * $circumference;
                                @endphp
                                
                                <div class="group overflow-hidden relative bg-gradient-to-br from-{{ $color['from'] }}-50 via-{{ $color['from'] }}-50 to-{{ $color['to'] }}-50 dark:from-gray-800 dark:via-gray-750 dark:to-gray-700 rounded-2xl p-4 sm:p-6 lg:p-8 border border-{{ $color['from'] }}-200/30 dark:border-gray-600/50 hover:shadow-2xl hover:shadow-{{ $color['from'] }}-500/10 transition-all duration-500 hover:-translate-y-1">
                                   
                                    <!-- Animated Background Pattern -->
                                    <div class="absolute inset-0 opacity-5 dark:opacity-10">
                                        <div class="absolute top-0 left-0 w-32 h-32 bg-{{ $color['from'] }}-400 rounded-full blur-3xl animate-pulse"></div>
                                        <div class="absolute bottom-0 right-0 w-24 h-24 bg-{{ $color['to'] }}-400 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
                                    </div>

                                    <!-- Floating Icon -->
                                    <div class="flex justify-center items-center absolute -top-3 -right-3 sm:-top-4 sm:-right-4 w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-{{ $color['from'] }}-500 via-{{ $color['from'] }}-500 to-{{ $color['to'] }}-600 rounded-xl sm:rounded-2xl shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                
                                    <div class="relative z-10">
                                        <!-- Header -->
                                        <div class="mb-6">
                                            <h4 class="text-xl font-bold bg-gradient-to-r from-{{ $color['from'] }}-600 to-{{ $color['to'] }}-600 bg-clip-text text-transparent dark:from-{{ $color['from'] }}-400 dark:to-{{ $color['to'] }}-400 mb-2">{{ is_array($balance['leave_type']) ? ($balance['leave_type']['name'] ?? '') : ($balance['leave_type'] ?? '') }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Votre solde pour {{ $balance['year'] }}</p>
                                        </div>

                                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-6">
                                            <!-- Stats Cards -->
                                            <div class="flex-1 grid grid-cols-2 gap-2 sm:gap-4">
                                                <!-- Remaining Days -->
                                                <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg sm:rounded-xl p-2 sm:p-4 backdrop-blur-sm border border-white/20 dark:border-gray-700/20">
                                                    <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-{{ $color['from'] }}-600 dark:text-{{ $color['from'] }}-400 mb-1">{{ $balance['current'] }}</div>
                                                    <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Jours restants</div>
                                                </div>
                                                
                                                <!-- Used Days -->
                                                <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg sm:rounded-xl p-2 sm:p-4 backdrop-blur-sm border border-white/20 dark:border-gray-700/20">
                                                    <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-{{ $color['to'] }}-600 dark:text-{{ $color['to'] }}-400 mb-1">{{ $balance['used'] }}</div>
                                                    <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Jours utilisés</div>
                                                </div>
                                                
                                                <!-- Total Allocation -->
                                                <div class="col-span-2 p-2 sm:p-3 bg-gradient-to-r from-{{ $color['from'] }}-500/10 to-{{ $color['to'] }}-500/10 dark:from-{{ $color['from'] }}-500/20 dark:to-{{ $color['to'] }}-500/20 rounded-lg border border-{{ $color['from'] }}-200/30 dark:border-{{ $color['from'] }}-700/30">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Allocation initiale</span>
                                                        <span class="text-sm sm:text-lg font-bold text-gray-900 dark:text-white">{{ $balance['initial'] }} jours</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Progress Circle -->
                                            <div class="flex-shrink-0 flex justify-center lg:justify-end">
                                                <div class="relative w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32">
                                                    <svg class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 transform -rotate-90" viewBox="0 0 100 100">
                                                        <!-- Background circle -->
                                                        <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="8" fill="none" class="text-{{ $color['from'] }}-200 dark:text-{{ $color['from'] }}-800" />
                                                        <!-- Progress circle -->
                                                        <circle cx="50" cy="50" r="45" stroke="url(#gradient{{ $loop->index }})" stroke-width="8" fill="none" 
                                                                class="transition-all duration-1000 ease-out"
                                                                stroke-dasharray="{{ $circumference }}"
                                                                stroke-dashoffset="{{ $offset }}"
                                                                stroke-linecap="round" />
                                                        <defs>
                                                            <linearGradient id="gradient{{ $loop->index }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                                                <stop offset="0%" style="stop-color:rgb({{ $color['from'] === 'blue' ? '59 130 246' : ($color['from'] === 'pink' ? '236 72 153' : ($color['from'] === 'cyan' ? '6 182 212' : ($color['from'] === 'red' ? '239 68 68' : '34 197 94'))) }});stop-opacity:1" />
                                                                <stop offset="100%" style="stop-color:rgb({{ $color['to'] === 'purple' ? '139 92 246' : ($color['to'] === 'rose' ? '244 63 94' : ($color['to'] === 'blue' ? '59 130 246' : ($color['to'] === 'orange' ? '249 115 22' : '16 185 129'))) }});stop-opacity:1" />
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                    <div class="absolute inset-0 flex items-center justify-center">
                                                        <div class="text-center">
                                                            <div class="text-lg sm:text-xl lg:text-2xl font-bold text-{{ $color['from'] }}-600 dark:text-{{ $color['from'] }}-400">{{ number_format($usagePercentage, 0) }}%</div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400">utilisé</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Progress Description -->
                                        <div class="mt-3 sm:mt-4 text-center">
                                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                                <span class="font-medium text-{{ $color['from'] }}-600 dark:text-{{ $color['from'] }}-400">{{ $balance['used'] }} jours utilisés</span> sur {{ $balance['initial'] }} 
                                                ({{ number_format($usagePercentage, 1) }}% d'utilisation)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Message si aucun solde n'est disponible -->
                            <div class="col-span-full text-center py-8">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Aucun solde de congé disponible</p>
                                    <p class="text-sm mt-1">Vos soldes de congés seront initialisés automatiquement.</p>
                                </div>
                            </div>
                        @endif
                        

                       
                    </div>
                </div>

                <!-- Mes demandes -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- En-tête de la section -->
                    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-3 sm:px-6 py-3 sm:py-4">
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                <svg class="w-3 h-3 sm:w-5 sm:h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Mes demandes de congés</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="">
                        <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
                                <tr>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1 sm:space-x-2">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            <span class="hidden sm:inline">Type</span>
                                        </div>
                                    </th>
                                    <th class="hidden sm:table-cell px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1 sm:space-x-2">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>Date de début</span>
                                        </div>
                                    </th>
                                    <th class="hidden lg:table-cell px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1 sm:space-x-2">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>Date de fin</span>
                                        </div>
                                    </th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1 sm:space-x-2">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="hidden sm:inline">Durée</span>
                                        </div>
                                    </th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1 sm:space-x-2">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="hidden sm:inline">Statut</span>
                                        </div>
                                    </th>
                                    <th class="hidden md:table-cell px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1 sm:space-x-2">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                            </svg>
                                            <span>Pièces jointes</span>
                                        </div>
                                    </th>
                                    <th class="hidden lg:table-cell px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1 sm:space-x-2">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>Demandeur</span>
                                        </div>
                                    </th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1 sm:space-x-2">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                            </svg>
                                            <span class="hidden sm:inline">Actions</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($leaves as $leave)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                        <!-- Type -->
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            @php
                                                // Système basé sur SpecialLeaveType
                                                if ($leave->specialLeaveType) {
                                                    // Couleurs selon le type de congé
                                                    $colorMap = [
                                                        'annual' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                        'sick' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                                        'maternity' => 'bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-300',
                                                        'paternity' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300'
                                                    ];
                                                    
                                                    $systemName = $leave->specialLeaveType->system_name;
                                                    $bgColor = $colorMap[$systemName] ?? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300';
                                                    
                                                    $config = [
                                                        'bg' => $bgColor,
                                                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                                        'label' => $leave->specialLeaveType->name
                                                    ];
                                                } else {
                                                    // Fallback pour les anciens types
                                                    $config = [
                                                        'bg' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300',
                                                        'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                                                        'label' => 'Type inconnu'
                                                    ];
                                                }
                                             @endphp
                                             <div class="flex items-center space-x-1 sm:space-x-2">
                                                 <div class="w-6 h-6 sm:w-8 sm:h-8 {{ $config['bg'] }} rounded-lg flex items-center justify-center">
                                                     <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
                                                     </svg>
                                                 </div>
                                                 <div class="sm:block">
                                                     <span class="hidden sm:inline text-xs sm:text-sm font-medium text-gray-900 dark:text-gray-100">{{ $config['label'] }}</span>
                                                     <div class="sm:hidden text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $leave->start_date->format('d/m') }} - {{ $leave->end_date->format('d/m') }}</div>
                                                 </div>
                                             </div>
                                        </td>
                                        
                                        <!-- Date début -->
                                        <td class="hidden sm:table-cell px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-1 sm:space-x-2">
                                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                <span class="text-xs sm:text-sm font-medium text-gray-900 dark:text-gray-100">{{ $leave->start_date->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $leave->start_date->locale('fr')->translatedFormat('l') }}</div>
                                        </td>
                                        
                                        <!-- Date fin -->
                                        <td class="hidden lg:table-cell px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-1 sm:space-x-2">
                                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                <span class="text-xs sm:text-sm font-medium text-gray-900 dark:text-gray-100">{{ $leave->end_date->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $leave->end_date->locale('fr')->translatedFormat('l') }}</div>
                                        </td>
                                        
                                        <!-- Durée -->
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-1 sm:space-x-2">
                                                <div class="w-6 h-6 sm:w-8 sm:h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="hidden sm:block">
                                                    <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-gray-100">{{ $leave->duration }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">jour(s)</div>
                                                </div>
                                                <div class="sm:hidden text-xs font-medium text-gray-900 dark:text-gray-100">{{ $leave->duration }}j</div>
                                            </div>
                                        </td>
                                        
                                        <!-- Statut -->
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <x-leave-status :status="$leave->status" />
                                        </td>
                                        
                                        <!-- Pièces jointes -->
                                        <td class="hidden md:table-cell px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            @if($leave->attachments->count() > 0)
                                                <div class="flex flex-col space-y-1">
                                                    @foreach($leave->attachments as $attachment)
                                                        <a href="{{ route('leaves.attachment.download', $attachment) }}" 
                                                            class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300 hover:bg-indigo-200 dark:hover:bg-indigo-900/50 transition-colors">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            <span class="hidden lg:inline">{{ $attachment->original_filename }}</span>
                                                            <span class="lg:hidden">{{ substr($attachment->original_filename, 0, 10) }}...</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    <span class="hidden lg:inline">Aucune</span>
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- Demandeur -->
                                        <td class="hidden lg:table-cell px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-2 sm:space-x-3">
                                                <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                                    {{ substr($leave->user->first_name, 0, 1) }}{{ substr($leave->user->last_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $leave->user->first_name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $leave->user->department ? $leave->user->department->name : 'Non assigné' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-1 sm:space-x-2">
                                                <a href="{{ route('leaves.show', ['leave' => $leave->id]) }}" 
                                                    class="inline-flex items-center px-2 sm:px-3 py-1 rounded-lg text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                                    <svg class="w-3 h-3 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    <span class="hidden sm:inline">Voir</span>
                                                </a>
                                                @if($leave->status === 'draft' && (Auth::check() && (auth()->user()->id == $leave->user_id || auth()->user()->hasAdminAccess())))
                                                    <a href="{{ route('leaves.edit', ['leave' => $leave->id]) }}" 
                                                        class="inline-flex items-center px-2 sm:px-3 py-1 rounded-lg text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                                                        <svg class="w-3 h-3 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                        <span class="hidden sm:inline">Modifier</span>
                                                    </a>
                                                    <button type="button"
                                                        @click="$dispatch('submit-leave', '{{ route('leaves.submit', $leave) }}')"
                                                        class="inline-flex items-center px-2 sm:px-3 py-1 rounded-lg text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                                        <svg class="w-3 h-3 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                                        </svg>
                                                        <span class="hidden lg:inline">Soumettre</span>
                                                    </button>
                                                    <button
                                                        @click="$dispatch('delete-dialog', '{{ route('leaves.destroy', $leave->id) }}')"
                                                        title="Supprimer"
                                                        type="button" 
                                                        class="inline-flex items-center px-2 sm:px-3 py-1 rounded-lg text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                                                        <svg class="w-3 h-3 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        <span class="hidden lg:inline">Supprimer</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                     <tr>
                                         <td colspan="9" class="px-3 sm:px-6 py-12 sm:py-16">
                                             <div class="text-center">
                                                 <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-3 sm:mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                     <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                     </svg>
                                                 </div>
                                                 <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Aucune demande de congé</h3>
                                                 <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mb-3 sm:mb-4">Vous n'avez pas encore soumis de demande de congé.</p>
                                                 <a href="{{ route('leaves.create') }}" class="inline-flex items-center px-3 sm:px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-sm">
                                                     <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                     </svg>
                                                     Créer une demande
                                                 </a>
                                             </div>
                                         </td>
                                     </tr>
                                 @endforelse
                            </tbody>
                        </table>
                    </div>
                        
                    <!-- Pagination -->
                    @if($leaves->hasPages())
                            @if($leaves instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <!-- Pagination -->
                            <x-pagination :paginator="$leaves" entity-name="congés" />
                        @endif
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modales --}}
    <x-modals.delete-dialog message="Êtes-vous sûr de vouloir annuler cette demande de congé ? Cette action ne peut pas être annulée." />
    <x-modals.submit-leave message="Êtes-vous sûr de vouloir soumettre cette demande de congé ? Une fois soumise, elle ne pourra plus être modifiée." />
    
</x-app-layout>