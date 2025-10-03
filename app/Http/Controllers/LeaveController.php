<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveAttachment;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Mail\LeaveStatusNotification;
use Illuminate\Support\Facades\Mail;
use App\Events\LeaveCreated;
use App\Events\LeaveStatusUpdated;
use App\Services\LeaveBalanceService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Company;

class LeaveController extends Controller
{
    protected $leaveBalanceService;

    public function __construct(LeaveBalanceService $leaveBalanceService)
    {
        $this->leaveBalanceService = $leaveBalanceService;
    }

    /**
     * Affiche la liste des congés de l'utilisateur connecté
     */
    public function index()
    {
        $leaves = Leave::with(['user.department', 'attachments'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Récupérer les soldes de congés de l'utilisateur
        $balanceSummary = $this->leaveBalanceService->getUserBalanceSummary(auth()->user());

        return view('leaves.index', compact('leaves', 'balanceSummary'));
    }

    /**
     * Affiche le formulaire de création d'une demande de congé
     */
    public function create()
    {
        return view('leaves.create');
    }

    /**
     * Enregistre une nouvelle demande de congé
     */

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
           // Validation de base
            

                 $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'start_date' => [
                    'required',
                    'date',
                    'before:+1 year',
                    function ($attribute, $value, $fail) {
                        $startDate = Carbon::parse($value);
                        if ($startDate->isWeekend()) {
                            $fail('La date de début ne peut pas être un weekend.');
                        }
                    }
                ],
                'end_date' => [
                    'required',
                    'date',
                    'after_or_equal:start_date',
                    function ($attribute, $value, $fail) {
                        $endDate = Carbon::parse($value);
                        if ($endDate->isWeekend()) {
                            $fail('La date de fin ne peut pas être un weekend.');
                        }
                    }
                ],
                'type' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $user = auth()->user();
                        if (!($user instanceof \App\Models\User)) {
                            $fail('Utilisateur non authentifié ou type utilisateur invalide.');
                            return;
                        }
                        $userSeniorityMonths = $user->getSeniorityInMonths();
                        
                        // Système unifié : tous les congés utilisent SpecialLeaveType (format: special_X)
                        if (preg_match('/^special_(\d+)$/', $value, $matches)) {
                            $specialLeaveTypeId = $matches[1];
                            $specialLeaveType = \App\Models\SpecialLeaveType::where('id', $specialLeaveTypeId)
                                ->where('company_id', $user->company_id)
                                ->where('is_active', true)
                                ->first();
                            
                            if (!$specialLeaveType) {
                                $fail('Le type de congé sélectionné n\'est pas valide ou n\'appartient pas à votre entreprise.');
                                return;
                            }
                            
                            // Vérification de l'ancienneté pour les types personnalisés
                            if ($specialLeaveType->seniority_months > 0 && $userSeniorityMonths < $specialLeaveType->seniority_months) {
                                $fail("Vous n'avez pas l'ancienneté requise pour ce type de congé. Ancienneté requise: {$specialLeaveType->seniority_months} mois, votre ancienneté: {$userSeniorityMonths} mois.");
                            }
                            return;
                        }
                        
                        // Types de congés par nom système (format: system_X)
                        if (preg_match('/^system_(.+)$/', $value, $matches)) {
                            $systemName = $matches[1];
                            $specialType = \App\Models\SpecialLeaveType::where('system_name', $systemName)
                                ->where('is_active', true)
                                ->first();
                            
                            if (!$specialType) {
                                $fail('Le type de congé spécial sélectionné n\'est pas valide ou n\'est pas actif.');
                                return;
                            }
                            
                            // Vérification de l'ancienneté pour les types système
                            if ($specialType->seniority_months > 0 && $userSeniorityMonths < $specialType->seniority_months) {
                                $fail("Vous n'avez pas l'ancienneté requise pour ce type de congé. Ancienneté requise: {$specialType->seniority_months} mois, votre ancienneté: {$userSeniorityMonths} mois.");
                            }
                            return;
                        }
                        
                        $fail('Le type de congé sélectionné n\'est pas valide. Veuillez utiliser un type défini dans le système.');
                    }
                ],
                'reason' => ['required', 'string', 'min:10', 'max:500'],
                'attachments.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048']
            ], [
                'start_date.required' => 'La date de début est requise.',
                'start_date.date' => 'La date de début doit être une date valide.',
                'start_date.before' => 'La date de début doit être dans moins d\'un an.',
                'end_date.required' => 'La date de fin est requise.',
                'end_date.date' => 'La date de fin doit être une date valide.',
                'end_date.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
                'type.required' => 'Le type de congé est requis.',
                'type.in' => 'Le type de congé sélectionné n\'est pas valide.',
                'reason.required' => 'Le motif est requis.',
                'reason.min' => 'Le motif doit faire au moins :min caractères.',
                'reason.max' => 'Le motif ne peut pas dépasser :max caractères.',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Veuillez corriger les erreurs dans le formulaire.');
            }

            $validated = $validator->validated();
               
           

            // Vérification des chevauchements
            $start = Carbon::parse($validated['start_date']);
            $end = Carbon::parse($validated['end_date']);
            
            $existingLeave = Leave::query()
                ->where('user_id', auth()->id())
                ->where('status', '!=', 'rejected')
                ->where(function ($query) use ($start, $end) {
                    $query->where(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                          ->where('end_date', '>=', $start);
                    })->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $end)
                          ->where('end_date', '>=', $end);
                    })->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '>=', $start)
                          ->where('end_date', '<=', $end);
                    })->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                          ->where('end_date', '>=', $end);
                    });
                })
                ->first();

            if ($existingLeave) {
                return back()->withInput()->with('error', sprintf(
                    'Cette période chevauche un congé existant du %s au %s.',
                    $existingLeave->start_date->format('d/m/Y'),
                    $existingLeave->end_date->format('d/m/Y')
                ));
            }

            // Calcul de la durée en jours ouvrables
            $duration = 0;
            for ($date = clone $start; $date->lte($end); $date->addDay()) {
                if (!$date->isWeekend()) {
                    $duration++;
                }
            }

            // Vérification de la durée maximale
            $specialLeaveType = null;
            $maxDuration = 30; // Valeur par défaut de sécurité
            
            // Récupérer le SpecialLeaveType (système unifié)
            if (preg_match('/^special_(\d+)$/', $validated['type'], $matches)) {
                $specialLeaveTypeId = $matches[1];
                $specialLeaveType = \App\Models\SpecialLeaveType::find($specialLeaveTypeId);
                
                if ($specialLeaveType) {
                    // Déterminer la durée maximale selon les champs disponibles dans SpecialLeaveType
                    if ($specialLeaveType->annual_leave_days > 0) {
                        $maxDuration = $specialLeaveType->annual_leave_days;
                    } elseif ($specialLeaveType->maternity_leave_days > 0) {
                        $maxDuration = $specialLeaveType->maternity_leave_days;
                    } elseif ($specialLeaveType->paternity_leave_days > 0) {
                        $maxDuration = $specialLeaveType->paternity_leave_days;
                    } elseif ($specialLeaveType->special_leave_days > 0) {
                        $maxDuration = $specialLeaveType->special_leave_days;
                    } elseif ($specialLeaveType->duration_days > 0) {
                        $maxDuration = $specialLeaveType->duration_days;
                    }
                }
            }
            // Récupérer le SpecialLeaveType par nom système
            elseif (preg_match('/^system_(.+)$/', $validated['type'], $matches)) {
                $systemName = $matches[1];
                $specialLeaveType = \App\Models\SpecialLeaveType::where('system_name', $systemName)->first();
                
                if ($specialLeaveType && $specialLeaveType->duration_days) {
                    $maxDuration = $specialLeaveType->duration_days;
                }
            }

            if ($duration > $maxDuration) {
                return back()->withInput()->with('error', 
                    "La durée maximale pour ce type de congé est de {$maxDuration} jours ouvrables."
                );
            }

            // Déterminer le statut selon l'action de l'utilisateur
            $status = $request->input('action') === 'submit' ? 'pending' : 'draft';
            
            // Création du congé
            $leave = new Leave($validated);
            $leave->user_id = auth()->id();
            $leave->status = $status;
            $leave->duration = $duration;
            
            // Associer le SpecialLeaveType
            if ($specialLeaveType) {
                $leave->special_leave_type_id = $specialLeaveType->id;
            }
            
            if (!$leave->save()) {
                throw new \Exception('Erreur lors de la sauvegarde du congé');
            }

            // Gestion des pièces jointes
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('leave_attachments');
                    $leave->attachments()->create([
                        'filename' => $path,
                        'original_filename' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize()
                    ]);
                }
            }

            DB::commit();
            
            // Déclencher l'événement de création de congé seulement si soumis
            if ($status === 'pending') {
                event(new LeaveCreated($leave));
            }
            
            $message = $status === 'pending' 
                ? 'Votre demande de congé a été soumise avec succès.' 
                : 'Votre demande de congé a été sauvegardée en brouillon.';
            
            return redirect()->route('leaves.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'une demande de congé
     */

    public function show(Leave $leave)
    {
        \Log::info('Attempting to show leave:', ['id' => $leave->id]);

        try {
            // Charger la demande avec ses relations
            $leave->load(['user.department', 'attachments', 'approver']);

            \Log::info('Leave loaded:', [
                'leave_id' => $leave->id,
                'user_id' => $leave->user_id,
                'auth_user_id' => auth()->id()
            ]);

            $this->authorize('view', $leave);
            
            \Log::info('Leave details:', [
                'leave' => $leave->toArray(),
                'user' => $leave->user ? $leave->user->toArray() : null,
                'department' => $leave->user && $leave->user->department ? $leave->user->department->toArray() : null
            ]);

            return view('leaves.show', compact('leave'));
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            \Log::error('Unauthorized access:', [
                'user_id' => auth()->id(),
                'leave_id' => $leave->id
            ]);
            abort(403, 'Vous n\'êtes pas autorisé à voir cette demande de congé');
        } catch (\Exception $e) {
            \Log::error('Error showing leave:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Une erreur est survenue lors de l\'affichage de la demande');
        }
    }

    /**
     * Télécharge la pièce jointe d'une demande de congé
     */
    public function downloadAttachment(Leave $leave, LeaveAttachment $attachment)
    {
        $this->authorize('view', $leave);

        if (!Storage::exists($attachment->filename)) {
            abort(404, 'Pièce jointe introuvable');
        }

        return Storage::download(
            $attachment->filename,
            $attachment->original_filename,
            ['Content-Type' => $attachment->mime_type]
        );
    }

    /**
     * Affiche la liste des demandes de congés pour le manager
     */
    public function managerIndex(Request $request)
    {
        $query = Leave::with(['user', 'user.department'])
            ->whereHas('user', function ($q) {
                $q->where('department_id', auth()->user()->department_id);
            });

        // Recherche par nom d'employé
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('status') && array_key_exists($request->status, Leave::STATUSES)) {
            $query->where('status', $request->status);
        }

        // Filtre par type de congé
        if ($request->filled('type')) {
            $specialLeaveType = \App\Models\SpecialLeaveType::where('system_name', $request->type)
                ->orWhere('name', $request->type)
                ->first();
            if ($specialLeaveType) {
                $query->where('special_leave_type_id', $specialLeaveType->id);
            }
        }

        // Filtre par date
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $leaves = $query->latest()->paginate(20);
        
        // Conserver les paramètres de filtrage dans les liens de pagination
        $leaves->appends($request->only(['search', 'status', 'type', 'date_from', 'date_to']));

        return view('manager.leaves.index', compact('leaves'));
    }

    /**
     * Approuve une demande de congé
     */
    public function approve(Leave $leave)
    {
        if (!auth()->user()->can('approve-leaves')) {
            abort(403, 'Vous n\'avez pas l\'autorisation d\'approuver les demandes de congé.');
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $oldStatus = $leave->status;
        
        try {
            DB::transaction(function () use ($leave, $oldStatus) {
                $leave->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                    'approved_at' => now()
                ]);

                // Décrémenter le solde via le service si nécessaire
                if ($leave->specialLeaveType && $leave->specialLeaveType->hasBalance()) {
                    $leaveBalanceService = app(LeaveBalanceService::class);
                    $decremented = $leaveBalanceService->decrementBalance($leave);
                    if (!$decremented) {
                        throw new \RuntimeException('Solde insuffisant pour approuver cette demande.');
                    }
                }

                // Déclencher l'événement de mise à jour du statut
                event(new LeaveStatusUpdated($leave, $oldStatus, 'approved'));
            });

            return redirect()->back()->with('success', 'La demande de congé a été approuvée.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Rejette une demande de congé
     */
    public function reject(Request $request, Leave $leave)
    {
        if (!auth()->user()->can('approve-leaves')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de refuser les demandes de congé.');
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $oldStatus = $leave->status;
        
        $leave->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $validated['rejection_reason']
        ]);
        
        // Déclencher l'événement de mise à jour du statut
        event(new LeaveStatusUpdated($leave, $oldStatus, 'rejected'));

        return redirect()->back()->with('success', 'La demande de congé a été refusée.');
    }

    /**
     * Annule une demande de congé approuvée
     */
    public function cancel(Request $request, Leave $leave)
    {
        if (!auth()->user()->can('approve-leaves')) {
            abort(403, 'Vous n\'avez pas l\'autorisation d\'annuler les demandes de congé.');
        }

        if ($leave->status !== 'approved') {
            return back()->with('error', 'Seules les demandes approuvées peuvent être annulées.');
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ]);

        $oldStatus = $leave->status;
        
        // Utiliser le service LeaveBalanceService pour rembourser le solde
        $leaveBalanceService = app(\App\Services\LeaveBalanceService::class);
        
        DB::beginTransaction();
        try {
            // Rembourser le solde si nécessaire
            $leaveBalanceService->incrementBalance($leave);
            
            // Mettre à jour le statut du congé
            $leave->update([
                'status' => 'cancelled',
                'cancelled_by' => auth()->id(),
                'cancelled_at' => now(),
                'cancellation_reason' => $validated['cancellation_reason']
            ]);
            
            DB::commit();
            
            // Déclencher l'événement de mise à jour du statut
            event(new LeaveStatusUpdated($leave, $oldStatus, 'cancelled'));

            return redirect()->back()->with('success', 'La demande de congé a été annulée et le solde a été remboursé.');
            
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de l\'annulation du congé', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Une erreur est survenue lors de l\'annulation du congé.');
        }
    }

    public function destroy(Leave $leave)
    {
        try {
            $leave->load(['user.department', 'attachments', 'approver']);

            $this->authorize('delete', $leave);

            if ($leave->status !== 'draft') {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez supprimer que les demandes en brouillon.'
                ], 400);
            }

            \Log::info('Suppression de la demande:', [
                'leave_id' => $leave->id,
                'user_id' => auth()->id()
            ]);

            // Supprimer les pièces jointes si elles existent
            if ($leave->attachments->count() > 0) {
                foreach ($leave->attachments as $attachment) {
                    Storage::delete($attachment->filename);
                    $attachment->delete();
                }
            }

            // Supprimer la demande
            $leave->delete();

            return response()->json([
                'success' => true,
                'message' => 'La demande de congé a été supprimée.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression de la demande.'
            ], 500);
        }
    }

    public function destroyOLD($id)
    {
        $leave = Leave::with(['user.department', 'attachments', 'approver'])
                         ->findOrFail($id);

        $this->authorize('delete', $leave);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Vous ne pouvez annuler que les demandes en attente.');
        }

        try {
            $leave->update([
                'status' => 'cancelled',
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);

            return redirect()->route('leaves.index')->with('success', 'La demande de congé a été annulée.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'annulation de la demande.');
        }
    }

    /**
     * Affiche le formulaire d'édition d'une demande de congé
     */
     public function edit($id)
    {

        $leave = Leave::with(['user.department', 'attachments', 'approver'])
                         ->findOrFail($id);

        \Log::info('Tentative d\'édition de la demande:', [
            'leave_id' => $leave->id,
            'user_id' => auth()->id(),
            'leave_status' => $leave->status
        ]);

        try {
            $this->authorize('update', $leave);

            if (!in_array($leave->status, ['pending', 'draft'])) {
                \Log::warning('Tentative de modification d\'une demande non modifiable', [
                    'leave_id' => $leave->id,
                    'status' => $leave->status
                ]);
                return back()->with('error', 'Vous ne pouvez modifier que les demandes en attente ou en brouillon.');
            }

            \Log::info('Affichage du formulaire d\'édition', [
                'leave' => $leave->toArray()
            ]);

            return view('leaves.edit', compact('leave'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'édition:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette demande.');
        }
    }

    /**
     * Met à jour une demande de congé
     */

    public function update(Request $request, $id)
    {
        try {
            $leave = Leave::findOrFail($id);

            \Log::info('Tentative de mise à jour de la demande:', [
                'leave_id' => $leave->id,
                'current_status' => $leave->status,
                'user_id' => auth()->id()
            ]);
            
            $this->authorize('update', $leave);

            // Recharger la demande depuis la base de données pour avoir les données à jour
            $leave = Leave::findOrFail($leave->id);
            
            \Log::info('Statut de la demande après rechargement:', [
                'leave_id' => $leave->id,
                'status' => $leave->status
            ]);

            if (!in_array($leave->status, ['pending', 'draft'])) {
                \Log::warning('Tentative de modification d\'une demande non modifiable:', [
                    'leave_id' => $leave->id,
                    'status' => $leave->status
                ]);
                return back()->with('error', 'Vous ne pouvez modifier que les demandes en attente ou en brouillon.');
            }

            // Gérer l'action de soumission pour les brouillons
            $action = $request->input('action');
            if ($action === 'submit' && $leave->status === 'draft') {
                $leave->update(['status' => 'pending']);
                event(new \App\Events\LeaveCreated($leave));
                return redirect()->route('leaves.index')
                    ->with('success', 'Votre demande de congé a été soumise avec succès.');
            }

            $validated = $request->validate([
                'type' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        // Système unifié : tous les congés utilisent SpecialLeaveType (format: special_X)
                        if (preg_match('/^special_(\d+)$/', $value, $matches)) {
                            $specialLeaveTypeId = $matches[1];
                            $specialLeaveType = \App\Models\SpecialLeaveType::where('id', $specialLeaveTypeId)
                                ->where('is_active', true)
                                ->first();
                            
                            if (!$specialLeaveType) {
                                $fail('Le type de congé sélectionné n\'est pas valide ou n\'est pas actif.');
                            }
                            return;
                        }
                        
                        // Types de congés par nom système (format: system_X)
                        if (preg_match('/^system_(.+)$/', $value, $matches)) {
                            $systemName = $matches[1];
                            $specialType = \App\Models\SpecialLeaveType::where('system_name', $systemName)
                                ->where('is_active', true)
                                ->first();
                            
                            if (!$specialType) {
                                $fail('Le type de congé spécial sélectionné n\'est pas valide ou n\'est pas actif.');
                            }
                            return;
                        }
                        
                        // Compatibilité temporaire avec les anciens types
                        if (array_key_exists($value, \App\Models\Leave::TYPES)) {
                            return;
                        }
                        
                        $fail('Le type de congé sélectionné n\'est pas valide. Veuillez utiliser un type défini dans le système.');
                    }
                ],
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required|string|min:10',
                'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            ]);

            // Calculer la durée en jours ouvrables
            $start = Carbon::parse($validated['start_date']);
            $end = Carbon::parse($validated['end_date']);
            $duration = 0;

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                if (!$date->isWeekend()) {
                    $duration++;
                }
            }

            DB::beginTransaction();

            // Déterminer le nouveau statut selon l'action
            $newStatus = $leave->status; // Garder le statut actuel par défaut
            if ($action === 'submit' && $leave->status === 'draft') {
                $newStatus = 'pending';
            } elseif ($action === 'draft') {
                $newStatus = 'draft';
            }

            $leave->update([
                'type' => $validated['type'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'duration' => $duration,
                'reason' => $validated['reason'],
                'status' => $newStatus
            ]);

            // Gérer les pièces jointes
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('leave_attachments');
                    $leave->attachments()->create([
                        'filename' => $path,
                        'original_filename' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize()
                    ]);
                }
            }

            DB::commit();
            
            // Déclencher l'événement si le statut passe à 'pending'
            if ($newStatus === 'pending' && $leave->wasChanged('status')) {
                event(new \App\Events\LeaveCreated($leave));
            }
            
            $message = match($newStatus) {
                'pending' => 'Votre demande de congé a été soumise avec succès.',
                'draft' => 'Votre demande de congé a été sauvegardée en brouillon.',
                default => 'Demande de congé mise à jour avec succès.'
            };
            
            return redirect()->route('leaves.show', $leave)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la mise à jour:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de la demande : ' . $e->getMessage());
        }
    }

    /**
     * Met à jour une demande de congé
     */
    public function updateOLD(Request $request, Leave $leave)
    {
        $this->authorize('update', $leave);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Vous ne pouvez modifier que les demandes en attente.');
        }

        $validated = $request->validate([
            'type' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Système unifié : tous les congés utilisent SpecialLeaveType (format: special_X)
                    if (preg_match('/^special_(\d+)$/', $value, $matches)) {
                        $specialLeaveTypeId = $matches[1];
                        $specialLeaveType = \App\Models\SpecialLeaveType::where('id', $specialLeaveTypeId)
                            ->where('is_active', true)
                            ->first();
                        
                        if (!$specialLeaveType) {
                            $fail('Le type de congé sélectionné n\'est pas valide ou n\'est pas actif.');
                        }
                        return;
                    }
                    
                    // Types de congés par nom système (format: system_X)
                    if (preg_match('/^system_(.+)$/', $value, $matches)) {
                        $systemName = $matches[1];
                        $specialType = \App\Models\SpecialLeaveType::where('system_name', $systemName)
                            ->where('is_active', true)
                            ->first();
                        
                        if (!$specialType) {
                            $fail('Le type de congé spécial sélectionné n\'est pas valide ou n\'est pas actif.');
                        }
                        return;
                    }
                    
                    $fail('Le type de congé sélectionné n\'est pas valide. Veuillez utiliser un type défini dans le système.');
                }
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        // Calculer la durée en jours ouvrables
        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);
        $duration = 0;

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if (!$date->isWeekend()) {
                $duration++;
            }
        }

        DB::beginTransaction();
        try {
            $leave->update([
                'type' => $validated['type'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'duration' => $duration,
                'reason' => $validated['reason']
            ]);

            // Gérer les pièces jointes
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('leave-attachments', 'public');
                    $leave->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName()
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('leaves.show', $leave)->with('success', 'Demande de congé mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour de la demande.');
        }
    }

    /**
     * Soumet une demande de congé en brouillon
     */
    public function submit(Leave $leave)
    {
        try {
            $this->authorize('update', $leave);

            if ($leave->status !== 'draft') {
                return back()->with('error', 'Seules les demandes en brouillon peuvent être soumises.');
            }

            $leave->update(['status' => 'pending']);
            
            // Déclencher l'événement de création de congé
            event(new LeaveCreated($leave));
            
            return redirect()->route('leaves.index')
                ->with('success', 'Votre demande de congé a été soumise avec succès.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la soumission de la demande.');
        }
    }

    /**
     * Génère et télécharge le PDF d'une demande de congé approuvée
     */
    public function downloadPdf(Leave $leave)
    {
        $this->authorize('view', $leave);

        // Vérifier que la demande est approuvée
        if ($leave->status !== 'approved') {
            return back()->with('error', 'Le PDF ne peut être généré que pour les demandes approuvées.');
        }

        try {
            // Préparer les données pour le template
            $data = $this->prepareTemplateData($leave);
            
            // Générer le PDF
            $pdf = Pdf::loadView('templates.leaves.leave_approval', $data)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true
                ]);

            // Nom du fichier
            $filename = 'autorisation_conge_' . $leave->user->first_name . '_' . $leave->user->last_name . '_' . $leave->id . '.pdf';
            
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la génération du PDF de congé:', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Erreur lors de la génération du PDF: ' . $e->getMessage());
        }
    }

    /**
     * Prépare les données pour le template PDF
     */
    private function prepareTemplateData(Leave $leave)
    {
        $user = $leave->user;
        $company = Company::first(); // Récupérer les informations de l'entreprise
        
        // Déterminer qui a approuvé la demande
        $approvedBy = $leave->approved_by ? 
            \App\Models\User::find($leave->approved_by) : 
            ($leave->processed_by ? \App\Models\User::find($leave->processed_by) : null);
        
        return [
            // Informations de l'entreprise
            'entreprise' => $company ? $company->name : 'Nom de l\'entreprise',
            'adresse_entreprise' => $company ? $company->address : 'Adresse de l\'entreprise',
            'code_postal_entreprise' => $company ? $company->postal_code : '00000',
            'ville_entreprise' => $company ? $company->city : 'Ville',
            'siret' => $company ? $company->siret : null,
            'logo_entreprise' => $company ? $company->logo : null,
            
            // Informations RH
            'hr_director_name' => $company && $company->hr_director_name ? $company->hr_director_name : 'Directeur RH',
            'directeur_rh' => $company && $company->hr_director_name ? $company->hr_director_name : 'Directeur RH',
            'hr_signature' => $company ? $company->hr_signature : null,
            'generateur' => $approvedBy ? ($approvedBy->first_name . ' ' . $approvedBy->last_name) : 'Système',
            
            // Informations du document
            'numero_demande' => 'CONGE-' . str_pad($leave->id, 6, '0', STR_PAD_LEFT),
            'date_generation' => now()->format('d/m/Y'),
            
            // Informations de l'employé
            'civilite' => $user->gender === 'M' ? 'Monsieur' : 'Madame',
            'nom_complet' => $user->first_name . ' ' . $user->last_name,
            'nom' => $user->last_name,
            'prenom' => $user->first_name,
            'email' => $user->email,
            'poste' => $user->position ?? 'Non renseigné',
            'departement' => $user->department ? $user->department->name : 'Non renseigné',
            'matricule' => $user->employee_id ?? null,
            
            // Informations de la demande de congé
            'type_conge' => $leave->specialLeaveType ? $leave->specialLeaveType->name : $leave->type,
            'date_debut' => $leave->start_date->format('d/m/Y'),
            'date_fin' => $leave->end_date->format('d/m/Y'),
            'duree_jours' => $leave->duration,
            'motif' => $leave->reason,
            'date_soumission' => $leave->created_at->format('d/m/Y'),
            
            // Informations d'approbation
            'statut' => 'Approuvé',
            'approuve_par' => $approvedBy ? ($approvedBy->first_name . ' ' . $approvedBy->last_name) : 'Système',
            'date_approbation' => $leave->approved_at ? $leave->approved_at->format('d/m/Y') : 
                                 ($leave->processed_at ? $leave->processed_at->format('d/m/Y') : now()->format('d/m/Y')),
            'commentaire_approbation' => $leave->rejection_reason ?? null, // Peut être utilisé pour des commentaires d'approbation
        ];
    }
}
