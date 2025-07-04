<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayslipController extends Controller
{
    /**
     * Affiche la liste des bulletins de paie de l'utilisateur connecté.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $payslips = $user->payslips()->orderBy('period_end', 'desc')->paginate(10);
        
        return view('payroll.payslips.index', compact('payslips'));
    }

    /**
     * Affiche les détails d'un bulletin de paie spécifique.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\View\View
     */
    public function show(Payslip $payslip)
    {
        $this->authorize('view', $payslip);
        
        $payrollItems = $payslip->payrollItems;
        $leaves = $payslip->leaves;
        
        return view('payroll.payslips.show', compact('payslip', 'payrollItems', 'leaves'));
    }

    /**
     * Télécharge un bulletin de paie au format PDF.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Payslip $payslip)
    {
        $this->authorize('view', $payslip);
        
        // Logique pour générer et télécharger le PDF
        // À implémenter ultérieurement
        
        return back()->with('error', 'La fonctionnalité de téléchargement sera disponible prochainement.');
    }
}
