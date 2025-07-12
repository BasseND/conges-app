<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold pb-5 text-bgray-900 dark:text-white">
                {{ __('Détails de l\'avance sur salaire') }}
            </h2>
            @if($salaryAdvance->status === 'pending')
                <form action="{{ route('salary-advances.cancel', $salaryAdvance) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette demande ?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ __('Annuler la demande') }}
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Informations de l'avance -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informations générales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Montant demandé</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ number_format($salaryAdvance->amount, 2, ',', ' ') }} {{ $globalCompanyCurrency }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de demande</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($salaryAdvance->request_date)->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Motif</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $salaryAdvance->reason }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Statut</p>
                                    <p class="text-base font-medium">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($salaryAdvance->status === 'approved') 
                                                bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                            @elseif($salaryAdvance->status === 'pending') 
                                                bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
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
                                            @elseif($salaryAdvance->status === 'rejected')
                                                Rejeté
                                            @elseif($salaryAdvance->status === 'cancelled')
                                                Annulé
                                            @else
                                                {{ ucfirst($salaryAdvance->status) }}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date d'approbation</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $salaryAdvance->approval_date ? \Carbon\Carbon::parse($salaryAdvance->approval_date)->format('d/m/Y') : 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Approuvé par</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $salaryAdvance->approver ? $salaryAdvance->approver->first_name . ' ' . $salaryAdvance->approver->last_name : 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de paiement</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $salaryAdvance->payment_date ? \Carbon\Carbon::parse($salaryAdvance->payment_date)->format('d/m/Y') : 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Remboursé</p>
                                    <p class="text-base font-medium">
                                        @if($salaryAdvance->is_fully_repaid)
                                            <span class="text-green-600 dark:text-green-400">Oui</span>
                                        @else
                                            <span class="text-yellow-600 dark:text-yellow-400">Non</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($salaryAdvance->comments)
                        <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Commentaires</p>
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $salaryAdvance->comments }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Historique des remboursements -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Historique des remboursements</h3>
                    
                    @if($repayments->isEmpty())
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                            @if($salaryAdvance->status === 'approved')
                                <p class="text-gray-500 dark:text-gray-400">Aucun remboursement n'a encore été effectué.</p>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">Les remboursements seront affichés ici une fois l'avance approuvée et les paiements commencés.</p>
                            @endif
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Montant</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bulletin de paie</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($repayments as $repayment)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($repayment->date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ number_format($repayment->amount, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                @if($repayment->payslip)
                                                    <a href="{{ route('payslips.show', $repayment->payslip) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                        {{ \Carbon\Carbon::parse($repayment->payslip->period_start)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($repayment->payslip->period_end)->format('d/m/Y') }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $repayment->notes ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">Total remboursé</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">
                                            {{ number_format($repayments->sum('amount'), 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">Reste à rembourser</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold 
                                            @if($salaryAdvance->amount - $repayments->sum('amount') > 0)
                                                text-red-600 dark:text-red-400
                                            @else
                                                text-green-600 dark:text-green-400
                                            @endif">
                                            {{ number_format(max(0, $salaryAdvance->amount - $repayments->sum('amount')), 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('salary-advances.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            {{ __('Retour à la liste') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
