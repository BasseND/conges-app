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

    // Note: Les types de congés sont maintenant définis via LeaveBalance

    protected $fillable = [
        'user_id',
        'type',
        'leave_balance_id',
        'special_leave_type_id',
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

    public function specialLeaveType()
    {
        return $this->belongsTo(SpecialLeaveType::class);
    }

    /**
     * Get the leave balance that defines this leave type.
     */
    public function leaveBalance()
    {
        return $this->belongsTo(LeaveBalance::class);
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
        // Nouveau système : utiliser le LeaveBalance si disponible
        if ($this->leaveBalance) {
            return $this->leaveBalance->description ?? 'Congé personnalisé';
        }
        
        // Legacy : ancien système avec types spéciaux
        if ($this->type === 'special' && $this->specialLeaveType) {
            return $this->specialLeaveType->name;
        }
        
        // Legacy : types hardcodés
        return self::TYPES[$this->type] ?? $this->type;
    }

    /**
     * Obtenir la durée maximale autorisée pour ce type de congé
     */
    public function getMaxDurationAttribute()
    {
        // Nouveau système : utiliser le LeaveBalance
        if ($this->leaveBalance) {
            // Déterminer le type de congé basé sur la description ou un champ spécifique
            $description = strtolower($this->leaveBalance->description ?? '');
            
            if (str_contains($description, 'annuel') || str_contains($description, 'annual')) {
                return $this->leaveBalance->annual_leave_days;
            } elseif (str_contains($description, 'maternité') || str_contains($description, 'maternity')) {
                return $this->leaveBalance->maternity_leave_days;
            } elseif (str_contains($description, 'paternité') || str_contains($description, 'paternity')) {
                return $this->leaveBalance->paternity_leave_days;
            } else {
                return $this->leaveBalance->special_leave_days;
            }
        }
        
        // Legacy : ancien système
        if ($this->type === 'special' && $this->specialLeaveType) {
            return $this->specialLeaveType->duration_days;
        }
        
        // Legacy : types hardcodés
        return match($this->type) {
            'annual' => 30,
            'sick' => 90,
            'unpaid' => 60,
            'maternity' => 120,
            'paternity' => 15,
            'other' => 5,
            default => 30,
        };
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
