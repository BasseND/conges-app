<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Leave;
use App\Models\SpecialLeaveType;
use App\Models\LeaveBalance;
use App\Http\Middleware\CheckLeaveBalance;
use App\Services\LeaveBalanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery;

class CheckLeaveBalanceMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected $middleware;
    protected $user;
    protected $leaveType;
    protected $leave;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->middleware = new CheckLeaveBalance();
        
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
            'duration_days' => 25,
            'has_balance' => true,
            'is_active' => true
        ]);
        
        // Créer un congé de test
        $this->leave = Leave::create([
            'user_id' => $this->user->id,
            'special_leave_type_id' => $this->leaveType->id,
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(5),
            'duration_days' => 5,
            'reason' => 'Test leave',
            'status' => 'pending'
        ]);
    }

    public function test_middleware_allows_request_with_sufficient_balance()
    {
        // Initialiser le solde
        $leaveBalanceService = new LeaveBalanceService();
        $leaveBalanceService->initializeUserBalances($this->user, now()->year);
        
        // Créer une requête simulée
        $request = Request::create('/leaves/' . $this->leave->id . '/approve', 'POST');
        $request->setRouteResolver(function () {
            $route = Mockery::mock();
            $route->shouldReceive('parameter')->with('leave')->andReturn($this->leave);
            return $route;
        });
        
        // Exécuter le middleware
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('Success', 200);
        });
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Success', $response->getContent());
    }

    public function test_middleware_blocks_request_with_insufficient_balance()
    {
        // Initialiser le solde avec moins de jours que nécessaire
        $leaveBalanceService = new LeaveBalanceService();
        $leaveBalanceService->initializeUserBalances($this->user, now()->year);
        
        // Utiliser presque tout le solde
        $leaveBalanceService->decrementBalance($this->user, $this->leaveType, 22, now()->year);
        
        // Créer une requête simulée
        $request = Request::create('/leaves/' . $this->leave->id . '/approve', 'POST');
        $request->setRouteResolver(function () {
            $route = Mockery::mock();
            $route->shouldReceive('parameter')->with('leave')->andReturn($this->leave);
            return $route;
        });
        
        // Exécuter le middleware
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('Success', 200);
        });
        
        $this->assertEquals(400, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertFalse($responseData['success']);
        $this->assertStringContainsString('Solde insuffisant', $responseData['message']);
    }

    public function test_middleware_allows_unlimited_leave_types()
    {
        // Créer un type de congé illimité
        $unlimitedLeaveType = SpecialLeaveType::create([
            'name' => 'Congé Illimité',
            'system_name' => 'conge_illimite',
            'duration_days' => null,
            'has_balance' => false,
            'is_active' => true
        ]);
        
        // Créer un congé avec le type illimité
        $unlimitedLeave = Leave::create([
            'user_id' => $this->user->id,
            'special_leave_type_id' => $unlimitedLeaveType->id,
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(30), // 30 jours
            'duration_days' => 30,
            'reason' => 'Test unlimited leave',
            'status' => 'pending'
        ]);
        
        // Créer une requête simulée
        $request = Request::create('/leaves/' . $unlimitedLeave->id . '/approve', 'POST');
        $request->setRouteResolver(function () use ($unlimitedLeave) {
            $route = Mockery::mock();
            $route->shouldReceive('parameter')->with('leave')->andReturn($unlimitedLeave);
            return $route;
        });
        
        // Exécuter le middleware
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('Success', 200);
        });
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Success', $response->getContent());
    }

    public function test_middleware_skips_non_approval_routes()
    {
        // Créer une requête pour une route non-approbation
        $request = Request::create('/leaves/' . $this->leave->id . '/reject', 'POST');
        $request->setRouteResolver(function () {
            $route = Mockery::mock();
            $route->shouldReceive('parameter')->with('leave')->andReturn($this->leave);
            return $route;
        });
        
        // Exécuter le middleware
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('Success', 200);
        });
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Success', $response->getContent());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}