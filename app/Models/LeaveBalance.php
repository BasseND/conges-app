<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'annual_leave_days',
        'maternity_leave_days',
        'paternity_leave_days',
        'special_leave_days',
        'is_default',
        'description'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the company that owns the leave balance.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the users that have this leave balance.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the departments that use this leave balance as default.
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Scope to get default leave balance for a company.
     */
    public function scopeDefault($query, $companyId)
    {
        return $query->where('company_id', $companyId)->where('is_default', true);
    }

    /**
     * Get the total leave days.
     */
    public function getTotalLeaveDaysAttribute()
    {
        return $this->annual_leave_days + 
               $this->maternity_leave_days + $this->paternity_leave_days + 
               $this->special_leave_days;
    }
}