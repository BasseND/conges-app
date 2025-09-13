<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de paie - {{ $payslip->user->last_name }} {{ $payslip->user->first_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0 0 5px 0;
        }
        .header p {
            margin: 0;
            font-size: 14px;
        }
        .company-info {
            float: left;
            width: 50%;
        }
        .employee-info {
            float: right;
            width: 50%;
            text-align: right;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 14px;
            margin: 0 0 10px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .status {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-draft {
            background-color: #ffeeba;
            color: #856404;
        }
        .status-validated {
            background-color: #b8daff;
            color: #004085;
        }
        .status-paid {
            background-color: #c3e6cb;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BULLETIN DE PAIE</h1>
        <p>Période : {{ \Carbon\Carbon::create(null, $payslip->period_month, 1)->locale('fr_FR')->isoFormat('MMMM YYYY') }}</p>
        
        @if ($payslip->status === 'draft')
            <span class="status status-draft">Brouillon</span>
        @elseif ($payslip->status === 'validated')
            <span class="status status-validated">Validé</span>
        @elseif ($payslip->status === 'paid')
            <span class="status status-paid">Payé</span>
        @endif
    </div>

    <div class="clearfix">
        <div class="company-info">
            <h3>ENTREPRISE</h3>
            <p>Nom de l'entreprise : {{ config('app.name', 'Conges App') }}</p>
            <p>Adresse : 123 Rue de l'Entreprise</p>
            <p>Code postal : 75000 Ville</p>
            <p>SIRET : 123 456 789 00012</p>
        </div>

        <div class="employee-info">
            <h3>EMPLOYÉ</h3>
            <p>{{ $payslip->user->last_name }} {{ $payslip->user->first_name }}</p>
            <p>ID employé : {{ $payslip->user->employee_id ?? 'Non défini' }}</p>
            <p>Poste : {{ $payslip->user->position ?? 'Non défini' }}</p>
            <p>Département : {{ $payslip->user->department->name ?? 'Non défini' }}</p>
            <p>Date d'embauche : {{ $payslip->user->hire_date ? $payslip->user->hire_date->format('d/m/Y') : 'Non définie' }}</p>
        </div>
    </div>

    <div class="section">
        <h2>RÉSUMÉ DU SALAIRE</h2>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Salaire de base</td>
                    <td class="text-right">{{ number_format($payslip->base_salary, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <td>Salaire brut</td>
                    <td class="text-right">{{ number_format($payslip->gross_salary, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <td>Charges sociales</td>
                    <td class="text-right">-{{ number_format($payslip->tax_amount, 2, ',', ' ') }} €</td>
                </tr>
                @if ($payslip->bonus_amount > 0)
                    <tr>
                        <td>Primes</td>
                        <td class="text-right">{{ number_format($payslip->bonus_amount, 2, ',', ' ') }} €</td>
                    </tr>
                @endif
                @if ($payslip->expense_reimbursement > 0)
                    <tr>
                        <td>Remboursement de frais</td>
                        <td class="text-right">{{ number_format($payslip->expense_reimbursement, 2, ',', ' ') }} €</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td>Salaire net</td>
                    <td class="text-right">{{ number_format($payslip->net_salary, 2, ',', ' ') }} €</td>
                </tr>
            </tbody>
        </table>
    </div>

    @if ($payslip->items && $payslip->items->count() > 0)
        <div class="section">
            <h2>DÉTAILS DES ÉLÉMENTS DE PAIE</h2>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Type</th>
                        <th class="text-right">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payslip->items as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td>
                                @if ($item->type === 'earning')
                                    Gain
                                @elseif ($item->type === 'deduction')
                                    Déduction
                                @elseif ($item->type === 'tax')
                                    Taxe
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($item->type === 'earning')
                                    {{ number_format($item->amount, 2, ',', ' ') }} €
                                @else
                                    -{{ number_format($item->amount, 2, ',', ' ') }} €
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($leaves && $leaves->count() > 0)
        <div class="section">
            <h2>CONGÉS PRIS DURANT LA PÉRIODE</h2>
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th class="text-right">Nombre de jours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr>
                            <td>
                                {{ $leave->specialLeaveType ? $leave->specialLeaveType->name : 'Congé' }}
                            </td>
                            <td>{{ $leave->start_date->format('d/m/Y') }}</td>
                            <td>{{ $leave->end_date->format('d/m/Y') }}</td>
                            <td class="text-right">{{ $leave->days_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($expenseReports && $expenseReports->count() > 0)
        <div class="section">
            <h2>NOTES DE FRAIS REMBOURSÉES</h2>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Date d'approbation</th>
                        <th class="text-right">Montant remboursé</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenseReports as $expenseReport)
                        <tr>
                            <td>{{ $expenseReport->description }}</td>
                            <td>{{ $expenseReport->approved_at ? $expenseReport->approved_at->format('d/m/Y') : 'N/A' }}</td>
                            <td class="text-right">{{ number_format($expenseReport->pivot->reimbursed_amount, 2, ',', ' ') }} €</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2" class="text-right">Total des remboursements</td>
                        <td class="text-right">{{ number_format($payslip->expense_reimbursement, 2, ',', ' ') }} €</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    @if ($payslip->comments)
        <div class="section">
            <h2>COMMENTAIRES</h2>
            <p>{{ $payslip->comments }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Ce bulletin de paie a été généré le {{ $payslip->generated_at->format('d/m/Y') }}.</p>
        @if ($payslip->payment_date)
            <p>Date de paiement : {{ $payslip->payment_date->format('d/m/Y') }}</p>
        @endif
        <p>Document à conserver sans limitation de durée.</p>
    </div>
</body>
</html>
