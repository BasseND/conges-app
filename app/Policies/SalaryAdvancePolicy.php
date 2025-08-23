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

        // Les RH peuvent voir toutes les avances sur salaire
        if ($user->isHR()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can submit the salary advance.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SalaryAdvance  $salaryAdvance
     * @return bool
     */
    public function submit(User $user, SalaryAdvance $salaryAdvance)
    {
        // L'utilisateur ne peut soumettre que ses propres avances sur salaire en attente
        return $user->id === $salaryAdvance->user_id && $salaryAdvance->status === SalaryAdvance::STATUS_PENDING;
    }

    /**
     * Determine whether the user can approve the salary advance.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SalaryAdvance  $salaryAdvance
     * @return bool
     */
    public function approve(User $user, SalaryAdvance $salaryAdvance)
    {
        // Seuls les RH peuvent approuver les demandes soumises
        return $user->isHR() && $salaryAdvance->status === SalaryAdvance::STATUS_SUBMITTED;
    }

    /**
     * Determine whether the user can reject the salary advance.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SalaryAdvance  $salaryAdvance
     * @return bool
     */
    public function reject(User $user, SalaryAdvance $salaryAdvance)
    {
        // Seuls les RH peuvent rejeter les demandes soumises
        return $user->isHR() && $salaryAdvance->status === SalaryAdvance::STATUS_SUBMITTED;
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
