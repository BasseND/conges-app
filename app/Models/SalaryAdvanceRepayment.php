<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalaryAdvanceRepayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_advance_id',
        'payslip_id',
        'amount',
        'repayment_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'repayment_date' => 'datetime',
    ];

    /**
     * Relation avec l'avance sur salaire
     */
    public function salaryAdvance(): BelongsTo
    {
        return $this->belongsTo(SalaryAdvance::class);
    }

    /**
     * Relation avec le bulletin de paie
     */
    public function payslip(): BelongsTo
    {
        return $this->belongsTo(Payslip::class);
    }
}
