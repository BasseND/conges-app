<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LeaveBalanceService;
use App\Models\User;
use App\Models\SpecialLeaveType;

class InitializeLeaveBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:initialize-balances 
                            {--user= : ID de l\'utilisateur spécifique (optionnel)}
                            {--year= : Année pour laquelle initialiser les soldes (défaut: année courante)}
                            {--force : Forcer la réinitialisation même si les soldes existent déjà}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialise les soldes de congés pour tous les utilisateurs ou un utilisateur spécifique';

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
        $year = $this->option('year') ?? now()->year;
        $force = $this->option('force');

        $this->info("Initialisation des soldes de congés pour l'année {$year}...");

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

        $progressBar = $this->output->createProgressBar($users->count());
        $progressBar->start();

        $initializedCount = 0;
        $skippedCount = 0;

        foreach ($users as $user) {
            try {
                $result = $this->leaveBalanceService->initializeUserBalances($user, $year, $force);
                
                if ($result['initialized'] > 0) {
                    $initializedCount += $result['initialized'];
                }
                if ($result['skipped'] > 0) {
                    $skippedCount += $result['skipped'];
                }
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Erreur lors de l'initialisation pour l'utilisateur {$user->name}: " . $e->getMessage());
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("Initialisation terminée :");
        $this->line("- {$initializedCount} soldes initialisés");
        $this->line("- {$skippedCount} soldes ignorés (déjà existants)");

        if ($force && $skippedCount > 0) {
            $this->warn("Utilisez l'option --force pour réinitialiser les soldes existants.");
        }

        return 0;
    }
}
