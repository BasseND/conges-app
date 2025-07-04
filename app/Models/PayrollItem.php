<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollItem extends Model
{
    use HasFactory;

    // Constantes pour les types d'éléments de paie
    const TYPE_BONUS = 'bonus';         // Prime
    const TYPE_DEDUCTION = 'deduction'; // Déduction
    const TYPE_BENEFIT = 'benefit';     // Avantage
    const TYPE_OVERTIME = 'overtime';   // Heures supplémentaires
    const TYPE_OTHER = 'other';         // Autre

    protected $fillable = [
        'payslip_id',
        'type',          // type d'élément (prime, déduction, avantage, etc.)
        'label',         // libellé descriptif
        'amount',        // montant
        'is_taxable',    // soumis aux charges sociales
        'description',   // description détaillée (optionnelle)
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_taxable' => 'boolean',
    ];

    /**
     * Relation avec le bulletin de paie
     */
    public function payslip(): BelongsTo
    {
        return $this->belongsTo(Payslip::class);
    }

    /**
     * Obtenir les types d'éléments de paie disponibles
     */
    public static function getTypes()
    {
        return [
            self::TYPE_BONUS => 'Prime',
            self::TYPE_DEDUCTION => 'Déduction',
            self::TYPE_BENEFIT => 'Avantage',
            self::TYPE_OVERTIME => 'Heures supplémentaires',
            self::TYPE_OTHER => 'Autre',
        ];
    }

    /**
     * Obtenir le libellé du type
     */
    public function getTypeNameAttribute()
    {
        $types = self::getTypes();
        return $types[$this->type] ?? $this->type;
    }

    /**
     * Formater le montant avec signe + ou - selon le type
     */
    public function getFormattedAmountAttribute()
    {
        if ($this->type === self::TYPE_DEDUCTION) {
            return '-' . number_format($this->amount, 2, ',', ' ') . ' €';
        }
        
        return '+' . number_format($this->amount, 2, ',', ' ') . ' €';
    }
}
