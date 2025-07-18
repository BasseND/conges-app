<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\LeaveTransaction;
use Illuminate\Support\Facades\DB;

class InitializeLeaveTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:initialize-transactions {--force : Force l\'initialisation même si des transactions existent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialise les transactions de congés pour tous les utilisateurs existants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de l\'initialisation des transactions de congés...');

        // Vérifier s'il y a déjà des transactions
        $existingTransactions = LeaveTransaction::count();
        if ($existingTransactions > 0 && !$this->option('force')) {
            $this->warn("Il y a déjà {$existingTransactions} transactions dans la base de données.");
            if (!$this->confirm('Voulez-vous continuer quand même ?')) {
                $this->info('Opération annulée.');
                return 0;
            }
        }

        $users = User::with(['leaveBalance', 'department.leaveBalance', 'company'])->get();
        $this->info("Traitement de {$users->count()} utilisateurs...");

        $progressBar = $this->output->createProgressBar($users->count());
        $progressBar->start();

        DB::transaction(function () use ($users, $progressBar) {
            foreach ($users as $user) {
                $this->initializeUserTransactions($user);
                $progressBar->advance();
            }
        });

        $progressBar->finish();
        $this->newLine();
        $this->info('Initialisation terminée avec succès!');

        return 0;
    }

    /**
     * Initialise les transactions pour un utilisateur
     */
    private function initializeUserTransactions(User $user)
    {
        $leaveTypes = [
            'annual' => $user->annual_leave_days,
            'maternity' => $user->maternity_leave_days,
            'paternity' => $user->paternity_leave_days,
            'special' => $user->special_leave_days,
            'sick' => 0 // Les congés maladie n'ont généralement pas d'allocation initiale
        ];

        foreach ($leaveTypes as $leaveType => $allocation) {
            if ($allocation > 0) {
                // Vérifier s'il n'y a pas déjà une transaction d'allocation pour ce type
                $existingAllocation = LeaveTransaction::where('user_id', $user->id)
                    ->where('leave_type', $leaveType)
                    ->where('transaction_type', 'allocation')
                    ->exists();

                if (!$existingAllocation) {
                    LeaveTransaction::createTransaction(
                        userId: $user->id,
                        leaveType: $leaveType,
                        transactionType: 'allocation',
                        amount: $allocation,
                        description: "Allocation initiale de congés {$leaveType} pour l'année " . now()->year,
                        metadata: [
                            'year' => now()->year,
                            'source' => 'initial_allocation',
                            'user_leave_balance_id' => $user->leave_balance_id,
                            'department_id' => $user->department_id,
                            'company_id' => $user->company_id
                        ],
                        createdBy: 1 // Système
                    );
                }
            }
        }

        // Décrémenter pour les congés déjà approuvés cette année
        $approvedLeaves = $user->leaves()
            ->whereYear('start_date', now()->year)
            ->where('status', 'approved')
            ->get();

        foreach ($approvedLeaves as $leave) {
            // Vérifier s'il n'y a pas déjà une transaction de déduction pour ce congé
            $existingDeduction = LeaveTransaction::where('leave_id', $leave->id)
                ->where('transaction_type', 'deduction')
                ->exists();

            if (!$existingDeduction && in_array($leave->type, ['annual', 'maternity', 'paternity', 'special', 'sick'])) {
                LeaveTransaction::createTransaction(
                    userId: $user->id,
                    leaveType: $leave->type,
                    transactionType: 'deduction',
                    amount: -$leave->duration,
                    leaveId: $leave->id,
                    description: "Déduction pour congé approuvé (ID: {$leave->id}) - Migration",
                    metadata: [
                        'leave_start_date' => $leave->start_date->format('Y-m-d'),
                        'leave_end_date' => $leave->end_date->format('Y-m-d'),
                        'leave_duration' => $leave->duration,
                        'leave_type' => $leave->type,
                        'migration' => true
                    ],
                    createdBy: 1 // Système
                );
            }
        }
    }
}