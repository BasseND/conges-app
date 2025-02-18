J'ai une souci pour envoyé un mail de notification aux employés lors leur demande de congés ait été refusée ou validé. 

Voici la methode de validation de la demande de congés :
 // protected function approveLeave(Request $request, Leave $leave)
    protected function approveLeave(Leave $leave)
    {
        //$this->authorize('approve', $leave);

        try {
            Log::info('Début de l\'approbation', ['leave_id' => $leave->id]);
            if (!auth()->user()->canManageUserLeaves($leave->user)) {
                abort(403, 'Vous n\'avez pas le droit de gérer les congés de cet employé.');
            }
            if (!$leave->relationLoaded('user')) {
                $leave->load('user');
            }

            if (!$leave->user || !$leave->user->email) {
                throw new \Exception("Utilisateur ou email manquant pour la demande ID: {$leave->id}");
            }
            if ($leave->status !== 'pending') {
                return back()->with('error', 'Cette demande de congé a déjà été traitée.');
            }

            $leave->update([
                'status' => 'approved',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

            // Mettre à jour le solde de congés de l'employé
            if ($leave->type === 'annual') {
                $leave->user->decrement('annual_leave_days', $leave->duration);
            } elseif ($leave->type === 'sick') {
                $leave->user->decrement('sick_leave_days', $leave->duration);
            }

            Mail::to($leave->user->email)->send(new LeaveStatusNotification($leave));

            Log::info('Approbation terminée avec succès', ['leave_id' => $leave->id]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'approbation', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    Et voici la methode de refus : 
     protected function rejectLeave(Request $request, Leave $leave)
    {
       //  $this->authorize('reject', $leave);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:255',
        ]);

        try {
            Log::info('Début du rejet', ['leave_id' => $leave->id]);

            $leave->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason'],
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

            Mail::to($leave->user->email)->send(new LeaveStatusNotification($leave));

            Log::info('Rejet terminé avec succès', ['leave_id' => $leave->id]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erreur lors du rejet', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    Et voici LeaveStatusNotification : 

    <?php

namespace App\Mail;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LeaveStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;

    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
        Log::info('Construction de la notification', [
            'leave_id' => $leave->id,
            'user_id' => $leave->user->id ?? 'null'
        ]);
    }

    public function build()
    {
        $statusMap = [
            'approved' => 'Approuvée',
            'rejected' => 'Rejetée', 
            'pending' => 'En attente'
        ];

        return $this->view('emails.leave-status-simple')
            ->with([
                'user_email' => $this->leave->user->email ?? 'inconnu@example.com',
                'user_name' => $this->leave->user->name ?? 'Utilisateur',
                //'status' => $statusMap[$this->leave->status],
                'status_label' => $statusMap[$this->leave->status] ?? 'Inconnu',
                'start_date' => $this->leave->start_date->format('d/m/Y'),
                'end_date' => $this->leave->end_date->format('d/m/Y'),
                'rejection_reason' => $this->leave->rejection_reason
            ])
            ->subject('Mise à jour de votre demande de congé');
    }
}

Et voici la vue emails.leave-status-simple.blade.php :
<div class="container">
        <h1 class="header">Statut de votre demande de congé</h1>
        
        <p>Bonjour {{ $leave->user->name }},</p>

        <p>Votre demande de congé a été mise à jour.</p>

        @if($user_email)
        <p>Bonjour {{ $user_name ?? 'collaborateur' }},</p>
        
        <div class="status {{ $status === 'approved' ? 'approved' : 'rejected' }}">
            Statut actuel : {{ $status === 'approved' ? 'Approuvée ✅' : 'Rejetée ❌' }}
        </div>

        <div class="details">
            <p><strong>Période :</strong> Du {{ $start_date }} au {{ $end_date }}</p>
            @if($status === 'rejected' && $rejection_reason)
            <p><strong>Motif du refus :</strong> {{ $rejection_reason }}</p>
            @endif
        </div>
        @else
        <p class="error">⚠️ Erreur : Destinataire inconnu</p>
        @endif

        <a href="{{ url("/leaves/{$leave->id}") }}" class="button">Voir les détails</a>

        <p>Cordialement,<br>
        {{ config('app.name') }}</p>
    </div>

    Et voici la config mail dans .env :

    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=608e620e27ed19
    MAIL_PASSWORD=my_pass_word
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"

    L'envoie de message ne marche pas.