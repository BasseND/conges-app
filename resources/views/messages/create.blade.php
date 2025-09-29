@section('title', 'Nouveau message')
<x-app-layout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête modernisé -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-2xl shadow-lg">  
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nouveau message</h1>
                               
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('messages.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Retour aux messages
                            </a>
                        </div>

                       
                    </div>
                </div>
            </div>


            <div class="">

                <!-- Formulaire -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Destinataire -->
                        <div class="mb-6">
                            <label for="recipient_id" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Destinataire <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="recipient-search-container">
                                <select name="recipient_id" 
                                        id="recipient_id" 
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                    <option value="">@if(auth()->user()->isHR())Sélectionner un employé...@elseSélectionner un responsable RH...@endif</option>
                                </select>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tapez le nom, prénom ou email pour rechercher
                            </p>
                            @error('recipient_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Sujet -->
                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sujet
                            </label>
                            <input type="text" 
                                id="subject" 
                                name="subject" 
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500" 
                                placeholder="Sujet du message"
                                value="{{ old('subject') }}"
                                required>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Message -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Message
                            </label>
                            <!-- Éditeur WYSIWYG -->
                            <div id="create-editor" class="bg-white dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600" style="min-height: 200px;">
                                {!! old('content') !!}
                            </div>
                            <!-- Champ caché pour le contenu -->
                            <textarea id="content" name="content" class="hidden" required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Pièces jointes -->
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                Pièces jointes
                                <span class="text-xs text-gray-500 ml-2">(optionnel)</span>
                            </label>
                            
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-indigo-400 dark:hover:border-indigo-500 transition-colors duration-200">
                                <input type="file" 
                                       name="attachments[]" 
                                       id="attachments" 
                                       multiple 
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.bmp,.svg"
                                       class="hidden"
                                       onchange="handleFileSelect(this)">
                                
                                <label for="attachments" class="cursor-pointer">
                                    <div class="space-y-2">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">Cliquez pour sélectionner</span>
                                            ou glissez-déposez vos fichiers
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, Word, Excel, Images (max. 10MB par fichier)
                                        </p>
                                    </div>
                                </label>
                            </div>
                            
                            <!-- Liste des fichiers sélectionnés -->
                            <div id="selected-files" class="space-y-2 mt-3"></div>
                            
                            @error('attachments')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            @error('attachments.*')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Boutons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('messages.index') }}" 
                            class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Envoyer le message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Informations d'aide -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-1">Informations importantes</h3>
                        <div class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                            @if(auth()->user()->isHR())
                                <p>• En tant que RH, vous pouvez envoyer des messages à tous les employés.</p>
                                <p>• Les employés ne verront que les messages qui leur sont destinés.</p>
                            @else
                                <p>• Vous ne pouvez envoyer des messages qu'aux membres des Ressources Humaines.</p>
                                <p>• Vos messages restent confidentiels et ne sont visibles que par vous et les RH.</p>
                            @endif
                            <p>• Tous les messages sont sécurisés et confidentiels.</p>
                        </div>
                    </div>
                </div>
            </div>

            </div>

        </div>
    </div>



   
   

    <!-- Choices.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@11.1.0/public/assets/styles/choices.min.css">

    <style>
        /* Personnalisation de Choices.js pour correspondre au design */
        .choices {
            margin-bottom: 0;
        }
        
        .choices__inner {
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            min-height: 48px;
        }
        
        .choices__inner:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .choices__list--dropdown {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .choices__item--choice {
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .choices__item--choice:last-child {
            border-bottom: none;
        }
        
        .choices__item--choice:hover {
            background-color: #f8fafc;
        }
        
        .choices__item--choice.is-highlighted {
            background-color: #3b82f6 !important;
            color: white !important;
            font-weight: 500;
            transform: translateX(2px);
        }
        
        .choices__item--choice.is-selected {
            background-color: #1e40af !important;
            color: white !important;
            font-weight: 600;
            position: relative;
        }
        
        .choices__item--choice.is-selected::after {
            content: '✓';
            position: absolute;
            right: 1rem;
            font-weight: bold;
        }
        
        .choices__placeholder {
            color: #9ca3af;
        }
        
        .dark .choices__inner {
            background-color: #374151;
            border-color: #4b5563;
            color: white;
        }
        
        .dark .choices__inner:focus-within {
            border-color: #3b82f6;
        }
        
        .dark .choices__list--dropdown {
            background-color: #374151;
            border-color: #4b5563;
        }
        
        .dark .choices__item--choice {
            color: white;
            border-bottom-color: #4b5563;
        }
        
        .dark .choices__item--choice:hover {
            background-color: #4b5563;
        }
        
        .dark .choices__item--choice.is-highlighted {
            background-color: #3b82f6 !important;
            color: white !important;
        }
        
        .dark .choices__item--choice.is-selected {
            background-color: #1e40af !important;
            color: white !important;
        }
        
        .dark .choices__placeholder {
            color: #9ca3af;
        }
        .ql-snow .ql-editor {
            min-height: 200px;
        }
       
    </style>

    <!-- Choices.js JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js@11.1.0/public/assets/scripts/choices.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        let recipientChoices;
        
        // Éléments DOM
        const recipientSelect = document.getElementById('recipient_id');
        
        // Initialiser Choices.js pour la recherche de destinataires
        if (recipientSelect) {
            recipientChoices = new Choices(recipientSelect, {
                searchEnabled: true,
                searchPlaceholderValue: 'Rechercher un destinataire...',
                noResultsText: 'Aucun destinataire trouvé',
                noChoicesText: 'Aucun destinataire disponible',
                itemSelectText: 'Cliquer pour sélectionner',
                loadingText: 'Chargement...',
                shouldSort: false,
                searchResultLimit: 10,
                searchFields: ['label'],
                fuseOptions: {
                    threshold: 0.3,
                    keys: ['label']
                }
            });
            
            // Charger les destinataires au focus
            recipientSelect.addEventListener('showDropdown', function() {
                const currentValue = recipientChoices.getValue();
                if ((!currentValue || currentValue.value === '') && recipientChoices._store.choices.length === 0) {
                    loadRecipients('a'); // Charger avec une lettre pour avoir des résultats initiaux
                }
            });
            
            // Recherche en temps réel
            recipientSelect.addEventListener('search', function(event) {
                const query = event.detail.value;
                if (query && query.length >= 2) {
                    loadRecipients(query);
                }
            });
        }
        
        // Fonction pour charger les destinataires
        function loadRecipients(query) {
            // Ne pas faire de requête si la query est vide
            if (!query || query.length < 2) {
                return;
            }
            
            const userType = @json(auth()->user()->isHR() ? 'employees' : 'hr');
            
            fetch(`/messages/search/recipients?q=${encodeURIComponent(query)}&type=${userType}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Vérifier que data est un tableau
                if (!Array.isArray(data)) {
                    console.error('La réponse n\'est pas un tableau:', data);
                    return;
                }
                
                // Effacer les choix existants
                recipientChoices.clearChoices();
                
                // Ajouter les nouveaux choix
                const choices = data.map(user => ({
                    value: user.id,
                    label: user.text
                }));
                
                recipientChoices.setChoices(choices, 'value', 'label', true);
            })
            .catch(error => {
                console.error('Erreur lors de la recherche:', error);
            });
        }
    });
    
    // Fonction pour gérer la sélection de fichiers
    function handleFileSelect(input) {
        const files = input.files;
        const selectedFilesDiv = document.getElementById('selected-files');
        
        // Vider la liste précédente
        selectedFilesDiv.innerHTML = '';
        
        if (files.length === 0) {
            return;
        }
        
        // Afficher chaque fichier sélectionné
        Array.from(files).forEach((file, index) => {
            const fileDiv = document.createElement('div');
            fileDiv.className = 'flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600';
            
            // Icône selon le type de fichier
            let iconSvg = '';
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'].includes(fileExtension)) {
                iconSvg = '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>';
            } else if (fileExtension === 'pdf') {
                iconSvg = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>';
            } else if (['doc', 'docx'].includes(fileExtension)) {
                iconSvg = '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';
            } else if (['xls', 'xlsx'].includes(fileExtension)) {
                iconSvg = '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>';
            } else {
                iconSvg = '<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';
            }
            
            // Formatage de la taille du fichier
            const formatFileSize = (bytes) => {
                if (bytes === 0) return '0 B';
                const k = 1024;
                const sizes = ['B', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            };
            
            fileDiv.innerHTML = `
                <div class="flex items-center space-x-3">
                    ${iconSvg}
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${file.name}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">${formatFileSize(file.size)}</p>
                    </div>
                </div>
                <button type="button" onclick="removeFile(${index})" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            
            selectedFilesDiv.appendChild(fileDiv);
        });
    }
    
    // Fonction pour supprimer un fichier
    function removeFile(index) {
        const input = document.getElementById('attachments');
        const dt = new DataTransfer();
        
        // Recréer la liste des fichiers sans celui à supprimer
        Array.from(input.files).forEach((file, i) => {
            if (i !== index) {
                dt.items.add(file);
            }
        });
        
        input.files = dt.files;
        handleFileSelect(input);
    }

    // Initialisation de l'éditeur Quill pour le formulaire de création
    let createQuill;
    document.addEventListener('DOMContentLoaded', function() {
        createQuill = new Quill('#create-editor', {
            theme: 'snow',
            placeholder: 'Tapez votre message ici...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        // Synchroniser le contenu avec le champ caché
        createQuill.on('text-change', function() {
            document.getElementById('content').value = createQuill.root.innerHTML;
        });

        // Gérer la soumission du formulaire
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('content').value = createQuill.root.innerHTML;
        });
    });
    </script>
</x-app-layout>
