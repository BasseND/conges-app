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
        return $user->id === $leave->user_id || $user->isAdmin() || $user->isDepartmentHead();
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
        return ($user->id === $leave->user_id && $leave->status === 'pending') || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Leave $leave): bool
    {
        return ($user->id === $leave->user_id && $leave->status === 'pending') || $user->isAdmin();
    }

    /**
     * Determine whether the user can approve leaves.
     */
    public function approveLeaves(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }
}
