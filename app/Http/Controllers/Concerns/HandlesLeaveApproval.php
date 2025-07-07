<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\LeaveStatusNotification;
use Illuminate\Support\Facades\Mail;

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

            $leave->update([
                'status' => 'approved',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

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
            $leave->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason'],
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

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