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
        \Log::info('Creating user notification for: ' . $user->email);
        
        // Notifier les admins et RH
        $recipients = User::whereIn('role', ['admin', 'hr'])
            ->where('id', '!=', $user->id)
            ->get();
        
        \Log::info('Found ' . $recipients->count() . ' recipients for user notification');
        
        foreach ($recipients as $recipient) {
            \Log::info('Creating notification for recipient: ' . $recipient->email);
            
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
            
            \Log::info('Notification created successfully for recipient: ' . $recipient->email);
        }
        
        \Log::info('User notification creation process completed');
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

    /**
     * Créer une notification pour un changement de rôle d'utilisateur
     */
    public function createUserRoleChangedNotification(User $user, string $oldRole, string $newRole): void
    {
        \Log::info('Creating role change notification for user: ' . $user->email);
        
        // Notifier l'utilisateur concerné
        Notification::createNotification(
            type: Notification::TYPE_USER_ROLE_CHANGED,
            title: 'Rôle modifié',
            message: "Votre rôle a été modifié de '{$oldRole}' vers '{$newRole}'.",
            userId: $user->id,
            createdBy: auth()->id(),
            data: [
                'user_id' => $user->id,
                'old_role' => $oldRole,
                'new_role' => $newRole,
                'url' => route('profile.show')
            ],
            priority: Notification::PRIORITY_NORMAL,
            category: Notification::CATEGORY_USER
        );
        
        // Notifier les admins et RH
        $recipients = User::whereIn('role', ['admin', 'hr'])
            ->where('id', '!=', $user->id)
            ->get();
        
        foreach ($recipients as $recipient) {
            Notification::createNotification(
                type: Notification::TYPE_USER_ROLE_CHANGED,
                title: 'Rôle utilisateur modifié',
                message: "Le rôle de {$user->first_name} {$user->last_name} a été modifié de '{$oldRole}' vers '{$newRole}'.",
                userId: $recipient->id,
                createdBy: auth()->id(),
                data: [
                    'user_id' => $user->id,
                    'old_role' => $oldRole,
                    'new_role' => $newRole,
                    'url' => route('admin.users.show', $user)
                ],
                priority: Notification::PRIORITY_LOW,
                category: Notification::CATEGORY_USER
            );
        }
        
        \Log::info('Role change notification creation completed');
    }

    /**
     * Créer une notification pour un changement de département d'utilisateur
     */
    public function createUserDepartmentChangedNotification(User $user, ?int $oldDepartmentId, ?int $newDepartmentId): void
    {
        \Log::info('Creating department change notification for user: ' . $user->email);
        
        $oldDepartmentName = $oldDepartmentId ? \App\Models\Department::find($oldDepartmentId)?->name ?? 'Inconnu' : 'Aucun';
        $newDepartmentName = $newDepartmentId ? \App\Models\Department::find($newDepartmentId)?->name ?? 'Inconnu' : 'Aucun';
        
        // Notifier l'utilisateur concerné
        Notification::createNotification(
            type: Notification::TYPE_USER_DEPARTMENT_CHANGED,
            title: 'Département modifié',
            message: "Votre département a été modifié de '{$oldDepartmentName}' vers '{$newDepartmentName}'.",
            userId: $user->id,
            createdBy: auth()->id(),
            data: [
                'user_id' => $user->id,
                'old_department_id' => $oldDepartmentId,
                'new_department_id' => $newDepartmentId,
                'old_department_name' => $oldDepartmentName,
                'new_department_name' => $newDepartmentName,
                'url' => route('profile.show')
            ],
            priority: Notification::PRIORITY_NORMAL,
            category: Notification::CATEGORY_USER
        );
        
        // Notifier les admins et RH
        $recipients = User::whereIn('role', ['admin', 'hr'])
            ->where('id', '!=', $user->id)
            ->get();
        
        foreach ($recipients as $recipient) {
            Notification::createNotification(
                type: Notification::TYPE_USER_DEPARTMENT_CHANGED,
                title: 'Département utilisateur modifié',
                message: "Le département de {$user->first_name} {$user->last_name} a été modifié de '{$oldDepartmentName}' vers '{$newDepartmentName}'.",
                userId: $recipient->id,
                createdBy: auth()->id(),
                data: [
                    'user_id' => $user->id,
                    'old_department_id' => $oldDepartmentId,
                    'new_department_id' => $newDepartmentId,
                    'old_department_name' => $oldDepartmentName,
                    'new_department_name' => $newDepartmentName,
                    'url' => route('admin.users.show', $user)
                ],
                priority: Notification::PRIORITY_LOW,
                category: Notification::CATEGORY_USER
            );
        }
        
        \Log::info('Department change notification creation completed');
    }

    /**
      * Créer une notification pour la modification d'un contrat
      */
     public function createContractUpdatedNotification(Contract $contract): void
     {
         \Log::info('Creating contract updated notification for contract: ' . $contract->id);
         
         // Charger la relation user si elle n'est pas déjà chargée
         $contract->load('user');
         
         // Notifier l'utilisateur concerné
         Notification::createNotification(
             type: Notification::TYPE_CONTRACT_UPDATED,
             title: 'Contrat modifié',
             message: "Votre contrat a été modifié. Veuillez consulter les détails.",
             userId: $contract->user_id,
             createdBy: auth()->id(),
             data: [
                 'contract_id' => $contract->id,
                 'user_id' => $contract->user_id,
                 'contract_type' => $contract->type,
                 'url' => route('profile.show')
             ],
             priority: Notification::PRIORITY_NORMAL,
             category: Notification::CATEGORY_CONTRACT
         );
         
         // Notifier les admins et RH
         $recipients = User::whereIn('role', ['admin', 'hr'])
             ->where('id', '!=', $contract->user_id)
             ->get();
         
         foreach ($recipients as $recipient) {
             Notification::createNotification(
                 type: Notification::TYPE_CONTRACT_UPDATED,
                 title: 'Contrat employé modifié',
                 message: "Le contrat de {$contract->user->first_name} {$contract->user->last_name} a été modifié.",
                 userId: $recipient->id,
                 createdBy: auth()->id(),
                 data: [
                     'contract_id' => $contract->id,
                     'user_id' => $contract->user_id,
                     'contract_type' => $contract->type,
                     'url' => route('admin.users.show', $contract->user)
                 ],
                 priority: Notification::PRIORITY_LOW,
                 category: Notification::CATEGORY_CONTRACT
             );
         }
         
         \Log::info('Contract updated notification creation completed');
     }

    /**
     * Créer une notification pour une nouvelle demande d'avance sur salaire
     */
    public function createSalaryAdvanceRequestNotification(\App\Models\SalaryAdvance $salaryAdvance): void
    {
        \Log::info('Creating salary advance notification for: ' . $salaryAdvance->user->email);
        
        // Notifier les admins et RH
        $recipients = User::whereIn('role', ['admin', 'hr'])->get();
        
        \Log::info('Found ' . $recipients->count() . ' recipients for salary advance notification');
        
        foreach ($recipients as $recipient) {
            \Log::info('Creating notification for recipient: ' . $recipient->email);
            
            Notification::createNotification(
                type: Notification::TYPE_SALARY_ADVANCE_REQUEST,
                title: "Nouvelle demande d'avance sur salaire",
                message: "{$salaryAdvance->user->first_name} {$salaryAdvance->user->last_name} a créé une demande d'avance sur salaire de " . number_format($salaryAdvance->amount, 2, ',', ' ') . " €.",
                userId: $recipient->id,
                createdBy: $salaryAdvance->user_id,
                data: [
                    'salary_advance_id' => $salaryAdvance->id,
                    'amount' => $salaryAdvance->amount,
                    'reason' => $salaryAdvance->reason,
                    'request_date' => $salaryAdvance->request_date->format('Y-m-d'),
                    'url' => route('salary-advances.show', $salaryAdvance)
                ],
                priority: Notification::PRIORITY_NORMAL,
                category: Notification::CATEGORY_SALARY_ADVANCE
            );
            
            \Log::info('Notification created successfully for recipient: ' . $recipient->email);
        }
        
        \Log::info('Salary advance notification creation process completed');
    }

    /**
     * Créer une notification pour un changement de statut d'avance sur salaire
     */
    public function createSalaryAdvanceStatusNotification(\App\Models\SalaryAdvance $salaryAdvance, string $previousStatus): void
    {
        \Log::info('Creating salary advance status notification for: ' . $salaryAdvance->user->email);
        
        $statusText = $this->getSalaryAdvanceStatusText($salaryAdvance->status);
        $previousStatusText = $this->getSalaryAdvanceStatusText($previousStatus);
        
        // Notifier l'auteur de la demande
        Notification::createNotification(
            type: Notification::TYPE_SALARY_ADVANCE_STATUS_UPDATED,
            title: "Mise à jour de votre demande d'avance sur salaire",
            message: "Votre demande d'avance sur salaire de " . number_format($salaryAdvance->amount, 2, ',', ' ') . " € a été {$statusText}.",
            userId: $salaryAdvance->user_id,
            createdBy: $salaryAdvance->approved_by ?? auth()->id(),
            data: [
                'salary_advance_id' => $salaryAdvance->id,
                'amount' => $salaryAdvance->amount,
                'status' => $salaryAdvance->status,
                'previous_status' => $previousStatus,
                'approval_date' => $salaryAdvance->approval_date?->format('Y-m-d H:i:s'),
                'notes' => $salaryAdvance->notes,
                'url' => route('salary-advances.show', $salaryAdvance)
            ],
            priority: Notification::PRIORITY_HIGH,
            category: Notification::CATEGORY_SALARY_ADVANCE
        );
        
        \Log::info('Salary advance status notification created successfully');
    }

    /**
     * Obtenir le texte du statut en français
     */
    private function getSalaryAdvanceStatusText(string $status): string
    {
        return match($status) {
            'pending' => 'en attente',
            'submitted' => 'soumise',
            'approved' => 'approuvée',
            'rejected' => 'rejetée',
            'paid' => 'payée',
            'cancelled' => 'annulée',
            default => $status
        };
    }
}