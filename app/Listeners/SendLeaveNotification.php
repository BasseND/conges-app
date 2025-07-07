<?php

namespace App\Listeners;

use App\Events\LeaveCreated;
use App\Events\LeaveStatusUpdated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLeaveNotification implements ShouldQueue
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
    public function handle(LeaveCreated|LeaveStatusUpdated $event): void
    {
        if ($event instanceof LeaveCreated) {
            $this->notificationService->createLeaveRequestNotification($event->leave);
        }
        
        if ($event instanceof LeaveStatusUpdated) {
            match ($event->newStatus) {
                'approved' => $this->notificationService->createLeaveApprovedNotification($event->leave),
                'rejected' => $this->notificationService->createLeaveRejectedNotification($event->leave),
                default => null,
            };
        }
    }
}