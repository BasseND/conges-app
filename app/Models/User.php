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

    // Constantes pour les rôles
    const ROLE_ADMIN = 'admin';
    const ROLE_DEPARTMENT_HEAD = 'department_head';
    const ROLE_EMPLOYEE = 'employee';
    const ROLE_HR = 'hr';
    const ROLE_MANAGER = 'manager';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'employee_id',
        'department_id',
        'annual_leave_days',
        'sick_leave_days'
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
     * Vérifie si l'utilisateur est un administrateur
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Vérifie si l'utilisateur est un chef de département
     */
    public function isDepartmentHead(): bool
    {
        return $this->role === self::ROLE_DEPARTMENT_HEAD;
    }

    /**
     * Vérifie si l'utilisateur est un employé
     */
    public function isEmployee(): bool
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    /**
     * Get the team that the user belongs to.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the teams managed by the user.
     */
    public function managedTeams()
    {
        return $this->hasMany(Team::class, 'manager_id');
    }

    /**
     * Méthodes de vérification des rôles
     */
    public function isManager()
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function isHR()
    {
        return $this->role === self::ROLE_HR;
    }

    public function hasAdminAccess()
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_HR]);
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
