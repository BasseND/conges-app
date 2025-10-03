<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'special_leave_type_id',
        'year',
        'initial_balance',
        'current_balance',
        'used_balance',
        'adjustment_balance',
        'notes'
    ];

    protected $casts = [
        'year' => 'integer',
        'initial_balance' => 'integer',
        'current_balance' => 'integer',
        'used_balance' => 'integer',
        'adjustment_balance' => 'integer'
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le type de congé spécial
     */
    public function specialLeaveType(): BelongsTo
    {
        return $this->belongsTo(SpecialLeaveType::class);
    }

    /**
     * Relation avec les ajustements
     */
    public function adjustments(): HasMany
    {
        return $this->hasMany(LeaveBalanceAdjustment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Scope pour filtrer par utilisateur
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope pour filtrer par type de congé
     */
    public function scopeForLeaveType($query, $leaveTypeId)
    {
        return $query->where('special_leave_type_id', $leaveTypeId);
    }

    /**
     * Scope pour filtrer par année
     */
    public function scopeForYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Scope pour l'année courante
     */
    public function scopeCurrentYear($query)
    {
        return $query->where('year', now()->year);
    }

    /**
     * Obtenir le solde total (initial + ajustements)
     */
    public function getTotalBalanceAttribute()
    {
        return $this->initial_balance + $this->adjustment_balance;
    }

    /**
     * Obtenir le pourcentage d'utilisation
     */
    public function getUsagePercentageAttribute()
    {
        $totalBalance = $this->getTotalBalanceAttribute();
        if ($totalBalance <= 0) {
            return 0;
        }
        
        return round(($this->used_balance / $totalBalance) * 100, 2);
    }

    /**
     * Vérifier si le solde est suffisant pour une durée donnée
     */
    public function hasSufficientBalance($days)
    {
        return $this->current_balance >= $days;
    }

    /**
     * Décrémenter le solde
     */
    public function decrementBalance($days, $notes = null)
    {
        if (!$this->hasSufficientBalance($days)) {
            throw new \InvalidArgumentException('Solde insuffisant pour cette opération');
        }

        $this->current_balance -= $days;
        $this->used_balance += $days;
        
        if ($notes) {
            $this->notes = $this->notes ? $this->notes . "\n" . $notes : $notes;
        }
        
        return $this->save();
    }

    /**
     * Incrémenter le solde (remboursement)
     */
    public function incrementBalance($days, $notes = null)
    {
        $this->current_balance += $days;
        $this->used_balance = max(0, $this->used_balance - $days);
        
        if ($notes) {
            $this->notes = $this->notes ? $this->notes . "\n" . $notes : $notes;
        }
        
        return $this->save();
    }

    /**
     * Ajuster le solde manuellement
     */
    public function adjustBalance($adjustment, $notes = null)
    {
        $this->adjustment_balance += $adjustment;
        $this->current_balance += $adjustment;
        
        if ($notes) {
            $this->notes = $this->notes ? $this->notes . "\n" . $notes : $notes;
        }
        
        return $this->save();
    }

    /**
     * Réinitialiser le solde pour une nouvelle année
     */
    public function resetForNewYear($newInitialBalance, $notes = null)
    {
        $this->initial_balance = $newInitialBalance;
        $this->current_balance = $newInitialBalance;
        $this->used_balance = 0;
        $this->adjustment_balance = 0;
        
        if ($notes) {
            $this->notes = $notes;
        }
        
        return $this->save();
    }
}
