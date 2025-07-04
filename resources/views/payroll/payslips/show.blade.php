<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold pb-5 text-bgray-900 dark:text-white">
                {{ __('Bulletin de paie') }} - {{ \Carbon\Carbon::parse($payslip->period_start)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($payslip->period_end)->format('d/m/Y') }}
            </h2>
            <a href="{{ route('payslips.download', $payslip) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                {{ __('Télécharger') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations employé -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informations employé</h3>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $payslip->user->last_name }} {{ $payslip->user->first_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Matricule</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $payslip->user->employee_id ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Poste</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $payslip->user->job_title ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Département</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $payslip->user->department->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations bulletin -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informations bulletin</h3>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Période</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($payslip->period_start)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($payslip->period_end)->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de paiement</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $payslip->payment_date ? \Carbon\Carbon::parse($payslip->payment_date)->format('d/m/Y') : 'Non payé' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Statut</p>
                                        <p class="text-base font-medium">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($payslip->status === 'paid') 
                                                    bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                @elseif($payslip->status === 'pending') 
                                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                @else 
                                                    bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                @endif">
                                                @if($payslip->status === 'paid')
                                                    Payé
                                                @elseif($payslip->status === 'pending')
                                                    En attente
                                                @else
                                                    {{ ucfirst($payslip->status) }}
                                                @endif
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Référence</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $payslip->reference_number ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Résumé des montants -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Résumé</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Salaire brut</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($payslip->gross_amount, 2, ',', ' ') }} €</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total cotisations</p>
                            <p class="text-xl font-bold text-red-600 dark:text-red-400">- {{ number_format($payslip->total_deductions, 2, ',', ' ') }} €</p>
                        </div>
                        <div class="bg-indigo-50 dark:bg-indigo-900 rounded-lg p-4">
                            <p class="text-sm font-medium text-indigo-700 dark:text-indigo-300">Salaire net</p>
                            <p class="text-xl font-bold text-indigo-700 dark:text-indigo-300">{{ number_format($payslip->net_amount, 2, ',', ' ') }} €</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails des éléments de paie -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Détails des éléments de paie</h3>
                    
                    @if($payrollItems->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 italic">Aucun élément de paie détaillé disponible.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Base</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Taux</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Montant</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($payrollItems as $item)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $item->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                @if($item->type === 'earning')
                                                    <span class="text-green-600 dark:text-green-400">Gain</span>
                                                @elseif($item->type === 'deduction')
                                                    <span class="text-red-600 dark:text-red-400">Déduction</span>
                                                @else
                                                    {{ ucfirst($item->type) }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $item->base_amount ? number_format($item->base_amount, 2, ',', ' ') . ' €' : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $item->rate ? $item->rate . '%' : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium 
                                                @if($item->type === 'earning') 
                                                    text-green-600 dark:text-green-400
                                                @elseif($item->type === 'deduction') 
                                                    text-red-600 dark:text-red-400
                                                @else 
                                                    text-gray-900 dark:text-gray-100
                                                @endif">
                                                @if($item->type === 'deduction')
                                                    - {{ number_format($item->amount, 2, ',', ' ') }} €
                                                @else
                                                    {{ number_format($item->amount, 2, ',', ' ') }} €
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Congés impactant la paie -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Congés impactant la paie</h3>
                    
                    @if($leaves->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 italic">Aucun congé n'a impacté cette période de paie.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Début</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fin</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Durée</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Impact</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($leaves as $leave)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $leave->type }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $leave->duration }} jour(s)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                @if($leave->pivot && $leave->pivot->impact_type)
                                                    @if($leave->pivot->impact_type === 'paid')
                                                        <span class="text-green-600 dark:text-green-400">Congé payé</span>
                                                    @elseif($leave->pivot->impact_type === 'unpaid')
                                                        <span class="text-red-600 dark:text-red-400">Congé sans solde</span>
                                                    @elseif($leave->pivot->impact_type === 'partial')
                                                        <span class="text-yellow-600 dark:text-yellow-400">Partiellement payé ({{ $leave->pivot->impact_rate }}%)</span>
                                                    @else
                                                        {{ ucfirst($leave->pivot->impact_type) }}
                                                    @endif
                                                @else
                                                    Non spécifié
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('payslips.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Retour à la liste') }}
                </a>
                <a href="{{ route('payslips.download', $payslip) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    {{ __('Télécharger le PDF') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
