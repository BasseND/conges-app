<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id',
        'role',
        'department_id',
        'annual_leave_days',
        'sick_leave_days',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'annual_leave_days' => 'integer',
        'sick_leave_days' => 'integer'
    ];

    /**
     * Get the leaves for the user.
     */
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    /**
     * Get the department that the user belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Méthodes de vérification des rôles
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    /**
     * Get all employees in the same department.
     */
    public function departmentEmployees()
    {
        return User::where('department_id', $this->department_id)
                  ->where('id', '!=', $this->id)
                  ->where('role', 'employee')
                  ->get();
    }

    /**
     * Check if the user can manage another user's leaves.
     */
    public function canManageUserLeaves(User $user): bool
    {
        return $this->isAdmin() || 
               ($this->isManager() && $this->department_id === $user->department_id);
    }
}
