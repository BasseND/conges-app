<?php

namespace App\Listeners;

use App\Events\SalaryAdvanceCreated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSalaryAdvanceNotification implements ShouldQueue
{
    use InteractsWithQueue;

    protected NotificationService $notificationService;

    /**
     * Create the event listener.
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(SalaryAdvanceCreated $event): void
    {
        $this->notificationService->createSalaryAdvanceRequestNotification($event->salaryAdvance);
    }
}