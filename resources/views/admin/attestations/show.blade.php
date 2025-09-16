@section('title', 'Détails de la demande d\'attestation')
<x-app-layout>
    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.attestations.index') }}" 
                               class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-3 rounded-2xl shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Demande #{{ $attestationRequest->id }}</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $attestationRequest->user->first_name }} {{ $attestationRequest->user->last_name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            @if($attestationRequest->status === 'pending')
                                <button onclick="approveRequest({{ $attestationRequest->id }})" 
                                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Approuver
                                </button>
                                <button onclick="rejectRequest({{ $attestationRequest->id }})" 
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Rejeter
                                </button>
                            @endif
                            @if($attestationRequest->status === 'approved' && !$attestationRequest->pdf_path)
                                <button onclick="generatePdf({{ $attestationRequest->id }})" 
                                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Générer PDF
                                </button>
                            @endif
                            @if($attestationRequest->pdf_path)
                                <a href="{{ route('admin.attestations.download', $attestationRequest->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Télécharger PDF
                                </a>
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
                    <!-- Informations de l'employé -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Informations employé -->
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informations de l'employé</h2>
                            
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="flex-shrink-0 h-16 w-16">
                                    <div class="h-16 w-16 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                        <span class="text-xl font-medium text-gray-700 dark:text-gray-300">
                                            {{ strtoupper(substr($attestationRequest->user->first_name, 0, 1) . substr($attestationRequest->user->last_name, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ $attestationRequest->user->first_name }} {{ $attestationRequest->user->last_name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $attestationRequest->user->email }}</p>
                                    @if($attestationRequest->user->phone)
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $attestationRequest->user->phone }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if($attestationRequest->user->employee_id)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID Employé</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->user->employee_id }}</p>
                                    </div>
                                @endif
                                @if($attestationRequest->user->department)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Département</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->user->department->name }}</p>
                                    </div>
                                @endif
                                @if($attestationRequest->user->position)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Poste</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->user->position }}</p>
                                    </div>
                                @endif
                                @if($attestationRequest->user->hire_date)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date d'embauche</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->user->hire_date->format('d/m/Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Détails de la demande -->
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Détails de la demande</h2>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type d'attestation</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->attestationType->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $attestationRequest->attestationType->formatted_type }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priorité</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attestationRequest->priority_class }} mt-1">
                                            {{ $attestationRequest->formatted_priority }}
                                        </span>
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
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes de l'employé</label>
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

                        <!-- Template de l'attestation -->
                        @if($templatePreview)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aperçu du template</h2>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md border-l-4 border-blue-500">
                                    <div class="text-sm text-gray-900 dark:text-white leading-relaxed prose prose-sm max-w-none">
                                        {!! $templatePreview !!}
                                    </div>
                                </div>
                                <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-md">
                                    <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">
                                        ✓ Aperçu avec les données de l'employé - Ceci est le contenu qui sera généré dans le PDF
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Statut et actions -->
                    <div class="space-y-6">
                        <!-- Statut actuel -->
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statut</h3>
                            
                            <div class="text-center">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $attestationRequest->status_class }}">
                                    {{ $attestationRequest->formatted_status }}
                                </span>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Demandé le</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->created_at->format('d/m/Y à H:i') }}</p>
                                </div>

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

                                @if($attestationRequest->generated_at)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PDF généré le</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $attestationRequest->generated_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Motif de rejet -->
                        @if($attestationRequest->rejection_reason)
                            <div class="bg-white dark:bg-gray-800 border border-red-200 dark:border-red-800 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-red-800 dark:text-red-300 mb-4">Motif de rejet</h3>
                                <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-md">
                                    <p class="text-sm text-red-800 dark:text-red-300 whitespace-pre-wrap">{{ $attestationRequest->rejection_reason }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Actions rapides -->
                        @if($attestationRequest->status === 'pending')
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                                <div class="space-y-3">
                                    <button onclick="approveRequest({{ $attestationRequest->id }})" 
                                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Approuver la demande
                                    </button>
                                    <button onclick="rejectRequest({{ $attestationRequest->id }})" 
                                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Rejeter la demande
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if($attestationRequest->status === 'approved' && !$attestationRequest->pdf_path)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Génération PDF</h3>
                                <button onclick="generatePdf({{ $attestationRequest->id }})" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Générer le PDF
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de rejet -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Motif de rejet</h3>
                <form id="rejectForm">
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Raison du rejet</label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="4" 
                                  class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                  placeholder="Expliquez pourquoi cette demande est rejetée..." required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRejectModal()" 
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors duration-200">
                            Rejeter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function approveRequest(requestId) {
            if (confirm('Êtes-vous sûr de vouloir approuver cette demande ?')) {
                fetch(`/admin/attestations/${requestId}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
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

        function rejectRequest(requestId) {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejection_reason').value = '';
        }

        function generatePdf(requestId) {
            if (confirm('Générer le PDF pour cette attestation ?')) {
                fetch(`/admin/attestations/${requestId}/generate-pdf`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
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

        document.getElementById('rejectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const reason = document.getElementById('rejection_reason').value;
            const requestId = {{ $attestationRequest->id }};
            
            fetch(`/admin/attestations/${requestId}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ rejection_reason: reason })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeRejectModal();
                    location.reload();
                } else {
                    alert(data.message || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            });
        });

        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>