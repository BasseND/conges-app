<?php

namespace App\Policies;

use App\Models\PayrollSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayrollSettingPolicy
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
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PayrollSetting  $payrollSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PayrollSetting $payrollSetting)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PayrollSetting  $payrollSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PayrollSetting $payrollSetting)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PayrollSetting  $payrollSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PayrollSetting $payrollSetting)
    {
        return $user->isAdmin();
    }
}
