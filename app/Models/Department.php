<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Team;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'head_id'
    ];

    /**
     * Get the manager of the department.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get the employees in this department.
     */
    public function employees()
    {
        return $this->hasMany(User::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function head()
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
