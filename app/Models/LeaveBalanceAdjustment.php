<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveBalanceAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_balance_id',
        'adjusted_by',
        'amount',
        'reason',
        'previous_balance',
        'new_balance',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'previous_balance' => 'decimal:2',
        'new_balance' => 'decimal:2',
    ];

    /**
     * Get the leave balance that was adjusted.
     */
    public function leaveBalance(): BelongsTo
    {
        return $this->belongsTo(LeaveBalance::class);
    }

    /**
     * Get the user who made the adjustment.
     */
    public function adjustedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }

    /**
     * Get the user whose balance was adjusted.
     */
    public function user(): BelongsTo
    {
        return $this->hasOneThrough(
            User::class,
            LeaveBalance::class,
            'id',
            'id',
            'leave_balance_id',
            'user_id'
        );
    }
}