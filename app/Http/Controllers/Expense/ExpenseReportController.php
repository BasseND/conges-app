<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\ExpenseReport;
use App\Models\ExpenseLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\ExpenseReportCreated;
use App\Events\ExpenseReportStatusUpdated;

class ExpenseReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Initialiser la requête
        $query = ExpenseReport::query();

        // Si l'utilisateur n'est ni admin ni RH, ne montrer que ses propres notes de frais
        if (!$user->isAdmin() && !$user->isHR()) {
            $query->where('user_id', $user->id);
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtre par date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Ajouter les relations nécessaires
        $query->with(['user', 'lines']);

        $expenseReports = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // Garde les paramètres de filtrage dans les liens de pagination

        return view('expenses.reports.index', compact('expenseReports'));
    }

    public function create()
    {
        return view('expenses.reports.create');
    }

    public function store(Request $request)
    {
        \Log::info('Début de la création de la note de frais');
        \Log::info('Données reçues:', $request->all());

        try {
            $validated = $request->validate([
                'description' => 'required|string|max:1000',
                'action' => 'required|in:draft,submit',
                'lines' => 'required|array|min:1',
                'lines.*.description' => 'required|string|max:255',
                'lines.*.amount' => 'required|numeric|min:0',
                'lines.*.spent_on' => 'required|date',
                'lines.*.receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
            ]);

            \Log::info('Validation passée avec succès');

            DB::beginTransaction();
            \Log::info('Transaction démarrée');

            // Créer la note de frais
            $reportData = [
                'user_id' => Auth::id(),
                'description' => $request->description,
                'status' => $request->action === 'submit' ? 'submitted' : 'draft',
                'submitted_at' => $request->action === 'submit' ? now() : null,
            ];
            \Log::info('Données de la note de frais:', $reportData);

            $report = ExpenseReport::create($reportData);
            \Log::info('Note de frais créée avec ID: ' . $report->id);

            // Créer les lignes de frais
            $totalAmount = 0;
            foreach ($request->lines as $index => $line) {
                \Log::info('Traitement de la ligne ' . $index, $line);
                
                $receiptPath = null;
                if (isset($line['receipt'])) {
                    \Log::info('Fichier présent pour la ligne ' . $index);
                    if ($line['receipt']->isValid()) {
                        try {
                            $receiptPath = Storage::disk('public')->putFile(
                                'receipts/' . $report->id,
                                $line['receipt']
                            );
                            \Log::info('Fichier enregistré: ' . $receiptPath);
                        } catch (\Exception $e) {
                            \Log::error('Erreur lors de l\'enregistrement du fichier: ' . $e->getMessage());
                            throw $e;
                        }
                    } else {
                        \Log::warning('Fichier invalide pour la ligne ' . $index);
                    }
                }

                $lineData = [
                    'expense_report_id' => $report->id,
                    'description' => $line['description'],
                    'amount' => $line['amount'],
                    'spent_on' => $line['spent_on'],
                    'receipt_path' => $receiptPath
                ];
                \Log::info('Données de la ligne de frais:', $lineData);

                $expenseLine = ExpenseLine::create($lineData);
                \Log::info('Ligne de frais créée avec ID: ' . $expenseLine->id);

                $totalAmount += $line['amount'];
            }

            // Mettre à jour le montant total
            \Log::info('Mise à jour du montant total: ' . $totalAmount);
            $report->update(['total_amount' => $totalAmount]);

            DB::commit();
            \Log::info('Transaction validée avec succès');
            
            // Déclencher l'événement de création de note de frais
            event(new ExpenseReportCreated($report));

            return redirect()->route('expense-reports.index')
                           ->with('success', 'Note de frais ' . ($request->action === 'submit' ? 'soumise' : 'enregistrée') . ' avec succès');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erreur de validation: ' . json_encode($e->errors()));
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la création de la note de frais: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->withInput()
                        ->withErrors(['error' => 'Une erreur est survenue lors de la création de la note de frais: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $query = ExpenseReport::query();

        // Si l'utilisateur n'est ni admin ni RH, ne montrer que ses propres notes de frais
        if (!$user->isAdmin() && !$user->isHR()) {
            $query->where('user_id', $user->id);
        }

        $report = $query->with(['user', 'lines'])->findOrFail($id);
        return view('expenses.reports.show', compact('report'));
    }

    public function edit($id)
    {
        $report = ExpenseReport::where('user_id', Auth::id())->findOrFail($id);
        return view('expenses.reports.edit', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = ExpenseReport::where('user_id', Auth::id())->findOrFail($id);

        // Vérifier que la note n'est pas déjà soumise
        if ($report->status !== 'draft') {
            return back()->withErrors(['error' => 'Seules les notes de frais en brouillon peuvent être modifiées.']);
        }

        \Log::info('Début de la mise à jour de la note de frais #' . $id);
        \Log::info('Données reçues:', $request->all());

        try {
            $validated = $request->validate([
                'description' => 'required|string|max:1000',
                'action' => 'required|in:draft,submit',
                'lines' => 'required|array|min:1',
                'lines.*.id' => 'nullable|exists:expense_lines,id',
                'lines.*.description' => 'required|string|max:255',
                'lines.*.amount' => 'required|numeric|min:0',
                'lines.*.spent_on' => 'required|date',
                'lines.*.receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
            ]);

            \Log::info('Validation passée avec succès');

            DB::beginTransaction();

            // Mise à jour de la note de frais
            $report->update([
                'description' => $request->description,
                'status' => $request->action === 'submit' ? 'submitted' : 'draft',
                'submitted_at' => $request->action === 'submit' ? now() : null,
            ]);

            \Log::info('Note de frais mise à jour');

            // Récupérer les IDs des lignes existantes
            $existingLineIds = $report->lines->pluck('id')->toArray();
            $updatedLineIds = [];
            $totalAmount = 0;

            // Traiter chaque ligne
            foreach ($request->lines as $index => $lineData) {
                \Log::info('Traitement de la ligne ' . $index, $lineData);

                // Gérer le justificatif
                $receiptPath = null;
                if (isset($lineData['id'])) {
                    // Ligne existante
                    $line = ExpenseLine::find($lineData['id']);
                    $receiptPath = $line->receipt_path; // Garder l'ancien chemin par défaut
                }

                if (isset($lineData['receipt']) && $lineData['receipt']->isValid()) {
                    // Nouveau fichier uploadé
                    try {
                        $receiptPath = Storage::disk('public')->putFile(
                            'receipts/' . $report->id,
                            $lineData['receipt']
                        );
                        \Log::info('Nouveau fichier enregistré: ' . $receiptPath);
                    } catch (\Exception $e) {
                        \Log::error('Erreur lors de l\'enregistrement du fichier: ' . $e->getMessage());
                        throw $e;
                    }
                }

                // Créer ou mettre à jour la ligne
                if (isset($lineData['id'])) {
                    // Mise à jour d'une ligne existante
                    $line->update([
                        'description' => $lineData['description'],
                        'amount' => $lineData['amount'],
                        'spent_on' => $lineData['spent_on'],
                        'receipt_path' => $receiptPath
                    ]);
                    $updatedLineIds[] = $line->id;
                    \Log::info('Ligne existante mise à jour: ' . $line->id);
                } else {
                    // Création d'une nouvelle ligne
                    $line = ExpenseLine::create([
                        'expense_report_id' => $report->id,
                        'description' => $lineData['description'],
                        'amount' => $lineData['amount'],
                        'spent_on' => $lineData['spent_on'],
                        'receipt_path' => $receiptPath
                    ]);
                    $updatedLineIds[] = $line->id;
                    \Log::info('Nouvelle ligne créée: ' . $line->id);
                }

                $totalAmount += $lineData['amount'];
            }

            // Supprimer les lignes qui n'existent plus
            $linesToDelete = array_diff($existingLineIds, $updatedLineIds);
            if (!empty($linesToDelete)) {
                \Log::info('Suppression des lignes: ' . implode(', ', $linesToDelete));
                ExpenseLine::whereIn('id', $linesToDelete)->delete();
            }

            // Mettre à jour le montant total
            \Log::info('Mise à jour du montant total: ' . $totalAmount);
            $report->update(['total_amount' => $totalAmount]);

            DB::commit();
            \Log::info('Transaction validée avec succès');

            return redirect()->route('expense-reports.index')
                           ->with('success', 'Note de frais ' . ($request->action === 'submit' ? 'soumise' : 'mise à jour') . ' avec succès');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erreur de validation: ' . json_encode($e->errors()));
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la mise à jour de la note de frais: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->withInput()
                        ->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour de la note de frais: ' . $e->getMessage()]);
        }
    }

    // Soumettre la note de frais
    public function submit($id)
    {
        $report = ExpenseReport::where('user_id', Auth::id())->findOrFail($id);

        $oldStatus = $report->status;
        
        $report->update([
            'status' => 'submitted',
            'submitted_at' => now()
        ]);
        
        // Déclencher l'événement de mise à jour du statut
        event(new ExpenseReportStatusUpdated($report, $oldStatus, 'submitted'));

        return redirect()->route('expense-reports.show', $report)
                         ->with('success', 'Note de frais soumise');
    }

    // Approuver la note de frais (pour un manager/admin)
    public function approve(ExpenseReport $expense_report)
    {
        // Seuls les managers/admins peuvent approuver
        if (!auth()->user()->canApproveExpenseReports()) {
            abort(403, 'Vous n\'avez pas l\'autorisation d\'approuver les notes de frais.');
        }

        $oldStatus = $expense_report->status;
        
        $expense_report->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);
        
        // Déclencher l'événement de mise à jour du statut
        event(new ExpenseReportStatusUpdated($expense_report, $oldStatus, 'approved'));

        return redirect()->route('expense-reports.show', $expense_report)
                         ->with('success', 'Note de frais approuvée');
    }

    // Rejeter la note de frais
    public function reject($id)
    {
        $report = ExpenseReport::findOrFail($id);

        $oldStatus = $report->status;
        
        $report->update([
            'status' => 'rejected'
        ]);
        
        // Déclencher l'événement de mise à jour du statut
        event(new ExpenseReportStatusUpdated($report, $oldStatus, 'rejected'));

        return redirect()->route('expense-reports.show', $report)
                         ->with('error', 'Note de frais rejetée');
    }

    // Payeer la note de frais
    public function pay($id)
    {
        // Seuls les RH et Administrateurs peuvent payer la note de frais
        if (!auth()->user()->canPayExpenseReports()) {
            abort(403, 'Vous n\'avez pas l\'autorisation de payer les notes de frais.');
        }

        $report = ExpenseReport::where('user_id', Auth::id())->findOrFail($id);

        $oldStatus = $report->status;
        
        $report->update([
            'status' => 'paid',
            'paid_at' => now()
        ]);
        
        // Déclencher l'événement de mise à jour du statut
        event(new ExpenseReportStatusUpdated($report, $oldStatus, 'paid'));

        return redirect()->route('expense-reports.show', $report)
                         ->with('success', 'Note de frais payée');
    }

    // Supprimer la note de frais
    public function destroy($id)
    {
        $report = ExpenseReport::findOrFail($id);
        $report->delete();

        return redirect()->route('expense-reports.index')
                         ->with('success', 'Note de frais supprimée');
    }
}
