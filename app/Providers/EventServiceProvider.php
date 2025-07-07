<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\RedirectAfterRegistration;
use App\Events\LeaveCreated;
use App\Events\LeaveStatusUpdated;
use App\Events\ExpenseReportCreated;
use App\Events\ExpenseReportStatusUpdated;
use App\Events\UserCreated;
use App\Listeners\SendLeaveNotification;
use App\Listeners\SendExpenseNotification;
use App\Listeners\SendUserNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            RedirectAfterRegistration::class,
        ],
        LeaveCreated::class => [
            SendLeaveNotification::class,
        ],
        LeaveStatusUpdated::class => [
            SendLeaveNotification::class,
        ],
        ExpenseReportCreated::class => [
            SendExpenseNotification::class,
        ],
        ExpenseReportStatusUpdated::class => [
            SendExpenseNotification::class,
        ],
        UserCreated::class => [
            SendUserNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
