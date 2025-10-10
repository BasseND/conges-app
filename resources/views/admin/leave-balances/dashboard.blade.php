@section('title', 'Dashboard des Soldes de Congés')

<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-950">
        <div class="px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
            
            <!-- En-tête -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl shadow-lg">
                            <svg  class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg> 
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Dashboard des Soldes de Congés
                            </h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Gestion et supervision des soldes de congés pour l'année {{ $year }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.leave-balances.tools') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Outils Admin
                        </a>
                        <a href="{{ route('admin.leave-balances.adjustments') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Ajustements
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 ring-1 ring-gray-200 dark:ring-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                              
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Utilisateurs Actifs</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_users']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 ring-1 ring-gray-200 dark:ring-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Avec Soldes</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['users_with_balances']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 ring-1 ring-gray-200 dark:ring-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                              
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Jours Utilisés</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_used_days']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 ring-1 ring-gray-200 dark:ring-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 {{ $stats['negative_balances'] > 0 ? 'bg-red-100 dark:bg-red-900' : 'bg-gray-100 dark:bg-gray-700' }} rounded-lg">
                            <svg class="w-6 h-6 {{ $stats['negative_balances'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Soldes Négatifs</p>
                            <p class="text-2xl font-bold {{ $stats['negative_balances'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                                {{ number_format($stats['negative_balances']) }}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- KPI: Jours Initiaux -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 ring-1 ring-gray-200 dark:ring-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                            <svg  class="w-6 h-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Jours Initiaux</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_initial_days'] ?? 0) }}</p>
                        </div>
                    </div>
                </div>
                <!-- KPI: Jours Courants -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 ring-1 ring-gray-200 dark:ring-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Jours Courants</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_current_days'] ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zone de graphiques -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Par département (Barres) -->
                <div class="relative bg-gradient-to-br from-white via-teal-50 to-cyan-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-500"></div>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">📊 Soldes par Département</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Année {{ $year }}</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="relative h-80 bg-white dark:bg-gray-800 rounded-xl p-4">
                            <canvas id="chartByDepartment"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Répartition par type (Donut) -->
                <div class="relative bg-gradient-to-br from-white via-indigo-50 to-purple-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500"></div>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">🟣 Répartition par Type de Congé</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Année {{ $year }}</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="relative h-80 bg-white dark:bg-gray-800 rounded-xl p-4">
                            <canvas id="chartByType"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Soldes négatifs (Ligne) -->
                <div class="relative bg-gradient-to-br from-white via-rose-50 to-red-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-rose-500 via-red-500 to-rose-500"></div>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">🔻 Évolution Soldes Négatifs</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Année {{ $year }}</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="relative h-80 bg-white dark:bg-gray-800 rounded-xl p-4">
                            <canvas id="chartNegative"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Heatmap par utilisateur/type -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-8 ring-1 ring-gray-200 dark:ring-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Matrice Soldes (Utilisateur × Type)</h3>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Top 20 utilisateurs</span>
                </div>
                <div id="heatmapBalances" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                    <!-- Les cases seront injectées par JS -->
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    // Données issues du contrôleur
    const departments = @json($departments->pluck('name'));
    const leaveTypes = @json($leaveTypes->pluck('name'));
    const users = @json($users->items());

    // Agrégations côté client
    const aggregates = (function() {
        const byDepartment = {};
        const byType = {};
        const negativesByMonth = new Array(12).fill(0);
        users.forEach(u => {
            const depName = u.department ? u.department.name : 'N/A';
            byDepartment[depName] = byDepartment[depName] || 0;
            (u.leave_balances || []).forEach(b => {
                byDepartment[depName] += (b.current_balance || 0);
                const typeName = b.special_leave_type ? b.special_leave_type.name : 'N/A';
                byType[typeName] = (byType[typeName] || 0) + (b.used_balance || 0);
                if ((b.current_balance || 0) < 0) {
                    const m = (new Date()).getMonth();
                    negativesByMonth[m] += 1;
                }
            });
        });
        return { byDepartment, byType, negativesByMonth };
    })();

    // Bar: Soldes par Département
    (function() {
        const labels = Object.keys(aggregates.byDepartment);
        const data = labels.map(l => aggregates.byDepartment[l]);
        const ctx = document.getElementById('chartByDepartment');
        if (ctx && labels.length) {
            new Chart(ctx, {
                type: 'bar',
                data: { labels, datasets: [{ label: 'Soldes courants', data, backgroundColor: 'rgba(37, 99, 235, 0.2)', borderColor: 'rgb(37, 99, 235)', borderWidth: 1 }] },
                options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
            });
        }
    })();

    // Doughnut: Répartition par Type
    (function() {
        const labels = Object.keys(aggregates.byType);
        const data = labels.map(l => aggregates.byType[l]);
        const ctx = document.getElementById('chartByType');
        if (ctx && labels.length) {
            new Chart(ctx, {
                type: 'doughnut',
                data: { labels, datasets: [{ data, backgroundColor: ['#3b82f6','#22c55e','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#84cc16','#f97316'] }] },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });
        }
    })();

    // Line: Évolution Soldes Négatifs
    (function() {
        const labels = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
        const data = aggregates.negativesByMonth;
        const ctx = document.getElementById('chartNegative');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: { labels, datasets: [{ label: 'Soldes négatifs', data, borderColor: 'rgb(239, 68, 68)', backgroundColor: 'rgba(239, 68, 68, 0.2)', tension: 0.3 }] },
                options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, precision: 0 } } }
            });
        }
    })();

    // Heatmap: Top 20 utilisateurs × types
    (function() {
        const container = document.getElementById('heatmapBalances');
        if (!container) return;
        const topUsers = users.slice(0, 20);
        topUsers.forEach(u => {
            const card = document.createElement('div');
            card.className = 'p-4 border border-gray-200 dark:border-gray-700 rounded-lg';
            const title = document.createElement('div');
            title.className = 'text-sm font-medium text-gray-900 dark:text-white mb-2';
            title.textContent = `${u.first_name} ${u.last_name}`;
            card.appendChild(title);
            const grid = document.createElement('div');
            grid.className = 'grid grid-cols-2 sm:grid-cols-3 gap-2';
            (u.leave_balances || []).forEach(b => {
                const name = b.special_leave_type ? b.special_leave_type.name : 'N/A';
                const val = (b.current_balance || 0);
                const box = document.createElement('div');
                const color = val < 0 ? 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' : val === 0 ? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' : 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300';
                box.className = `text-xs ${color} rounded-md px-2 py-1 flex items-center justify-between`;
                box.innerHTML = `<span>${name}</span><span class='font-semibold'>${val}</span>`;
                grid.appendChild(box);
            });
            card.appendChild(grid);
            container.appendChild(card);
        });
    })();
</script>