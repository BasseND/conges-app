<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\SalaryAdvance;
use App\Models\User;
use App\Models\Company;
use App\Events\SalaryAdvanceCreated;
use App\Events\SalaryAdvanceStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalaryAdvanceController extends Controller
{
    /**
     * Affiche la liste des avances sur salaire de l'utilisateur connecté.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $salaryAdvances = $user->salaryAdvances()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('salary-advances.index', compact('salaryAdvances'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle avance sur salaire.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $company = Company::first();
        return view('salary-advances.create', compact('company'));
    }

    /**
     * Enregistre une nouvelle avance sur salaire.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
            'request_date' => 'required|date',
        ]);
        
        $user = Auth::user();
        $requestDate = Carbon::parse($validated['request_date']);
        $company = Company::first(); // Récupérer les paramètres de l'entreprise
        
        // Validation 1: Vérifier qu'il n'y a pas déjà une demande pour ce mois
        $existingAdvance = SalaryAdvance::where('user_id', $user->id)
            ->whereYear('request_date', $requestDate->year)
            ->whereMonth('request_date', $requestDate->month)
            ->whereIn('status', ['pending', 'submitted', 'approved'])
            ->first();
            
        if ($existingAdvance) {
            // Configurer la locale française pour Carbon
            $requestDate->locale('fr');
            return back()->withErrors([
                'request_date' => 'Vous avez déjà une demande d\'avance pour le mois de ' . $requestDate->translatedFormat('F Y') . '.'
            ])->withInput();
        }
        
        // Validation 2: Vérifier que la demande est faite avant la date limite
        $deadlineDay = $company ? $company->salary_advance_deadline_day : 20;
        $currentDate = Carbon::now();
        
        // Si la demande est pour le mois en cours, vérifier la date limite
        if ($requestDate->year == $currentDate->year && $requestDate->month == $currentDate->month) {
            if ($currentDate->day > $deadlineDay) {
                return back()->withErrors([
                    'request_date' => 'La date limite pour soumettre une demande d\'avance pour ce mois était le ' . $deadlineDay . '. Vous pouvez faire une demande pour le mois prochain.'
                ])->withInput();
            }
        }
        
        // Si la demande est pour un mois passé, la rejeter
        if ($requestDate->isPast() && !($requestDate->year == $currentDate->year && $requestDate->month == $currentDate->month)) {
            return back()->withErrors([
                'request_date' => 'Vous ne pouvez pas faire une demande d\'avance pour un mois passé.'
            ])->withInput();
        }
        
        $salaryAdvance = new SalaryAdvance();
        $salaryAdvance->user_id = $user->id;
        $salaryAdvance->amount = $validated['amount'];
        $salaryAdvance->reason = $validated['reason'];
        $salaryAdvance->request_date = $validated['request_date'];
        $salaryAdvance->status = 'pending';
        $salaryAdvance->save();
        
        // Déclencher l'événement pour notifier les RH
        event(new SalaryAdvanceCreated($salaryAdvance));
        
        return redirect()->route('salary-advances.index')
            ->with('success', 'Votre demande d\'avance sur salaire a été soumise avec succès.');
    }

    /**
     * Affiche les détails d'une avance sur salaire spécifique.
     *
     * @param  \App\Models\SalaryAdvance  $salaryAdvance
     * @return \Illuminate\View\View
     */
    public function show(SalaryAdvance $salaryAdvance)
    {
        $this->authorize('view', $salaryAdvance);
        
        $repayments = $salaryAdvance->repayments;
        
        return view('salary-advances.show', compact('salaryAdvance', 'repayments'));
    }

    /**
     * Soumet une demande d'avance sur salaire (passage de pending à submitted).
     *
     * @param  \App\Models\SalaryAdvance  $salaryAdvance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(SalaryAdvance $salaryAdvance)
    {
        $this->authorize('submit', $salaryAdvance);
        
        if ($salaryAdvance->status !== 'pending') {
            return back()->with('error', 'Seules les demandes en attente peuvent être soumises.');
        }
        
        $salaryAdvance->status = 'submitted';
        $salaryAdvance->save();
        
        return redirect()->route('salary-advances.index')
            ->with('success', 'Votre demande d\'avance sur salaire a été soumise pour validation.');
    }

    /**
     * Approuve une demande d'avance sur salaire soumise (RH seulement).
     *
     * @param  \App\Models\SalaryAdvance  $salaryAdvance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(SalaryAdvance $salaryAdvance)
    {
        $this->authorize('approve', $salaryAdvance);
        
        if ($salaryAdvance->status !== 'submitted') {
            return back()->with('error', 'Seules les demandes soumises peuvent être approuvées.');
        }
        
        $previousStatus = $salaryAdvance->status;
        $salaryAdvance->status = 'approved';
        $salaryAdvance->approved_by = Auth::id();
        $salaryAdvance->approval_date = now();
        $salaryAdvance->save();
        
        // Déclencher l'événement pour notifier l'auteur de la demande
        event(new SalaryAdvanceStatusUpdated($salaryAdvance, $previousStatus));
        
        return back()->with('success', 'La demande d\'avance sur salaire a été approuvée.');
    }

    /**
     * Rejette une demande d'avance sur salaire soumise (RH seulement).
     *
     * @param  \App\Models\SalaryAdvance  $salaryAdvance
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(SalaryAdvance $salaryAdvance, Request $request)
    {
        $this->authorize('reject', $salaryAdvance);
        
        if ($salaryAdvance->status !== 'submitted') {
            return back()->with('error', 'Seules les demandes soumises peuvent être rejetées.');
        }
        
        $validated = $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);
        
        $previousStatus = $salaryAdvance->status;
        $salaryAdvance->status = 'rejected';
        $salaryAdvance->approved_by = Auth::id();
        $salaryAdvance->approval_date = now();
        $salaryAdvance->notes = $validated['notes'] ?? null;
        $salaryAdvance->save();
        
        // Déclencher l'événement pour notifier l'auteur de la demande
        event(new SalaryAdvanceStatusUpdated($salaryAdvance, $previousStatus));
        
        return back()->with('success', 'La demande d\'avance sur salaire a été rejetée.');
    }

    /**
     * Annule une demande d'avance sur salaire en attente.
     *
     * @param  \App\Models\SalaryAdvance  $salaryAdvance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(SalaryAdvance $salaryAdvance)
    {
        $this->authorize('cancel', $salaryAdvance);
        
        if ($salaryAdvance->status !== 'pending') {
            return back()->with('error', 'Seules les demandes en attente peuvent être annulées.');
        }
        
        $salaryAdvance->status = 'cancelled';
        $salaryAdvance->save();
        
        return redirect()->route('salary-advances.index')
            ->with('success', 'Votre demande d\'avance sur salaire a été annulée.');
    }
}
