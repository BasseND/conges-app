<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'director_name',
        'hr_director_name',
        'hr_signature',
        'logo',
        'website_url',
        'address',
        'city',
        'country',
        'postal_code',
        'registration_number',
        'location',
        'contact_email',
        'contact_phone',
        'currency',
        'salary_advance_deadline_day',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the users for the company.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the departments for the company.
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get the contracts for the company.
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get the special leave types for the company.
     */
    public function specialLeaveTypes(): HasMany
    {
        return $this->hasMany(SpecialLeaveType::class);
    }

    // Relations LeaveBalance supprimées - remplacées par SpecialLeaveType
}