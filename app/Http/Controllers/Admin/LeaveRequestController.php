<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $query = Leave::with(['user', 'user.department', 'attachments']);

        // Si c'est un manager, ne montrer que les demandes de son département
        if (auth()->user()->role === 'manager') {
            $departmentId = auth()->user()->department_id;
            $query->whereHas('user', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $leaves = $query->orderBy('created_at', 'desc')->get();

        return view('admin.leaves.index', compact('leaves'));
    }

    public function approve(Leave $leave)
    {
        // Vérifier que l'utilisateur a le droit d'approuver cette demande
        if (auth()->user()->role === 'manager' && auth()->user()->department_id !== $leave->user->department_id) {
            return back()->with('error', 'Vous n\'avez pas le droit d\'approuver cette demande');
        }

        // Vérifier que la demande est en attente
        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cette demande ne peut plus être approuvée');
        }

        // Mettre à jour le solde de congés
        $user = $leave->user;
        if ($leave->type === 'annual') {
            $user->annual_leave_days -= $leave->duration;
        } elseif ($leave->type === 'sick') {
            $user->sick_leave_days -= $leave->duration;
        }
        $user->save();

        // Approuver la demande
        $leave->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        return back()->with('success', 'Demande approuvée avec succès');
    }

    public function reject(Request $request, Leave $leave)
    {
        // Vérifier que l'utilisateur a le droit de rejeter cette demande
        if (auth()->user()->role === 'manager' && auth()->user()->department_id !== $leave->user->department_id) {
            return back()->with('error', 'Vous n\'avez pas le droit de rejeter cette demande');
        }

        // Vérifier que la demande est en attente
        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cette demande ne peut plus être rejetée');
        }

        // Valider le motif du rejet
        $request->validate([
            'rejection_reason' => 'required|string|min:10'
        ]);

        // Rejeter la demande
        $leave->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        return back()->with('success', 'Demande rejetée avec succès');
    }
}
