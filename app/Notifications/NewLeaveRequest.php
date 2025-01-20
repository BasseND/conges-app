<?php

namespace App\Notifications;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeaveRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $leave;

    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $employee = $this->leave->user;
        
        return (new MailMessage)
            ->subject("Nouvelle demande de congé à valider")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("{$employee->name} a soumis une nouvelle demande de congé.")
            ->line("Détails de la demande :")
            ->line("- Type : " . ucfirst($this->leave->type))
            ->line("- Période : du {$this->leave->start_date->format('d/m/Y')} au {$this->leave->end_date->format('d/m/Y')}")
            ->line("- Durée : {$this->leave->duration_days} jour(s)")
            ->line("- Motif : {$this->leave->reason}")
            ->action('Examiner la demande', route('leaves.show', $this->leave))
            ->line("Merci de traiter cette demande dans les meilleurs délais.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'leave_id' => $this->leave->id,
            'employee_id' => $this->leave->user_id,
            'department_id' => $this->leave->user->department_id,
        ];
    }
}
