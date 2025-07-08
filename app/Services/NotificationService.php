<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Leave;
use App\Models\ExpenseReport;
use App\Models\Contract;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * Créer une notification pour une nouvelle demande de congé
     */
    public function createLeaveRequestNotification(Leave $leave): void
    {
        // Notifier les managers et admins
        $recipients = $this->getLeaveApprovers($leave->user);
        
        foreach ($recipients as $recipient) {
            Notification::createNotification(
                type: Notification::TYPE_LEAVE_REQUEST,
                title: 'Nouvelle demande de congé',
                message: "{$leave->user->first_name} {$leave->user->last_name} a soumis une demande de congé du {$leave->start_date->format('d/m/Y')} au {$leave->end_date->format('d/m/Y')}.",
                userId: $recipient->id,
                createdBy: $leave->user_id,
                data: [
                    'leave_id' => $leave->id,
                    'leave_type' => $leave->type,
                    'duration' => $leave->duration,
                    'url' => route('leaves.show', $leave)
                ],
                priority: Notification::PRIORITY_NORMAL,
                category: Notification::CATEGORY_LEAVE
            );
        }
    }

    /**
     * Créer une notification pour l'approbation d'un congé
     */
    public function createLeaveApprovedNotification(Leave $leave): void
    {
        Notification::createNotification(
            type: Notification::TYPE_LEAVE_APPROVED,
            title: 'Congé approuvé',
            message: "Votre demande de congé du {$leave->start_date->format('d/m/Y')} au {$leave->end_date->format('d/m/Y')} a été approuvée.",
            userId: $leave->user_id,
            createdBy: $leave->approved_by,
            data: [
                'leave_id' => $leave->id,
                'leave_type' => $leave->type,
                'duration' => $leave->duration,
                'url' => route('leaves.show', $leave)
            ],
            priority: Notification::PRIORITY_NORMAL,
            category: Notification::CATEGORY_LEAVE
        );
    }

    /**
     * Créer une notification pour le rejet d'un congé
     */
    public function createLeaveRejectedNotification(Leave $leave): void
    {
        Notification::createNotification(
            type: Notification::TYPE_LEAVE_REJECTED,
            title: 'Congé refusé',
            message: "Votre demande de congé du {$leave->start_date->format('d/m/Y')} au {$leave->end_date->format('d/m/Y')} a été refusée.",
            userId: $leave->user_id,
            createdBy: $leave->approved_by,
            data: [
                'leave_id' => $leave->id,
                'leave_type' => $leave->type,
                'duration' => $leave->duration,
                'rejection_reason' => $leave->rejection_reason,
                'url' => route('leaves.show', $leave)
            ],
            priority: Notification::PRIORITY_HIGH,
            category: Notification::CATEGORY_LEAVE
        );
    }

    /**
     * Créer une notification pour une nouvelle note de frais
     */
    public function createExpenseRequestNotification(ExpenseReport $expenseReport): void
    {
        // Notifier les admins et RH
        $recipients = User::whereIn('role', ['admin', 'hr'])->get();
        
        foreach ($recipients as $recipient) {
            Notification::createNotification(
                type: Notification::TYPE_EXPENSE_REQUEST,
                title: 'Nouvelle note de frais',
                message: "{$expenseReport->user->first_name} {$expenseReport->user->last_name} a soumis une note de frais de {$expenseReport->total_amount}€.",
                userId: $recipient->id,
                createdBy: $expenseReport->user_id,
                data: [
                    'expense_report_id' => $expenseReport->id,
                    'total_amount' => $expenseReport->total_amount,
                    'url' => route('expense-reports.show', $expenseReport)
                ],
                priority: Notification::PRIORITY_NORMAL,
                category: Notification::CATEGORY_EXPENSE
            );
        }
    }

    /**
     * Créer une notification pour l'approbation d'une note de frais
     */
    public function createExpenseApprovedNotification(ExpenseReport $expenseReport): void
    {
        Notification::createNotification(
            type: Notification::TYPE_EXPENSE_APPROVED,
            title: 'Note de frais approuvée',
            message: "Votre note de frais de {$expenseReport->total_amount}€ a été approuvée.",
            userId: $expenseReport->user_id,
            createdBy: $expenseReport->approved_by,
            data: [
                'expense_report_id' => $expenseReport->id,
                'total_amount' => $expenseReport->total_amount,
                'url' => route('expense-reports.show', $expenseReport)
            ],
            priority: Notification::PRIORITY_NORMAL,
            category: Notification::CATEGORY_EXPENSE
        );
    }

    /**
     * Créer une notification pour le rejet d'une note de frais
     */
    public function createExpenseRejectedNotification(ExpenseReport $expenseReport): void
    {
        Notification::createNotification(
            type: Notification::TYPE_EXPENSE_REJECTED,
            title: 'Note de frais refusée',
            message: "Votre note de frais de {$expenseReport->total_amount}€ a été refusée.",
            userId: $expenseReport->user_id,
            createdBy: $expenseReport->approved_by,
            data: [
                'expense_report_id' => $expenseReport->id,
                'total_amount' => $expenseReport->total_amount,
                'rejection_reason' => $expenseReport->rejection_reason,
                'url' => route('expense-reports.show', $expenseReport)
            ],
            priority: Notification::PRIORITY_HIGH,
            category: Notification::CATEGORY_EXPENSE
        );
    }

    /**
     * Créer une notification pour le paiement d'une note de frais
     */
    public function createExpensePaidNotification(ExpenseReport $expenseReport): void
    {
        Notification::createNotification(
            type: Notification::TYPE_EXPENSE_PAID,
            title: 'Note de frais payée',
            message: "Votre note de frais de {$expenseReport->total_amount}€ a été payée.",
            userId: $expenseReport->user_id,
            createdBy: $expenseReport->paid_by,
            data: [
                'expense_report_id' => $expenseReport->id,
                'total_amount' => $expenseReport->total_amount,
                'paid_at' => $expenseReport->paid_at,
                'url' => route('expense-reports.show', $expenseReport)
            ],
            priority: Notification::PRIORITY_NORMAL,
            category: Notification::CATEGORY_EXPENSE
        );
    }

    /**
     * Créer une notification pour un nouvel utilisateur
     */
    public function createUserCreatedNotification(User $user): void
    {
        // Notifier les admins et RH
        $recipients = User::whereIn('role', ['admin', 'hr'])
            ->where('id', '!=', $user->id)
            ->get();
        
        foreach ($recipients as $recipient) {
            Notification::createNotification(
                type: Notification::TYPE_USER_CREATED,
                title: 'Nouvel utilisateur créé',
                message: "Un nouvel utilisateur {$user->first_name} {$user->last_name} ({$user->email}) a été créé.",
                userId: $recipient->id,
                createdBy: auth()->id(),
                data: [
                    'user_id' => $user->id,
                    'user_role' => $user->role,
                    'url' => route('admin.users.show', $user)
                ],
                priority: Notification::PRIORITY_LOW,
                category: Notification::CATEGORY_USER
            );
        }
    }

    /**
     * Créer une notification pour un contrat qui expire bientôt
     */
    public function createContractExpiringNotification(Contract $contract): void
    {
        // Notifier l'utilisateur concerné
        Notification::createNotification(
            type: Notification::TYPE_CONTRACT_EXPIRING,
            title: 'Contrat bientôt expiré',
            message: "Votre contrat expire le {$contract->end_date->format('d/m/Y')}. Veuillez contacter les RH.",
            userId: $contract->user_id,
            data: [
                'contract_id' => $contract->id,
                'end_date' => $contract->end_date,
                'days_remaining' => $contract->end_date->diffInDays(now()),
                'url' => route('profile.show')
            ],
            priority: Notification::PRIORITY_HIGH,
            category: Notification::CATEGORY_CONTRACT
        );

        // Notifier les admins et RH
        $recipients = User::whereIn('role', ['admin', 'hr'])->get();
        
        foreach ($recipients as $recipient) {
            Notification::createNotification(
                type: Notification::TYPE_CONTRACT_EXPIRING,
                title: 'Contrat employé bientôt expiré',
                message: "Le contrat de {$contract->user->first_name} {$contract->user->last_name} expire le {$contract->end_date->format('d/m/Y')}.",
                userId: $recipient->id,
                data: [
                    'contract_id' => $contract->id,
                    'user_id' => $contract->user_id,
                    'end_date' => $contract->end_date,
                    'days_remaining' => $contract->end_date->diffInDays(now()),
                    'url' => route('admin.users.show', $contract->user)
                ],
                priority: Notification::PRIORITY_HIGH,
                category: Notification::CATEGORY_CONTRACT
            );
        }
    }

    /**
     * Obtenir les utilisateurs qui peuvent approuver les congés d'un utilisateur
     */
    private function getLeaveApprovers(User $user): Collection
    {
        $approvers = collect();
        
        // Admins et RH
        $approvers = $approvers->merge(
            User::whereIn('role', ['admin', 'hr'])->get()
        );
        
        // Manager du même département
        if ($user->department_id) {
            $approvers = $approvers->merge(
                User::where('department_id', $user->department_id)
                    ->where('role', 'manager')
                    ->get()
            );
            
            // Chef de département
            $approvers = $approvers->merge(
                User::where('department_id', $user->department_id)
                    ->where('role', 'department_head')
                    ->get()
            );
        }
        
        return $approvers->unique('id');
    }

    /**
     * Marquer toutes les notifications d'un utilisateur comme lues
     */
    public function markAllAsReadForUser(int $userId): void
    {
        Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
    }

    /**
     * Supprimer les anciennes notifications (plus de 30 jours)
     */
    public function cleanOldNotifications(): int
    {
        return Notification::where('created_at', '<', now()->subDays(30))
            ->where('is_read', true)
            ->delete();
    }
}