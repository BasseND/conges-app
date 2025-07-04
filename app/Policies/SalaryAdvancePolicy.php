<?php

namespace App\Policies;

use App\Models\SalaryAdvance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryAdvancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the salary advance.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SalaryAdvance  $salaryAdvance
     * @return bool
     */
    public function view(User $user, SalaryAdvance $salaryAdvance)
    {
        // L'utilisateur peut voir ses propres avances sur salaire
        if ($user->id === $salaryAdvance->user_id) {
            return true;
        }

        // Les administrateurs peuvent voir toutes les avances
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can cancel the salary advance.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SalaryAdvance  $salaryAdvance
     * @return bool
     */
    public function cancel(User $user, SalaryAdvance $salaryAdvance)
    {
        // L'utilisateur ne peut annuler que ses propres avances sur salaire en attente
        return $user->id === $salaryAdvance->user_id && $salaryAdvance->status === SalaryAdvance::STATUS_PENDING;
    }
}
