<?php

namespace App\Http\Controllers;

use App\Models\Payslip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PayslipController extends Controller
{
    /**
     * Affiche la liste des bulletins de paie de l'utilisateur connecté.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Payslip::where('user_id', Auth::id());
        
        // Filtrage par mois
        if ($request->filled('month')) {
            $query->where('period_month', $request->month);
        }
        
        // Filtrage par année
        if ($request->filled('year')) {
            $query->where('period_year', $request->year);
        }
        
        // Filtrage par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $payslips = $query->orderBy('period_year', 'desc')
                         ->orderBy('period_month', 'desc')
                         ->paginate(20);
        
        // Récupération des années et mois disponibles pour les filtres
        $years = Payslip::where('user_id', Auth::id())
                        ->distinct()
                        ->pluck('period_year')
                        ->sort()
                        ->reverse()
                        ->values();
        
        $months = collect(range(1, 12));
        
        return view('payslips.index', compact('payslips', 'years', 'months'));
    }

    /**
     * Affiche les détails d'un bulletin de paie spécifique.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function show(Payslip $payslip)
    {
        // Vérifier que l'utilisateur consulte son propre bulletin
        if ($payslip->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à consulter ce bulletin de paie.');
        }
        
        return view('payslips.show', compact('payslip'));
    }

    /**
     * Génère un PDF du bulletin de paie.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function generatePdf(Payslip $payslip)
    {
        // Vérifier que l'utilisateur télécharge son propre bulletin
        if ($payslip->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à télécharger ce bulletin de paie.');
        }
        
        $pdf = Pdf::loadView('admin.payslips.pdf', [
            'payslip' => $payslip,
            'user' => $payslip->user,
            'contract' => $payslip->contract,
        ]);
        
        $filename = 'bulletin_' . $payslip->period_month . '_' . $payslip->period_year . '_' . $payslip->user->last_name . '.pdf';
        
        return $pdf->download($filename);
    }
}
