<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\LeaveStatusNotification;
use Illuminate\Support\Facades\Mail;

class LeaveApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:approve-leaves']);
    }

    public function approve(Request $request, Leave $leave)
    {
    
        $user_email = $leave->user->email;
        $user_name = $leave->user->name;
        $start_date = $leave->start_date->format('d/m/Y');
        $end_date = $leave->end_date->format('d/m/Y');
        $status = $leave->status;
      

        if (!$leave->user()->exists()) {
            Log::error('Aucun utilisateur associé à la demande', ['leave_id' => $leave->id]);
            return back()->withErrors(['error' => 'Aucun utilisateur associé à cette demande']);
        }

        try {
            Log::info('Début de l\'approbation', ['leave_id' => $leave->id]);

            if (!$leave->relationLoaded('user')) {
                $leave->load('user');
            }
    
            if (!$leave->user || !$leave->user->email) {
                throw new \Exception("Utilisateur ou email manquant pour la demande ID: {$leave->id}");
            }

            $leave->update([
                'status' => 'approved',
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);

            // Envoi de l'email de notification
            Mail::to($user_email)->send(new LeaveStatusNotification($leave));

            Log::info('Approbation terminée avec succès', ['leave_id' => $leave->id]);

            return back()->with('success', 'La demande de congé a été approuvée.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'approbation', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'approbation.']);
        }
    }

    public function reject(Request $request, Leave $leave)
    {
        $validated = $request->validate([
             'rejection_reason' => 'required|string|min:10|max:255',
        ]);

        try {
            Log::info('Début du rejet', ['leave_id' => $leave->id]);

            // Ajouter ce log pour vérifier la réception des données
            Log::debug('Données de rejet reçues', [
                'rejection_reason' => $validated['rejection_reason'],
                'leave_id' => $leave->id
            ]);

            $leave->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason'],
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);

            // Envoi de l'email de notification
            Mail::to($user_email)->send(new LeaveStatusNotification($leave));

            Log::info('Rejet terminé avec succès', ['leave_id' => $leave->id]);

            return back()->with('success', 'La demande de congé a été rejetée.');
        } catch (\Exception $e) {
            Log::error('Erreur lors du rejet', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Une erreur est survenue lors du rejet.']);
        }
    }

    public function pending()
    {
        $user = Auth::user();
        
        $leaves = $user->isAdmin()
            ? Leave::pending()->with(['user', 'approver'])->latest()->paginate(10)
            : Leave::pending()
                ->whereHas('user', function($query) use ($user) {
                    $query->where('department_id', $user->department_id);
                })
                ->with(['user', 'approver'])
                ->latest()
                ->paginate(10);

        return view('leaves.pending', compact('leaves'));
    }
}
