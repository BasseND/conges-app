<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Leave;
use App\Models\LeaveTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\LeaveStatusNotification;
use Illuminate\Support\Facades\Mail;
use App\Events\LeaveStatusUpdated;
use App\Services\LeaveBalanceService;
use Illuminate\Support\Facades\DB;

trait HandlesLeaveApproval
{
    // protected function approveLeave(Request $request, Leave $leave)
    protected function approveLeave(Leave $leave)
    {
        //$this->authorize('approve', $leave);

        try {
            Log::info('Début de l\'approbation', ['leave_id' => $leave->id]);
            if (!auth()->user()->canManageUserLeaves($leave->user)) {
                abort(403, 'Vous n\'avez pas le droit de gérer les congés de cet employé.');
            }
            if (!$leave->relationLoaded('user')) {
                $leave->load('user');
            }

            if (!$leave->user || !$leave->user->email) {
                throw new \Exception("Utilisateur ou email manquant pour la demande ID: {$leave->id}");
            }
            if ($leave->status !== 'pending') {
                return back()->with('error', 'Cette demande de congé a déjà été traitée.');
            }

            $oldStatus = $leave->status;

            return DB::transaction(function () use ($leave, $oldStatus) {
                $leave->update([
                    'status' => 'approved',
                    'processed_by' => auth()->id(),
                    'processed_at' => now(),
                ]);

                // Décrémenter le solde via le service si le type a un solde limité
                if ($leave->specialLeaveType && $leave->specialLeaveType->hasBalance()) {
                    $leaveBalanceService = app(LeaveBalanceService::class);
                    $decremented = $leaveBalanceService->decrementBalance($leave);
                    if (!$decremented) {
                        throw new \RuntimeException('Solde insuffisant pour décrémenter ce congé.');
                    }
                }

                // Créer une transaction de déduction pour le congé approuvé
                if ($leave->specialLeaveType && in_array($leave->specialLeaveType->system_name, ['annual', 'maternity', 'paternity', 'special', 'sick', 'conge_annuel', 'maternite', 'paternite', 'maladie'])) {
                    LeaveTransaction::createTransaction(
                        userId: $leave->user_id,
                        leaveType: $leave->specialLeaveType->system_name,
                        transactionType: 'deduction',
                        amount: -$leave->duration_days, // Négatif car c'est une déduction
                        leaveId: $leave->id,
                        description: "Déduction pour congé approuvé (ID: {$leave->id})",
                        metadata: [
                            'leave_start_date' => $leave->start_date->format('Y-m-d'),
                            'leave_end_date' => $leave->end_date->format('Y-m-d'),
                            'leave_duration' => $leave->duration_days,
                            'leave_type' => $leave->specialLeaveType->system_name
                        ],
                        createdBy: auth()->id()
                    );
                }

                // Déclencher l'événement de mise à jour du statut
                event(new LeaveStatusUpdated($leave, $oldStatus, 'approved'));

                Mail::to($leave->user->email)->send(new LeaveStatusNotification($leave));

                return true;
            });
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'approbation', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    protected function rejectLeave(Request $request, Leave $leave)
    {
       //  $this->authorize('reject', $leave);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:255',
        ]);

        try {
            $oldStatus = $leave->status;
            
            $leave->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason'],
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);
            
            // Déclencher l'événement de mise à jour du statut
            event(new LeaveStatusUpdated($leave, $oldStatus, 'rejected'));

            Mail::to($leave->user->email)->send(new LeaveStatusNotification($leave));
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur lors du rejet', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}