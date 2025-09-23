<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AttestationRequest extends Model
{
    use HasFactory;

    // Constantes pour les catégories
    const CATEGORY_HR_GENERATED = 'hr_generated';
    const CATEGORY_EMPLOYEE_REQUEST = 'employee_request';

    /**
     * Les statuts possibles pour une demande d'attestation
     */
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_SIGNED = 'signed';
    const STATUS_GENERATED = 'generated';
    const STATUS_DRAFT = 'draft';
    const STATUS_SENT = 'sent';
    const STATUS_ARCHIVED = 'archived';

    /**
     * Les priorités possibles
     */
    const PRIORITY_LOW = 'low';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    protected $fillable = [
        'user_id',
        'attestation_type_id',
        'category',
        'status',
        'priority',
        'start_date',
        'end_date',
        'custom_data',
        'notes',
        'processed_by',
        'processed_at',
        'rejection_reason',
        'pdf_path',
        'generated_at',
        'generated_by',
        'document_number',
        'sent_at',
        'archived_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'processed_at' => 'datetime',
        'generated_at' => 'datetime',
        'sent_at' => 'datetime',
        'archived_at' => 'datetime',
        'custom_data' => 'array'
    ];

    /**
     * Get the user who made the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attestation type.
     */
    public function attestationType()
    {
        return $this->belongsTo(AttestationType::class);
    }

    /**
     * Get the user who processed the request.
     */
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Get the user who generated the attestation.
     */
    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Scope pour récupérer les demandes en attente
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope pour récupérer les demandes approuvées
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope pour récupérer les demandes d'un utilisateur
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Vérifier si la demande est en attente
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Vérifier si la demande est approuvée
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Vérifier si la demande est rejetée
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Vérifier si l'attestation a été générée
     */
    public function isGenerated()
    {
        return $this->status === self::STATUS_GENERATED;
    }

    /**
     * Vérifier si la demande est en brouillon
     */
    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Vérifier si l'attestation a été envoyée
     */
    public function isSent()
    {
        return $this->status === self::STATUS_SENT;
    }

    /**
     * Vérifier si l'attestation est archivée
     */
    public function isArchived()
    {
        return $this->status === self::STATUS_ARCHIVED;
    }

    /**
     * Obtenir le statut formaté
     */
    public function getFormattedStatusAttribute()
    {
        $statuses = [
            self::STATUS_PENDING => 'En attente',
            self::STATUS_APPROVED => 'Approuvée',
            self::STATUS_REJECTED => 'Rejetée',
            self::STATUS_GENERATED => 'Générée',
            self::STATUS_DRAFT => 'Brouillon',
            self::STATUS_SENT => 'Envoyée',
            self::STATUS_ARCHIVED => 'Archivée'
        ];

        return $statuses[$this->status] ?? 'Statut inconnu';
    }

    /**
     * Obtenir la priorité formatée
     */
    public function getFormattedPriorityAttribute()
    {
        $priorities = [
            self::PRIORITY_LOW => 'Faible',
            self::PRIORITY_NORMAL => 'Normale',
            self::PRIORITY_HIGH => 'Élevée',
            self::PRIORITY_URGENT => 'Urgente'
        ];

        return $priorities[$this->priority] ?? 'Normale';
    }

    /**
     * Obtenir la classe CSS pour la priorité
     */
    public function getPriorityClassAttribute()
    {
        $classes = [
            self::PRIORITY_LOW => 'text-gray-600',
            self::PRIORITY_NORMAL => 'text-blue-600',
            self::PRIORITY_HIGH => 'text-orange-600',
            self::PRIORITY_URGENT => 'text-red-600'
        ];

        return $classes[$this->priority] ?? 'text-blue-600';
    }

    /**
     * Obtenir la classe CSS pour le statut
     */
    public function getStatusClassAttribute()
    {
        $classes = [
            self::STATUS_PENDING => 'text-yellow-600 bg-yellow-100',
            self::STATUS_APPROVED => 'text-green-600 bg-green-100',
            self::STATUS_REJECTED => 'text-red-600 bg-red-100',
            self::STATUS_GENERATED => 'text-blue-600 bg-blue-100',
            self::STATUS_DRAFT => 'text-gray-600 bg-gray-100',
            self::STATUS_SENT => 'text-purple-600 bg-purple-100',
            self::STATUS_ARCHIVED => 'text-indigo-600 bg-indigo-100'
        ];

        return $classes[$this->status] ?? 'text-gray-600 bg-gray-100';
    }

    /**
     * Obtenir les statuts disponibles
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'En attente',
            self::STATUS_APPROVED => 'Approuvé',
            self::STATUS_REJECTED => 'Rejeté',
            self::STATUS_GENERATED => 'Généré',
            self::STATUS_DRAFT => 'Brouillon',
            self::STATUS_SENT => 'Envoyé',
            self::STATUS_ARCHIVED => 'Archivé'
        ];
    }
}