@props(['unreadCount' => 0])

<div class="relative" x-data="{ open: false, unreadCount: {{ $unreadCount }}, notifications: [] }" 
     x-init="
        // Charger le nombre de notifications non lues
        fetch('{{ route('notifications.unread-count') }}')
            .then(response => response.json())
            .then(data => unreadCount = data.count);
        
        // Actualiser toutes les 30 secondes
        setInterval(() => {
            fetch('{{ route('notifications.unread-count') }}')
                .then(response => response.json())
                .then(data => unreadCount = data.count);
        }, 30000);
     ">
    <!-- Bouton de notification -->
    <button @click="open = !open; if(open) { 
                fetch('{{ route('notifications.recent') }}')
                    .then(response => response.json())
                    .then(data => notifications = data);
             }" 
            class="relative p-2 text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors duration-200">
        <!-- Icône de cloche -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 17h5l-5 5-5-5h5v-12a1 1 0 011-1h4a1 1 0 011 1v12z M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M18.364 18.364l-.707-.707M12 21v-1m-6.364-1.636l.707-.707M3 12h1M5.636 5.636l.707.707"></path>
        </svg>
        
        <!-- Badge de compteur -->
        <span x-show="unreadCount > 0" 
              x-text="unreadCount > 99 ? '99+' : unreadCount"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold min-w-[20px]">
        </span>
    </button>

    <!-- Dropdown des notifications -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
        
        <!-- En-tête -->
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                <a href="{{ route('notifications.index') }}" 
                   class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Voir tout
                </a>
            </div>
        </div>

        <!-- Liste des notifications -->
        <div class="max-h-96 overflow-y-auto">
            <template x-if="notifications.length === 0">
                <div class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-12a1 1 0 011-1h4a1 1 0 011 1v12z" />
                    </svg>
                    <p class="text-sm">Aucune nouvelle notification</p>
                </div>
            </template>
            
            <template x-for="notification in notifications" :key="notification.id">
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notification.title"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="notification.message"></p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1" x-text="new Date(notification.created_at).toLocaleDateString('fr-FR', { 
                                year: 'numeric', 
                                month: 'short', 
                                day: 'numeric', 
                                hour: '2-digit', 
                                minute: '2-digit' 
                            })"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Pied de page -->
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <form method="POST" action="{{ route('notifications.mark-all-read') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            x-show="unreadCount > 0"
                            @click="unreadCount = 0"
                            class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        Marquer tout comme lu
                    </button>
                </form>
                <a href="{{ route('notifications.index') }}" 
                   class="text-xs text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                    Gérer les notifications
                </a>
            </div>
        </div>
    </div>
</div>