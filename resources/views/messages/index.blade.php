<x-app-layout>
    <div class="py-8">
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-900 px-6 py-4">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                           
                            <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ __('Messagerie') }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">
                                Vos conversations avec les ressources humaines
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('messages.create') }}" 
                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nouveau message
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filtres de recherche -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900  shadow-xs border-b border-gray-200 dark:border-gray-700 mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Rechercher dans vos conversations</h3>
                        </div>
                    </div>
                    
                    <form method="GET" action="{{ route('messages.index') }}">
                        <div class="flex flex-wrap items-end gap-4">
                            <!-- Recherche globale -->
                            <div class="flex-1 min-w-[250px]">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Recherche
                                </label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, sujet ou contenu du message..." class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                            </div>
                            
                            <!-- Filtre par statut -->
                            <div class="min-w-[150px]">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                                    </svg>
                                    Statut
                                </label>
                                <select name="status" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    <option value="">Tous les messages</option>
                                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Non lus</option>
                                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Lus</option>
                                </select>
                            </div>
                            
                            <!-- Tri par date -->
                            <div class="min-w-[150px]">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Trier par
                                </label>
                                <select name="sort" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    <option value="recent" {{ request('sort', 'recent') == 'recent' ? 'selected' : '' }}>Plus récent</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus ancien</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nom (A-Z)</option>
                                </select>
                            </div>
                            
                            <div class="flex gap-3">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Rechercher
                                </button>
                                <a href="{{ route('messages.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 dark:from-gray-600 dark:to-gray-700 text-white font-medium rounded-xl hover:from-gray-600 hover:to-gray-700 dark:hover:from-gray-700 dark:hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Réinitialiser
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-6">
                <!-- Liste des conversations -->
                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden">
                    @if($conversations->isEmpty())
                        <div class="p-12 text-center">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Aucune conversation</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Vous n'avez encore aucune conversation. Commencez par envoyer un message.</p>
                            <a href="{{ route('messages.create') }}" 
                            class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Envoyer un message
                            </a>
                        </div>
                    @else
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($conversations as $conversation)
                                <a href="{{ route('messages.show', $conversation->other_user_id) }}" 
                                class="block hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <div class="p-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4 flex-1">
                                                <!-- Avatar -->
                                                <div class="flex-shrink-0">
                                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                                        <span class="text-white font-semibold text-lg">
                                                            {{ strtoupper(substr($conversation->first_name, 0, 1) . substr($conversation->last_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Informations de la conversation -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between">
                                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">
                                                            {{ $conversation->first_name }} {{ $conversation->last_name }}
                                                        </h3>
                                                        <div class="flex items-center space-x-2">
                                                            @if($conversation->unread_count > 0)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                                    {{ $conversation->unread_count }}
                                                                </span>
                                                            @endif
                                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                                {{ \Carbon\Carbon::parse($conversation->last_message_date)->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center justify-between space-x-2">
                                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                                            {{ $conversation->subject }}
                                                        </p>
                                                        @if(($conversation->attachment_count ?? 0) > 0)
                                                            
                                                            <svg class="w-6 h-6 ml-2 text-red-500 dark:text-gray-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                                            </svg>
                                                              
                                                        @endif
                                                    </div>
                                                    
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">
                                                        @if($conversation->sender_id === auth()->id())
                                                            <span class="font-medium">Vous:</span>
                                                        @endif
                                                        {{ Str::limit(strip_tags($conversation->content), 100) }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <!-- Flèche -->
                                            <div class="flex-shrink-0 ml-4">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>



@push('scripts')
<script>
// Actualiser le nombre de messages non lus toutes les 30 secondes
setInterval(function() {
    fetch('{{ route("messages.unread-count") }}', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
        .then(response => {
            if (response.ok) {
                // Vérifier si la réponse est bien du JSON
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    throw new Error('Réponse non-JSON reçue');
                }
            }
            throw new Error('Erreur réseau: ' + response.status);
        })
        .then(data => {
            // Mettre à jour l'indicateur dans la navigation si nécessaire
            const badge = document.querySelector('.messages-badge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des messages non lus:', error);
        });
}, 30000);
</script>
@endpush

</x-app-layout>


