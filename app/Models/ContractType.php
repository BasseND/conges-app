<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractType extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'system_name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the company that owns the contract type.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the contracts for the contract type.
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Scope a query to only include active contract types.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by company.
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Generate a unique system name based on the display name.
     */
    public static function generateSystemName($name, $companyId, $excludeId = null)
    {
        $baseSystemName = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $name), '_'));
        $systemName = $baseSystemName;
        $counter = 1;

        while (self::systemNameExists($systemName, $companyId, $excludeId)) {
            $systemName = $baseSystemName . '_' . $counter;
            $counter++;
        }

        return $systemName;
    }

    /**
     * Check if a system name already exists for the company.
     */
    public static function systemNameExists($systemName, $companyId, $excludeId = null)
    {
        $query = self::where('company_id', $companyId)
                    ->where('system_name', $systemName);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Check if a name already exists for the company.
     */
    public static function nameExists($name, $companyId, $excludeId = null)
    {
        $query = self::where('company_id', $companyId)
                    ->where('name', $name);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}