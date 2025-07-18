<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\LeaveTransaction;
use Illuminate\Support\Facades\DB;

class AllocateAnnualLeave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:allocate-annual {--year= : L\'année pour laquelle allouer les congés (par défaut: année courante)} {--user= : ID de l\'utilisateur spécifique (optionnel)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alloue les congés annuels pour tous les utilisateurs ou un utilisateur spécifique';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $year = $this->option('year') ?? now()->year;
        $userId = $this->option('user');

        $this->info("Allocation des congés annuels pour l'année {$year}...");

        if ($userId) {
            $users = User::where('id', $userId)->with(['leaveBalance', 'department.leaveBalance', 'company'])->get();
            if ($users->isEmpty()) {
                $this->error("Utilisateur avec l'ID {$userId} non trouvé.");
                return 1;
            }
        } else {
            $users = User::where('is_active', true)
                ->with(['leaveBalance', 'department.leaveBalance', 'company'])
                ->get();
        }

        $this->info("Traitement de {$users->count()} utilisateur(s)...");

        $progressBar = $this->output->createProgressBar($users->count());
        $progressBar->start();

        $allocated = 0;
        $skipped = 0;

        DB::transaction(function () use ($users, $year, $progressBar, &$allocated, &$skipped) {
            foreach ($users as $user) {
                if ($this->allocateUserAnnualLeave($user, $year)) {
                    $allocated++;
                } else {
                    $skipped++;
                }
                $progressBar->advance();
            }
        });

        $progressBar->finish();
        $this->newLine();
        $this->info("Allocation terminée: {$allocated} utilisateur(s) traité(s), {$skipped} ignoré(s).");

        return 0;
    }

    /**
     * Alloue les congés annuels pour un utilisateur
     */
    private function allocateUserAnnualLeave(User $user, int $year): bool
    {
        // Vérifier s'il y a déjà une allocation pour cette année
        $existingAllocation = LeaveTransaction::where('user_id', $user->id)
            ->where('leave_type', 'annual')
            ->where('transaction_type', 'allocation')
            ->whereJsonContains('metadata->year', $year)
            ->exists();

        if ($existingAllocation) {
            return false; // Déjà alloué
        }

        $annualLeaveDays = $user->annual_leave_days;

        if ($annualLeaveDays > 0) {
            LeaveTransaction::createTransaction(
                userId: $user->id,
                leaveType: 'annual',
                transactionType: 'allocation',
                amount: $annualLeaveDays,
                description: "Allocation annuelle de congés pour l'année {$year}",
                metadata: [
                    'year' => $year,
                    'source' => 'annual_allocation',
                    'user_leave_balance_id' => $user->leave_balance_id,
                    'department_id' => $user->department_id,
                    'company_id' => $user->company_id,
                    'allocated_days' => $annualLeaveDays
                ],
                createdBy: auth()->id() ?? 1 // Utilisateur connecté ou système
            );

            return true;
        }

        return false;
    }
}