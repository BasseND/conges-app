<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\LeaveStatusNotification;
use Illuminate\Support\Facades\Mail;
use App\Events\LeaveStatusUpdated;

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
            
            $leave->update([
                'status' => 'approved',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);
            
            // Déclencher l'événement de mise à jour du statut
            event(new LeaveStatusUpdated($leave, $oldStatus, 'approved'));

            // Mettre à jour le solde de congés de l'employé via LeaveBalance
            if ($leave->type === 'annual') {
                $leaveBalance = $leave->user->leaveBalance;
                if ($leaveBalance) {
                    $leaveBalance->decrement('annual_leave_days', $leave->duration);
                }
            } elseif ($leave->type === 'sick') {
                $leaveBalance = $leave->user->leaveBalance;
                if ($leaveBalance) {
                    $leaveBalance->decrement('sick_leave_days', $leave->duration);
                }
            }

            Mail::to($leave->user->email)->send(new LeaveStatusNotification($leave));

            //Log::info('Approbation terminée avec succès', ['leave_id' => $leave->id]);

            return true;
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