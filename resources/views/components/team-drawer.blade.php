<!-- Drawer pour afficher les détails de l'équipe -->
<div x-data="{
        drawerOpen: false,
        teamData: null,
        init() {
            this.$watch('drawerOpen', value => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = 'auto';
                }
            });
        }
    }"
    @open-team-drawer.window="
        teamData = $event.detail;
        drawerOpen = true;
    "
    @keydown.escape.window="drawerOpen = false"
    x-show="drawerOpen"
    x-cloak
    class="fixed inset-0 z-50 overflow-hidden"
    style="display: none;">
    
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity"
         @click="drawerOpen = false"></div>
    
    <!-- Drawer -->
    <div class="fixed right-0 top-0 h-full w-96 bg-white dark:bg-gray-800 shadow-2xl transform transition-transform duration-300 ease-in-out"
         x-show="drawerOpen"
         x-transition:enter="transform transition ease-in-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg mr-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold" x-text="teamData?.teamName || 'Équipe'"></h3>
                        <p class="text-indigo-100 text-sm">Détails de l'équipe</p>
                    </div>
                </div>
                <button @click="drawerOpen = false" 
                        class="text-white/80 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Content -->
        <div class="flex-1 overflow-y-auto p-6">
            <!-- Informations du manager -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                    <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    Responsable
                </h4>
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl p-4 border border-indigo-200 dark:border-indigo-700">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full mr-4 text-white text-sm font-semibold"
                             x-text="teamData?.teamManager?.first_name ? teamData.teamManager.first_name.substring(0, 2).toUpperCase() : 'M'">
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white" 
                               x-text="teamData?.teamManager?.first_name + ' ' + teamData?.teamManager?.last_name || 'Manager'"></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400" 
                               x-text="teamData?.teamManager?.email || 'email@example.com'"></p>
                            <p class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">Responsable d'équipe</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Liste des membres -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                    </svg>
                    Membres de l'équipe
                    <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200"
                          x-text="teamData?.teamMembers?.length || 0"></span>
                </h4>
                
                <div class="space-y-3" x-show="teamData?.teamMembers?.length > 0">
                    <template x-for="member in teamData?.teamMembers || []" :key="member.id">
                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-500 to-teal-600 rounded-full mr-3 text-white text-sm font-semibold"
                                     x-text="member.first_name ? member.first_name.substring(0, 2).toUpperCase() : 'U'">
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white" 
                                       x-text="member.first_name + ' ' + member.last_name"></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400" 
                                       x-text="member.email"></p>
                                    <div class="flex items-center mt-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                              :class="{
                                                  'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': member.is_active,
                                                  'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': !member.is_active
                                              }"
                                              x-text="member.is_active ? 'Actif' : 'Inactif'">
                                        </span>
                                        <span class="ml-2 text-xs text-gray-500 dark:text-gray-400" 
                                              x-text="member.position || 'Poste non défini'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                
                <!-- État vide pour les membres -->
                <div x-show="!teamData?.teamMembers?.length" class="text-center py-8">
                    <div class="flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mx-auto mb-4">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                    </div>
                    <h5 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucun membre</h5>
                    <p class="text-gray-600 dark:text-gray-400">Cette équipe n'a pas encore de membres assignés.</p>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="border-t border-gray-200 dark:border-gray-600 px-6 py-4 bg-gray-50 dark:bg-gray-700">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span x-text="'Équipe créée le ' + (teamData?.created_at ? new Date(teamData.created_at).toLocaleDateString('fr-FR') : 'N/A')"></span>
                </div>
                <button @click="drawerOpen = false" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>