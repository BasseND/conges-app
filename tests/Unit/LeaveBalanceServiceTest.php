<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Leave;
use App\Models\SpecialLeaveType;
use App\Models\LeaveBalance;
use App\Services\LeaveBalanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaveBalanceServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $leaveBalanceService;
    protected $user;
    protected $leaveType;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->leaveBalanceService = new LeaveBalanceService();
        
        // Créer un utilisateur de test
        $this->user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com'
        ]);
        
        // Créer un type de congé avec solde
        $this->leaveType = SpecialLeaveType::create([
            'name' => 'Congé Test',
            'system_name' => 'conge_test',
            'type' => 'système',
            'duration_days' => 25,
            'has_balance' => true,
            'is_active' => true
        ]);
    }

    public function test_initialize_user_balances()
    {
        $result = $this->leaveBalanceService->initializeUserBalances($this->user, 2025);
        
        $this->assertEquals(1, $result['initialized']);
        $this->assertEquals(0, $result['skipped']);
        
        // Vérifier que le solde a été créé
        $balance = LeaveBalance::where('user_id', $this->user->id)
            ->where('special_leave_type_id', $this->leaveType->id)
            ->where('year', 2025)
            ->first();
            
        $this->assertNotNull($balance);
        $this->assertEquals(25, $balance->initial_balance);
        $this->assertEquals(25, $balance->current_balance);
        $this->assertEquals(0, $balance->used_balance);
    }

    public function test_check_balance_sufficient()
    {
        // Initialiser le solde
        $this->leaveBalanceService->initializeUserBalances($this->user, 2025);
        
        // Vérifier un solde suffisant
        $result = $this->leaveBalanceService->checkBalance($this->user, $this->leaveType, 10, 2025);
        
        $this->assertTrue($result['has_sufficient_balance']);
        $this->assertEquals(25, $result['current_balance']);
        $this->assertEquals(10, $result['required_duration']);
        $this->assertEquals(15, $result['remaining_after']);
    }

    public function test_check_balance_insufficient()
    {
        // Initialiser le solde
        $this->leaveBalanceService->initializeUserBalances($this->user, 2025);
        
        // Vérifier un solde insuffisant
        $result = $this->leaveBalanceService->checkBalance($this->user, $this->leaveType, 30, 2025);
        
        $this->assertFalse($result['has_sufficient_balance']);
        $this->assertEquals(25, $result['current_balance']);
        $this->assertEquals(30, $result['required_duration']);
        $this->assertEquals(-5, $result['remaining_after']);
    }

    public function test_decrement_balance()
    {
        // Initialiser le solde
        $this->leaveBalanceService->initializeUserBalances($this->user, 2025);
        
        // Créer un congé pour décrémenter le solde
        $leave = Leave::create([
            'user_id' => $this->user->id,
            'special_leave_type_id' => $this->leaveType->id,
            'start_date' => '2025-01-15',
            'end_date' => '2025-01-24',
            'duration' => 10,
            'status' => 'approved',
            'reason' => 'Test leave'
        ]);
        
        // Décrémenter le solde
        $result = $this->leaveBalanceService->decrementBalance($leave);
        
        $this->assertTrue($result);
        
        // Vérifier en base de données
        $balance = LeaveBalance::where('user_id', $this->user->id)
            ->where('special_leave_type_id', $this->leaveType->id)
            ->where('year', 2025)
            ->first();
            
        $this->assertEquals(15, $balance->current_balance);
        $this->assertEquals(10, $balance->used_balance);
    }

    public function test_increment_balance()
    {
        // Initialiser le solde
        $this->leaveBalanceService->initializeUserBalances($this->user, 2025);
        
        // Créer un congé et le décrémenter
        $leave = Leave::create([
            'user_id' => $this->user->id,
            'special_leave_type_id' => $this->leaveType->id,
            'start_date' => '2025-01-15',
            'end_date' => '2025-01-24',
            'duration' => 10,
            'status' => 'approved',
            'reason' => 'Test leave'
        ]);
        
        $this->leaveBalanceService->decrementBalance($leave);
        
        // Créer un congé d'annulation partielle et l'incrémenter
        $cancelLeave = Leave::create([
            'user_id' => $this->user->id,
            'special_leave_type_id' => $this->leaveType->id,
            'start_date' => '2025-01-20',
            'end_date' => '2025-01-24',
            'duration' => 5,
            'status' => 'cancelled',
            'reason' => 'Partial cancellation'
        ]);
        
        // Incrémenter le solde (annulation)
        $result = $this->leaveBalanceService->incrementBalance($cancelLeave);
        
        $this->assertTrue($result);
        
        // Vérifier en base de données
        $balance = LeaveBalance::where('user_id', $this->user->id)
            ->where('special_leave_type_id', $this->leaveType->id)
            ->where('year', 2025)
            ->first();
            
        $this->assertEquals(20, $balance->current_balance);
        $this->assertEquals(5, $balance->used_balance);
    }

    public function test_unlimited_leave_type()
    {
        // Créer un type de congé illimité
        $unlimitedLeaveType = SpecialLeaveType::create([
            'name' => 'Congé Illimité',
            'system_name' => 'conge_illimite',
            'type' => 'système',
            'duration_days' => 0,
            'has_balance' => false,
            'is_active' => true
        ]);
        
        // Vérifier le solde pour un type illimité
        $result = $this->leaveBalanceService->checkBalance($this->user, $unlimitedLeaveType, 100, 2025);
        
        $this->assertTrue($result['has_sufficient_balance']);
        $this->assertNull($result['current_balance']);
        $this->assertEquals('Type de congé illimité', $result['message']);
    }

    public function test_get_user_balance_summary()
    {
        // Initialiser les soldes
        $this->leaveBalanceService->initializeUserBalances($this->user, 2025);
        
        // Créer un congé pour simuler une utilisation réelle
        $leave = Leave::create([
            'user_id' => $this->user->id,
            'special_leave_type_id' => $this->leaveType->id,
            'start_date' => '2025-01-15',
            'end_date' => '2025-01-19',
            'duration' => 5,
            'status' => 'approved',
            'reason' => 'Test leave'
        ]);
        
        // Décrémenter le solde avec le congé
        $this->leaveBalanceService->decrementBalance($leave);
        
        // Obtenir le résumé
        $summary = $this->leaveBalanceService->getUserBalanceSummary($this->user, 2025);
        
        // Trouver le solde pour notre type de congé de test
        $testBalance = collect($summary['balances'])->firstWhere('leave_type', 'Congé Test');
        
        $this->assertNotNull($testBalance);
        $this->assertEquals('Congé Test', $testBalance['leave_type']);
        $this->assertEquals(25, $testBalance['initial']);
        $this->assertEquals(20, $testBalance['current']);
        $this->assertEquals(5, $testBalance['used']);
    }

    public function test_force_reinitialize_balances()
    {
        // Initialiser les soldes
        $this->leaveBalanceService->initializeUserBalances($this->user, 2025);
        
        // Utiliser quelques jours
        $this->leaveBalanceService->adjustBalance($this->user, $this->leaveType, -10, 'Test usage', 2025);
        
        // Réinitialiser avec force
        $result = $this->leaveBalanceService->initializeUserBalances($this->user, 2025, true);
        
        $this->assertEquals(1, $result['initialized']);
        $this->assertEquals(0, $result['skipped']);
        
        // Vérifier que le solde a été réinitialisé
        $balance = LeaveBalance::where('user_id', $this->user->id)
            ->where('special_leave_type_id', $this->leaveType->id)
            ->where('year', 2025)
            ->first();
            
        $this->assertEquals(25, $balance->current_balance);
        $this->assertEquals(0, $balance->used_balance);
    }
}