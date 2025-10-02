<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\LeaveBalanceService;
use App\Models\Leave;

class CheckLeaveBalance
{
    protected LeaveBalanceService $leaveBalanceService;

    public function __construct(LeaveBalanceService $leaveBalanceService)
    {
        $this->leaveBalanceService = $leaveBalanceService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ce middleware s'applique uniquement aux routes d'approbation de congés
        if ($request->route()->getName() === 'leaves.approve') {
            $leave = $request->route('leave');
            
            if (!$leave instanceof Leave) {
                return response()->json([
                    'success' => false,
                    'message' => 'Demande de congé non trouvée.'
                ], 404);
            }

            // Vérifier seulement si le type de congé a un solde limité
            if ($leave->specialLeaveType && $leave->specialLeaveType->hasBalance()) {
                $year = $leave->start_date->year;
                
                // Vérifier si l'utilisateur a un solde suffisant
                if (!$this->leaveBalanceService->hasSufficientBalance(
                    $leave->user,
                    $leave->specialLeaveType,
                    $leave->duration_days,
                    $year
                )) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Solde de congé insuffisant pour approuver cette demande.',
                        'balance_info' => $this->leaveBalanceService->getBalanceSummary($leave->user, $year)
                    ], 422);
                }
            }
        }

        return $next($request);
    }
}
