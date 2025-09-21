<div x-data="{ showUploadModal: false }" class="space-y-6">
    <!-- En-tête modernisé -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Documents de l'employé</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Gérez les documents administratifs et contractuels</p>
                </div>
            </div>
            <button @click="showUploadModal = true" 
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un document
            </button>
        </div>
    </div>

    <!-- Liste des documents -->
    @forelse($user->documents ?? [] as $document)
        <div class="bg-gradient-to-br from-white to-green-50 dark:from-gray-800 dark:to-gray-700 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4 flex-1">
                    <!-- Icône du document -->
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                            @if(str_contains($document->filename, '.pdf'))
                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                </svg>
                            @elseif(str_contains($document->filename, '.doc') || str_contains($document->filename, '.docx'))
                                <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Informations du document -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">
                                {{ $document->title ?? 'Sans titre' }}
                            </h3>
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $document->status_badge_class }}">
                                {{ $document->status_label }}
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $document->filename }}</p>
                        
                        <!-- Informations détaillées -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-600/50 p-3">
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Type</div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $document->type }}</div>
                            </div>
                            
                            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-600/50 p-3">
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Taille</div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $document->human_readable_size }}</div>
                            </div>
                            
                            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-600/50 p-3">
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Ajouté le</div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $document->created_at->format('d/m/Y') }}</div>
                            </div>
                            
                            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-600/50 p-3">
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Ajouté par</div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $document->uploadedBy->first_name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        
                        @if($document->formatted_expiration_date)
                            <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Expire le {{ $document->formatted_expiration_date }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center space-x-2 ml-4">
                    <!-- Valider -->
                    <button type="button" 
                            @click="$dispatch('status-dialog', {url: '{{ route('admin.users.documents.update-status', [$user->id, $document->id]) }}', status: '{{ $document->status }}', documentId: '{{ $document->id }}'})" 
                            class="p-2 text-green-600 hover:text-green-700 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors duration-200" 
                            title="Changer le statut">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                    
                    <!-- Télécharger -->
                    <a href="{{ route('admin.users.documents.download', [$user->id, $document->id]) }}" 
                       class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors duration-200" 
                       title="Télécharger">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>
                    
                    <!-- Supprimer -->
                    <button type="button" 
                            @click="$dispatch('delete-dialog', '{{ route('admin.users.documents.destroy', [$user->id, $document->id]) }}')" 
                            class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200" 
                            title="Supprimer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <!-- État vide -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
            <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Aucun document</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Aucun document n'a encore été ajouté pour cet employé.</p>
            <button @click="showUploadModal = true" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter le premier document
            </button>
        </div>
    @endforelse

    <!-- Modal d'upload de document -->
    <div x-show="showUploadModal" 
         class="fixed z-50 inset-0 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true"
         style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showUploadModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showUploadModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl px-6 pt-6 pb-6 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100" id="modal-title">
                                Ajouter un document
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Sélectionnez un ou plusieurs fichiers à ajouter pour cet employé
                            </p>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('admin.users.documents.store', $user->id) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Titre du document</label>
                            <input type="text" id="title" name="title" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Statut</label>
                            <select id="status" name="status" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="pending">En attente</option>
                                <option value="validated">Validé</option>
                                <option value="rejected">Rejeté</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="document_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type de document</label>
                            <select id="document_type" name="document_type" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" onchange="toggleExpirationDate()">
                                <option value="identity">Pièce d'identité</option>
                                <option value="passport">Passeport</option>
                                <option value="criminal_record">Casier judiciaire</option>
                                <option value="nationality_certificate">Certificat de nationalité</option>
                                <option value="niu">NIU</option>
                                <option value="diploma">Diplôme</option>
                                <option value="certificate">Certificat professionnel</option>
                                <option value="contract">Contrat</option>
                                <option value="cv">CV</option>
                                <option value="amendment">Avenant</option>
                                <option value="rib">RIB</option>
                                <option value="sick_leave">Arrêt maladie</option>
                                <option value="medical_certificate">Certificat médical (embauche)</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>

                        <div id="expiration_date_container" style="display: block;">
                            <label for="expiration_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date d'expiration</label>
                            <input type="date" id="expiration_date" name="expiration_date" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description (optionnel)</label>
                        <textarea id="description" name="description" rows="3" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-none"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fichier(s)</label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-colors duration-200">
                            <div class="space-y-4">
                                <div class="mx-auto w-16 h-16 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div>
                                    <label for="file-upload" class="cursor-pointer">
                                        <span class="text-blue-600 dark:text-blue-400 font-medium hover:text-blue-700 dark:hover:text-blue-300">Cliquez pour télécharger</span>
                                        <span class="text-gray-500 dark:text-gray-400"> ou glissez-déposez vos fichiers</span>
                                        <input id="file-upload" name="documents[]" type="file" class="sr-only" multiple>
                                    </label>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    PNG, JPG, PDF, DOC jusqu'à 10MB
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <button type="button" @click="showUploadModal = false" class="px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            Télécharger
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>


<!-- Modal de mise à jour du statut -->
<div x-data="{ show: false, url: '', status: 'pending', documentId: '' }" 
     x-show="show" 
     @status-dialog.window="show = true; url = $event.detail.url; status = $event.detail.status; documentId = $event.detail.documentId"
     class="fixed z-50 inset-0 overflow-y-auto" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true"
     style="display: none;">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" 
             aria-hidden="true">
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl px-6 pt-6 pb-6 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="modal-title">
                                Mise à jour du statut du document
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Veuillez sélectionner le nouveau statut pour ce document.
                            </p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form x-bind:action="url" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Statut</label>
                    <select id="status" name="status" x-model="status" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="pending">En attente</option>
                        <option value="validated">Validé</option>
                        <option value="rejected">Rejeté</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" 
                            @click="show = false"
                            class="px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        Annuler
                    </button>
                    <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-modals.delete-dialog message="Êtes-vous sûr de vouloir supprimer ce document ? Cette action est irréversible." />


<!-- JavaScript -->
<script>
    function toggleExpirationDate() {
        var documentType = document.getElementById('document_type').value;
        var expirationDateContainer = document.getElementById('expiration_date_container');
        
        if (documentType &&documentType === 'identity' || documentType === 'passport') {
            expirationDateContainer.style.display = 'block';
        } else {
            expirationDateContainer.style.display = 'none';
            document.getElementById('expiration_date').value = '';
        }
    }

    // Exécuter au chargement pour définir l'état initial
    document.addEventListener('DOMContentLoaded', function() {
        toggleExpirationDate();
    });
</script>