<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\ExpenseLine;
use App\Models\ExpenseReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseLineController extends Controller
{
    public function store(Request $request, $reportId)
    {
        // Vérifier si le rapport appartient bien à l'utilisateur (sauf si manager ou admin)
        $report = ExpenseReport::where('user_id', Auth::id())->findOrFail($reportId);

        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'spent_on' => 'required|date',
            // 'receipt_path' => 'file|mimes:jpg,png,pdf' -> si upload
        ]);

        $line = new ExpenseLine($request->only('description', 'amount', 'spent_on'));

        // Si vous gérez l'upload du justificatif
        if ($request->hasFile('receipt_path')) {
            $path = $request->file('receipt_path')->store('receipts', 'public');
            $line->receipt_path = $path;
        }

        $report->expenseLines()->save($line);

        // Recalcule du total
        $report->recalculateTotal();

        return redirect()->route('expense-reports.show', $reportId)
                         ->with('success', 'Ligne de dépense ajoutée');
    }

    public function edit($reportId, $lineId)
    {
        $report = ExpenseReport::where('user_id', Auth::id())->findOrFail($reportId);
        $line = $report->expenseLines()->findOrFail($lineId);

        return view('expenses.lines.edit', compact('report', 'line'));
    }

    public function update(Request $request, $reportId, $lineId)
    {
        $report = ExpenseReport::where('user_id', Auth::id())->findOrFail($reportId);
        $line = $report->expenseLines()->findOrFail($lineId);

        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'spent_on' => 'required|date',
        ]);

        $line->update($request->only('description', 'amount', 'spent_on'));
        // Gérer aussi la mise à jour du receipt_path si besoin

        // Recalcule du total
        $report->recalculateTotal();

        return redirect()->route('expense-reports.show', $reportId)
                         ->with('success', 'Ligne de dépense mise à jour');
    }

    public function destroy($reportId, $lineId)
    {
        $report = ExpenseReport::where('user_id', Auth::id())->findOrFail($reportId);
        $line = $report->expenseLines()->findOrFail($lineId);

        $line->delete();

        // Recalcule du total
        $report->recalculateTotal();

        return redirect()->route('expense-reports.show', $reportId)
                         ->with('success', 'Ligne de dépense supprimée');
    }
}
