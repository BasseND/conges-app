<div class="sidebar-container fixed inset-y-0 left-0 z-30 w-64 bg-indigo-50 dark:bg-gray-800 shadow-lg transform transition-transform duration-300 ease-in-out" 
    :class="{'translate-x-0': $store.sidebar.open, '-translate-x-full': !$store.sidebar.open}"
    x-cloak>
    
    <div class="flex flex-col h-full">
        <!-- Logo et titre -->
        <div class="flex items-center justify-between p-4 border-b border-indigo-100 dark:border-gray-700">
            <a href="{{ route('welcome.index') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
            <button @click="$store.sidebar.toggle()" class="p-1 rounded-md hover:bg-indigo-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 lg:hidden">
                <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Menu principal -->
        <div class="flex-1 overflow-y-auto py-4 px-3">
            <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2 px-3">
                Menu
            </div>
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.stats.index') }}" class="sidebar-link {{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Présence / Attendance -->
                <a href="#" class="sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    <span>Présence</span>
                    <span class="sidebar-badge">5</span>
                </a>

                <!-- Paie / Payroll -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="sidebar-link w-full flex justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-3">Paie</span>
                        </div>
                        <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="space-y-1 pl-8">
                        <a href="{{ route('payslips.index') }}" class="sidebar-sublink {{ request()->routeIs('payslips.*') ? 'active' : '' }}">
                            Bulletins de paie
                        </a>
                        <a href="{{ route('salary-advances.index') }}" class="sidebar-sublink {{ request()->routeIs('salary-advances.*') ? 'active' : '' }}">
                            Avances sur salaire
                        </a>
                        @if (Auth::check() && auth()->user()->hasAdminAccess())
                        <a href="{{ route('admin.salary-advances.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.salary-advances.*') ? 'active' : '' }}">
                            Gestion des avances
                        </a>
                        <a href="{{ route('admin.payroll-settings.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.payroll-settings.*') ? 'active' : '' }}">
                            Paramètres de paie
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Employés / Employees -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="sidebar-link w-full flex justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                            <span class="ml-3">Employés</span>
                        </div>
                        <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="space-y-1 pl-8">
                        <a href="{{ route('admin.users.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            Liste des employés
                        </a>
                        <a href="{{ route('admin.departments.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                            Entités
                        </a>
                    </div>
                </div>

                <!-- Congés / Leave -->
                <a href="{{ route('leaves.index') }}" class="sidebar-link {{ request()->routeIs('leaves.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <span>Congés</span>
                </a>

                <!-- Notes de frais / Expense Reports -->
                <a href="{{ route('expense-reports.index') }}" class="sidebar-link {{ request()->routeIs('expense-reports.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                    <span>Notes de frais</span>
                </a>

                <!-- Messagerie / Messages -->
                <a href="{{ route('messages.index') }}" class="sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" 
                   x-data="{ 
                       unreadCount: 0,
                       fetchUnreadCount() {
                           fetch('{{ route('messages.unread-count') }}', {
                               method: 'GET',
                               headers: {
                                   'Accept': 'application/json',
                                   'X-Requested-With': 'XMLHttpRequest'
                               },
                               credentials: 'same-origin'
                           })
                           .then((response) => {
                               if (response.ok) {
                                   // Vérifier si la réponse est bien du JSON
                                   const contentType = response.headers.get('content-type');
                                   if (contentType && contentType.includes('application/json')) {
                                       return response.json();
                                   } else {
                                       // Probablement une redirection vers la page de connexion
                                       throw new Error('Réponse non-JSON reçue');
                                   }
                               }
                               throw new Error('Erreur réseau: ' + response.status);
                           })
                           .then((data) => {
                               if (data && typeof data.count !== 'undefined') {
                                   this.unreadCount = data.count;
                               }
                           })
                           .catch((error) => {
                               console.error('Erreur lors de la récupération des messages non lus:', error);
                               // Ne pas modifier unreadCount en cas d'erreur
                           });
                       }
                   }" 
                   x-init="
                       // Récupérer le nombre initial après un délai pour s'assurer que l'authentification est complète
                       setTimeout(() => fetchUnreadCount(), 1000);
                    
                        // Actualiser toutes les 30 secondes
                        setInterval(() => fetchUnreadCount(), 30000);
                ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    <span>Messagerie</span>
                    <span x-show="unreadCount > 0" x-text="unreadCount" class="sidebar-badge" x-cloak></span>
                </a>
            </nav>
        </div>

        <!-- Pied de page -->
        <div class="p-4 border-t border-indigo-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <img src="{{ Auth::check() ? (auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->first_name.' '.auth()->user()->last_name).'&color=7F9CF5&background=EBF4FF') : 'https://ui-avatars.com/api/?name=Invité&color=7F9CF5&background=EBF4FF' }}" alt="{{ Auth::check() ? auth()->user()->first_name : 'Invité' }}" class="h-8 w-8 rounded-full">
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::check() ? auth()->user()->first_name.' '.auth()->user()->last_name : 'Invité' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::check() ? auth()->user()->role : 'Non connecté' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H3zm1 2v10h10V5H4zm4 5a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Overlay pour fermer la sidebar sur mobile -->
<div x-show="$store.sidebar.open" @click="$store.sidebar.toggle()" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity lg:hidden"></div>

<!-- Bouton pour ouvrir la sidebar sur mobile -->
<button @click="$store.sidebar.toggle()" class="fixed bottom-4 right-4 p-2 rounded-full bg-indigo-600 text-white shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 lg:hidden z-30">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>
