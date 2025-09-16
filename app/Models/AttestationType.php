<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttestationType extends Model
{
    use HasFactory;

    /**
     * Les statuts possibles pour un type d'attestation
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * Les types d'attestations disponibles
     */
    const TYPE_SALARY = 'salary';
    const TYPE_PRESENCE = 'presence';
    const TYPE_EMPLOYMENT = 'employment';
    const TYPE_CUSTOM = 'custom';

    protected $fillable = [
        'name',
        'description',
        'template_file',
        'type',
        'status',
        'requires_date_range',
        'requires_salary_info',
        'requires_custom_fields',
        'custom_fields_config',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'requires_date_range' => 'boolean',
        'requires_salary_info' => 'boolean',
        'requires_custom_fields' => 'boolean',
        'custom_fields_config' => 'array'
    ];

    /**
     * Get the user who created this attestation type.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this attestation type.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get all attestation requests for this type.
     */
    public function attestationRequests()
    {
        return $this->hasMany(AttestationRequest::class);
    }

    /**
     * Scope pour récupérer seulement les types actifs
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Vérifier si le type d'attestation est actif
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Obtenir le nom formaté du type
     */
    public function getFormattedTypeAttribute()
    {
        $types = [
            self::TYPE_SALARY => 'Attestation de salaire',
            self::TYPE_PRESENCE => 'Attestation de présence',
            self::TYPE_EMPLOYMENT => 'Attestation de travail',
            self::TYPE_CUSTOM => 'Attestation personnalisée'
        ];

        return $types[$this->type] ?? 'Type inconnu';
    }

    /**
     * Obtenir le statut formaté
     */
    public function getFormattedStatusAttribute()
    {
        return $this->status === self::STATUS_ACTIVE ? 'Actif' : 'Inactif';
    }
}