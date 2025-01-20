namespace App\Notifications;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $leave;

    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $status = match ($this->leave->status) {
            'approved' => 'approuvée',
            'rejected' => 'refusée',
            'cancelled' => 'annulée',
            default => $this->leave->status
        };

        $message = (new MailMessage)
            ->subject("Mise à jour de votre demande de congé")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Votre demande de congé du {$this->leave->start_date->format('d/m/Y')} au {$this->leave->end_date->format('d/m/Y')} a été {$status}.");

        if ($this->leave->status === 'approved') {
            $message->line("Votre congé a été validé par {$this->leave->approver->name}.")
                   ->line("Vous pouvez maintenant planifier votre absence.");
        } elseif ($this->leave->status === 'rejected') {
            $message->line("Motif du refus : {$this->leave->rejection_reason}")
                   ->line("Pour plus d'informations, vous pouvez contacter votre responsable.");
        }

        return $message->action('Voir les détails', route('leaves.show', $this->leave))
                      ->line("Merci d'utiliser notre application de gestion des congés.");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'leave_id' => $this->leave->id,
            'status' => $this->leave->status,
            'updated_by' => $this->leave->approved_by,
        ];
    }
}
