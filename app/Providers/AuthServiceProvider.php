<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Leave;
use App\Models\SalaryAdvance;
use App\Models\PayrollSetting;
use App\Models\Payslip;
use App\Models\Message;
use App\Policies\LeavePolicy;
use App\Policies\SalaryAdvancePolicy;
use App\Policies\PayrollSettingPolicy;
use App\Policies\PayslipPolicy;
use App\Policies\MessagePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Leave::class => LeavePolicy::class,
        SalaryAdvance::class => SalaryAdvancePolicy::class,
        PayrollSetting::class => PayrollSettingPolicy::class,
        Payslip::class => PayslipPolicy::class,
        Message::class => MessagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('approve-leaves', function (User $user) {
            return $user->isAdmin() || $user->isDepartmentHead();
        });

        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('manage-departments', function (User $user) {
            return $user->isAdmin();
        });
    }
}
