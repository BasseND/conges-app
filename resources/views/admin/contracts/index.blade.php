<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ __('Gestion des Contrats') }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Suivi et gestion des contrats actifs</p>
                </div>
            </div>
            
           
        </div>
    </x-slot>

    <div class="pb-8">
        <div class="bg-white dark:bg-darkblack-600 rounded-lg p-4 mb-8">
           
            <x-alert type="success" :message="session('success') ?: request('success')" />
            <x-alert type="error" :message="session('error')" />
            
            <!-- En-tête avec statistiques compactes -->
            <div class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                   <!-- Total Contrats -->
                    <div class="group bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 dark:from-blue-900/30 dark:via-blue-800/25 dark:to-blue-700/20 rounded-2xl p-6 border border-blue-200/60 dark:border-blue-600/40 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 hover:border-blue-300/80 dark:hover:border-blue-500/60 relative overflow-hidden">
                        <!-- Effet de brillance animé -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out"></div>
                        
                        <div class="flex items-center justify-between relative z-10">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg group-hover:shadow-blue-500/25 transition-all duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6 text-white group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-1 group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors duration-300">Total Contrats</p>
                                <p class="text-3xl font-bold text-blue-900 dark:text-blue-100 group-hover:scale-110 transition-transform duration-300">{{ $contracts->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contrats Actifs -->
                    <div class="group bg-gradient-to-br from-emerald-50 via-green-100 to-emerald-200 dark:from-emerald-900/30 dark:via-green-800/25 dark:to-emerald-700/20 rounded-2xl p-6 border border-emerald-200/60 dark:border-emerald-600/40 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 hover:border-emerald-300/80 dark:hover:border-emerald-500/60 relative overflow-hidden">
                        <!-- Effet de brillance animé -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out"></div>
                        
                        <div class="flex items-center justify-between relative z-10">
                            <div class="bg-gradient-to-br from-emerald-500 to-green-600 p-3 rounded-xl shadow-lg group-hover:shadow-emerald-500/25 transition-all duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6 text-white group-hover:rotate-12 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 mb-1 group-hover:text-emerald-700 dark:group-hover:text-emerald-300 transition-colors duration-300">Contrats Actifs</p>
                                <p class="text-3xl font-bold text-emerald-900 dark:text-emerald-100 group-hover:scale-110 transition-transform duration-300">
                                    {{ $contracts->where('statut', 'actif')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contrats expirant bientôt -->
                    <div class="group bg-gradient-to-br from-amber-50 via-orange-100 to-amber-200 dark:from-amber-900/30 dark:via-orange-800/25 dark:to-amber-700/20 rounded-2xl p-6 border border-amber-200/60 dark:border-amber-600/40 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 hover:border-amber-300/80 dark:hover:border-amber-500/60 relative overflow-hidden">
                        <!-- Effet de brillance animé -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out"></div>
                        
                        <!-- Animation de pulsation pour l'alerte -->
                        <div class="absolute top-2 right-2 w-3 h-3 bg-amber-400 rounded-full animate-pulse group-hover:animate-bounce"></div>
                        
                        <div class="flex items-center justify-between relative z-10">
                            <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-3 rounded-xl shadow-lg group-hover:shadow-amber-500/25 transition-all duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6 text-white group-hover:animate-pulse transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-amber-600 dark:text-amber-400 mb-1 group-hover:text-amber-700 dark:group-hover:text-amber-300 transition-colors duration-300">Expirent Bientôt</p>
                                <p class="text-3xl font-bold text-amber-900 dark:text-amber-100 group-hover:scale-110 transition-transform duration-300">
                                    {{ $contracts->filter(function($contract) {
                                        return $contract->date_fin && $contract->date_fin->diffInDays(now()) <= 60 && $contract->date_fin->isFuture();
                                    })->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contrats expirés -->
                    <div class="group bg-gradient-to-br from-rose-50 via-red-100 to-rose-200 dark:from-rose-900/30 dark:via-red-800/25 dark:to-rose-700/20 rounded-2xl p-6 border border-rose-200/60 dark:border-rose-600/40 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 hover:border-rose-300/80 dark:hover:border-rose-500/60 relative overflow-hidden">
                        <!-- Effet de brillance animé -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out"></div>
                        
                        <!-- Indicateur d'alerte critique -->
                        <div class="absolute top-2 right-2 w-3 h-3 bg-red-500 rounded-full animate-ping"></div>
                        <div class="absolute top-2 right-2 w-3 h-3 bg-red-400 rounded-full"></div>
                        
                        <div class="flex items-center justify-between relative z-10">
                            <div class="bg-gradient-to-br from-rose-500 to-red-600 p-3 rounded-xl shadow-lg group-hover:shadow-rose-500/25 transition-all duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6 text-white group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-rose-600 dark:text-rose-400 mb-1 group-hover:text-rose-700 dark:group-hover:text-rose-300 transition-colors duration-300">Contrats Expirés</p>
                                <p class="text-3xl font-bold text-rose-900 dark:text-rose-100 group-hover:scale-110 transition-transform duration-300">
                                    {{ $contracts->filter(function($contract) {
                                        return $contract->date_fin && $contract->date_fin->isPast();
                                    })->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres -->
            <div class="mb-8" x-data="{ 
                statusFilter: '', 
                typeFilter: '', 
                searchTerm: '',
                expiringFilter: '',
                filteredContracts: [],
                init() {
                    this.filterContracts();
                },
                filterContracts() {
                    // Cette fonction sera utilisée côté client pour filtrer
                    this.$nextTick(() => {
                        const rows = document.querySelectorAll('#contracts-table tbody tr[data-contract]');
                        rows.forEach(row => {
                            const status = row.dataset.status;
                            const type = row.dataset.type;
                            const name = row.dataset.name.toLowerCase();
                            const isExpiring = row.dataset.expiring === 'true';
                            
                            const statusMatch = !this.statusFilter || status === this.statusFilter;
                            const typeMatch = !this.typeFilter || type === this.typeFilter;
                            const nameMatch = !this.searchTerm || name.includes(this.searchTerm.toLowerCase());
                            const expiringMatch = !this.expiringFilter || (this.expiringFilter === 'expiring' && isExpiring);
                            
                            if (statusMatch && typeMatch && nameMatch && expiringMatch) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });
                }
            }">
                <div class="bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100 dark:from-slate-800/50 dark:via-gray-800/50 dark:to-slate-700/50 rounded-2xl p-6 border border-slate-200/60 dark:border-slate-600/40 shadow-lg hover:shadow-xl transition-all duration-300 backdrop-blur-sm relative overflow-hidden">
                    <!-- Effet de brillance subtil -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -skew-x-12 -translate-x-full hover:translate-x-full transition-transform duration-1000 ease-out"></div>
                    
                    <div class="flex flex-wrap items-center gap-6 relative z-10">
                        <!-- Recherche -->
                        <div class="flex-1 min-w-72">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </div>
                                <input type="text" x-model="searchTerm" @input="filterContracts()" 
                                       class="block w-full pl-12 pr-4 py-3 border border-slate-300/60 dark:border-slate-600/60 rounded-xl bg-white/80 dark:bg-slate-700/80 text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 shadow-sm hover:shadow-md transition-all duration-200 backdrop-blur-sm" 
                                       placeholder="🔍 Rechercher un employé...">
                            </div>
                        </div>
                        
                        <!-- Filtre par statut -->
                        <div class="min-w-48">
                            <div class="relative group">
                                <select x-model="statusFilter" @change="filterContracts()" 
                                        class="block w-full px-4 py-3 border border-slate-300/60 dark:border-slate-600/60 rounded-xl bg-white/80 dark:bg-slate-700/80 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 shadow-sm hover:shadow-md transition-all duration-200 backdrop-blur-sm appearance-none cursor-pointer">
                                    <option value="">📊 Tous les statuts</option>
                                    <option value="actif">✅ Actif</option>
                                    <option value="suspendu">⏸️ Suspendu</option>
                                    <option value="termine">🔚 Terminé</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filtre par type -->
                        <div class="min-w-48">
                            <div class="relative group">
                                <select x-model="typeFilter" @change="filterContracts()" 
                                        class="block w-full px-4 py-3 border border-slate-300/60 dark:border-slate-600/60 rounded-xl bg-white/80 dark:bg-slate-700/80 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500/50 shadow-sm hover:shadow-md transition-all duration-200 backdrop-blur-sm appearance-none cursor-pointer">
                                    <option value="">📋 Tous les types</option>
                                    <option value="CDI">🏢 CDI</option>
                                    <option value="CDD">📅 CDD</option>
                                    <option value="Interim">⚡ Intérim</option>
                                    <option value="Stage">🎓 Stage</option>
                                    <option value="Alternance">🔄 Alternance</option>
                                    <option value="Freelance">💼 Freelance</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400 group-focus-within:text-amber-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filtre par expiration -->
                        <div class="min-w-48">
                            <div class="relative group">
                                <select x-model="expiringFilter" @change="filterContracts()" 
                                        class="block w-full px-4 py-3 border border-slate-300/60 dark:border-slate-600/60 rounded-xl bg-white/80 dark:bg-slate-700/80 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 shadow-sm hover:shadow-md transition-all duration-200 backdrop-blur-sm appearance-none cursor-pointer">
                                    <option value="">⏰ Toutes les expirations</option>
                                    <option value="expiring">⚠️ Expirent bientôt</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400 group-focus-within:text-red-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bouton reset -->
                        <button @click="statusFilter = ''; typeFilter = ''; searchTerm = ''; expiringFilter = ''; filterContracts();" 
                                class="group inline-flex items-center px-6 py-3 border border-rose-300/60 dark:border-rose-600/60 rounded-xl bg-gradient-to-r from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20 text-rose-700 dark:text-rose-300 hover:from-rose-100 hover:to-pink-100 dark:hover:from-rose-800/30 dark:hover:to-pink-800/30 focus:outline-none focus:ring-2 focus:ring-rose-500/50 shadow-sm hover:shadow-md transition-all duration-200 backdrop-blur-sm hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            <span class="font-medium">Réinitialiser</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tableau des contrats modernisé -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Liste de tous les contrats
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table id="contracts-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Employé</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 0a1 1 0 100 2h.01a1 1 0 100-2H9zm2 0a1 1 0 100 2h.01a1 1 0 100-2H11z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Type</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Début</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Fin</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Statut</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Rémunération</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 8a2 2 0 110-4 2 2 0 010 4zM10 18a8 8 0 100-16 8 8 0 000 16zM8 9a2 2 0 100 4 2 2 0 000-4zM12 9a2 2 0 100 4 2 2 0 000-4z"></path>
                                        </svg>
                                        <span>Actions</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($contracts as $contract)
                                @php
                                    $isExpiringSoon = $contract->date_fin && $contract->date_fin->diffInDays(now()) <= 60 && $contract->date_fin->isFuture();
                                    $isExpired = $contract->date_fin && $contract->date_fin->isPast();
                                @endphp
                                <tr data-contract="true" 
                                    data-status="{{ $contract->statut }}" 
                                    data-type="{{ $contract->type }}" 
                                    data-name="{{ $contract->user->first_name }} {{ $contract->user->last_name }}" 
                                    data-expiring="{{ $isExpiringSoon ? 'true' : 'false' }}" 
                                    class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 dark:hover:from-blue-900/10 dark:hover:to-indigo-900/10 transition-all duration-200 {{ $isExpired ? 'bg-red-50 dark:bg-red-900/10' : ($isExpiringSoon ? 'bg-orange-50 dark:bg-orange-900/10' : '') }}">
                                    <!-- Employé -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-200">
                                                    <span class="text-sm font-bold text-white">
                                                        {{ strtoupper(substr($contract->user->first_name, 0, 1) . substr($contract->user->last_name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">
                                                    {{ $contract->user->first_name }} {{ $contract->user->last_name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $contract->user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Type de contrat -->
                                    <td class="px-6 py-5" x-data="{ showType: false }">
                                        <div class="flex items-center space-x-2">
                                            <span x-show="!showType" class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200 dark:from-gray-900/30 dark:to-slate-900/30 dark:text-gray-300 dark:border-gray-700">
                                                •••••
                                            </span>
                                            <span x-show="showType" class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm
                                                @switch($contract->type)
                                                    @case('CDI')
                                                        bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200 dark:from-green-900/30 dark:to-emerald-900/30 dark:text-green-300 dark:border-green-700
                                                        @break
                                                    @case('CDD')
                                                        bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200 dark:from-blue-900/30 dark:to-indigo-900/30 dark:text-blue-300 dark:border-blue-700
                                                        @break
                                                    @case('Interim')
                                                        bg-gradient-to-r from-purple-100 to-violet-100 text-purple-800 border border-purple-200 dark:from-purple-900/30 dark:to-violet-900/30 dark:text-purple-300 dark:border-purple-700
                                                        @break
                                                    @case('Stage')
                                                        bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 border border-yellow-200 dark:from-yellow-900/30 dark:to-orange-900/30 dark:text-yellow-300 dark:border-yellow-700
                                                        @break
                                                    @case('Alternance')
                                                        bg-gradient-to-r from-indigo-100 to-blue-100 text-indigo-800 border border-indigo-200 dark:from-indigo-900/30 dark:to-blue-900/30 dark:text-indigo-300 dark:border-indigo-700
                                                        @break
                                                    @case('Freelance')
                                                        bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200 dark:from-gray-900/30 dark:to-slate-900/30 dark:text-gray-300 dark:border-gray-700
                                                        @break
                                                    @default
                                                        bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200 dark:from-gray-900/30 dark:to-slate-900/30 dark:text-gray-300 dark:border-gray-700
                                                @endswitch">
                                                @switch($contract->type)
                                                    @case('CDI')
                                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        @break
                                                    @case('CDD')
                                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        @break
                                                    @case('Freelance')
                                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        @break
                                                @endswitch
                                                {{ $contract->type }}
                                            </span>
                                            <button @click="showType = !showType" 
                                                    class="inline-flex items-center p-1 rounded-md text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                                <svg x-show="!showType" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <svg x-show="showType" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    
                                    <!-- Date de début -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center text-sm text-gray-900 dark:text-gray-100">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $contract->date_debut->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    
                                    <!-- Date de fin -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex items-center text-sm text-gray-900 dark:text-gray-100">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $contract->date_fin ? $contract->date_fin->format('d/m/Y') : 'Indéterminée' }}
                                            </div>
                                            @if($isExpired)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200 dark:from-red-900/30 dark:to-pink-900/30 dark:text-red-300 dark:border-red-700 animate-pulse">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Expiré
                                                </span>
                                            @elseif($isExpiringSoon)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-orange-100 to-yellow-100 text-orange-800 border border-orange-200 dark:from-orange-900/30 dark:to-yellow-900/30 dark:text-orange-300 dark:border-orange-700">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $contract->date_fin->diffInDays(now()) }} jours
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <!-- Statut -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm
                                            @switch($contract->statut)
                                                @case('actif')
                                                    bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200 dark:from-green-900/30 dark:to-emerald-900/30 dark:text-green-300 dark:border-green-700
                                                    @break
                                                @case('suspendu')
                                                    bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 border border-yellow-200 dark:from-yellow-900/30 dark:to-orange-900/30 dark:text-yellow-300 dark:border-yellow-700
                                                    @break
                                                @case('termine')
                                                    bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200 dark:from-red-900/30 dark:to-pink-900/30 dark:text-red-300 dark:border-red-700
                                                    @break
                                                @default
                                                    bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200 dark:from-gray-900/30 dark:to-slate-900/30 dark:text-gray-300 dark:border-gray-700
                                            @endswitch">
                                            <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ ucfirst($contract->statut) }}
                                        </span>
                                    </td>
                                    
                                    <!-- Rémunération -->
                                    <td class="px-6 py-5" x-data="{ showSalary: false }">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex items-center text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span x-show="!showSalary">•••••</span>
                                                <span x-show="showSalary">
                                                    @if($contract->type === 'Freelance')
                                                        {{ number_format($contract->tjm, 2) }} {{ $globalCompanyCurrency }} / jour
                                                    @else
                                                        {{ number_format($contract->salaire_brut, 2) }} {{ $globalCompanyCurrency }} / Brut an
                                                    @endif
                                                </span>
                                            </div>
                                            <button @click="showSalary = !showSalary" 
                                                    class="inline-flex items-center p-1 rounded-md text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                                <svg x-show="!showSalary" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <svg x-show="showSalary" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center space-x-3">
                                            @if($contract->statut !== 'termine')
                                                <!-- Bouton de modification du contrat -->
                                                <button @click="$nextTick(() => $dispatch('edit-contract', { contractId: {{ $contract->id }}, userId: {{ $contract->user->id }} }))" 
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-300 dark:hover:bg-green-900/50 transition-all duration-200 group/btn">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Modifier contrat
                                                </button>
                                            @else
                                                <!-- Message pour contrat terminé -->
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                    </svg>
                                                    Non modifiable
                                                </span>
                                            @endif
                                             
                                             <!-- Bouton de profil utilisateur -->
                                             <button @click="$dispatch('open-user-drawer', {{ $contract->user->toJson() }})" 
                                                     class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:hover:bg-blue-900/50 transition-all duration-200 group/btn">
                                                <svg class="w-3 h-3 mr-1.5 group-hover/btn:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Voir Profil
                                            </button>
                                            @if($contract->contrat_file)
                                                <a href="{{ route('admin.users.contracts.download', [$contract->user, $contract]) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-300 dark:hover:bg-green-900/50 transition-all duration-200 group/btn">
                                                    <svg class="w-3 h-3 mr-1.5 group-hover/btn:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Télécharger
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                             @empty
                                 <tr>
                                     <td colspan="7" class="px-6 py-16 text-center">
                                         <div class="flex flex-col items-center justify-center space-y-4">
                                             <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center">
                                                 <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                 </svg>
                                             </div>
                                             <div class="text-center">
                                                 <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Aucun contrat actif</h3>
                                                 <p class="text-gray-500 dark:text-gray-400 max-w-sm">Il n'y a actuellement aucun contrat actif dans le système. Les nouveaux contrats apparaîtront ici une fois créés.</p>
                                             </div>
                                         </div>
                                     </td>
                                 </tr>
                             @endforelse
                         </tbody>
                     </table>
                 </div>
             </div>
             
             <!-- Pagination -->
             <x-pagination :paginator="$contracts" entity-name="contrats" />
         </div>
     </div>
     
     <!-- User Drawer Component -->
     <x-user-drawer />
     
     <!-- Contract Edit Modal Component -->
     <x-contract-edit-modal :globalCompanyCurrency="$globalCompanyCurrency ?? '€'" />
 </x-app-layout>