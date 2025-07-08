<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendUserUpdateNotification implements ShouldQueue
{
    use InteractsWithQueue;

    protected $notificationService;

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
    public function handle(UserUpdated $event): void
    {
        Log::info('UserUpdated event received for user: ' . $event->user->email);
        
        // Vérifier si le rôle a changé
        if (isset($event->oldData['role']) && isset($event->newData['role']) && 
            $event->oldData['role'] !== $event->newData['role']) {
            
            Log::info('Role changed from ' . $event->oldData['role'] . ' to ' . $event->newData['role']);
            
            // Créer une notification pour le changement de rôle
            $this->notificationService->createUserRoleChangedNotification(
                $event->user, 
                $event->oldData['role'], 
                $event->newData['role']
            );
        }
        
        // Vérifier si le département a changé
        if (isset($event->oldData['department_id']) && isset($event->newData['department_id']) && 
            $event->oldData['department_id'] !== $event->newData['department_id']) {
            
            Log::info('Department changed from ' . $event->oldData['department_id'] . ' to ' . $event->newData['department_id']);
            
            // Créer une notification pour le changement de département
            $this->notificationService->createUserDepartmentChangedNotification(
                $event->user, 
                $event->oldData['department_id'], 
                $event->newData['department_id']
            );
        }
        
        Log::info('UserUpdated event processed successfully for user: ' . $event->user->email);
    }
}