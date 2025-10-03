<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LeaveBalanceService;
use App\Models\User;
use App\Models\SpecialLeaveType;

class ResetLeaveBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:reset-balances 
                            {--user= : ID de l\'utilisateur spécifique (optionnel)}
                            {--from-year= : Année source (défaut: année précédente)}
                            {--to-year= : Année cible (défaut: année courante)}
                            {--dry-run : Simulation sans modification de la base de données}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Réinitialise les soldes de congés pour une nouvelle année';

    protected LeaveBalanceService $leaveBalanceService;

    public function __construct(LeaveBalanceService $leaveBalanceService)
    {
        parent::__construct();
        $this->leaveBalanceService = $leaveBalanceService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user');
        $fromYear = $this->option('from-year') ?? (now()->year - 1);
        $toYear = $this->option('to-year') ?? now()->year;
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('MODE SIMULATION - Aucune modification ne sera apportée à la base de données');
        }

        $this->info("Réinitialisation des soldes de congés de {$fromYear} vers {$toYear}...");

        // Récupérer les utilisateurs à traiter
        if ($userId) {
            $users = User::where('id', $userId)->get();
            if ($users->isEmpty()) {
                $this->error("Utilisateur avec l'ID {$userId} non trouvé.");
                return 1;
            }
        } else {
            $users = User::all();
        }

        // Récupérer les types de congés avec solde
        $leaveTypesWithBalance = SpecialLeaveType::withBalance()->get();

        if ($leaveTypesWithBalance->isEmpty()) {
            $this->warn('Aucun type de congé avec solde trouvé.');
            return 0;
        }

        // Confirmation avant exécution
        if (!$dryRun && !$this->confirm("Êtes-vous sûr de vouloir réinitialiser les soldes pour {$users->count()} utilisateur(s) ?")) {
            $this->info('Opération annulée.');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($users->count());
        $progressBar->start();

        $resetCount = 0;
        $errorCount = 0;

        foreach ($users as $user) {
            try {
                if (!$dryRun) {
                    $result = $this->leaveBalanceService->resetBalancesForNewYear($user, $fromYear, $toYear);
                    $resetCount += $result['reset'];
                } else {
                    // En mode simulation, on affiche juste ce qui serait fait
                    $balances = $user->leaveBalances()->where('year', $fromYear)->get();
                    if ($balances->count() > 0) {
                        $this->newLine();
                        $this->line("Utilisateur: {$user->name} ({$user->email})");
                        foreach ($balances as $balance) {
                            $this->line("  - {$balance->specialLeaveType->name}: {$balance->current_balance} jours restants");
                        }
                        $resetCount += $balances->count();
                    }
                }
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Erreur lors de la réinitialisation pour l'utilisateur {$user->full_name}: " . $e->getMessage());
                $errorCount++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        if ($dryRun) {
            $this->info("SIMULATION terminée :");
            $this->line("- {$resetCount} soldes seraient réinitialisés");
            $this->line("- {$errorCount} erreurs détectées");
            $this->warn("Exécutez la commande sans --dry-run pour appliquer les modifications.");
        } else {
            $this->info("Réinitialisation terminée :");
            $this->line("- {$resetCount} soldes réinitialisés");
            $this->line("- {$errorCount} erreurs rencontrées");
        }

        return $errorCount > 0 ? 1 : 0;
    }
}
