<?php

namespace App\Policies;

use App\Models\Payslip;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayslipPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // Les utilisateurs peuvent voir leurs propres bulletins
        // Les administrateurs et RH peuvent voir tous les bulletins
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Payslip $payslip)
    {
        // L'utilisateur peut voir ses propres bulletins
        if ($user->id === $payslip->user_id) {
            return true;
        }

        // Les administrateurs et RH peuvent voir tous les bulletins
        return $user->isAdmin() || $user->isHR();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // Seuls les administrateurs et RH peuvent créer des bulletins
        return $user->isAdmin() || $user->isHR();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Payslip $payslip)
    {
        // Seuls les administrateurs et RH peuvent modifier des bulletins
        return $user->isAdmin() || $user->isHR();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Payslip $payslip)
    {
        // Seuls les administrateurs peuvent supprimer des bulletins
        // Et uniquement s'ils sont en brouillon
        return $user->isAdmin() && $payslip->status === Payslip::STATUS_DRAFT;
    }
}
