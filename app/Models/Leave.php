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
        'rejected' => 'Rejeté',
        'cancelled' => 'Annulé'
    ];

    // Les types de congés sont définis via le modèle SpecialLeaveType
    // La relation specialLeaveType() permet d'accéder aux types configurés

    protected $fillable = [
        'user_id',
        'special_leave_type_id',
        'start_date',
        'end_date',
        'duration',
        'reason',
        'status',
        'processed_by',
        'processed_at',
        'rejection_reason',
        'approved_by',
        'cancelled_by',
        'cancelled_at',
        'cancellation_reason'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'processed_at' => 'datetime',
        'cancelled_at' => 'datetime'
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

    public function canceller()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public function specialLeaveType()
    {
        return $this->belongsTo(SpecialLeaveType::class);
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
        // Utiliser SpecialLeaveType
        if ($this->specialLeaveType) {
            return $this->specialLeaveType->name;
        }
        
        return 'Congé';
    }

    /**
     * Obtenir le system_name du type de congé
     */
    public function getSystemNameAttribute()
    {
        return $this->specialLeaveType?->system_name;
    }

    /**
     * Obtenir la durée maximale autorisée pour ce type de congé
     */
    public function getMaxDurationAttribute()
    {
        // Utiliser SpecialLeaveType si disponible
        if ($this->specialLeaveType) {
            // Déterminer le type de congé basé sur le nom ou la description
            $name = strtolower($this->specialLeaveType->name ?? '');
            $description = strtolower($this->specialLeaveType->description ?? '');
            
            if (str_contains($name, 'annuel') || str_contains($description, 'annuel') || 
                str_contains($name, 'annual') || str_contains($description, 'annual')) {
                return $this->specialLeaveType->annual_leave_days ?? $this->specialLeaveType->duration_days;
            } elseif (str_contains($name, 'maternité') || str_contains($description, 'maternité') ||
                     str_contains($name, 'maternity') || str_contains($description, 'maternity')) {
                return $this->specialLeaveType->maternity_leave_days ?? $this->specialLeaveType->duration_days;
            } elseif (str_contains($name, 'paternité') || str_contains($description, 'paternité') ||
                     str_contains($name, 'paternity') || str_contains($description, 'paternity')) {
                return $this->specialLeaveType->paternity_leave_days ?? $this->specialLeaveType->duration_days;
            } else {
                return $this->specialLeaveType->special_leave_days ?? $this->specialLeaveType->duration_days;
            }
        }
        
        // Valeur par défaut si aucun SpecialLeaveType n'est défini
        return 30;
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
