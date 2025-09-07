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

class LeaveController extends Controller
{
    /**
     * Affiche la liste des congés de l'utilisateur connecté
     */
    public function index()
    {
        $leaves = Leave::with(['user.department', 'attachments'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('leaves.index', compact('leaves'));
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
                        // Système unifié : tous les congés utilisent LeaveBalance (format: balance_X)
                        if (preg_match('/^balance_(\d+)$/', $value, $matches)) {
                            $leaveBalanceId = $matches[1];
                            $leaveBalance = \App\Models\LeaveBalance::where('id', $leaveBalanceId)
                                ->where('company_id', auth()->user()->company_id)
                                ->first();
                            
                            if (!$leaveBalance) {
                                $fail('Le type de congé sélectionné n\'est pas valide ou n\'appartient pas à votre entreprise.');
                            }
                            return;
                        }
                        
                        // Types de congés spéciaux (format: special_X)
                        if (preg_match('/^special_(.+)$/', $value, $matches)) {
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
            $leaveBalance = null;
            $specialLeaveType = null;
            $maxDuration = 30; // Valeur par défaut de sécurité
            
            // Récupérer le LeaveBalance (système unifié)
            if (preg_match('/^balance_(\d+)$/', $validated['type'], $matches)) {
                $leaveBalanceId = $matches[1];
                $leaveBalance = \App\Models\LeaveBalance::find($leaveBalanceId);
                
                if ($leaveBalance) {
                    // Déterminer la durée maximale selon les champs disponibles dans LeaveBalance
                    if ($leaveBalance->annual_leave_days > 0) {
                        $maxDuration = $leaveBalance->annual_leave_days;
                    } elseif ($leaveBalance->maternity_leave_days > 0) {
                        $maxDuration = $leaveBalance->maternity_leave_days;
                    } elseif ($leaveBalance->paternity_leave_days > 0) {
                        $maxDuration = $leaveBalance->paternity_leave_days;
                    } elseif ($leaveBalance->special_leave_days > 0) {
                        $maxDuration = $leaveBalance->special_leave_days;
                    }
                }
            }
            // Récupérer le SpecialLeaveType
            elseif (preg_match('/^special_(.+)$/', $validated['type'], $matches)) {
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
            
            // Associer le LeaveBalance ou SpecialLeaveType
            if ($leaveBalance) {
                $leave->leave_balance_id = $leaveBalance->id;
            } elseif ($specialLeaveType) {
                // Pour les types spéciaux, le type est déjà stocké dans $validated['type'] (format: special_system_name)
                // Le system_name est utilisé pour identifier de manière unique le type de congé spécial
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
        if ($request->filled('type') && array_key_exists($request->type, Leave::TYPES)) {
            $query->where('type', $request->type);
        }

        // Filtre par date
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $leaves = $query->latest()->paginate(10);
        
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
        
        $leave->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);
        
        // Déclencher l'événement de mise à jour du statut
        event(new LeaveStatusUpdated($leave, $oldStatus, 'approved'));

        return redirect()->back()->with('success', 'La demande de congé a été approuvée.');
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
     * Annule une demande de congé
     */

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
                'type' => 'required|in:' . implode(',', array_keys(Leave::TYPES)),
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
            'type' => 'required|in:' . implode(',', array_keys(Leave::TYPES)),
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
            \Log::error('Erreur lors de la soumission de la demande:', [
                'error' => $e->getMessage(),
                'leave_id' => $leave->id
            ]);
            return back()->with('error', 'Une erreur est survenue lors de la soumission de la demande.');
        }
    }
}
