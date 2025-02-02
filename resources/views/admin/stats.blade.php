<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Statistiques des congés -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100  mb-4">Statistiques des congés</h3>
                        {{-- <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">En attente</span>
                                <span class="text-yellow-600 dark:text-yellow-400 font-semibold">{{ $stats['pending'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Approuvés</span>
                                <span class="text-green-600 dark:text-green-400 font-semibold">{{ $stats['approved'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Rejetés</span>
                                <span class="text-red-600 dark:text-red-400 font-semibold">{{ $stats['rejected'] }}</span>
                            </div>
                        </div> --}}

                        <div class="chart-container">
                            <canvas id="congesChart"></canvas>
                        </div>
                    </div>
                </div>


                

                <!-- Statistiques des utilisateurs -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100  mb-4">Statistiques des utilisateurs</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Total employés</span>
                                <span class="text-blue-600 dark:text-blue-400 font-semibold">{{ $stats['employees'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Managers</span>
                                <span class="text-purple-600 dark:text-purple-400 font-semibold">{{ $stats['managers'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Administrateurs</span>
                                <span class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ $stats['admins'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100  mb-4">Actions rapides</h3>
                        <div class="space-y-4">
                            <a href="{{ route('admin.leaves.index') }}" 
                               class="block w-full text-center dark:bg-indigo-600 dark:text-white px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Gérer les congés
                            </a>
                            <a href="{{ route('admin.users.index') }}" 
                               class="block w-full text-center px-4 py-2 bg-green-600 dark:bg-green-600 text-white dark:text-white rounded-md hover:bg-green-700 transition-colors">
                                Gérer les utilisateurs
                            </a>
                            <a href="{{ route('admin.departments.index') }}" 
                               class="block w-full text-center px-4 py-2 bg-purple-600  dark:bg-purple-600 dark:text-white text-white rounded-md hover:bg-purple-700 transition-colors">
                                Gérer les départements
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Graphiques -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Graphique par département -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Jours de congés par département</h3>
                        <div class="h-80">
                            <canvas id="departmentChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Graphique par mois -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Jours de congés par mois</h3>
                        <div class="h-80">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Dernières activités -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100  mb-4">Dernières activités</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Utilisateur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Action</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentLeaves as $activity)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-100">
                                            {{ $activity->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $activity->user->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-100">{{ $activity->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-100">
                                            Demande de congé
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $activity->status === 'approved' ? 'bg-green-100 dark:bg-green-200 text-green-800' : 
                                                       ($activity->status === 'rejected' ? 'bg-red-100 dark:bg-red-200 text-red-800' : 
                                                       'bg-yellow-100 dark:bg-yellow-200 text-yellow-800') }}">
                                                    @switch($activity->status)
                                                        @case('approved')
                                                            Approuvé
                                                            @break
                                                        @case('rejected')
                                                            Rejeté
                                                            @break
                                                        @default
                                                            En attente
                                                    @endswitch
                                                </span>
                                                @if($activity->processed_at)
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        {{ $activity->processed_at->format('d/m/Y H:i') }}
                                                    </div>
                                                @endif
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

     @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        // Données pour le graphique des congés
        const congesData = @json($stats);
        const congesChart = new Chart(
            document.getElementById('congesChart'),
            {
                type: 'doughnut',
                data: {
                    labels: ['En attente', 'Approuvés', 'Rejetés'],
                    datasets: [{
                        data: [
                            congesData.pending, 
                            congesData.approved, 
                            congesData.rejected
                        ],
                        backgroundColor: [
                            'rgb(132 108 249)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgb(7 182 213)'
                        ],
                        borderColor: [
                            'rgb(132 108 249)',
                            'rgba(54, 162, 235, 1)',
                            'rgb(7 182 213)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        );
        // Données pour le graphique par département
        const departmentData = @json($departmentStats);
        const departmentChart = new Chart(
            document.getElementById('departmentChart'),
            {
                type: 'bar',
                data: {
                    labels: departmentData.map(item => item.name),
                    datasets: [{
                        label: 'Jours de congés',
                        data: departmentData.map(item => item.total_days),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nombre de jours'
                            }
                        }
                    }
                }
            }
        );

        // Données pour le graphique par mois
        const monthlyData = @json($monthlyStats);
        const monthlyChart = new Chart(
            document.getElementById('monthlyChart'),
            {
                type: 'line',
                data: {
                    labels: monthlyData.map(item => item.month),
                    datasets: [{
                        label: 'Jours de congés',
                        data: monthlyData.map(item => item.total_days),
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: true,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nombre de jours'
                            }
                        }
                    }
                }
            }
        );
    </script>
    @endpush
</x-app-layout>
