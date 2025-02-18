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
                'status' => $statusMap[$this->leave->status],
                'status_label' => $statusMap[$this->leave->status] ?? 'Inconnu',
                'start_date' => $this->leave->start_date->format('d/m/Y'),
                'end_date' => $this->leave->end_date->format('d/m/Y'),
                'rejection_reason' => $this->leave->rejection_reason
            ])
            ->subject('Mise à jour de votre demande de congé');
    }
}