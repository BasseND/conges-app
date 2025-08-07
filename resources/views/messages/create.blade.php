<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nouveau message') }}
        </h2>
    </x-slot>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <a href="{{ route('messages.index') }}" 
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Retour aux messages
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nouveau message</h1>
                    <div class="w-32"></div> <!-- Spacer pour centrer le titre -->
                </div>
            </div>

            <!-- Formulaire -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        
                        <!-- Destinataire -->
                        <div class="mb-6">
                            <label for="recipient_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Destinataire
                            </label>
                            <!-- Système de sélection multiple avec recherche -->
                            <div class="relative" id="recipient-selector">
                                <!-- Champ de recherche -->
                                <div class="relative">
                                    <input type="text" 
                                           id="recipient-search" 
                                           placeholder="Rechercher et sélectionner des destinataires..."
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500 pr-10"
                                           autocomplete="off">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Liste déroulante des résultats -->
                                <div id="recipient-dropdown" class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                    @if(auth()->user()->isHR())
                                        @foreach($users as $user)
                                            <div class="recipient-option px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer border-b border-gray-100 dark:border-gray-600 last:border-b-0" 
                                                 data-id="{{ $user->id }}" 
                                                 data-name="{{ $user->first_name }} {{ $user->last_name }}" 
                                                 data-email="{{ $user->email }}">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                                            {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                            {{ $user->first_name }} {{ $user->last_name }}
                                                        </p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                                            {{ $user->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($hrUsers as $user)
                                            <div class="recipient-option px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer border-b border-gray-100 dark:border-gray-600 last:border-b-0" 
                                                 data-id="{{ $user->id }}" 
                                                 data-name="{{ $user->first_name }} {{ $user->last_name }}" 
                                                 data-email="{{ $user->email }}">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                                            {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                            {{ $user->first_name }} {{ $user->last_name }} - RH
                                                        </p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                                            {{ $user->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Badges des destinataires sélectionnés -->
                                <div id="selected-recipients" class="mt-3 flex flex-wrap gap-2"></div>

                                <!-- Champs cachés pour les destinataires sélectionnés -->
                                <div id="hidden-recipients"></div>
                            </div>
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
                            <textarea id="content" 
                                    name="content" 
                                    rows="8" 
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500" 
                                    placeholder="Tapez votre message ici..."
                                    required>{{ old('content') }}</textarea>
                            @error('content')
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
</x-app-layout>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('recipient-search');
    const dropdown = document.getElementById('recipient-dropdown');
    const selectedRecipientsContainer = document.getElementById('selected-recipients');
    const hiddenRecipientsContainer = document.getElementById('hidden-recipients');
    const recipientOptions = document.querySelectorAll('.recipient-option');
    
    // Vérifier que tous les éléments existent
    if (!searchInput || !dropdown || !selectedRecipientsContainer || !hiddenRecipientsContainer) {
        console.error('Éléments manquants pour le système de sélection des destinataires');
        return;
    }
    
    let selectedRecipients = [];
    
    // Fonction pour filtrer les options
    function filterOptions(searchTerm) {
        recipientOptions.forEach(option => {
            const name = option.dataset.name.toLowerCase();
            const email = option.dataset.email.toLowerCase();
            const isVisible = name.includes(searchTerm.toLowerCase()) || email.includes(searchTerm.toLowerCase());
            option.style.display = isVisible ? 'block' : 'none';
        });
    }
    
    // Fonction pour créer un badge de destinataire
    function createRecipientBadge(id, name, email) {
        const badge = document.createElement('div');
        badge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
        badge.innerHTML = `
            <span class="mr-2">${name}</span>
            <button type="button" class="remove-recipient ml-1 inline-flex items-center justify-center w-4 h-4 text-blue-400 hover:text-blue-600 dark:text-blue-300 dark:hover:text-blue-100" data-id="${id}">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        return badge;
    }
    
    // Fonction pour créer un champ caché
    function createHiddenInput(id) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'recipient_ids[]';
        input.value = id;
        return input;
    }
    
    // Fonction pour ajouter un destinataire
    function addRecipient(id, name, email) {
        if (selectedRecipients.find(r => r.id === id)) {
            return; // Déjà sélectionné
        }
        
        selectedRecipients.push({ id, name, email });
        
        // Créer le badge
        const badge = createRecipientBadge(id, name, email);
        selectedRecipientsContainer.appendChild(badge);
        
        // Créer le champ caché
        const hiddenInput = createHiddenInput(id);
        hiddenRecipientsContainer.appendChild(hiddenInput);
        
        // Masquer l'option dans la liste
        const option = document.querySelector(`[data-id="${id}"]`);
        if (option) {
            option.style.display = 'none';
        }
        
        // Vider le champ de recherche
        searchInput.value = '';
        dropdown.classList.add('hidden');
        
        // Réinitialiser l'affichage des options
        recipientOptions.forEach(opt => {
            if (!selectedRecipients.find(r => r.id === opt.dataset.id)) {
                opt.style.display = 'block';
            }
        });
    }
    
    // Fonction pour supprimer un destinataire
    function removeRecipient(id) {
        selectedRecipients = selectedRecipients.filter(r => r.id !== id);
        
        // Supprimer le badge
        const badge = document.querySelector(`[data-id="${id}"]`).closest('.inline-flex');
        if (badge) {
            badge.remove();
        }
        
        // Supprimer le champ caché
        const hiddenInput = document.querySelector(`input[value="${id}"]`);
        if (hiddenInput) {
            hiddenInput.remove();
        }
        
        // Réafficher l'option dans la liste
        const option = document.querySelector(`.recipient-option[data-id="${id}"]`);
        if (option) {
            option.style.display = 'block';
        }
    }
    
    // Événement de recherche
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.trim();
        
        if (searchTerm.length > 0) {
            filterOptions(searchTerm);
            dropdown.style.display = 'block';
            dropdown.classList.remove('hidden');
        } else {
            // Garder la liste visible même sans texte de recherche
            dropdown.style.display = 'block';
            dropdown.classList.remove('hidden');
            // Réinitialiser l'affichage des options
            recipientOptions.forEach(opt => {
                if (!selectedRecipients.find(r => r.id === opt.dataset.id)) {
                    opt.style.display = 'block';
                }
            });
        }
    });
    
    // Fonction pour afficher la liste déroulante
    function showDropdown() {
        dropdown.style.display = 'block';
        dropdown.classList.remove('hidden');
        // Réinitialiser l'affichage des options
        recipientOptions.forEach(opt => {
            if (!selectedRecipients.find(r => r.id === opt.dataset.id)) {
                opt.style.display = 'block';
            }
        });
    }
    
    // Événement de focus sur le champ de recherche
    searchInput.addEventListener('focus', showDropdown);
    
    // Événement de clic sur le champ de recherche
    searchInput.addEventListener('click', showDropdown);
    
    // Masquer la liste déroulante quand on clique en dehors
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = 'none';
            dropdown.classList.add('hidden');
        }
    });
    
    // Événement de clic sur une option
    recipientOptions.forEach(option => {
        option.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const email = this.dataset.email;
            addRecipient(id, name, email);
        });
    });
    
    // Événement de suppression d'un destinataire
    selectedRecipientsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-recipient')) {
            const id = e.target.closest('.remove-recipient').dataset.id;
            removeRecipient(id);
        }
    });
    
    // Fermer la liste déroulante en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (!document.getElementById('recipient-selector').contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Validation du formulaire
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (selectedRecipients.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un destinataire.');
            searchInput.focus();
        }
    });
});
</script>
@endpush
