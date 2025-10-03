<?php

namespace App\Services;

use App\Models\LeaveBalance;
use App\Models\SpecialLeaveType;
use App\Models\User;
use App\Models\Leave;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LeaveBalanceService
{
    /**
     * Initialiser les soldes pour un utilisateur
     */
    public function initializeUserBalances(User $user, int $year = null, bool $force = false): array
    {
        $year = $year ?? now()->year;
        $initialized = 0;
        $skipped = 0;

        // Récupérer tous les types de congés avec solde
        $leaveTypesWithBalance = SpecialLeaveType::withBalance()
            ->where('is_active', true)
            ->get();

        foreach ($leaveTypesWithBalance as $leaveType) {
            // Vérifier si le solde existe déjà
            $existingBalance = LeaveBalance::where('user_id', $user->id)
                ->where('special_leave_type_id', $leaveType->id)
                ->where('year', $year)
                ->first();

            if ($existingBalance && !$force) {
                $skipped++;
                continue;
            }

            if ($existingBalance && $force) {
                // Réinitialiser le solde existant
                $existingBalance->update([
                    'initial_balance' => $leaveType->duration_days ?? 0,
                    'current_balance' => $leaveType->duration_days ?? 0,
                    'used_balance' => 0,
                    'adjustment_balance' => 0,
                    'notes' => 'Solde réinitialisé automatiquement'
                ]);
                $initialized++;
            } else {
                // Créer un nouveau solde
                LeaveBalance::create([
                    'user_id' => $user->id,
                    'special_leave_type_id' => $leaveType->id,
                    'year' => $year,
                    'initial_balance' => $leaveType->duration_days ?? 0,
                    'current_balance' => $leaveType->duration_days ?? 0,
                    'used_balance' => 0,
                    'adjustment_balance' => 0,
                    'notes' => 'Solde initialisé automatiquement'
                ]);
                $initialized++;
            }
        }

        Log::info('Soldes initialisés pour l\'utilisateur', [
            'user_id' => $user->id,
            'year' => $year,
            'initialized' => $initialized,
            'skipped' => $skipped
        ]);

        return [
            'initialized' => $initialized,
            'skipped' => $skipped
        ];
    }

    /**
     * Obtenir ou créer un solde pour un utilisateur et un type de congé
     */
    public function getOrCreateBalance(User $user, SpecialLeaveType $leaveType, int $year = null): LeaveBalance
    {
        $year = $year ?? now()->year;

        $balance = LeaveBalance::where('user_id', $user->id)
            ->where('special_leave_type_id', $leaveType->id)
            ->where('year', $year)
            ->first();

        if (!$balance) {
            $balance = LeaveBalance::create([
                'user_id' => $user->id,
                'special_leave_type_id' => $leaveType->id,
                'year' => $year,
                'initial_balance' => $leaveType->duration_days ?? 0,
                'current_balance' => $leaveType->duration_days ?? 0,
                'used_balance' => 0,
                'adjustment_balance' => 0,
                'notes' => 'Solde initialisé automatiquement'
            ]);

            Log::info('Nouveau solde créé', [
                'user_id' => $user->id,
                'leave_type_id' => $leaveType->id,
                'year' => $year,
                'initial_balance' => $balance->initial_balance
            ]);
        }

        return $balance;
    }

    /**
     * Vérifier si un utilisateur a suffisamment de solde pour un congé
     */
    public function checkBalance(User $user, SpecialLeaveType $leaveType, int $duration, int $year = null): array
    {
        $year = $year ?? now()->year;

        // Si le type de congé n'a pas de solde, il est illimité
        if (!$leaveType->hasBalance()) {
            return [
                'has_sufficient_balance' => true,
                'current_balance' => null,
                'required_duration' => $duration,
                'remaining_after' => null,
                'message' => 'Type de congé illimité'
            ];
        }

        $balance = $this->getOrCreateBalance($user, $leaveType, $year);

        $hasSufficientBalance = $balance->current_balance >= $duration;

        return [
            'has_sufficient_balance' => $hasSufficientBalance,
            'current_balance' => $balance->current_balance,
            'required_duration' => $duration,
            'remaining_after' => $balance->current_balance - $duration,
            'message' => $hasSufficientBalance 
                ? 'Solde suffisant' 
                : "Solde insuffisant. Disponible: {$balance->current_balance} jours, Requis: {$duration} jours"
        ];
    }

    /**
     * Décrémenter le solde lors de l'approbation d'un congé
     */
    public function decrementBalance(Leave $leave): bool
    {
        if (!$leave->specialLeaveType || !$leave->specialLeaveType->hasBalance()) {
            Log::info('Pas de décrémentation nécessaire - type illimité', [
                'leave_id' => $leave->id,
                'leave_type' => $leave->specialLeaveType?->name ?? 'N/A'
            ]);
            return true;
        }

        $year = $leave->start_date->year;
        $balance = $this->getOrCreateBalance($leave->user, $leave->specialLeaveType, $year);

        // Utiliser la durée calculée en jours ouvrables
        if ($balance->current_balance < $leave->duration_days) {
            Log::warning('Tentative de décrémentation avec solde insuffisant', [
                'leave_id' => $leave->id,
                'current_balance' => $balance->current_balance,
                'required' => $leave->duration_days
            ]);
            return false;
        }

        return DB::transaction(function () use ($balance, $leave) {
            $balance->decrement('current_balance', $leave->duration_days);
            $balance->increment('used_balance', $leave->duration_days);
            
            Log::info('Solde décrémenté', [
                'leave_id' => $leave->id,
                'user_id' => $leave->user_id,
                'duration' => $leave->duration_days,
                'new_balance' => $balance->fresh()->current_balance
            ]);

            return true;
        });
    }

    /**
     * Incrémenter le solde lors de l'annulation d'un congé approuvé
     */
    public function incrementBalance(Leave $leave): bool
    {
        if (!$leave->specialLeaveType || !$leave->specialLeaveType->hasBalance()) {
            Log::info('Pas d\'incrémentation nécessaire - type illimité', [
                'leave_id' => $leave->id,
                'leave_type' => $leave->specialLeaveType?->name ?? 'N/A'
            ]);
            return true;
        }

        $year = $leave->start_date->year;
        $balance = $this->getOrCreateBalance($leave->user, $leave->specialLeaveType, $year);

        return DB::transaction(function () use ($balance, $leave) {
            $balance->increment('current_balance', $leave->duration_days);
            $balance->decrement('used_balance', $leave->duration_days);
            
            Log::info('Solde incrémenté (annulation)', [
                'leave_id' => $leave->id,
                'user_id' => $leave->user_id,
                'duration' => $leave->duration_days,
                'new_balance' => $balance->fresh()->current_balance
            ]);

            return true;
        });
    }

    /**
     * Ajuster manuellement le solde d'un utilisateur
     */
    public function adjustBalance(User $user, SpecialLeaveType $leaveType, int $adjustment, string $reason, int $year = null): LeaveBalance
    {
        $year = $year ?? now()->year;
        $balance = $this->getOrCreateBalance($user, $leaveType, $year);

        return DB::transaction(function () use ($balance, $adjustment, $reason, $user, $leaveType, $year) {
            $oldBalance = $balance->current_balance;
            
            $balance->increment('current_balance', $adjustment);
            $balance->increment('adjustment_balance', $adjustment);
            $balance->notes = ($balance->notes ? $balance->notes . "\n" : '') . 
                             now()->format('d/m/Y H:i') . " - Ajustement: {$adjustment} jours. Raison: {$reason}";
            $balance->save();

            Log::info('Solde ajusté manuellement', [
                'user_id' => $user->id,
                'leave_type_id' => $leaveType->id,
                'year' => $year,
                'old_balance' => $oldBalance,
                'adjustment' => $adjustment,
                'new_balance' => $balance->current_balance,
                'reason' => $reason
            ]);

            return $balance;
        });
    }

    /**
     * Obtenir un résumé des soldes pour un utilisateur
     */
    public function getUserBalanceSummary(User $user, int $year = null): array
    {
        $year = $year ?? now()->year;

        $balances = LeaveBalance::with('specialLeaveType')
            ->where('user_id', $user->id)
            ->where('year', $year)
            ->get();

        $summary = [
            'year' => $year,
            'total_types' => $balances->count(),
            'total_initial' => $balances->sum('initial_balance'),
            'total_current' => $balances->sum('current_balance'),
            'total_used' => $balances->sum('used_balance'),
            'total_adjustments' => $balances->sum('adjustment_balance'),
            'balances' => $balances->map(function ($balance) {
                $usagePercentage = $balance->initial_balance > 0 
                    ? round(($balance->used_balance / $balance->initial_balance) * 100, 1)
                    : 0;
                    
                return [
                    'leave_type' => $balance->specialLeaveType->name,
                    'year' => $balance->year,
                    'initial' => $balance->initial_balance,
                    'current' => $balance->current_balance,
                    'used' => $balance->used_balance,
                    'adjustments' => $balance->adjustment_balance,
                    'usage_percentage' => $usagePercentage
                ];
            })
        ];

        return $summary;
    }

    /**
     * Réinitialiser les soldes pour une nouvelle année
     */
    public function resetBalancesForNewYear(int $newYear, int $previousYear = null): int
    {
        $previousYear = $previousYear ?? ($newYear - 1);
        $resetCount = 0;

        $users = User::where('is_active', true)->get();
        $leaveTypesWithBalance = SpecialLeaveType::withBalance()
            ->where('is_active', true)
            ->get();

        foreach ($users as $user) {
            foreach ($leaveTypesWithBalance as $leaveType) {
                $newBalance = LeaveBalance::create([
                    'user_id' => $user->id,
                    'special_leave_type_id' => $leaveType->id,
                    'year' => $newYear,
                    'initial_balance' => $leaveType->duration_days ?? 0,
                    'current_balance' => $leaveType->duration_days ?? 0,
                    'used_balance' => 0,
                    'adjustment_balance' => 0,
                    'notes' => "Solde réinitialisé pour l'année {$newYear}"
                ]);

                $resetCount++;
            }
        }

        Log::info('Soldes réinitialisés pour nouvelle année', [
            'new_year' => $newYear,
            'previous_year' => $previousYear,
            'reset_count' => $resetCount
        ]);

        return $resetCount;
    }

    /**
     * Vérifier la cohérence des soldes
     */
    public function checkBalanceConsistency(User $user = null, int $year = null): array
    {
        $year = $year ?? now()->year;
        $issues = [];

        $query = LeaveBalance::with(['user', 'specialLeaveType'])
            ->where('year', $year);

        if ($user) {
            $query->where('user_id', $user->id);
        }

        $balances = $query->get();

        foreach ($balances as $balance) {
            // Vérifier que current_balance = initial_balance - used_balance + adjustment_balance
            $expectedBalance = $balance->initial_balance - $balance->used_balance + $balance->adjustment_balance;
            
            if ($balance->current_balance !== $expectedBalance) {
                $issues[] = [
                    'type' => 'balance_mismatch',
                    'user' => $balance->user->name,
                    'leave_type' => $balance->specialLeaveType->name,
                    'year' => $balance->year,
                    'current_balance' => $balance->current_balance,
                    'expected_balance' => $expectedBalance,
                    'difference' => $balance->current_balance - $expectedBalance
                ];
            }

            // Vérifier que le solde courant n'est pas négatif
            if ($balance->current_balance < 0) {
                $issues[] = [
                    'type' => 'negative_balance',
                    'user' => $balance->user->name,
                    'leave_type' => $balance->specialLeaveType->name,
                    'year' => $balance->year,
                    'current_balance' => $balance->current_balance
                ];
            }
        }

        return [
            'total_checked' => $balances->count(),
            'issues_found' => count($issues),
            'issues' => $issues
        ];
    }
}