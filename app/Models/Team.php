<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department_id',
        'manager_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // public function members()
    // {
    //     return $this->hasMany(User::class);
    // }
     public function members()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }
}
