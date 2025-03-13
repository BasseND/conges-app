<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier le bulletin de paie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Affichage des erreurs de validation -->
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-800 dark:border-red-600 dark:text-red-100" role="alert">
                            <p class="font-bold">{{ __('Erreurs de validation') }}</p>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-800 dark:border-red-600 dark:text-red-100" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.payslips.update', $payslip) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="max-w-xl">
                            <!-- Informations de base -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informations de base</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <x-input-label for="period_month" :value="__('Mois')" />
                                        <select id="period_month" name="period_month" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ old('period_month', $payslip->period_month) == $i ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create(null, $i, 1)->locale('fr_FR')->isoFormat('MMMM') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="period_year" :value="__('Année')" />
                                        <select id="period_year" name="period_year" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                            @foreach (range(date('Y') - 2, date('Y') + 1) as $year)
                                                <option value="{{ $year }}" {{ old('period_year', $payslip->period_year) == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="user_id" :value="__('Employé')" />
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $payslip->user->last_name }} {{ $payslip->user->first_name }} ({{ $payslip->user->employee_id ?? 'ID non défini' }})</p>
                                    <input type="hidden" name="user_id" value="{{ $payslip->user_id }}">
                                </div>
                            </div>

                            <!-- Informations de salaire -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informations de salaire</h3>
                                
                                <div class="mb-4">
                                    <x-input-label for="base_salary" :value="__('Salaire de base')" />
                                    <x-text-input id="base_salary" class="block mt-1 w-full" type="number" name="base_salary" :value="old('base_salary', $payslip->base_salary)" step="0.01" required />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="gross_salary" :value="__('Salaire brut')" />
                                    <x-text-input id="gross_salary" class="block mt-1 w-full" type="number" name="gross_salary" :value="old('gross_salary', $payslip->gross_salary)" step="0.01" required />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="tax_amount" :value="__('Montant des charges sociales')" />
                                    <x-text-input id="tax_amount" class="block mt-1 w-full" type="number" name="tax_amount" :value="old('tax_amount', $payslip->tax_amount)" step="0.01" required />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="bonus_amount" :value="__('Montant des primes')" />
                                    <x-text-input id="bonus_amount" class="block mt-1 w-full" type="number" name="bonus_amount" :value="old('bonus_amount', $payslip->bonus_amount)" step="0.01" required />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="expense_reimbursement" :value="__('Remboursement de frais')" />
                                    <x-text-input id="expense_reimbursement" class="block mt-1 w-full" type="number" name="expense_reimbursement" :value="old('expense_reimbursement', $payslip->expense_reimbursement)" step="0.01" required />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="net_salary" :value="__('Salaire net')" />
                                    <x-text-input id="net_salary" class="block mt-1 w-full" type="number" name="net_salary" :value="old('net_salary', $payslip->net_salary)" step="0.01" required />
                                </div>
                            </div>

                            <!-- Statut -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Statut</h3>
                                
                                <div class="mb-4">
                                    <x-input-label for="status" :value="__('Statut du bulletin')" />
                                    <select id="status" name="status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                        <option value="{{ \App\Models\Payslip::STATUS_DRAFT }}" {{ old('status', $payslip->status) == \App\Models\Payslip::STATUS_DRAFT ? 'selected' : '' }}>Brouillon</option>
                                        <option value="{{ \App\Models\Payslip::STATUS_VALIDATED }}" {{ old('status', $payslip->status) == \App\Models\Payslip::STATUS_VALIDATED ? 'selected' : '' }}>Validé</option>
                                        <option value="{{ \App\Models\Payslip::STATUS_PAID }}" {{ old('status', $payslip->status) == \App\Models\Payslip::STATUS_PAID ? 'selected' : '' }}>Payé</option>
                                    </select>
                                </div>
                                
                                <div id="payment_date_container" class="mb-4 {{ old('status', $payslip->status) == \App\Models\Payslip::STATUS_PAID ? '' : 'hidden' }}">
                                    <x-input-label for="payment_date" :value="__('Date de paiement')" />
                                    <x-text-input id="payment_date" class="block mt-1 w-full" type="date" name="payment_date" :value="old('payment_date', $payslip->payment_date)" />
                                </div>
                            </div>

                            <!-- Commentaires -->
                            <div class="mb-6">
                                <x-input-label for="comments" :value="__('Commentaires')" />
                                <textarea id="comments" name="comments" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('comments', $payslip->comments) }}</textarea>
                            </div>

                            <div class="flex items-center justify-between mt-6">
                                <a href="{{ route('admin.payslips.show', $payslip) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('Annuler') }}
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('Mettre à jour') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calculer automatiquement le salaire net lorsque les autres valeurs changent
            const baseSalaryInput = document.getElementById('base_salary');
            const grossSalaryInput = document.getElementById('gross_salary');
            const taxAmountInput = document.getElementById('tax_amount');
            const bonusAmountInput = document.getElementById('bonus_amount');
            const expenseReimbursementInput = document.getElementById('expense_reimbursement');
            const netSalaryInput = document.getElementById('net_salary');

            function calculateNetSalary() {
                const grossSalary = parseFloat(grossSalaryInput.value) || 0;
                const taxAmount = parseFloat(taxAmountInput.value) || 0;
                const bonusAmount = parseFloat(bonusAmountInput.value) || 0;
                const expenseReimbursement = parseFloat(expenseReimbursementInput.value) || 0;
                
                const netSalary = grossSalary - taxAmount + bonusAmount + expenseReimbursement;
                netSalaryInput.value = netSalary.toFixed(2);
            }

            // Calculer le salaire brut à partir du salaire de base
            baseSalaryInput.addEventListener('input', function() {
                const baseSalary = parseFloat(baseSalaryInput.value) || 0;
                grossSalaryInput.value = baseSalary.toFixed(2);
                calculateNetSalary();
            });

            // Recalculer le salaire net lorsque d'autres valeurs changent
            grossSalaryInput.addEventListener('input', calculateNetSalary);
            taxAmountInput.addEventListener('input', calculateNetSalary);
            bonusAmountInput.addEventListener('input', calculateNetSalary);
            expenseReimbursementInput.addEventListener('input', calculateNetSalary);

            // Gestion de l'affichage du champ de date de paiement en fonction du statut
            const statusSelect = document.getElementById('status');
            const paymentDateContainer = document.getElementById('payment_date_container');
            const paymentDateInput = document.getElementById('payment_date');

            statusSelect.addEventListener('change', function() {
                if (this.value === '{{ \App\Models\Payslip::STATUS_PAID }}') {
                    paymentDateContainer.classList.remove('hidden');
                    paymentDateInput.setAttribute('required', 'required');
                    // Si la date de paiement n'est pas définie, utiliser la date du jour
                    if (!paymentDateInput.value) {
                        const today = new Date();
                        const formattedDate = today.toISOString().split('T')[0];
                        paymentDateInput.value = formattedDate;
                    }
                } else {
                    paymentDateContainer.classList.add('hidden');
                    paymentDateInput.removeAttribute('required');
                }
            });
        });
    </script>
</x-app-layout>
