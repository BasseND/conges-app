<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserNotification implements ShouldQueue
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
    public function handle(UserCreated $event): void
    {
        \Log::info('UserCreated event triggered for user: ' . $event->user->email);
        $this->notificationService->createUserCreatedNotification($event->user);
        \Log::info('Notification creation completed for user: ' . $event->user->email);
    }
}