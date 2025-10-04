<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialLeaveType extends Model
{
    use HasFactory;

    // Types de congés spéciaux
    const TYPE_SYSTEM = 'systeme';
    const TYPE_CUSTOM = 'custom';

    // Types disponibles
    const AVAILABLE_TYPES = [
        self::TYPE_SYSTEM,
        self::TYPE_CUSTOM
    ];

    protected $fillable = [
        'name',
        'system_name',
        'type',
        'duration_days',
        'seniority_months',
        'description',
        'is_active',
        'has_balance',
        'company_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'has_balance' => 'boolean',
        'duration_days' => 'integer',
        'seniority_months' => 'integer',
        'type' => 'string'
    ];
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($specialLeaveType) {
            if (empty($specialLeaveType->system_name)) {
                $specialLeaveType->system_name = static::generateSystemName($specialLeaveType->name);
            }
            
            // Définir le type par défaut si non spécifié
            if (empty($specialLeaveType->type)) {
                $specialLeaveType->type = self::TYPE_CUSTOM;
            }
        });
        
        static::updating(function ($specialLeaveType) {
            if ($specialLeaveType->isDirty('name') && !$specialLeaveType->isDirty('system_name')) {
                $specialLeaveType->system_name = static::generateSystemName($specialLeaveType->name);
            }
        });
        
        // Validation du type avant sauvegarde
        static::saving(function ($specialLeaveType) {
            if (!in_array($specialLeaveType->type, self::AVAILABLE_TYPES)) {
                throw new \InvalidArgumentException('Le type doit être "systeme" ou "custom"');
            }
        });
    }
    
    /**
     * Génère un nom système unique à partir du nom
     */
    public static function generateSystemName($name)
    {
        $systemName = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', $name));
        
        // Vérifier l'unicité et ajouter un suffixe si nécessaire
        $baseSystemName = $systemName;
        $counter = 1;
        
        while (static::where('system_name', $systemName)->exists()) {
            $systemName = $baseSystemName . '_' . $counter++;
        }
        
        return $systemName;
    }

    /**
     * Scope pour les types actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les types système
     */
    public function scopeSystem($query)
    {
        return $query->where('type', self::TYPE_SYSTEM);
    }

    /**
     * Scope pour les types custom
     */
    public function scopeCustom($query)
    {
        return $query->where('type', self::TYPE_CUSTOM);
    }

    /**
     * Scope pour les types avec solde
     */
    public function scopeWithBalance($query)
    {
        return $query->where('has_balance', true);
    }

    /**
     * Scope pour les types illimités (sans solde)
     */
    public function scopeUnlimited($query)
    {
        return $query->where('has_balance', false);
    }

    /**
     * Vérifier si c'est un type système
     */
    public function isSystem()
    {
        return $this->type === self::TYPE_SYSTEM;
    }

    /**
     * Vérifier si c'est un type custom
     */
    public function isCustom()
    {
        return $this->type === self::TYPE_CUSTOM;
    }

    /**
     * Vérifier si ce type de congé a un solde limité
     */
    public function hasBalance()
    {
        return $this->has_balance;
    }

    /**
     * Vérifier si ce type de congé est illimité
     */
    public function isUnlimited()
    {
        return !$this->has_balance;
    }

    /**
     * Relation avec les congés
     */
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    /**
     * Relation avec les soldes de congés
     */
    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

    /**
     * Obtenir la durée formatée
     */
    public function getFormattedDurationAttribute()
    {
        if ($this->duration_days == 0) {
            return 'Solde variable';
        }
        
        if ($this->duration_days >= 7 && $this->duration_days % 7 == 0) {
            $weeks = $this->duration_days / 7;
            return $weeks == 1 ? '1 semaine' : "{$weeks} semaines";
        }
        
        return $this->duration_days == 1 ? '1 jour' : "{$this->duration_days} jours";
    }

    /**
     * Obtenir la condition d'ancienneté formatée
     */
    public function getFormattedSeniorityAttribute()
    {
        if ($this->seniority_months == 0) {
            return 'Aucune condition d\'ancienneté';
        }
        
        if ($this->seniority_months >= 12 && $this->seniority_months % 12 == 0) {
            $years = $this->seniority_months / 12;
            return $years == 1 ? '1 an d\'ancienneté' : "{$years} ans d\'ancienneté";
        }
        
        return $this->seniority_months == 1 ? '1 mois d\'ancienneté' : "{$this->seniority_months} mois d\'ancienneté";
    }

    /**
     * Vérifier si un utilisateur respecte la condition d'ancienneté
     */
    public function userMeetsSeniorityRequirement($user)
    {
        if ($this->seniority_months == 0) {
            return true;
        }
        
        if (!$user->hired_at) {
            return false;
        }
        
        $monthsWorked = $user->hired_at->diffInMonths(now());
        return $monthsWorked >= $this->seniority_months;
    }

    /**
     * Get the company that owns the special leave type.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}