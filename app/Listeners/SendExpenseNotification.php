<?php

namespace App\Listeners;

use App\Events\ExpenseReportCreated;
use App\Events\ExpenseReportStatusUpdated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendExpenseNotification implements ShouldQueue
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
    public function handle(ExpenseReportCreated|ExpenseReportStatusUpdated $event): void
    {
        if ($event instanceof ExpenseReportCreated) {
            $this->notificationService->createExpenseRequestNotification($event->expenseReport);
        }
        
        if ($event instanceof ExpenseReportStatusUpdated) {
            match ($event->newStatus) {
                'approved' => $this->notificationService->createExpenseApprovedNotification($event->expenseReport),
                'rejected' => $this->notificationService->createExpenseRejectedNotification($event->expenseReport),
                'paid' => $this->notificationService->createExpensePaidNotification($event->expenseReport),
                default => null,
            };
        }
    }
}