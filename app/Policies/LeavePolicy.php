<?php

namespace App\Policies;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeavePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Tout utilisateur authentifié peut voir la liste des congés
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Leave $leave): bool
    {
        return $user->isAdmin() 
            || $user->id === $leave->user_id 
            || ($user->isManager() && $user->department_id === $leave->user->department_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Tout utilisateur authentifié peut créer une demande
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Leave $leave): bool
    {
        return $user->id === $leave->user_id && $leave->status === 'pending';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Leave $leave): bool
    {
        \Log::info('Tentative de suppression de congé', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'leave_user_id' => $leave->user_id,
            'leave_status' => $leave->status,
            'is_owner' => $user->id === $leave->user_id,
            'is_admin' => $user->isAdmin(),
            'is_pending' => $leave->status === 'pending'
        ]);

        // Un utilisateur ne peut annuler que ses propres congés en attente
        // Un admin peut annuler n'importe quelle demande en attente
        $canDelete = ($user->id === $leave->user_id && $leave->status === 'pending')
            || ($user->isAdmin() && $leave->status === 'pending');

        \Log::info('Résultat autorisation', ['can_delete' => $canDelete]);

        return $canDelete;
    }

    /**
     * Determine whether the user can approve leaves.
     */
    public function approveLeaves(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }
}
