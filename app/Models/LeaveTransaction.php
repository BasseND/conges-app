<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_id',
        'leave_type',
        'transaction_type',
        'amount',
        'balance_before',
        'balance_after',
        'description',
        'metadata',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'metadata' => 'array',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le congé (optionnel)
     */
    public function leave(): BelongsTo
    {
        return $this->belongsTo(Leave::class);
    }

    /**
     * Relation avec l'utilisateur qui a créé la transaction
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope pour filtrer par type de congé
     */
    public function scopeForLeaveType($query, string $leaveType)
    {
        return $query->where('leave_type', $leaveType);
    }

    /**
     * Scope pour filtrer par type de transaction
     */
    public function scopeForTransactionType($query, string $transactionType)
    {
        return $query->where('transaction_type', $transactionType);
    }

    /**
     * Scope pour obtenir les transactions d'un utilisateur
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Méthode statique pour créer une transaction
     */
    public static function createTransaction(
        int $userId,
        string $leaveType,
        string $transactionType,
        float $amount,
        ?int $leaveId = null,
        ?string $description = null,
        ?array $metadata = null,
        ?int $createdBy = null
    ): self {
        // Calculer le solde avant la transaction
        $balanceBefore = self::getCurrentBalance($userId, $leaveType);
        $balanceAfter = $balanceBefore + $amount;

        return self::create([
            'user_id' => $userId,
            'leave_id' => $leaveId,
            'leave_type' => $leaveType,
            'transaction_type' => $transactionType,
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'description' => $description,
            'metadata' => $metadata,
            'created_by' => $createdBy,
        ]);
    }

    /**
     * Obtenir le solde actuel pour un utilisateur et un type de congé
     */
    public static function getCurrentBalance(int $userId, string $leaveType): float
    {
        $lastTransaction = self::where('user_id', $userId)
            ->where('leave_type', $leaveType)
            ->orderBy('created_at', 'desc')
            ->first();

        return $lastTransaction ? $lastTransaction->balance_after : 0;
    }

    /**
     * Obtenir l'historique des transactions pour un utilisateur
     */
    public static function getTransactionHistory(int $userId, ?string $leaveType = null)
    {
        $query = self::where('user_id', $userId)
            ->with(['leave', 'createdBy'])
            ->orderBy('created_at', 'desc');

        if ($leaveType) {
            $query->where('leave_type', $leaveType);
        }

        return $query->get();
    }
}