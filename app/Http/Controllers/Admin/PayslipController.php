<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use App\Models\PayrollSetting;
use App\Models\User;
use App\Models\Contract;
use App\Models\Leave;
use App\Models\SalaryAdvance;
use App\Models\ExpenseReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class PayslipController extends Controller
{
    /**
     * Affiche la liste des bulletins de paie générés.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Payslip::class);
        
        $query = Payslip::with('user');
        
        // Filtrer par mois
        if ($request->filled('month')) {
            $query->where('period_month', $request->month);
        }
        
        // Filtrer par année
        if ($request->filled('year')) {
            $query->where('period_year', $request->year);
        }
        
        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $payslips = $query->orderBy('period_year', 'desc')
            ->orderBy('period_month', 'desc')
            ->paginate(15)
            ->withQueryString();
        
        return view('admin.payslips.index', compact('payslips'));
    }

    /**
     * Affiche le formulaire de génération de bulletins de paie.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Payslip::class);
        
        $users = User::where('is_active', true)->orderBy('last_name')->get();
        $months = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create(null, $i, 1)->locale('fr_FR')->isoFormat('MMMM');
        }
        
        $currentYear = Carbon::now()->year;
        $years = range($currentYear - 2, $currentYear + 1);
        
        return view('admin.payslips.create', compact('users', 'months', 'years'));
    }

    /**
     * Génère les bulletins de paie pour les utilisateurs sélectionnés.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Payslip::class);
        
        $validated = $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
        ], [
            'users.required' => 'Veuillez sélectionner au moins un employé.',
            'users.array' => 'La sélection des employés est invalide.',
            'users.*.exists' => 'Un des employés sélectionnés n\'existe pas.',
            'month.required' => 'Le mois est obligatoire.',
            'month.integer' => 'Le mois doit être un nombre entier.',
            'month.min' => 'Le mois doit être compris entre 1 et 12.',
            'month.max' => 'Le mois doit être compris entre 1 et 12.',
            'year.required' => 'L\'année est obligatoire.',
            'year.integer' => 'L\'année doit être un nombre entier.',
            'year.min' => 'L\'année doit être supérieure ou égale à 2000.',
            'year.max' => 'L\'année doit être inférieure ou égale à 2100.',
        ]);
        
        $month = $validated['month'];
        $year = $validated['year'];
        $userIds = $validated['users'];
        
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        
        $generatedCount = 0;
        $skippedCount = 0;
        
        foreach ($userIds as $userId) {
            $user = User::findOrFail($userId);
            
            // Vérifier si un bulletin existe déjà pour cet utilisateur et cette période
            $existingPayslip = Payslip::where('user_id', $userId)
                ->where('period_month', $month)
                ->where('period_year', $year)
                ->first();
            
            if ($existingPayslip) {
                $skippedCount++;
                continue;
            }
            
            // Récupérer le contrat actif de l'utilisateur
            $contract = Contract::where('user_id', $userId)
                ->where('date_debut', '<=', $endDate)
                ->where(function ($query) use ($startDate) {
                    $query->where('date_fin', '>=', $startDate)
                        ->orWhereNull('date_fin');
                })
                ->first();
            
            if (!$contract) {
                $skippedCount++;
                continue;
            }
            
            // Calculer le salaire brut et net
            $baseSalary = $contract->salaire_brut;
            $grossSalary = $this->calculateGrossSalary($user, $baseSalary, $month, $year);
            $taxAmount = $this->calculateTaxes($user, $grossSalary);
            $netSalary = $grossSalary - $taxAmount;
            
            // Créer le bulletin de paie
            $payslip = new Payslip([
                'user_id' => $userId,
                'contract_id' => $contract->id,
                'period_month' => $month,
                'period_year' => $year,
                'base_salary' => $baseSalary,
                'gross_salary' => $grossSalary,
                'net_salary' => $netSalary,
                'tax_amount' => $taxAmount,
                'bonus_amount' => 0, // À calculer
                'expense_reimbursement' => 0, // À calculer
                'status' => Payslip::STATUS_DRAFT,
                'generated_at' => now(),
            ]);
            
            $payslip->save();
            
            // Ajouter les éléments de paie
            $this->addPayrollItems($payslip);
            
            // Associer les congés du mois
            $this->attachLeaves($payslip);
            
            // Associer les notes de frais
            $this->attachExpenseReports($payslip);
            
            $generatedCount++;
        }
        
        if ($generatedCount > 0) {
            $message = $generatedCount . ' bulletin(s) de paie généré(s) avec succès.';
            if ($skippedCount > 0) {
                $message .= ' ' . $skippedCount . ' bulletin(s) ignoré(s) (déjà existant ou pas de contrat actif).';
            }
            return redirect()->route('admin.payslips.index')->with('success', $message);
        } else {
            return redirect()->route('admin.payslips.create')->with('error', 'Aucun bulletin de paie n\'a pu être généré. Veuillez vérifier que les employés sélectionnés ont des contrats actifs pour la période choisie.');
        }
    }

    /**
     * Affiche les détails d'un bulletin de paie.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\View\View
     */
    public function show(Payslip $payslip)
    {
        $this->authorize('view', $payslip);
        
        $payrollItems = $payslip->items;
        $leaves = $payslip->leaves;
        $expenseReports = $payslip->expenseReports;
        
        return view('admin.payslips.show', compact('payslip', 'payrollItems', 'leaves', 'expenseReports'));
    }

    /**
     * Affiche le formulaire d'édition d'un bulletin de paie.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\View\View
     */
    public function edit(Payslip $payslip)
    {
        $this->authorize('update', $payslip);
        
        $payrollItems = $payslip->items;
        $leaves = $payslip->leaves;
        $expenseReports = $payslip->expenseReports;
        
        return view('admin.payslips.edit', compact('payslip', 'payrollItems', 'leaves', 'expenseReports'));
    }

    /**
     * Met à jour un bulletin de paie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Payslip $payslip)
    {
        $this->authorize('update', $payslip);
        
        $validated = $request->validate([
            'gross_salary' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'bonus_amount' => 'required|numeric|min:0',
            'expense_reimbursement' => 'required|numeric|min:0',
            'status' => 'required|in:' . implode(',', [Payslip::STATUS_DRAFT, Payslip::STATUS_VALIDATED, Payslip::STATUS_PAID]),
            'payment_date' => 'nullable|date',
        ], [
            'gross_salary.required' => 'Le salaire brut est obligatoire.',
            'gross_salary.numeric' => 'Le salaire brut doit être un nombre.',
            'gross_salary.min' => 'Le salaire brut doit être positif ou nul.',
            'tax_amount.required' => 'Le montant des charges est obligatoire.',
            'tax_amount.numeric' => 'Le montant des charges doit être un nombre.',
            'tax_amount.min' => 'Le montant des charges doit être positif ou nul.',
            'bonus_amount.required' => 'Le montant des primes est obligatoire.',
            'bonus_amount.numeric' => 'Le montant des primes doit être un nombre.',
            'bonus_amount.min' => 'Le montant des primes doit être positif ou nul.',
            'expense_reimbursement.required' => 'Le montant des remboursements de frais est obligatoire.',
            'expense_reimbursement.numeric' => 'Le montant des remboursements de frais doit être un nombre.',
            'expense_reimbursement.min' => 'Le montant des remboursements de frais doit être positif ou nul.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut doit être valide.',
            'payment_date.date' => 'La date de paiement doit être une date valide.',
        ]);
        
        // Calculer le salaire net
        $netSalary = $validated['gross_salary'] - $validated['tax_amount'] + $validated['bonus_amount'] + $validated['expense_reimbursement'];
        
        $payslip->gross_salary = $validated['gross_salary'];
        $payslip->tax_amount = $validated['tax_amount'];
        $payslip->net_salary = $netSalary;
        $payslip->bonus_amount = $validated['bonus_amount'];
        $payslip->expense_reimbursement = $validated['expense_reimbursement'];
        $payslip->status = $validated['status'];
        
        if ($validated['status'] === Payslip::STATUS_PAID && isset($validated['payment_date'])) {
            $payslip->payment_date = $validated['payment_date'];
        }
        
        $payslip->save();
        
        return redirect()->route('admin.payslips.show', $payslip)
            ->with('success', 'Le bulletin de paie a été mis à jour avec succès.');
    }

    /**
     * Valide un bulletin de paie.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validatePayslip(Payslip $payslip)
    {
        $this->authorize('update', $payslip);
        
        if ($payslip->status !== Payslip::STATUS_DRAFT) {
            return back()->with('error', 'Seuls les bulletins en brouillon peuvent être validés.');
        }
        
        $payslip->status = Payslip::STATUS_VALIDATED;
        $payslip->save();
        
        return redirect()->route('admin.payslips.show', $payslip)->with('success', 'Le bulletin de paie a été validé avec succès.');
    }

    /**
     * Marque un bulletin de paie comme payé.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsPaid(Request $request, Payslip $payslip)
    {
        $this->authorize('update', $payslip);
        
        if ($payslip->status !== Payslip::STATUS_VALIDATED) {
            return back()->with('error', 'Seuls les bulletins validés peuvent être marqués comme payés.');
        }
        
        $validated = $request->validate([
            'payment_date' => 'required|date',
        ], [
            'payment_date.required' => 'La date de paiement est obligatoire.',
            'payment_date.date' => 'La date de paiement doit être une date valide.',
        ]);
        
        $payslip->status = Payslip::STATUS_PAID;
        $payslip->payment_date = $validated['payment_date'];
        $payslip->save();
        
        return redirect()->route('admin.payslips.show', $payslip)
            ->with('success', 'Le bulletin de paie a été marqué comme payé avec succès.');
    }

    /**
     * Génère un PDF du bulletin de paie.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generatePdf(Payslip $payslip)
    {
        $this->authorize('view', $payslip);
        
        $payrollItems = $payslip->items;
        $leaves = $payslip->leaves;
        $expenseReports = $payslip->expenseReports;
        
        $pdf = PDF::loadView('admin.payslips.pdf', compact('payslip', 'payrollItems', 'leaves', 'expenseReports'));
        
        // Définir le nom du fichier
        $filename = 'bulletin_' . $payslip->user->last_name . '_' . 
                    Carbon::create(null, $payslip->period_month, 1)->locale('fr_FR')->isoFormat('MMMM') . 
                    '_' . $payslip->period_year . '.pdf';
        
        // Retourner le PDF comme téléchargement
        return $pdf->download($filename);
    }

    /**
     * Calcule le salaire brut en incluant les primes et autres éléments.
     *
     * @param  \App\Models\User  $user
     * @param  float  $baseSalary
     * @param  int  $month
     * @param  int  $year
     * @return float
     */
    private function calculateGrossSalary(User $user, float $baseSalary, int $month, int $year): float
    {
        // Pour l'instant, on retourne simplement le salaire de base
        // À améliorer ultérieurement pour inclure les primes, etc.
        return $baseSalary;
    }

    /**
     * Calcule les taxes et charges sociales.
     *
     * @param  \App\Models\User  $user
     * @param  float  $grossSalary
     * @return float
     */
    private function calculateTaxes(User $user, float $grossSalary): float
    {
        // Récupérer les paramètres de paie pour les taxes
        $taxSettings = PayrollSetting::where('type', 'tax')
            ->where('is_active', true)
            ->where('applies_to', 'all')
            ->get();
        
        $taxAmount = 0;
        
        foreach ($taxSettings as $tax) {
            if ($tax->is_percentage) {
                $taxAmount += $grossSalary * ($tax->value / 100);
            } else {
                $taxAmount += $tax->value;
            }
        }
        
        // Si aucun paramètre de taxe n'est défini, on applique un taux par défaut de 23%
        if ($taxAmount === 0) {
            $taxAmount = $grossSalary * 0.23;
        }
        
        return $taxAmount;
    }

    /**
     * Ajoute des éléments de paie au bulletin.
     *
     * @param  \App\Models\Payslip  $payslip
     * @param  array  $items
     * @return void
     */
    protected function addPayrollItems(Payslip $payslip, $items = [])
    {
        // Supprimer les éléments existants si nécessaire
        if ($payslip->items()->exists()) {
            $payslip->items()->delete();
        }
        
        // Si aucun élément n'est fourni, ajouter les éléments par défaut
        if (empty($items)) {
            try {
                // Ajouter le salaire de base
                $payslip->items()->create([
                    'description' => 'Salaire de base',
                    'type' => 'bonus', // Utiliser une constante définie dans PayrollItem
                    'amount' => $payslip->base_salary,
                    'is_taxable' => true,
                    'label' => 'Salaire de base' // Ajouter le label qui est obligatoire
                ]);
                
                // Ajouter les charges sociales
                $payslip->items()->create([
                    'description' => 'Charges sociales',
                    'type' => 'deduction', // Utiliser une constante définie dans PayrollItem
                    'amount' => $payslip->tax_amount,
                    'is_taxable' => false,
                    'label' => 'Charges sociales' // Ajouter le label qui est obligatoire
                ]);
                
                // Ajouter les primes si présentes
                if ($payslip->bonus_amount > 0) {
                    $payslip->items()->create([
                        'description' => 'Prime',
                        'type' => 'bonus', // Utiliser une constante définie dans PayrollItem
                        'amount' => $payslip->bonus_amount,
                        'is_taxable' => true,
                        'label' => 'Prime' // Ajouter le label qui est obligatoire
                    ]);
                }
                
                // Ajouter les remboursements de frais si présents
                if ($payslip->expense_reimbursement > 0) {
                    $payslip->items()->create([
                        'description' => 'Remboursement de frais',
                        'type' => 'benefit', // Utiliser une constante définie dans PayrollItem
                        'amount' => $payslip->expense_reimbursement,
                        'is_taxable' => false,
                        'label' => 'Remboursement de frais' // Ajouter le label qui est obligatoire
                    ]);
                }
            } catch (\Exception $e) {
                // Enregistrer l'erreur pour le débogage
                \Log::error('Erreur lors de l\'ajout des éléments de paie: ' . $e->getMessage());
                throw $e;
            }
        } else {
            // Ajouter les éléments fournis
            foreach ($items as $item) {
                try {
                    // S'assurer que tous les champs requis sont présents
                    if (!isset($item['label'])) {
                        $item['label'] = $item['description'] ?? 'Élément de paie';
                    }
                    
                    $payslip->items()->create($item);
                } catch (\Exception $e) {
                    // Enregistrer l'erreur pour le débogage
                    \Log::error('Erreur lors de l\'ajout d\'un élément de paie: ' . $e->getMessage());
                    throw $e;
                }
            }
        }
    }

    /**
     * Attache les congés pris pendant la période au bulletin de paie.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return void
     */
    protected function attachLeaves(Payslip $payslip)
    {
        // Détacher les congés existants si nécessaire
        $payslip->leaves()->detach();
        
        // Définir la période du bulletin (du premier au dernier jour du mois)
        $startOfMonth = Carbon::create($payslip->period_year, $payslip->period_month, 1)->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth()->endOfDay();
        
        // Récupérer tous les congés de l'utilisateur qui chevauchent la période
        $leaves = Leave::where('user_id', $payslip->user_id)
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                    ->orWhere(function ($q) use ($startOfMonth, $endOfMonth) {
                        $q->where('start_date', '<', $startOfMonth)
                          ->where('end_date', '>', $endOfMonth);
                    });
            })
            ->where('status', 'approved')
            ->get();
        
        // Attacher les congés au bulletin
        foreach ($leaves as $leave) {
            $payslip->leaves()->attach($leave->id);
        }
    }

    /**
     * Attache les notes de frais approuvées au bulletin de paie.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return void
     */
    protected function attachExpenseReports(Payslip $payslip)
    {
        try {
            // Détacher les notes de frais existantes si nécessaire
            $payslip->expenseReports()->detach();
            
            // Définir la période du bulletin (du premier au dernier jour du mois)
            $startOfMonth = Carbon::create($payslip->period_year, $payslip->period_month, 1)->startOfDay();
            $endOfMonth = $startOfMonth->copy()->endOfMonth()->endOfDay();
            
            // Récupérer toutes les notes de frais approuvées mais non payées de l'utilisateur
            $expenseReports = ExpenseReport::where('user_id', $payslip->user_id)
                ->where('status', ExpenseReport::STATUS_APPROVED)
                ->where('approved_at', '<=', $endOfMonth)
                ->whereDoesntHave('payslips')
                ->get();
            
            // Montant total des remboursements
            $totalReimbursement = 0;
            
            // Attacher les notes de frais au bulletin
            foreach ($expenseReports as $expenseReport) {
                $payslip->expenseReports()->attach($expenseReport->id, [
                    'reimbursed_amount' => $expenseReport->total_amount
                ]);
                
                // Mettre à jour le statut de la note de frais
                $expenseReport->update([
                    'status' => ExpenseReport::STATUS_PAID
                ]);
                
                // Ajouter au total
                $totalReimbursement += $expenseReport->total_amount;
            }
            
            // Mettre à jour le montant total des remboursements dans le bulletin
            $payslip->expense_reimbursement = $totalReimbursement;
            $payslip->save();
            
            // Recalculer le salaire net
            $payslip->net_salary = $payslip->gross_salary - $payslip->tax_amount + $payslip->bonus_amount + $payslip->expense_reimbursement;
            $payslip->save();
            
            // Mettre à jour les éléments de paie
            $this->addPayrollItems($payslip);
            
        } catch (\Exception $e) {
            // Enregistrer l'erreur pour le débogage
            \Log::error('Erreur lors de l\'attachement des notes de frais: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Affiche le formulaire pour la validation en masse des bulletins de paie.
     *
     * @return \Illuminate\View\View
     */
    public function batchValidateForm()
    {
        // Récupérer les années et mois disponibles pour les bulletins en brouillon
        $availablePeriods = Payslip::where('status', Payslip::STATUS_DRAFT)
            ->select(DB::raw('DISTINCT period_year, period_month'))
            ->orderBy('period_year', 'desc')
            ->orderBy('period_month', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'year' => $item->period_year,
                    'month' => $item->period_month,
                    'label' => Carbon::create($item->period_year, $item->period_month, 1)->locale('fr_FR')->isoFormat('MMMM YYYY')
                ];
            });

        return view('admin.payslips.batch-validate', compact('availablePeriods'));
    }

    /**
     * Valide en masse les bulletins de paie pour une période donnée.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function batchValidate(Request $request)
    {
        $validated = $request->validate([
            'period_year' => 'required|integer|min:2000|max:2100',
            'period_month' => 'required|integer|min:1|max:12',
        ], [
            'period_year.required' => 'L\'année est obligatoire.',
            'period_year.integer' => 'L\'année doit être un nombre entier.',
            'period_year.min' => 'L\'année doit être supérieure ou égale à 2000.',
            'period_year.max' => 'L\'année doit être inférieure ou égale à 2100.',
            'period_month.required' => 'Le mois est obligatoire.',
            'period_month.integer' => 'Le mois doit être un nombre entier.',
            'period_month.min' => 'Le mois doit être compris entre 1 et 12.',
            'period_month.max' => 'Le mois doit être compris entre 1 et 12.',
        ]);

        try {
            // Récupérer tous les bulletins en brouillon pour la période spécifiée
            $payslips = Payslip::where('status', Payslip::STATUS_DRAFT)
                ->where('period_year', $validated['period_year'])
                ->where('period_month', $validated['period_month'])
                ->get();

            if ($payslips->isEmpty()) {
                return redirect()->route('admin.payslips.batchValidateForm')
                    ->with('error', 'Aucun bulletin en brouillon trouvé pour cette période.');
            }

            // Valider chaque bulletin
            $validatedCount = 0;
            foreach ($payslips as $payslip) {
                $payslip->status = Payslip::STATUS_VALIDATED;
                $payslip->save();
                $validatedCount++;
            }

            return redirect()->route('admin.payslips.index')
                ->with('success', "{$validatedCount} bulletins de paie ont été validés avec succès pour " . Carbon::create($validated['period_year'], $validated['period_month'], 1)->locale('fr_FR')->isoFormat('MMMM YYYY') . ".");
        } catch (\Exception $e) {
            return redirect()->route('admin.payslips.batchValidateForm')
                ->with('error', 'Une erreur est survenue lors de la validation des bulletins : ' . $e->getMessage());
        }
    }

    /**
     * Affiche le formulaire pour la génération en masse de PDF des bulletins de paie.
     *
     * @return \Illuminate\View\View
     */
    public function batchPdfForm()
    {
        // Récupérer les années et mois disponibles pour les bulletins validés ou payés
        $availablePeriods = Payslip::whereIn('status', [Payslip::STATUS_VALIDATED, Payslip::STATUS_PAID])
            ->select(DB::raw('DISTINCT period_year, period_month'))
            ->orderBy('period_year', 'desc')
            ->orderBy('period_month', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'year' => $item->period_year,
                    'month' => $item->period_month,
                    'label' => Carbon::create($item->period_year, $item->period_month, 1)->locale('fr_FR')->isoFormat('MMMM YYYY')
                ];
            });

        return view('admin.payslips.batch-pdf', compact('availablePeriods'));
    }

    /**
     * Génère en masse les PDF des bulletins de paie pour une période donnée.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function batchPdf(Request $request)
    {
        $validated = $request->validate([
            'period_year' => 'required|integer|min:2000|max:2100',
            'period_month' => 'required|integer|min:1|max:12',
        ], [
            'period_year.required' => 'L\'année est obligatoire.',
            'period_year.integer' => 'L\'année doit être un nombre entier.',
            'period_year.min' => 'L\'année doit être supérieure ou égale à 2000.',
            'period_year.max' => 'L\'année doit être inférieure ou égale à 2100.',
            'period_month.required' => 'Le mois est obligatoire.',
            'period_month.integer' => 'Le mois doit être un nombre entier.',
            'period_month.min' => 'Le mois doit être compris entre 1 et 12.',
            'period_month.max' => 'Le mois doit être compris entre 1 et 12.',
        ]);

        try {
            // Récupérer tous les bulletins validés ou payés pour la période spécifiée
            $payslips = Payslip::whereIn('status', [Payslip::STATUS_VALIDATED, Payslip::STATUS_PAID])
                ->where('period_year', $validated['period_year'])
                ->where('period_month', $validated['period_month'])
                ->with(['user', 'items', 'leaves', 'expenseReports'])
                ->get();

            if ($payslips->isEmpty()) {
                return redirect()->route('admin.payslips.batchPdfForm')
                    ->with('error', 'Aucun bulletin validé ou payé trouvé pour cette période.');
            }

            // Créer un dossier temporaire pour stocker les PDF individuels
            $tempDir = storage_path('app/temp/payslips/' . uniqid());
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Générer un PDF pour chaque bulletin et les stocker dans le dossier temporaire
            $files = [];
            foreach ($payslips as $payslip) {
                $payrollItems = $payslip->items;
                $leaves = $payslip->leaves;
                $expenseReports = $payslip->expenseReports;
                
                $pdf = PDF::loadView('admin.payslips.pdf', compact('payslip', 'payrollItems', 'leaves', 'expenseReports'));
                
                $filename = 'bulletin_' . $payslip->user->last_name . '_' . 
                            $payslip->user->first_name . '_' . 
                            Carbon::create($payslip->period_year, $payslip->period_month, 1)->format('Y_m') . '.pdf';
                
                $filePath = $tempDir . '/' . $filename;
                $pdf->save($filePath);
                $files[] = $filePath;
            }

            // Créer un fichier ZIP contenant tous les PDF
            $zipFileName = 'bulletins_' . Carbon::create($validated['period_year'], $validated['period_month'], 1)->format('Y_m') . '.zip';
            $zipFilePath = storage_path('app/temp/' . $zipFileName);
            
            $zip = new \ZipArchive();
            if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                foreach ($files as $file) {
                    $zip->addFile($file, basename($file));
                }
                $zip->close();
            }

            // Supprimer les fichiers PDF individuels
            foreach ($files as $file) {
                unlink($file);
            }
            rmdir($tempDir);

            // Télécharger le fichier ZIP
            return response()->download($zipFilePath, $zipFileName, [
                'Content-Type' => 'application/zip',
            ])->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return redirect()->route('admin.payslips.batchPdfForm')
                ->with('error', 'Une erreur est survenue lors de la génération des PDF : ' . $e->getMessage());
        }
    }
}
