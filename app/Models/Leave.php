<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\LeaveAttachment;

class Leave extends Model
{
    use HasFactory;

    /**
     * Les statuts possibles pour une demande de congé
     */
    const STATUSES = [
        'pending' => 'En attente',
        'approved' => 'Approuvé',
        'rejected' => 'Rejeté'
    ];

    /**
     * Les types de congés disponibles
     */
    const TYPES = [
        'annual' => 'Annuel',
        'sick' => 'Maladie',
        'unpaid' => 'Sans solde',
        'other' => 'Autre'
    ];

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'duration',
        'reason',
        'status',
        'processed_by',
        'processed_at',
        'rejection_reason'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'processed_at' => 'datetime'
    ];

    /**
     * Get the user that owns the leave request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function attachments()
    {
        return $this->hasMany(LeaveAttachment::class);
    }

    /**
     * Obtenir le libellé du statut
     */
    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /**
     * Obtenir le libellé du type de congé
     */
    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
