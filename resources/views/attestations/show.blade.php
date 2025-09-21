@section('title', 'Détails de la demande d\'attestation')
<x-app-layout>
    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border-0">
            <!-- En-tête modernisé -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-900 px-6 py-4">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('attestations.index') }}" 
                           class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg hover:scale-105 transition-transform duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                                Attestation #{{ $attestationRequest->id }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">
                                {{ $attestationRequest->attestationType->name }}
                            </p>
                            <div class="flex items-center space-x-3 mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attestationRequest->status_class }}">
                                    {{ $attestationRequest->formatted_status }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attestationRequest->priority_class }}">
                                    {{ $attestationRequest->formatted_priority }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @if($attestationRequest->status === 'generated' && $attestationRequest->pdf_path)
                            <a href="{{ route('attestations.download', $attestationRequest->id) }}" 
                               class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-cyan-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Télécharger PDF
                            </a>
                        @endif
                        @if($attestationRequest->status === 'pending')
                            <button onclick="cancelRequest({{ $attestationRequest->id }})" 
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-pink-600 border border-transparent rounded-xl hover:from-red-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Annuler la demande
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-8">
                @if(session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-6 py-4 rounded-xl relative mb-8 shadow-sm" role="alert">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-base">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-6 py-4 rounded-xl relative mb-8 shadow-sm" role="alert">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-base">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Informations principales -->
                    <div class="lg:col-span-2">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 border border-blue-200 dark:border-gray-600 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informations de la demande</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Détails de votre demande d'attestation</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type d'attestation</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $attestationRequest->attestationType->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Statut</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attestationRequest->status_class }}">
                                            {{ $attestationRequest->formatted_status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priorité</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attestationRequest->priority_class }}">
                                            {{ $attestationRequest->formatted_priority }}
                                        </span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de demande</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $attestationRequest->created_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>

                                @if($attestationRequest->start_date || $attestationRequest->end_date)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @if($attestationRequest->start_date)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de début</label>
                                                <p class="text-sm text-gray-900 dark:text-white">{{ $attestationRequest->start_date->format('d/m/Y') }}</p>
                                            </div>
                                        @endif
                                        @if($attestationRequest->end_date)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de fin</label>
                                                <p class="text-sm text-gray-900 dark:text-white">{{ $attestationRequest->end_date->format('d/m/Y') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if($attestationRequest->notes)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600">
                                            <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $attestationRequest->notes }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($attestationRequest->custom_data && count($attestationRequest->custom_data) > 0)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Informations complémentaires</label>
                                        <div class="space-y-2">
                                            @foreach($attestationRequest->custom_data as $key => $value)
                                                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-600">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                                    <span class="text-sm text-gray-900 dark:text-white">{{ $value }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Historique et actions -->
                    <div class="space-y-8">
                        <!-- Statut et traitement -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 border border-green-200 dark:border-gray-600 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Traitement</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Informations sur le traitement de votre demande</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                @if($attestationRequest->processed_at)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Traité le</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->processed_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                @endif

                                @if($attestationRequest->processor)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Traité par</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->processor->first_name }} {{ $attestationRequest->processor->last_name }}</p>
                                    </div>
                                @endif

                                @if($attestationRequest->rejection_reason)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Motif de rejet</label>
                                        <div class="mt-1 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md">
                                            <p class="text-sm text-red-800 dark:text-red-300">{{ $attestationRequest->rejection_reason }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($attestationRequest->generated_at)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PDF généré le</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->generated_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="bg-gradient-to-br from-purple-50 to-violet-50 dark:from-gray-800 dark:to-gray-700 border border-purple-200 dark:border-gray-600 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Historique</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Chronologie des événements de votre demande</p>
                                </div>
                            </div>
                            
                            <div class="flow-root">
                                <ul class="-mb-8 space-y-6">
                                    <li>
                                        <div class="relative pb-8">
                                            @if($attestationRequest->processed_at || $attestationRequest->generated_at)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gradient-to-b from-blue-400 to-purple-400 dark:from-blue-500 dark:to-purple-500" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-4">
                                                <div>
                                                    <span class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center ring-4 ring-white dark:ring-gray-800 shadow-lg">
                                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-2">
                                                    <div class="bg-white dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-100 dark:border-gray-600">
                                                        <p class="text-sm text-gray-900 dark:text-white font-semibold">Demande créée</p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $attestationRequest->created_at->format('d/m/Y à H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    @if($attestationRequest->processed_at)
                                        <li>
                                            <div class="relative pb-8">
                                                @if($attestationRequest->generated_at)
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full @if($attestationRequest->status === 'approved') bg-green-500 @elseif($attestationRequest->status === 'rejected') bg-red-500 @else bg-gray-500 @endif flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                            @if($attestationRequest->status === 'approved')
                                                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @elseif($attestationRequest->status === 'rejected')
                                                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @else
                                                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5">
                                                        <div>
                                                            <p class="text-sm text-gray-900 dark:text-white font-medium">
                                                                @if($attestationRequest->status === 'approved')
                                                                    Demande approuvée
                                                                @elseif($attestationRequest->status === 'rejected')
                                                                    Demande rejetée
                                                                @else
                                                                    Demande traitée
                                                                @endif
                                                            </p>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $attestationRequest->processed_at->format('d/m/Y à H:i') }}</p>
                                                            @if($attestationRequest->processor)
                                                                <p class="text-sm text-gray-500 dark:text-gray-400">par {{ $attestationRequest->processor->first_name }} {{ $attestationRequest->processor->last_name }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    @if($attestationRequest->generated_at)
                                        <li>
                                            <div class="relative">
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5">
                                                        <div>
                                                            <p class="text-sm text-gray-900 dark:text-white font-medium">PDF généré</p>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $attestationRequest->generated_at->format('d/m/Y à H:i') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cancelRequest(requestId) {
            if (confirm('Êtes-vous sûr de vouloir annuler cette demande ?')) {
                fetch(`/attestations/${requestId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route("attestations.index") }}';
                    } else {
                        alert(data.message || 'Une erreur est survenue');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
            }
        }
    </script>
</x-app-layout>