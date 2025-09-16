@section('title', 'Détails de la demande d\'attestation')
<x-app-layout>
    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('attestations.index') }}" 
                               class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-2xl shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Demande d'attestation #{{ $attestationRequest->id }}</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $attestationRequest->attestationType->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            @if($attestationRequest->status === 'generated' && $attestationRequest->pdf_path)
                                <a href="{{ route('attestations.download', $attestationRequest->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Télécharger PDF
                                </a>
                            @endif
                            @if($attestationRequest->status === 'pending')
                                <button onclick="cancelRequest({{ $attestationRequest->id }})" 
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Annuler la demande
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="font-semibold text-base block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 dark:bg-red-900 border border-red-400 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="font-semibold text-base block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Informations principales -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informations de la demande</h2>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type d'attestation</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->attestationType->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attestationRequest->status_class }} mt-1">
                                            {{ $attestationRequest->formatted_status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priorité</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attestationRequest->priority_class }} mt-1">
                                            {{ $attestationRequest->formatted_priority }}
                                        </span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de demande</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->created_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>

                                @if($attestationRequest->start_date || $attestationRequest->end_date)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @if($attestationRequest->start_date)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de début</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->start_date->format('d/m/Y') }}</p>
                                            </div>
                                        @endif
                                        @if($attestationRequest->end_date)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de fin</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->end_date->format('d/m/Y') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if($attestationRequest->notes)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                        <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
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
                    <div class="space-y-6">
                        <!-- Statut et traitement -->
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Traitement</h3>
                            
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
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Historique</h3>
                            
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    <li>
                                        <div class="relative pb-8">
                                            @if($attestationRequest->processed_at || $attestationRequest->generated_at)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                        <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-900 dark:text-white font-medium">Demande créée</p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $attestationRequest->created_at->format('d/m/Y à H:i') }}</p>
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
                                                        <span class="h-8 w-8 rounded-full {{ $attestationRequest->status === 'approved' ? 'bg-green-500' : 'bg-red-500' }} flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                            @if($attestationRequest->status === 'approved')
                                                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @else
                                                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5">
                                                        <div>
                                                            <p class="text-sm text-gray-900 dark:text-white font-medium">
                                                                Demande {{ $attestationRequest->status === 'approved' ? 'approuvée' : 'rejetée' }}
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