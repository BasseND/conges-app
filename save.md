<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold pb-5 text-bgray-900 dark:text-white">
            {{ __('Demande de congé') }}
            @if($leave->user_id)
                @if($leave->user)
                    de {{ $leave->user->first_name }} {{ $leave->user->last_name }}
                @else
                    (Utilisateur ID: {{ $leave->user_id }})
                @endif
            @else
                (Aucun utilisateur associé)
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg dark:bg-gray-800">
                <div class="px-4 py-5 sm:px-6">

                    @if(session('success'))
                        <div class="bg-green-100 mb-4 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                        Demande de {{ $leave->user ? $leave->user->first_name . ' ' . $leave->user->last_name : 'Utilisateur inconnu (ID: ' . $leave->user_id . ')' }}
                    </h3>
                   
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-white">    
                        @if($leave->created_at)
                            Soumise le {{ $leave->created_at->format('d/m/Y à H:i') }}
                        @else
                            Date de soumission non disponible
                        @endif
                    </p>
                </div>
                <div class="group relative bg-gradient-to-br from-white via-cyan-50/30 to-teal-50/50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-2xl p-8 mb-8 border border-cyan-200/50 dark:border-gray-700/50 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 overflow-hidden">
                    <!-- Decorative background elements -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-cyan-400/10 to-teal-500/10 rounded-full -translate-y-20 translate-x-20 group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-emerald-400/10 to-green-500/10 rounded-full translate-y-16 -translate-x-16 group-hover:scale-110 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <!-- Header with icon -->
                        <div class="flex items-center mb-8">
                            <div class="bg-gradient-to-r from-cyan-500 to-teal-600 p-4 rounded-2xl shadow-lg mr-4 group-hover:scale-110 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h2.25m-2.25 3h2.25m-2.25 3h2.25m3-6h2.25m-2.25 3h2.25m-2.25 3h2.25" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Détails de la demande de congé</h2>
                                <p class="text-gray-600 dark:text-gray-400">Informations complètes et statut de traitement</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Type de congé -->
                            <div class="bg-gradient-to-br from-cyan-50 to-cyan-100/50 dark:from-cyan-900/20 dark:to-cyan-800/20 p-6 rounded-2xl border border-cyan-200/50 dark:border-cyan-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 p-3 rounded-xl shadow-lg mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-cyan-700 dark:text-cyan-300 mb-1">Type de congé</h3>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 {{ 
                                            $leave->type === 'annual' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' : 
                                            ($leave->type === 'sick' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' : 
                                            ($leave->type === 'unpaid' ? 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white' : 
                                            'bg-gradient-to-r from-gray-500 to-gray-600 text-white')) 
                                        }}">
                                            @switch($leave->type)
                                                @case('annual')
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                                    </svg>
                                                    Congé annuel
                                                    @break
                                                @case('sick')
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                    </svg>
                                                    Congé maladie
                                                    @break
                                                @case('unpaid')
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Congé sans solde
                                                    @break
                                                @default
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                                    </svg>
                                                    Autre
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Période -->
                            <div class="bg-gradient-to-br from-teal-50 to-teal-100/50 dark:from-teal-900/20 dark:to-teal-800/20 p-6 rounded-2xl border border-teal-200/50 dark:border-teal-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-3 rounded-xl shadow-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-teal-700 dark:text-teal-300">Période</h3>
                                </div>
                                <div class="ml-14">
                                    @if($leave->start_date && $leave->end_date)
                                        <p class="text-base font-semibold text-gray-900 dark:text-gray-100">Du {{ $leave->start_date->format('d/m/Y') }} au {{ $leave->end_date->format('d/m/Y') }}</p>
                                        <p class="text-sm text-teal-600 dark:text-teal-400 font-medium">({{ $leave->duration_days }} jour(s))</p>
                                    @else
                                        <p class="text-base font-semibold text-gray-500 dark:text-gray-400">Période non disponible</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Demandeur -->
                            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-800/20 p-6 rounded-2xl border border-emerald-200/50 dark:border-emerald-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-3 rounded-xl shadow-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Demandeur</h3>
                                </div>
                                <div class="ml-14">
                                    <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $leave->user ? $leave->user->first_name : 'Utilisateur inconnu' }}</p>
                                </div>
                            </div>

                            <!-- Département -->
                            <div class="bg-gradient-to-br from-green-50 to-green-100/50 dark:from-green-900/20 dark:to-green-800/20 p-6 rounded-2xl border border-green-200/50 dark:border-green-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl shadow-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m2.25-18v18m13.5-18v18m2.25-18v18M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3M14.25 21v-3a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-green-700 dark:text-green-300">Département</h3>
                                </div>
                                <div class="ml-14">
                                    <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $leave->user && $leave->user->department ? $leave->user->department->name : 'Non assigné' }}</p>
                                </div>
                            </div>

                            <!-- Statut -->
                            <div class="bg-gradient-to-br from-cyan-50 to-cyan-100/50 dark:from-cyan-900/20 dark:to-cyan-800/20 p-6 rounded-2xl border border-cyan-200/50 dark:border-cyan-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 p-3 rounded-xl shadow-lg mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-medium text-cyan-700 dark:text-cyan-300">Statut</h3>
                                    </div>
                                    <div>
                                        @switch($leave->status)
                                            @case('pending')
                                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    En attente
                                                </span>
                                                @break
                                            @case('approved')
                                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Approuvé
                                                </span>
                                                @break
                                            @case('rejected')
                                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Refusé
                                                </span>
                                                @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>

                            <!-- Motif de la demande -->
                            <div class="bg-gradient-to-br from-teal-50 to-teal-100/50 dark:from-teal-900/20 dark:to-teal-800/20 p-6 rounded-2xl border border-teal-200/50 dark:border-teal-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-3 rounded-xl shadow-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-teal-700 dark:text-teal-300">Motif de la demande</h3>
                                </div>
                                <div class="ml-14">
                                    <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $leave->reason }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Sections conditionnelles -->
                        @if($leave->status === 'rejected' && $leave->rejection_reason)
                            <div class="mt-6 bg-gradient-to-br from-red-50 to-red-100/50 dark:from-red-900/20 dark:to-red-800/20 p-6 rounded-2xl border border-red-200/50 dark:border-red-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="bg-gradient-to-r from-red-500 to-red-600 p-3 rounded-xl shadow-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-red-700 dark:text-red-300">Motif du refus</h3>
                                </div>
                                <div class="ml-14">
                                    <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $leave->rejection_reason }}</p>
                                </div>
                            </div>
                        @endif

                        @if($leave->approved_by)
                            <div class="mt-6 bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-800/20 p-6 rounded-2xl border border-emerald-200/50 dark:border-emerald-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center mb-3">
                                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-3 rounded-xl shadow-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Traité par</h3>
                                </div>
                                <div class="ml-14">
                                    <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $leave->approver->name }} le {{ $leave->approved_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($leave->attachments->count() > 0)
                            <div class="mt-6 bg-gradient-to-br from-green-50 to-green-100/50 dark:from-green-900/20 dark:to-green-800/20 p-6 rounded-2xl border border-green-200/50 dark:border-green-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center mb-4">
                                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl shadow-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-green-700 dark:text-green-300">Pièces jointes</h3>
                                </div>
                                <div class="ml-14 space-y-3">
                                    @foreach($leave->attachments as $attachment)
                                        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-green-200/50 dark:border-green-700/50">
                                            <div class="flex items-center space-x-3">
                                                <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-2 rounded-lg">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $attachment->original_filename }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($attachment->size / 1024, 2) }} KB</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('leaves.download-attachment', ['leave' => $leave->id, 'attachment' => $attachment->id]) }}" 
                                            class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-cyan-500 to-teal-500 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                </svg>
                                                Télécharger
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @can('update', $leave)
                     @if($leave->status === 'pending')
                        <div class="mt-6 flex justify-end p-3">
                            <a href="{{ route('leaves.edit', ['leave' => $leave->id]) }}" 
                            class="btn btn-vert-extra flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Modifier
                            </a>
                        </div>
                    @endif
                @endcan

                <div class="flex justify-between px-4 py-5 sm:px-6 border-t border-gray-200">

                <a href="{{ route('leaves.index') }}" class="btn btn-secondary"> Retour</a>

                @if(auth()->user()->can('approve-leaves') && $leave->status === 'pending')
                    <div class="">
                        
                        <div class="flex justify-end space-x-3">
                            <button @click="$dispatch('approve-leave', '{{ route('leaves.approve', $leave) }}')" class="btn btn-primary inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Approuver
                            </button>
                            <button @click="$dispatch('reject-leave', '{{ route('leaves.reject', $leave) }}')" class="btn btn-error inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Refuser
                            </button>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>

    <x-modals.approve-leave message="Êtes-vous sûr de vouloir approuver cette demande de congé ? Cette action déduira automatiquement les jours du solde de l'employé." />
    <x-modals.reject-leave message="Êtes-vous sûr de vouloir rejeter cette demande de congé ?" />
    
</x-app-layout>
