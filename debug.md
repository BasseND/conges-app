J'arrive pas à me connecter. Quand je soumets mon formulaire je reste sur la page de connexion. Je ne vois pas pourquoi. J'ai l'impression que le front ne communique pas avec le back. 
Voici mes variables Railway :

APP_DEBUG="true"
APP_ENV="production"
APP_KEY="base64:PQQKHZ/jgKWxqNnQMqWElMkdmncoBunW7dftMS7dX+o="
APP_NAME="Laravel"
APP_URL="https://conges-app-production.up.railway.app"
ASSET_URL="https://conges-app-production.up.railway.app"
AWS_ACCESS_KEY_ID=""
AWS_BUCKET=""
AWS_DEFAULT_REGION="us-east-1"
AWS_SECRET_ACCESS_KEY=""
AWS_USE_PATH_STYLE_ENDPOINT="false"
BROADCAST_DRIVER="log"
CACHE_DRIVER="file"
DB_CONNECTION="mysql"
DB_DATABASE="railway"
DB_HOST="mysql.railway.internal"
DB_PASSWORD="my_password"
DB_PORT="3306"
DB_USERNAME="root"
FILESYSTEM_DISK="public"
FORCE_HTTPS="true"
LOG_CHANNEL="stack"
LOG_DEPRECATIONS_CHANNEL="null"
LOG_LEVEL="debug"
MAIL_ENCRYPTION="tls"
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
MAIL_HOST="sandbox.smtp.mailtrap.io"
MAIL_MAILER="smtp"
MAIL_PASSWORD="2b2578eed0e7f0"
MAIL_PORT="2525"
MAIL_USERNAME="608e620e27ed19"
MEMCACHED_HOST="127.0.0.1"
PUSHER_APP_CLUSTER="mt1"
PUSHER_APP_ID=""
PUSHER_APP_KEY=""
PUSHER_APP_SECRET=""
PUSHER_HOST=""
PUSHER_PORT="443"
PUSHER_SCHEME="https"
QUEUE_CONNECTION="sync"
REDIS_HOST="127.0.0.1"
REDIS_PASSWORD="null"
REDIS_PORT="6379"
SANCTUM_STATEFUL_DOMAINS="conges-app-production.up.railway.app"
SESSION_DOMAIN="conges-app-production.up.railway.app"
SESSION_DRIVER="file"
SESSION_LIFETIME="10080"
VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"

Alors je suis un perdu avec les variables de l'environnement et les variables qu'on a mis dans le .env.railway. Je pense qu'il a du travail à faire pour mettre tous ça clair.






















<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Détails de la demande d\'avance sur salaire') }}
            </h2>
            <a href="{{ route('admin.salary-advances.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                ← Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages de notification -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-800 dark:border-green-600 dark:text-green-100" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-800 dark:border-red-600 dark:text-red-100" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Informations de la demande -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informations de la demande</h3>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if($salaryAdvance->status === 'approved') 
                                bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                            @elseif($salaryAdvance->status === 'pending') 
                                bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                            @elseif($salaryAdvance->status === 'submitted') 
                                bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                            @elseif($salaryAdvance->status === 'rejected') 
                                bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                            @elseif($salaryAdvance->status === 'cancelled') 
                                bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @else 
                                bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @endif">
                            @if($salaryAdvance->status === 'approved')
                                Approuvé
                            @elseif($salaryAdvance->status === 'pending')
                                En attente
                            @elseif($salaryAdvance->status === 'submitted')
                                Soumis
                            @elseif($salaryAdvance->status === 'rejected')
                                Rejeté
                            @elseif($salaryAdvance->status === 'cancelled')
                                Annulé
                            @else
                                {{ ucfirst($salaryAdvance->status) }}
                            @endif
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations de l'employé -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-600 pb-2">Informations de l'employé</h4>
                            
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <div class="h-12 w-12 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                        <span class="text-lg font-medium text-gray-700 dark:text-gray-300">
                                            {{ substr($salaryAdvance->user->first_name, 0, 1) }}{{ substr($salaryAdvance->user->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ $salaryAdvance->user->first_name }} {{ $salaryAdvance->user->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $salaryAdvance->user->email }}
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Département :</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100 ml-2">
                                    {{ $salaryAdvance->user->department->name ?? 'N/A' }}
                                </span>
                            </div>
                            
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Poste :</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100 ml-2">
                                    {{ $salaryAdvance->user->position ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        <!-- Détails de la demande -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-600 pb-2">Détails de la demande</h4>
                            
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de demande :</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100 ml-2">
                                    {{ \Carbon\Carbon::parse($salaryAdvance->requested_date)->format('d/m/Y à H:i') }}
                                </span>
                            </div>
                            
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Montant demandé :</span>
                                <span class="text-lg font-bold text-gray-900 dark:text-gray-100 ml-2">
                                    {{ number_format($salaryAdvance->amount, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                </span>
                            </div>
                            
                            @if($salaryAdvance->approved_date)
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Date d'approbation :</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100 ml-2">
                                        {{ \Carbon\Carbon::parse($salaryAdvance->approved_date)->format('d/m/Y à H:i') }}
                                    </span>
                                </div>
                            @endif
                            
                            @if($salaryAdvance->approver)
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Approuvé par :</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100 ml-2">
                                        {{ $salaryAdvance->approver->first_name }} {{ $salaryAdvance->approver->last_name }}
                                    </span>
                                </div>
                            @endif
                            
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Remboursement :</span>
                                <span class="text-sm ml-2 {{ $salaryAdvance->is_fully_repaid ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                    {{ $salaryAdvance->is_fully_repaid ? 'Entièrement remboursé' : 'En cours de remboursement' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Motif de la demande -->
                    <div class="mt-6">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">Motif de la demande</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $salaryAdvance->reason }}</p>
                        </div>
                    </div>

                    <!-- Notes (si rejeté) -->
                    @if($salaryAdvance->status === 'rejected' && $salaryAdvance->notes)
                        <div class="mt-6">
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">Motif du rejet</h4>
                            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                                <p class="text-sm text-red-700 dark:text-red-300">{{ $salaryAdvance->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    @if($salaryAdvance->status === 'submitted')
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                            <div class="flex space-x-4">
                                <form action="{{ route('admin.salary-advances.approve', $salaryAdvance) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" onclick="return confirm('Êtes-vous sûr de vouloir approuver cette demande ?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Approuver
                                    </button>
                                </form>
                                
                                <button type="button" onclick="openRejectModal({{ $salaryAdvance->id }})" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Rejeter
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Historique des remboursements -->
            @if($salaryAdvance->repayments->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Historique des remboursements</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Montant</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Solde restant</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($salaryAdvance->repayments as $repayment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($repayment->repayment_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ number_format($repayment->amount, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ number_format($repayment->remaining_balance, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total remboursé :</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($salaryAdvance->repayments->sum('amount'), 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Solde restant :</span>
                                <span class="text-sm font-bold {{ $salaryAdvance->remaining_balance > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                    {{ number_format($salaryAdvance->remaining_balance, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de rejet -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Rejeter la demande</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Motif du rejet (optionnel)
                        </label>
                        <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100" placeholder="Expliquez pourquoi cette demande est rejetée..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Rejeter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(advanceId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = '/admin/salary-advances/' + advanceId + '/reject';
            modal.classList.remove('hidden');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            const notesField = document.getElementById('notes');
            modal.classList.add('hidden');
            notesField.value = '';
        }

        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>