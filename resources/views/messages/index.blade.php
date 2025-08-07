<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Messagerie') }}
    </h2>
</x-slot>
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Messagerie</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Vos conversations avec les ressources humaines</p>
                </div>
                <a href="{{ route('messages.create') }}" 
                   class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nouveau message
                </a>
            </div>
        </div>

        <!-- Liste des conversations -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
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
                                            
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300 mt-1">
                                                {{ $conversation->subject }}
                                            </p>
                                            
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">
                                                @if($conversation->sender_id === auth()->id())
                                                    <span class="font-medium">Vous:</span>
                                                @endif
                                                {{ Str::limit($conversation->content, 100) }}
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


@push('scripts')
<script>
// Actualiser le nombre de messages non lus toutes les 30 secondes
setInterval(function() {
    fetch('{{ route("messages.unread-count") }}')
        .then(response => response.json())
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
        .catch(error => console.error('Erreur:', error));
}, 30000);
</script>
@endpush

</x-app-layout>


