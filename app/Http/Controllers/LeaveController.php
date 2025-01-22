<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveAttachment;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
    /**
     * Affiche la liste des congés de l'utilisateur connecté
     */
    public function index()
    {
        $leaves = Leave::with(['user.department', 'attachments'])
            ->where('user_id', auth()->id())
            ->latest()
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
        $validated = $request->validate([
            'type' => 'required|in:' . implode(',', array_keys(Leave::TYPES)),
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

        // Calcul de la durée en jours (en excluant les weekends)
        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);
        $duration = 0;

        for ($date = $start; $date->lte($end); $date->addDay()) {
            if (!$date->isWeekend()) {
                $duration++;
            }
        }

        $leave = new Leave($validated);
        $leave->user_id = auth()->id();
        $leave->status = 'pending';
        $leave->duration = $duration;
        $leave->save();

        // Gérer les pièces jointes après avoir sauvegardé la demande
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

        return redirect()->route('leaves.index')
            ->with('success', 'Votre demande de congé a été soumise avec succès.');
    }

    /**
     * Affiche les détails d'une demande de congé
     */
    public function show(Leave $leave)
    {
        $this->authorize('view', $leave);
        $leave->load(['user.department', 'attachments']);
        return view('leaves.show', compact('leave'));
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
                $q->where('name', 'like', "%{$search}%")
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
        $this->authorize('manage', $leave);

        Log::info('Approbation congé', [
            'leave_id' => $leave->id,
            'type' => $leave->type,
            'duration' => $leave->duration,
            'user_id' => $leave->user_id
        ]);

        // Mettre à jour le solde de congés de l'utilisateur
        $user = User::find($leave->user_id);
        
        Log::info('Solde avant mise à jour', [
            'annual_days' => $user->annual_leave_days,
            'sick_days' => $user->sick_leave_days
        ]);

        if ($leave->type === 'annual') {
            if ($user->annual_leave_days < $leave->duration) {
                return redirect()->back()
                    ->with('error', 'Le solde de congés annuels est insuffisant.');
            }
            $user->annual_leave_days = $user->annual_leave_days - $leave->duration;
            $user->save();

            Log::info('Solde annuel mis à jour', [
                'nouveau_solde' => $user->annual_leave_days
            ]);
        } elseif ($leave->type === 'sick') {
            if ($user->sick_leave_days < $leave->duration) {
                return redirect()->back()
                    ->with('error', 'Le solde de congés maladie est insuffisant.');
            }
            $user->sick_leave_days = $user->sick_leave_days - $leave->duration;
            $user->save();

            Log::info('Solde maladie mis à jour', [
                'nouveau_solde' => $user->sick_leave_days
            ]);
        }

        $leave->update([
            'status' => 'approved',
            'processed_at' => now(),
            'processed_by' => auth()->id()
        ]);

        // Rafraîchir l'utilisateur pour vérifier les changements
        $user->refresh();
        Log::info('Solde final après mise à jour', [
            'annual_days' => $user->annual_leave_days,
            'sick_days' => $user->sick_leave_days
        ]);

        return redirect()->back()
            ->with('success', 'La demande de congé a été approuvée.');
    }

    /**
     * Rejette une demande de congé
     */
    public function reject(Leave $leave, Request $request)
    {
        $this->authorize('manage', $leave);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10'
        ]);

        $leave->update([
            'status' => 'rejected',
            'processed_at' => now(),
            'processed_by' => auth()->id(),
            'rejection_reason' => $validated['rejection_reason']
        ]);

        return redirect()->back()
            ->with('success', 'La demande de congé a été rejetée.');
    }

    /**
     * Annule une demande de congé
     */
    public function destroy(Leave $leave)
    {
        \Log::info('Tentative d\'annulation de congé', [
            'user' => auth()->user()->only(['id', 'name', 'email', 'role']),
            'leave' => $leave->only(['id', 'user_id', 'status'])
        ]);

        try {
            $this->authorize('delete', $leave);
            
            // Supprimer les pièces jointes si elles existent
            foreach ($leave->attachments as $attachment) {
                Storage::delete($attachment->path);
                $attachment->delete();
            }

            // Supprimer la demande
            $leave->delete();

            return redirect()->route('leaves.index')
                ->with('success', 'Votre demande de congé a été annulée avec succès.');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'annulation du congé', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            abort(403, 'Vous n\'avez pas l\'autorisation d\'annuler cette demande de congé.');
        }
    }

    /**
     * Affiche le formulaire d'édition d'une demande de congé
     */
    public function edit(Leave $leave)
    {
        $this->authorize('update', $leave);
        return view('leaves.edit', compact('leave'));
    }

    /**
     * Met à jour une demande de congé
     */
    public function update(Request $request, Leave $leave)
    {
        $this->authorize('update', $leave);

        $validated = $request->validate([
            'type' => 'required|in:' . implode(',', array_keys(Leave::TYPES)),
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

        // Calcul de la durée en jours (en excluant les weekends)
        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);
        $duration = 0;

        for ($date = $start; $date->lte($end); $date->addDay()) {
            if (!$date->isWeekend()) {
                $duration++;
            }
        }

        $leave->update([
            'type' => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'],
            'duration' => $duration
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

        return redirect()->route('leaves.show', $leave)
            ->with('success', 'Votre demande de congé a été mise à jour avec succès.');
    }
}
