<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payslip extends Model
{
    use HasFactory;

    // Constantes pour les statuts
    const STATUS_DRAFT = 'draft';
    const STATUS_VALIDATED = 'validated';
    const STATUS_PAID = 'paid';

    protected $fillable = [
        'user_id',
        'contract_id',
        'period_month',
        'period_year',
        'base_salary',     // Salaire de base mensuel
        'gross_salary',    // Salaire brut (avec primes, etc.)
        'net_salary',      // Salaire net
        'tax_amount',      // Montant des charges
        'bonus_amount',    // Montant des primes
        'expense_reimbursement', // Remboursement de frais
        'status',          // brouillon, validé, payé
        'payment_date',
        'generated_at',
    ];

    protected $casts = [
        'period_month' => 'integer',
        'period_year' => 'integer',
        'base_salary' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
        'expense_reimbursement' => 'decimal:2',
        'payment_date' => 'datetime',
        'generated_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le contrat
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * Relation avec les éléments de paie
     */
    public function items(): HasMany
    {
        return $this->hasMany(PayrollItem::class);
    }

    /**
     * Relation avec les congés pris durant cette période
     */
    public function leaves()
    {
        return $this->belongsToMany(Leave::class, 'payslip_leave')
            ->withPivot('impact_amount')
            ->withTimestamps();
    }

    /**
     * Recalculer le salaire brut en fonction des éléments de paie
     */
    public function recalculateGrossSalary()
    {
        $this->gross_salary = $this->base_salary + $this->items()
            ->where('is_taxable', true)
            ->sum('amount');
        $this->save();
    }

    /**
     * Recalculer le salaire net
     */
    public function recalculateNetSalary()
    {
        $this->net_salary = $this->gross_salary - $this->tax_amount;
        $this->save();
    }

    /**
     * Obtenir le libellé du statut
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_DRAFT => 'Brouillon',
            self::STATUS_VALIDATED => 'Validé',
            self::STATUS_PAID => 'Payé',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Obtenir la période formatée (mois/année)
     */
    public function getPeriodFormattedAttribute()
    {
        $months = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        return $months[$this->period_month] . ' ' . $this->period_year;
    }
}
