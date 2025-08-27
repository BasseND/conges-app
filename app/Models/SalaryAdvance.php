<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalaryAdvance extends Model
{
    use HasFactory;

    // Constantes pour les statuts
    const STATUS_PENDING = 'pending';     // En attente
    const STATUS_SUBMITTED = 'submitted'; // Soumis
    const STATUS_APPROVED = 'approved';   // Approuvé
    const STATUS_REJECTED = 'rejected';   // Rejeté
    const STATUS_PAID = 'paid';           // Payé
    const STATUS_CANCELLED = 'cancelled'; // Annulé

    // Constantes pour les méthodes de remboursement
    const PAYBACK_SINGLE = 'single';      // Remboursement unique
    const PAYBACK_INSTALLMENT = 'installment'; // Remboursement échelonné

    protected $fillable = [
        'user_id',
        'amount',
        'reason',
        'request_date',
        'approval_date',
        'payment_date',
        'status',
        'payback_method',      // méthode de remboursement (unique, échelonné)
        'payback_period',      // nombre de mois pour le remboursement
        'approved_by',         // ID de l'utilisateur qui a approuvé
        'notes',               // Notes internes
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'request_date' => 'datetime',
        'approval_date' => 'datetime',
        'payment_date' => 'datetime',
        'payback_period' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'approbateur
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relation avec les remboursements
     */
    public function repayments(): HasMany
    {
        return $this->hasMany(SalaryAdvanceRepayment::class);
    }

    /**
     * Obtenir les statuts disponibles
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'En attente',
            self::STATUS_SUBMITTED => 'Soumis',
            self::STATUS_APPROVED => 'Approuvé',
            self::STATUS_REJECTED => 'Rejeté',
            self::STATUS_PAID => 'Payé',
            self::STATUS_CANCELLED => 'Annulé',
        ];
    }

    /**
     * Obtenir les méthodes de remboursement disponibles
     */
    public static function getPaybackMethods()
    {
        return [
            self::PAYBACK_SINGLE => 'Remboursement unique',
            self::PAYBACK_INSTALLMENT => 'Remboursement échelonné',
        ];
    }

    /**
     * Obtenir le libellé du statut
     */
    public function getStatusLabelAttribute()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Obtenir le libellé de la méthode de remboursement
     */
    public function getPaybackMethodLabelAttribute()
    {
        $methods = self::getPaybackMethods();
        return $methods[$this->payback_method] ?? $this->payback_method;
    }

    /**
     * Calculer le montant remboursé
     */
    public function getRepaidAmountAttribute()
    {
        return $this->repayments()->sum('amount');
    }

    /**
     * Calculer le montant restant à rembourser
     */
    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->repaid_amount;
    }

    /**
     * Vérifier si l'avance est entièrement remboursée
     */
    public function getIsFullyRepaidAttribute()
    {
        return $this->remaining_amount <= 0;
    }
}
