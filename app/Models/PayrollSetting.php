<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSetting extends Model
{
    use HasFactory;

    // Constantes pour les types de paramètres
    const TYPE_TAX = 'tax';             // Charge sociale
    const TYPE_CONTRIBUTION = 'contribution'; // Cotisation
    const TYPE_THRESHOLD = 'threshold';  // Seuil
    const TYPE_RATE = 'rate';           // Taux
    const TYPE_OTHER = 'other';         // Autre

    protected $fillable = [
        'name',          // Nom du paramètre
        'value',         // Valeur du paramètre
        'description',   // Description
        'type',          // Type de paramètre
        'is_percentage', // Indique si la valeur est un pourcentage
        'is_active',     // Indique si le paramètre est actif
        'applies_to',    // À quoi s'applique ce paramètre (ex: 'all', 'cdi', 'freelance')
        'valid_from',    // Date de début de validité
        'valid_until',   // Date de fin de validité
    ];

    protected $casts = [
        'value' => 'decimal:4',
        'is_percentage' => 'boolean',
        'is_active' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    /**
     * Obtenir les types de paramètres disponibles
     */
    public static function getTypes()
    {
        return [
            self::TYPE_TAX => 'Charge sociale',
            self::TYPE_CONTRIBUTION => 'Cotisation',
            self::TYPE_THRESHOLD => 'Seuil',
            self::TYPE_RATE => 'Taux',
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
     * Formater la valeur (avec % si pourcentage)
     */
    public function getFormattedValueAttribute()
    {
        if ($this->is_percentage) {
            return number_format($this->value, 2, ',', ' ') . ' %';
        }
        
        return number_format($this->value, 2, ',', ' ') . ' €';
    }

    /**
     * Vérifier si le paramètre est valide à une date donnée
     */
    public function isValidAt($date = null)
    {
        $date = $date ?: now();
        
        if (!$this->is_active) {
            return false;
        }
        
        $validFrom = $this->valid_from ? $this->valid_from->startOfDay() : null;
        $validUntil = $this->valid_until ? $this->valid_until->endOfDay() : null;
        
        if ($validFrom && $date < $validFrom) {
            return false;
        }
        
        if ($validUntil && $date > $validUntil) {
            return false;
        }
        
        return true;
    }

    /**
     * Récupérer tous les paramètres actifs
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->get();
    }
}
