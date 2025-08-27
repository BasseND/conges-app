<?php

namespace App\Notifications;

use App\Models\SalaryAdvance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSalaryAdvanceRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $salaryAdvance;

    public function __construct(SalaryAdvance $salaryAdvance)
    {
        $this->salaryAdvance = $salaryAdvance;
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
        $employee = $this->salaryAdvance->user;
        
        return (new MailMessage)
            ->subject("Nouvelle demande d'avance sur salaire à examiner")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("{$employee->name} a créé une nouvelle demande d'avance sur salaire.")
            ->line("Détails de la demande :")
            ->line("- Montant : " . number_format($this->salaryAdvance->amount, 2, ',', ' ') . " €")
            ->line("- Motif : {$this->salaryAdvance->reason}")
            ->line("- Date de demande : {$this->salaryAdvance->request_date->format('d/m/Y')}")
            ->line("- Statut : En attente")
            ->action('Examiner la demande', route('salary-advances.show', $this->salaryAdvance))
            ->line("Cette demande nécessitera votre validation une fois soumise par l'employé.");
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => "Nouvelle demande d'avance sur salaire",
            'message' => "Nouvelle demande d'avance sur salaire de {$this->salaryAdvance->user->name}",
            'salary_advance_id' => $this->salaryAdvance->id,
            'employee_id' => $this->salaryAdvance->user_id,
            'employee_name' => $this->salaryAdvance->user->name,
            'amount' => $this->salaryAdvance->amount,
            'reason' => $this->salaryAdvance->reason,
            'request_date' => $this->salaryAdvance->request_date->format('Y-m-d'),
            'department_id' => $this->salaryAdvance->user->department_id,
        ];
    }
}