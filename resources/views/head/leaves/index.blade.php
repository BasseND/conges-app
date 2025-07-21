@section('title', 'Validation des congés')
<x-app-layout>
    <div class="min-h-screen">
       <!-- Hedare -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
            <div class="flex items-center">
                <div class="bg-white/20 rounded-xl p-3 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">{{ __('Validation des congés') }}</h1>
                    <p class="text-blue-100 mt-1">Gérez et approuvez les demandes de congés de votre équipe</p>
                </div>
            </div>
        </div>

        <!-- Formulaire de recherche et filtres -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 mb-8">
            <div class="p-8 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-700 border-b border-gray-200 dark:border-gray-600">
                <form action="{{ route('head.leaves.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Recherche par nom -->
                    <div>
                        <label for="search" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Rechercher un employé</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="pl-10 block w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200"
                                placeholder="Nom, email ou ID">
                        </div>
                    </div>

                    <!-- Statut -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Statut</label>
                        <select name="status" id="status"
                            class="block w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200">
                            <option value="">Tous les statuts</option>
                            @foreach(\App\Models\Leave::STATUSES as $value => $label)
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type de congé -->
                    <div>
                        <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Type de congé</label>
                        <select name="type" id="type"
                            class="block w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200">
                            <option value="">Tous les types</option>
                            @foreach(\App\Models\Leave::TYPES as $value => $label)
                                <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Période -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Période</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                    class="block w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200">
                            </div>
                            <div>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                    class="block w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200">
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="md:col-span-3 flex justify-end space-x-4">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Filtrer
                        </button>

                        <a href="{{ route('head.leaves.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-gray-500 dark:bg-gray-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-lg">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>



        <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center">
                    <div class="bg-green-100 dark:bg-green-900/30 rounded-xl p-3 mr-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Demandes de congés</h3>
                </div>

                <!-- Boutons de basculement vue -->
                <div class="flex justify-end">
                    <div class="view-toggle-container">
                        <button id="table-view-btn" class="view-toggle-btn active">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18m-9 8h9"/>
                            </svg>
                            <span>Vue Tableau</span>
                        </button>
                        <button id="calendar-view-btn" class="view-toggle-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Vue Calendrier</span>
                        </button>
                    </div>
                </div>

            </div>


             <!-- Vue Calendrier (cachée par défaut) -->
            <div id="calendar-view" class="hidden calendar-container mb-6">
                <div class="p-6">
                    <div id="calendar" class="relative"></div>
                </div>
            </div>

            <!-- Vue Tableau -->
            <div id="table-view">
                <div class="relative">
                    @if(session('success'))
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900 dark:to-emerald-900 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-6 py-4 rounded-xl relative mb-6 shadow-lg" role="alert">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900 dark:to-pink-900 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-6 py-4 rounded-xl relative mb-6 shadow-lg" role="alert">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($leaves->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">Aucune demande de congé trouvée</p>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Modifiez vos critères de recherche pour voir plus de résultats</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                            Employé
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                            Département
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                            Période
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                            Durée
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach($leaves as $leave)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                                                            {{ substr($leave->user->first_name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-200">{{ $leave->user->first_name }}</div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $leave->user->email }}</div>
                                                        <div class="text-xs text-gray-400 dark:text-gray-500">ID: {{ $leave->user->employee_id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $leave->user->department->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $leave->user->department->code }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <x-leave-type-badge :type="$leave->type" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-200">
                                                    <div class="flex items-center mb-1">
                                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">Du</span>
                                                    </div>
                                                    <div class="font-medium">{{ $leave->start_date->format('d/m/Y') }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Au {{ $leave->end_date->format('d/m/Y') }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900 dark:to-purple-900 rounded-lg px-3 py-1">
                                                        <span class="text-sm font-semibold text-indigo-800 dark:text-indigo-200">{{ $leave->duration }}</span>
                                                        <span class="text-xs text-indigo-600 dark:text-indigo-300 ml-1">jour(s)</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <x-leave-status :status="$leave->status" />
                                                @if($leave->processed_at)
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        {{ $leave->processed_at->format('d/m/Y H:i') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($leave->status === 'pending' && Auth::check() && auth()->user()->canManageUserLeaves($leave->user))
                                                    <div class="flex space-x-2">
                                                        <button title="Approuver" @click="$dispatch('approve-leave', '{{ route('head.leaves.approve', $leave) }}')" 
                                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            Approuver
                                                        </button>
                                                        <button title="Rejeter" @click="$dispatch('reject-leave', '{{ route('head.leaves.reject', $leave) }}')" 
                                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            Rejeter
                                                        </button>
                                                    </div>
                                                @else
                                                    @if($leave->status === 'approved')
                                                        <span class="inline-flex items-center px-3 py-2 text-sm text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded-lg">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            Approuvé
                                                        </span>
                                                    @elseif($leave->status === 'rejected')
                                                        <span class="inline-flex items-center px-3 py-2 text-sm text-red-700 bg-red-100 dark:bg-red-900/30 dark:text-red-400 rounded-lg">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            Rejeté
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($leaves instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <!-- Pagination -->
                            <x-pagination :paginator="$leaves" entity-name="congés" />
                        @endif
                        
                    @endif
                </div>
            </div>

        </div>
       
    </div>

    <x-modals.approve-leave message="Êtes-vous sûr de vouloir approuver cette demande de congé ?" />
    <x-modals.reject-leave message="Êtes-vous sûr de vouloir rejeter cette demande de congé ?" />

    @push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <!-- Les styles du calendrier sont maintenant dans le fichier SCSS _calendar.scss -->
    @endpush

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableViewBtn = document.getElementById('table-view-btn');
            const calendarViewBtn = document.getElementById('calendar-view-btn');
            const tableView = document.getElementById('table-view');
            const calendarView = document.getElementById('calendar-view');
            const calendarEl = document.getElementById('calendar');
            
            let calendar;
            let currentView = 'table';

            // Fonction pour basculer entre les vues
            function switchView(view) {
                if (view === 'calendar') {
                    // Transition avec animation
                    tableView.classList.add('view-transition-exit-active');
                    setTimeout(() => {
                        tableView.classList.add('hidden');
                        tableView.classList.remove('view-transition-exit-active');
                        
                        calendarView.classList.remove('hidden');
                        calendarView.classList.add('view-transition-enter-active');
                        
                        setTimeout(() => {
                            calendarView.classList.remove('view-transition-enter-active');
                        }, 300);
                    }, 150);
                    
                    // Mettre à jour les styles des boutons
                    tableViewBtn.classList.remove('active');
                    calendarViewBtn.classList.add('active');
                    
                    // Initialiser le calendrier si ce n'est pas déjà fait
                    if (!calendar) {
                        setTimeout(() => {
                            initializeCalendar();
                        }, 200);
                    }
                    
                    currentView = 'calendar';
                } else {
                    // Transition avec animation
                    calendarView.classList.add('view-transition-exit-active');
                    setTimeout(() => {
                        calendarView.classList.add('hidden');
                        calendarView.classList.remove('view-transition-exit-active');
                        
                        tableView.classList.remove('hidden');
                        tableView.classList.add('view-transition-enter-active');
                        
                        setTimeout(() => {
                            tableView.classList.remove('view-transition-enter-active');
                        }, 300);
                    }, 150);
                    
                    // Mettre à jour les styles des boutons
                    calendarViewBtn.classList.remove('active');
                    tableViewBtn.classList.add('active');
                    
                    currentView = 'table';
                }
            }

            // Variable pour suivre la vue actuelle du calendrier
            let currentCalendarView = 'dayGridMonth';

            // Fonction pour initialiser le calendrier
            function initializeCalendar() {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'fr',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek,listWeek'
                    },
                    views: {
                        dayGridMonth: {
                            buttonText: 'Mois'
                        },
                        dayGridWeek: {
                            buttonText: 'Semaine'
                        },
                        listWeek: {
                            buttonText: 'Liste'
                        }
                    },
                    buttonText: {
                        today: 'Aujourd\'hui',
                        month: 'Mois',
                        week: 'Semaine',
                        list: 'Liste'
                    },
                    viewDidMount: function(info) {
                        // Mettre à jour la vue actuelle quand elle change
                        currentCalendarView = info.view.type;
                    },
                    customButtons: {
                        dayGridMonth: {
                            text: 'Mois',
                            click: function() {
                                if (currentCalendarView === 'dayGridMonth') {
                                    // Si on est déjà en vue mois, ne rien faire (c'est la vue par défaut)
                                    return;
                                }
                                calendar.changeView('dayGridMonth');
                            }
                        },
                        dayGridWeek: {
                            text: 'Semaine',
                            click: function() {
                                if (currentCalendarView === 'dayGridWeek') {
                                    // Si on est déjà en vue semaine, revenir à la vue mois
                                    calendar.changeView('dayGridMonth');
                                } else {
                                    calendar.changeView('dayGridWeek');
                                }
                            }
                        },
                        listWeek: {
                            text: 'Liste',
                            click: function() {
                                if (currentCalendarView === 'listWeek') {
                                    // Si on est déjà en vue liste, revenir à la vue mois
                                    calendar.changeView('dayGridMonth');
                                } else {
                                    calendar.changeView('listWeek');
                                }
                            }
                        }
                    },
                    events: function(fetchInfo, successCallback, failureCallback) {
                        // Récupérer les paramètres de filtrage actuels
                        const urlParams = new URLSearchParams(window.location.search);
                        const filterParams = {
                            search: urlParams.get('search') || '',
                            department: urlParams.get('department') || '',
                            status: urlParams.get('status') || '',
                            type: urlParams.get('type') || '',
                            date_from: urlParams.get('date_from') || '',
                            date_to: urlParams.get('date_to') || ''
                        };

                        fetch('{{ route("head.leaves.calendar-data") }}?' + new URLSearchParams(filterParams))
                            .then(response => response.json())
                            .then(data => {
                                successCallback(data);
                            })
                            .catch(error => {
                                console.error('Erreur lors du chargement des données:', error);
                                failureCallback(error);
                            });
                    },
                    eventClick: function(info) {
                        // Rediriger vers la page de détail du congé
                        if (info.event.extendedProps.url) {
                            window.location.href = info.event.extendedProps.url;
                        }
                    },
                    eventMouseEnter: function(info) {
                        // Créer un tooltip avec les nouvelles classes CSS
                        const tooltip = document.createElement('div');
                        tooltip.className = 'fc-tooltip';
                        tooltip.style.position = 'absolute';
                        tooltip.style.zIndex = '1000';
                        tooltip.style.pointerEvents = 'none';
                        
                        const props = info.event.extendedProps;
                        tooltip.innerHTML = `
                            <div class="tooltip-header">${props.employee}</div>
                            <div class="tooltip-row">
                                <div class="tooltip-label">Département:</div>
                                <div class="tooltip-value">${props.department}</div>
                            </div>
                            <div class="tooltip-row">
                                <div class="tooltip-label">Type:</div>
                                <div class="tooltip-value">${props.type}</div>
                            </div>
                            <div class="tooltip-row">
                                <div class="tooltip-label">Statut:</div>
                                <div class="tooltip-value">${props.status}</div>
                            </div>
                            <div class="tooltip-row">
                                <div class="tooltip-label">Durée:</div>
                                <div class="tooltip-value">${props.duration} jour(s)</div>
                            </div>
                            ${props.reason ? `
                                <div class="tooltip-row">
                                    <div class="tooltip-label">Motif:</div>
                                    <div class="tooltip-value">${props.reason}</div>
                                </div>
                            ` : ''}
                        `;
                        
                        document.body.appendChild(tooltip);
                        info.el.tooltip = tooltip;
                        
                        // Positionner le tooltip
                        const rect = info.el.getBoundingClientRect();
                        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
                        
                        tooltip.style.left = (rect.left + scrollLeft) + 'px';
                        tooltip.style.top = (rect.bottom + scrollTop + 5) + 'px';
                        
                        // Ajuster la position si le tooltip dépasse de l'écran
                        setTimeout(() => {
                            const tooltipRect = tooltip.getBoundingClientRect();
                            if (tooltipRect.right > window.innerWidth) {
                                tooltip.style.left = (rect.right + scrollLeft - tooltipRect.width) + 'px';
                            }
                            if (tooltipRect.bottom > window.innerHeight) {
                                tooltip.style.top = (rect.top + scrollTop - tooltipRect.height - 5) + 'px';
                            }
                        }, 0);
                    },
                    eventMouseLeave: function(info) {
                        // Supprimer le tooltip
                        if (info.el.tooltip) {
                            document.body.removeChild(info.el.tooltip);
                            info.el.tooltip = null;
                        }
                    }
                });
                
                calendar.render();
            }

            // Gestionnaires d'événements pour les boutons
            tableViewBtn.addEventListener('click', () => switchView('table'));
            calendarViewBtn.addEventListener('click', () => switchView('calendar'));

            // Recharger le calendrier quand les filtres changent
            const form = document.querySelector('form[action="{{ route('head.leaves.index') }}"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (currentView === 'calendar' && calendar) {
                        e.preventDefault();
                        
                        // Mettre à jour l'URL avec les nouveaux paramètres
                        const formData = new FormData(form);
                        const params = new URLSearchParams();
                        for (let [key, value] of formData.entries()) {
                            if (value) params.append(key, value);
                        }
                        
                        const newUrl = window.location.pathname + '?' + params.toString();
                        window.history.pushState({}, '', newUrl);
                        
                        // Recharger les événements du calendrier
                        calendar.refetchEvents();
                    }
                });
            }
        });
    </script>
    @endpush

</x-app-layout>
