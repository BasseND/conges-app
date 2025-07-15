<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="rounded-2xl mb-8 border border-cyan-200/50 dark:border-gray-700/50 overflow-hidden">
                        <!-- Header with icon -->
                        <div class="flex items-center border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                            <div class="bg-gradient-to-r from-cyan-500 to-teal-600 p-4 rounded-2xl shadow-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h2.25m-2.25 3h2.25m-2.25 3h2.25m3-6h2.25m-2.25 3h2.25m-2.25 3h2.25" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Demande de congé de {{ $leave->user ? $leave->user->first_name . ' ' . $leave->user->last_name : 'Utilisateur inconnu' }}</h2>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">    
                                    @if($leave->created_at)
                                        Soumise le {{ $leave->created_at->format('d/m/Y à H:i') }}
                                    @else
                                        Date de soumission non disponible
                                    @endif
                                </p>
                            </div>
                        </div>


                        <!-- Contenu principal -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Type de congé -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-cyan-700 dark:text-cyan-300 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Type de congé
                                    </label>
                                    <div class="ml-6">
                                        <x-leave-type-badge :type="$leave->type" />
                                    </div>
                                </div>

                                <!-- Période -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-cyan-700 dark:text-cyan-300 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Période
                                    </label>
                                    <div class="ml-6">
                                        @if($leave->start_date && $leave->end_date)
                                            <p class="text-base font-semibold text-gray-900 dark:text-gray-100">Du {{ $leave->start_date->format('d/m/Y') }} au {{ $leave->end_date->format('d/m/Y') }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">({{ $leave->duration_days }} jour(s))</p>
                                        @else
                                            <p class="text-base text-cyan-700 dark:text-cyan-300">Période non disponible</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Demandeur -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-cyan-700 dark:text-cyan-300 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Demandeur
                                    </label>
                                    <div class="ml-6">
                                        <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $leave->user ? $leave->user->first_name . ' ' . $leave->user->last_name : 'Utilisateur inconnu' }}</p>
                                    </div>
                                </div>

                                <!-- Département -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-cyan-700 dark:text-cyan-300 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Département
                                    </label>
                                    <div class="ml-6">
                                        <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $leave->user && $leave->user->department ? $leave->user->department->name : 'Non assigné' }}</p>
                                    </div>
                                </div>

                                <!-- Statut -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-cyan-700 dark:text-cyan-300 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Statut
                                    </label>
                                    <div class="ml-6">
                                        <x-leave-status :status="$leave->status" />
                                    </div>
                                </div>

                                <!-- Motif de la demande -->
                                <div class="md:col-span-2 space-y-1">
                                    <label class="text-sm font-medium text-cyan-700 dark:text-cyan-300 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Motif de la demande
                                    </label>
                                    <div class="ml-6">
                                        <p class="text-base text-gray-900 dark:text-gray-100 leading-relaxed">{{ $leave->reason ?: 'Aucun motif spécifié' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sections conditionnelles -->
                        @if($leave->status === 'rejected' && $leave->rejection_reason)
                            <div class="border-t border-gray-200 dark:border-gray-700 p-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Motif du refus
                                    </label>
                                    <div class="ml-6">
                                        <p class="text-base text-gray-900 dark:text-gray-100">{{ $leave->rejection_reason }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($leave->approved_by)
                            <div class="border-t border-gray-200 dark:border-gray-700 p-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-green-600 dark:text-green-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Traité par
                                    </label>
                                    <div class="ml-6">
                                        <p class="text-base text-gray-900 dark:text-gray-100">{{ $leave->approver->name }} le {{ $leave->approved_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($leave->attachments->count() > 0)
                            <div class="border-t border-gray-200 dark:border-gray-700 p-6">
                                <div class="space-y-3">
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                        Pièces jointes
                                    </label>
                                    <div class="space-y-2">
                                        @foreach($leave->attachments as $attachment)
                                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $attachment->original_filename }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($attachment->size / 1024, 2) }} KB</p>
                                                    </div>
                                                </div>
                                                <a href="{{ route('leaves.attachment.download', $attachment) }}" 
                                                class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                    </svg>
                                                    Télécharger
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-between px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('leaves.index') }}" class="inline-flex items-center justify-center px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Retour
                            </a>

                            <!-- Actions -->
                            @if(Auth::check() && (auth()->user()->can('update', $leave) || auth()->user()->can('approve-leaves')))
                                <div class="">
                                    <div class="flex flex-wrap gap-3">
                                        @can('update', $leave)
                                            @if($leave->status === 'draft')
                                                <a href="{{ route('leaves.edit', $leave) }}" 
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-800 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                    Modifier
                                                </a>
                                                
                                                <button @click="$dispatch('submit-leave', '{{ route('leaves.submit', $leave) }}')" 
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 dark:bg-cyan-700 dark:hover:bg-cyan-800 rounded-lg border border-cyan-600 dark:border-cyan-700 transition-colors shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                                    </svg>
                                                    Soumettre
                                                </button>
                                            @endif
                                        @endcan
                                        
                                        @if(Auth::check() && auth()->user()->can('approve-leaves') && $leave->status === 'pending')
                                            <button @click="$dispatch('approve-leave', '{{ route('leaves.approve', $leave) }}')" 
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-600 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-800 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                                Approuver
                                            </button>
                                            
                                            <button @click="$dispatch('reject-leave', '{{ route('leaves.reject', $leave) }}')" 
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30 rounded-lg border border-red-200 dark:border-red-800 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Refuser
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>



                    </div>


                </div>     
                </div>
            </div>



        </div>
    </div>
 
    <x-modals.submit-leave message="Êtes-vous sûr de vouloir soumettre cette demande de congé ? Une fois soumise, elle ne pourra plus être modifiée." />
    <x-modals.approve-leave message="Êtes-vous sûr de vouloir approuver cette demande de congé ? Cette action déduira automatiquement les jours du solde de l'employé." />
    <x-modals.reject-leave message="Êtes-vous sûr de vouloir rejeter cette demande de congé ?" />
    
</x-app-layout>































