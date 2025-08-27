<?php

namespace App\Listeners;

use App\Events\SalaryAdvanceStatusUpdated;
use App\Notifications\SalaryAdvanceStatusUpdated as SalaryAdvanceStatusUpdatedNotification;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSalaryAdvanceStatusNotification implements ShouldQueue
{
    use InteractsWithQueue;

    protected $notificationService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SalaryAdvanceStatusUpdated  $event
     * @return void
     */
    public function handle(SalaryAdvanceStatusUpdated $event)
    {
        $salaryAdvance = $event->salaryAdvance;
        $previousStatus = $event->previousStatus;
        
        // Notifier l'auteur de la demande si le statut a changé vers approuvé ou rejeté
        if (in_array($salaryAdvance->status, ['approved', 'rejected'])) {
            // Envoyer une notification email directe à l'utilisateur
            $salaryAdvance->user->notify(new SalaryAdvanceStatusUpdatedNotification($salaryAdvance, $previousStatus));
        }
    }
}