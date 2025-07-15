<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\LeaveAttachment;
use Carbon\Carbon;

class Leave extends Model
{
    use HasFactory;

    /**
     * Les statuts possibles pour une demande de congé
     */
    const STATUSES = [
        'draft' => 'Brouillon',
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
        'maternity' => 'Maternité',
        'paternity' => 'Paternité',
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
        'rejection_reason',
        'approved_by'
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

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
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

    /**
     * Get the duration in days (excluding weekends)
     */
    public function getDurationDaysAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }

        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        $duration = 0;

        for ($date = $start; $date->lte($end); $date->addDay()) {
            if (!$date->isWeekend()) {
                $duration++;
            }
        }

        return $duration;
    }
}
