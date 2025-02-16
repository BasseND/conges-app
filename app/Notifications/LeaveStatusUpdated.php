<?php

namespace App\Notifications;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class LeaveStatusUpdated extends Notification
{
    use Queueable;

    protected $leave;

    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
        Log::info('LeaveStatusUpdated notification créée', [
            'leave_id' => $leave->id,
            'user_id' => $leave->user->id,
            'status' => $leave->status
        ]);
    }

    public function via($notifiable)
    {
        Log::info('Via appelé pour notification', [
            'channels' => ['mail'],
            'notifiable' => $notifiable->email ?? 'no email'
        ]);
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $status = match ($this->leave->status) {
            'approved' => 'approuvée',
            'rejected' => 'refusée',
            'cancelled' => 'annulée',
            default => $this->leave->status
        };

        Log::info('Construction du mail de notification', [
            'status' => $status,
            'user_email' => $notifiable->email ?? 'no email',
            'leave_dates' => [
                'start' => $this->leave->start_date->format('d/m/Y'),
                'end' => $this->leave->end_date->format('d/m/Y')
            ]
        ]);

        $message = (new MailMessage)
            ->subject("Mise à jour de votre demande de congé")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Votre demande de congé du {$this->leave->start_date->format('d/m/Y')} au {$this->leave->end_date->format('d/m/Y')} a été {$status}.");

        if ($this->leave->status === 'approved') {
            $message->line("Votre congé a été validé.");
        } elseif ($this->leave->status === 'rejected' && $this->leave->rejection_reason) {
            $message->line("Motif du refus : {$this->leave->rejection_reason}");
        }

        return $message
            ->action('Voir les détails', url("/leaves/{$this->leave->id}"))
            ->line("Merci d'utiliser notre application de gestion des congés.");
    }

    public function toArray($notifiable)
    {
        return [
            'leave_id' => $this->leave->id,
            'status' => $this->leave->status,
        ];
    }
}
