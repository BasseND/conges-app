<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract  extends Model
{
    use HasFactory;

     // Constantes pour les contrats
     const CONTRACT_CDI = 'CDI';
     const CONTRACT_CDD = 'CDD';
     const CONTRACT_INTERIM = 'Interim';
     const CONTRACT_STAGE = 'Stage';
     const CONTRACT_ALTERNANCE = 'Alternance';
     const CONTRACT_FREELANCE = 'Freelance';

    protected $table = 'contrats';

    protected $fillable = [
        'user_id',
        'type',
        'is_expired',
        'is_active',
        'date_debut',
        'date_fin',
        'salaire_brut',
        'statut',
        'contrat_file',
        'tjm',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'salaire_brut' => 'decimal:2',
        'tjm' => 'decimal:2',
        'is_expired' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Relation avec l'utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


     /**
     * Get the Contract types available for the user.
     */
    public static function getContractTypes()
    {
        return [
            self::CONTRACT_CDI => 'CDI',
            self::CONTRACT_CDD => 'CDD',
            self::CONTRACT_INTERIM => 'Interim',
            self::CONTRACT_STAGE => 'Stage',
            self::CONTRACT_ALTERNANCE => 'Alternance',
            self::CONTRACT_FREELANCE => 'Freelance',
        ];
    }

    /**
     * Scope to get active contract for a user.
     */
    public function scopeActive($query, $userId)
    {
        return $query->where('user_id', $userId)->where('is_active', true);
    }

    /**
     * Set this contract as active and deactivate all other contracts for the same user.
     */
    public function setAsActive()
    {
        // Désactiver tous les autres contrats de cet utilisateur
        static::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_active' => false]);
        
        // Activer ce contrat
        $this->update(['is_active' => true]);
    }

    /**
     * Get the active contract for a user.
     */
    public static function getActiveForUser($userId)
    {
        return static::active($userId)->first();
    }
}
