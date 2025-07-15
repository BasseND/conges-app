<!-- Drawer moderne pour afficher les informations utilisateur -->
<div x-data="{
    open: false,
    user: null,
    openDrawer(userData) {
        this.user = userData;
        this.open = true;
        document.body.style.overflow = 'hidden';
    },
    closeDrawer() {
        this.open = false;
        document.body.style.overflow = '';
        setTimeout(() => {
            this.user = null;
        }, 300);
    }
}"
     @open-user-drawer.window="openDrawer($event.detail)"
     class="relative z-50">
    
    <!-- Overlay moderne -->
    <div x-show="open" 
         x-transition:enter="transition-all ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-all ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-md"
         @click="closeDrawer()"></div>

    <!-- Drawer moderne -->
    <div x-show="open"
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-x-full opacity-0 scale-95"
         x-transition:enter-end="translate-x-0 opacity-100 scale-100"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="translate-x-0 opacity-100 scale-100"
         x-transition:leave-end="translate-x-full opacity-0 scale-95"
         class="fixed right-0 top-0 h-full w-[420px] bg-white dark:bg-gray-900 shadow-2xl overflow-hidden flex flex-col">
        
        <!-- Header compact -->
        <div class="relative bg-gradient-to-br from-slate-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 px-6 py-4">
            <button @click="closeDrawer()" 
                    class="absolute top-3 right-3 p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 rounded-full transition-all duration-200 hover:scale-110">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-600 rounded-xl shadow-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Profil utilisateur</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Informations détaillées</p>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="flex-1 overflow-y-auto" x-show="user">
            <!-- Profil utilisateur -->
            <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-800">
                <div class="text-center">
                    <div class="relative inline-block">
                        <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-600 rounded-3xl mx-auto mb-4 text-white text-xl font-bold shadow-xl">
                            <span x-text="user?.first_name?.charAt(0) + (user?.last_name?.charAt(0) || '')"></span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full border-2 border-white dark:border-gray-900"
                             :class="user?.is_active ? 'bg-green-500' : 'bg-red-500'"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1" x-text="(user?.first_name || '') + ' ' + (user?.last_name || '')"></h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-3" x-text="user?.email"></p>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold"
                          :class="user?.is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300'">
                        <div class="w-2 h-2 rounded-full mr-2"
                             :class="user?.is_active ? 'bg-green-500 animate-pulse' : 'bg-red-500'"></div>
                        <span x-text="user?.is_active ? 'Actif' : 'Inactif'"></span>
                    </span>
                </div>
            </div>

            <!-- Informations personnelles -->
            <div class="px-6 py-4">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Informations personnelles</h4>
                </div>
                <div class="space-y-4">
                    <div class="group">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Prénom</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mt-1" x-text="user?.first_name || 'Non renseigné'"></p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nom</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mt-1" x-text="user?.last_name || 'Non renseigné'"></p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Genre</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mt-1" x-text="user?.gender || 'Non renseigné'"></p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Poste</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mt-1" x-text="user?.poste || 'Non renseigné'"></p>
                    </div>
                </div>
            </div>

            <!-- Informations professionnelles -->
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Informations professionnelles</h4>
                </div>
                <div class="space-y-4">
                    <div class="group">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rôle</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mt-1" x-text="user?.role || 'Non renseigné'"></p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mt-1" x-text="user?.is_prestataire ? 'Prestataire' : 'Employé'"></p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Membre depuis</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mt-1" x-text="user?.created_at ? new Date(user.created_at).toLocaleDateString('fr-FR') : 'Non renseigné'"></p>
                    </div>
                </div>
            </div>

        </div>
        
        <!-- Actions modernes -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800">
            <div class="grid grid-cols-2 gap-3">
                <a :href="user ? '/admin/users/' + user.id : '#'"
                   class="group inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-xl hover:from-green-700 hover:to-emerald-800 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span class="font-medium">Voir</span>
                </a>
                <a :href="user ? '/admin/users/' + user.id + '/edit' : '#'"
                   class="group inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="font-medium">Modifier</span>
                </a>
            </div>
        </div>
    </div>
</div>