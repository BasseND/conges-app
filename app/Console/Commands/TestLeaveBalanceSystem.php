<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\SpecialLeaveType;
use App\Models\LeaveBalance;
use App\Services\LeaveBalanceService;

class TestLeaveBalanceSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:leave-balance-system {user_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the leave balance system functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test du système de solde de congés');
        $this->newLine();

        // Récupérer un utilisateur pour le test
        $userId = $this->argument('user_id');
        $user = $userId ? User::find($userId) : User::first();
        
        if (!$user) {
            $this->error('❌ Aucun utilisateur trouvé');
            return 1;
        }

        $this->info("👤 Utilisateur de test: {$user->first_name} {$user->last_name} (ID: {$user->id})");
        $this->newLine();

        // Test 1: Vérifier les soldes existants
        $this->info('📊 Test 1: Vérification des soldes existants');
        $balances = LeaveBalance::where('user_id', $user->id)->get();
        
        if ($balances->isEmpty()) {
            $this->warn('⚠️  Aucun solde trouvé pour cet utilisateur');
        } else {
            $this->info("✅ {$balances->count()} solde(s) trouvé(s):");
            foreach ($balances as $balance) {
                $leaveType = SpecialLeaveType::find($balance->special_leave_type_id);
                if ($leaveType) {
                    $this->line("   - {$leaveType->name}: {$balance->current_balance}/{$balance->initial_balance} jours (utilisés: {$balance->used_balance})");
                }
            }
        }
        $this->newLine();

        // Test 2: Utiliser le service LeaveBalanceService
        $this->info('🔧 Test 2: Test du LeaveBalanceService');
        $leaveBalanceService = app(LeaveBalanceService::class);
        
        try {
            $summary = $leaveBalanceService->getUserBalanceSummary($user);
            $this->info('✅ Service fonctionnel - Résumé des soldes:');
            $this->line("   Total types: {$summary['total_types']}");
            $this->line("   Total initial: {$summary['total_initial']} jours");
            $this->line("   Total actuel: {$summary['total_current']} jours");
            $this->line("   Total utilisé: {$summary['total_used']} jours");
            
            foreach ($summary['balances'] as $balance) {
                $this->line("   - {$balance['leave_type']}: {$balance['current']}/{$balance['initial']} jours (utilisés: {$balance['used']}, {$balance['usage_percentage']}%)");
            }
        } catch (\Exception $e) {
            $this->error("❌ Erreur du service: {$e->getMessage()}");
        }
        $this->newLine();

        // Test 3: Vérifier les types de congés disponibles
        $this->info('📋 Test 3: Types de congés disponibles');
        $specialLeaveTypes = SpecialLeaveType::where('is_active', true)->get();
        
        if ($specialLeaveTypes->isEmpty()) {
            $this->warn('⚠️  Aucun type de congé actif trouvé');
        } else {
            $this->info("✅ {$specialLeaveTypes->count()} type(s) de congé actif(s):");
            foreach ($specialLeaveTypes as $type) {
                $this->line("   - {$type->name} ({$type->duration_days} jours)");
            }
        }
        $this->newLine();

        // Test 4: Simulation d'une vérification de solde
        $this->info('🎯 Test 4: Simulation de vérification de solde');
        $firstLeaveType = $specialLeaveTypes->first();
        
        if ($firstLeaveType) {
            try {
                $checkResult = $leaveBalanceService->checkBalance($user, $firstLeaveType, 5);
                $this->info("✅ Vérification pour 5 jours de '{$firstLeaveType->name}':");
                $this->line("   - Solde suffisant: " . ($checkResult['has_sufficient_balance'] ? 'Oui' : 'Non'));
                $this->line("   - Solde actuel: {$checkResult['current_balance']} jours");
                $this->line("   - Solde après: {$checkResult['remaining_after']} jours");
            } catch (\Exception $e) {
                $this->error("❌ Erreur lors de la vérification: {$e->getMessage()}");
            }
        }
        $this->newLine();

        $this->info('🎉 Tests terminés avec succès !');
        return 0;
    }
}
