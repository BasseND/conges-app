<?php

namespace App\Notifications;

use App\Models\SalaryAdvance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SalaryAdvanceStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $salaryAdvance;
    protected $previousStatus;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SalaryAdvance $salaryAdvance, $previousStatus)
    {
        $this->salaryAdvance = $salaryAdvance;
        $this->previousStatus = $previousStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $statusText = $this->getStatusText();
        $subject = "Mise à jour de votre demande d'avance sur salaire";
        
        $message = (new MailMessage)
            ->subject($subject)
            ->greeting('Bonjour ' . $notifiable->first_name . ',');
            
        if ($this->salaryAdvance->status === 'approved') {
            $message->line('Bonne nouvelle ! Votre demande d\'avance sur salaire a été approuvée.')
                   ->line('**Détails de la demande :**')
                   ->line('• Montant : ' . number_format($this->salaryAdvance->amount, 2, ',', ' ') . ' €')
                   ->line('• Motif : ' . $this->salaryAdvance->reason)
                   ->line('• Date d\'approbation : ' . $this->salaryAdvance->approval_date->format('d/m/Y à H:i'))
                   ->line('Le montant sera versé selon les modalités de remboursement convenues.')
                   ->success();
        } elseif ($this->salaryAdvance->status === 'rejected') {
            $message->line('Nous regrettons de vous informer que votre demande d\'avance sur salaire a été rejetée.')
                   ->line('**Détails de la demande :**')
                   ->line('• Montant : ' . number_format($this->salaryAdvance->amount, 2, ',', ' ') . ' €')
                   ->line('• Motif : ' . $this->salaryAdvance->reason)
                   ->line('• Date de rejet : ' . $this->salaryAdvance->approval_date->format('d/m/Y à H:i'));
                   
            if ($this->salaryAdvance->notes) {
                $message->line('• Commentaires : ' . $this->salaryAdvance->notes);
            }
            
            $message->line('N\'hésitez pas à contacter les ressources humaines pour plus d\'informations.')
                   ->error();
        }
        
        return $message->action('Voir la demande', route('salary-advances.show', $this->salaryAdvance))
                      ->line('Merci de votre confiance.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $statusText = $this->getStatusText();
        
        return [
            'title' => "Mise à jour de votre demande d'avance sur salaire",
            'message' => "Votre demande d'avance sur salaire de " . number_format($this->salaryAdvance->amount, 2, ',', ' ') . " € a été {$statusText}.",
            'salary_advance_id' => $this->salaryAdvance->id,
            'employee_id' => $this->salaryAdvance->user_id,
            'amount' => $this->salaryAdvance->amount,
            'status' => $this->salaryAdvance->status,
            'previous_status' => $this->previousStatus,
            'approval_date' => $this->salaryAdvance->approval_date,
            'notes' => $this->salaryAdvance->notes,
        ];
    }

    /**
     * Get the status text in French.
     *
     * @return string
     */
    private function getStatusText()
    {
        switch ($this->salaryAdvance->status) {
            case 'approved':
                return 'approuvée';
            case 'rejected':
                return 'rejetée';
            case 'paid':
                return 'payée';
            default:
                return $this->salaryAdvance->status;
        }
    }
}