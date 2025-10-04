<x-app-layout>
    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête modernisé -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-start sm:items-center space-x-3 sm:space-x-4 min-w-0">
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-2 sm:p-3 rounded-xl sm:rounded-2xl shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white truncate">
                                    {{ $specialLeaveType->name }}
                                </h1>
                                <div class="flex items-center space-x-3 mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $specialLeaveType->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' }}">
                                        {{ $specialLeaveType->is_active ? __('Actif') : __('Inactif') }}
                                    </span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $specialLeaveType->duration_days }} {{ __('jour(s)') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 sm:space-x-3 flex-shrink-0">
                            <a href="{{ route('admin.special-leave-types.edit', $specialLeaveType) }}" 
                               class="inline-flex items-center justify-center px-3 sm:px-4 py-2 sm:py-3 bg-amber-600 hover:bg-amber-700 border border-transparent rounded-lg sm:rounded-xl font-medium text-sm text-white transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span class="hidden sm:inline">Modifier</span>
                            </a>
                            <a href="{{ route('admin.company.show') }}" 
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
                <!-- Informations principales -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Détails du type de congé -->
                    <div class="lg:col-span-2">
                        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 dark:border-gray-700/50 p-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ __('Détails du type de congé') }}
                            </h2>
                            
                            <div class="space-y-6">
                                <!-- Nom -->
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Nom du type') }}</dt>
                                        <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $specialLeaveType->name }}</dd>
                                    </div>
                                </div>

                                <!-- Durée -->
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Durée accordée') }}</dt>
                                        <dd class="mt-1">
                                            <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $specialLeaveType->duration_days }}</span>
                                            <span class="text-lg text-gray-600 dark:text-gray-400 ml-1">{{ __('jour(s)') }}</span>
                                        </dd>
                                    </div>
                                </div>

                                <!-- Condition d'ancienneté -->
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Condition d\'ancienneté') }}</dt>
                                        <dd class="mt-1">
                                            @if($specialLeaveType->seniority_months == 0)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    {{ __('Aucune condition') }}
                                                </span>
                                            @else
                                                <span class="text-lg font-semibold text-orange-600 dark:text-orange-400">{{ $specialLeaveType->formatted_seniority }}</span>
                                            @endif
                                        </dd>
                                    </div>
                                </div>

                                <!-- Statut -->
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 {{ $specialLeaveType->is_active ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-lg flex items-center justify-center">
                                            @if($specialLeaveType->is_active)
                                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Statut') }}</dt>
                                        <dd class="mt-1">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $specialLeaveType->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' }}">
                                                {{ $specialLeaveType->is_active ? __('Actif') : __('Inactif') }}
                                            </span>
                                        </dd>
                                    </div>
                                </div>

                                <!-- Description -->
                                @if($specialLeaveType->description)
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Description') }}</dt>
                                            <dd class="mt-1 text-gray-900 dark:text-white leading-relaxed">{{ $specialLeaveType->description }}</dd>
                                        </div>
                                    </div>
                                @endif

                                <!-- Dates -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Créé le') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $specialLeaveType->created_at->format('d/m/Y à H:i') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Modifié le') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $specialLeaveType->updated_at->format('d/m/Y à H:i') }}</dd>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <div class="lg:col-span-1">
                        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 dark:border-gray-700/50 p-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                {{ __('Statistiques') }}
                            </h2>
                            
                            <div class="space-y-4">
                                <!-- Total des demandes -->
                                <div class="bg-blue-50/80 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200/30 dark:border-blue-700/30">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ __('Total demandes') }}</p>
                                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $specialLeaveType->leaves()->count() }}</p>
                                        </div>
                                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Demandes approuvées -->
                                <div class="bg-green-50/80 dark:bg-green-900/20 rounded-xl p-4 border border-green-200/30 dark:border-green-700/30">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ __('Approuvées') }}</p>
                                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $specialLeaveType->leaves()->where('status', 'approved')->count() }}</p>
                                        </div>
                                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Demandes en attente -->
                                <div class="bg-yellow-50/80 dark:bg-yellow-900/20 rounded-xl p-4 border border-yellow-200/30 dark:border-yellow-700/30">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">{{ __('En attente') }}</p>
                                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $specialLeaveType->leaves()->where('status', 'pending')->count() }}</p>
                                        </div>
                                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Demandes rejetées -->
                                <div class="bg-red-50/80 dark:bg-red-900/20 rounded-xl p-4 border border-red-200/30 dark:border-red-700/30">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ __('Rejetées') }}</p>
                                            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $specialLeaveType->leaves()->where('status', 'rejected')->count() }}</p>
                                        </div>
                                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Liste des congés récents -->
                @if($specialLeaveType->leaves()->count() > 0)
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 dark:border-gray-700/50 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h6m-6 0l-.5 8.5A2 2 0 0013.5 21h-3A2 2 0 018.5 15.5L8 7z"/>
                            </svg>
                            {{ __('Demandes récentes') }}
                            <span class="ml-2 text-sm font-normal text-gray-500 dark:text-gray-400">({{ __('5 dernières') }})</span>
                        </h2>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Employé') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Période') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Durée') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Statut') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Demandé le') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800/30 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($specialLeaveType->leaves()->with('user')->latest()->take(5)->get() as $leave)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-white">{{ substr($leave->user->name, 0, 2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $leave->user->name }}</div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $leave->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $leave->start_date->format('d/m/Y') }} - {{ $leave->end_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $leave->start_date->diffInDays($leave->end_date) + 1 }} {{ __('jour(s)') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'
                                                    ];
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$leave->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($leave->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $leave->created_at->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($specialLeaveType->leaves()->count() > 5)
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Et') }} {{ $specialLeaveType->leaves()->count() - 5 }} {{ __('autre(s) demande(s)...') }}
                                </p>
                            </div>
                        @endif
                    </div>
                @else
                    <!-- État vide -->
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 dark:border-gray-700/50 p-12 text-center">
                        <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            {{ __('Aucune demande de congé') }}
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ __('Ce type de congé n\'a encore été utilisé par aucun employé.') }}
                        </p>
                    </div>
                @endif

                <!-- Actions rapides -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('admin.special-leave-types.edit', $specialLeaveType) }}" 
                       class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 border border-transparent rounded-xl font-semibold text-sm text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        {{ __('Modifier ce type') }}
                    </a>
                    
                    <form action="{{ route('admin.special-leave-types.destroy', $specialLeaveType) }}" 
                          method="POST" 
                          class="flex-1 sm:flex-none"
                          onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce type de congé ? Cette action est irréversible.') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 border border-transparent rounded-xl font-semibold text-sm text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            {{ __('Supprimer') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>