<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Team;
use App\Models\Leave;
use App\Models\ExpenseReport;
use App\Models\ExpenseLine;
use App\Models\Payslip;
use App\Models\SalaryAdvance;
use Carbon\Carbon;

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
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'role',
        'employee_id',
        'department_id',
        'company_id',
        'leave_balance_id',

        'is_active',
        'position',
        'is_prestataire'
        //'team_id'
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
     * Get the company that the user belongs to.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the leave balance that the user belongs to.
     */
    public function leaveBalance()
    {
        return $this->belongsTo(LeaveBalance::class);
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
     * Vérifie si l'utilisateur est RH
     */
    public function isHR(): bool
    {
        return $this->role === self::ROLE_HR;
    }

    /**
     * Get the team that the user belongs to.
     */
    // public function team()
    // {
    //     return $this->belongsTo(Team::class);
    // }

     /**
     * Get the teams that the user belongs to.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
    }

    /**
     * Get the teams managed by the user.
     */
    public function managedTeams()
    {
        return $this->hasMany(Team::class, 'manager_id');
    }

    /**
     * Get the contracts created by the user.
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get the documents for the user.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the expense reports created by the user.
     */
    public function expenseReports()
    {
        return $this->hasMany(ExpenseReport::class);
    }

    /**
     * Get the expense lines created by the user.
     */
    public function expenseLines()
    {
        return $this->hasMany(ExpenseLine::class);
    }

    /**
     * Get the payslips for the user.
     */
    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    /**
     * Get the salary advances for the user.
     */
    public function salaryAdvances()
    {
        return $this->hasMany(SalaryAdvance::class);
    }

    /**
     * Get the approved salary advances (as an approver).
     */
    public function approvedSalaryAdvances()
    {
        return $this->hasMany(SalaryAdvance::class, 'approved_by');
    }

    /**
     * Méthodes de vérification des rôles
     */
    public function isManager()
    {
        return $this->role === self::ROLE_MANAGER;
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
               ($this->isManager() && $this->department_id === $user->department_id) ||
               ($this->isDepartmentHead() && $this->department_id === $user->department_id);
    }

    public function canApproveExpenseReports(): bool
    {
        return $this->isAdmin() || $this->isHR();
    }

    public function canPayExpenseReports(): bool
    {
        return $this->isAdmin() || $this->isHR();
    }

    /**
     * Get the roles available for the user.
     */
    public static function getRoles()
    {
        return [
            self::ROLE_EMPLOYEE => 'Employé',
            self::ROLE_MANAGER => 'Manager',
            self::ROLE_ADMIN => 'Administrateur',
            self::ROLE_HR => 'RH',
            self::ROLE_DEPARTMENT_HEAD => 'Chef de Département',
        ];
    }

    /**
     * Get the remaining days of leave for the user
     * 
     * @return int
     */
    public function getRemainingDaysAttribute()
    {
        // Si l'utilisateur a un solde de congés spécifique, utiliser le solde actuel
        if ($this->leaveBalance) {
            return $this->leaveBalance->annual_leave_days;
        }
        
        // Sinon, calculer à partir du solde par défaut moins les congés utilisés
        $usedLeaves = $this->leaves()
            ->whereYear('start_date', now()->year)
            ->where('status', 'approved')
            ->where('type', 'annual')
            ->sum('duration');

        $annualLeaveDays = $this->getAnnualLeaveDaysAttribute();
        
        return max(0, $annualLeaveDays - $usedLeaves);
    }

    /**
     * Get the annual leave days for the user (from leave balance)
     * 
     * @return int
     */
    public function getAnnualLeaveDaysAttribute()
    {
        // Si l'utilisateur a un solde de congés spécifique, l'utiliser
        if ($this->leaveBalance) {
            return $this->leaveBalance->annual_leave_days;
        }
        
        // Sinon, utiliser le solde par défaut de l'entreprise
        if ($this->company && $this->company->defaultLeaveBalance()) {
            return $this->company->defaultLeaveBalance()->annual_leave_days;
        }
        
        // Valeur par défaut
        return 25;
    }

    /**
     * Get the sick leave days for the user (from leave balance)
     * 
     * @return int
     */
    public function getSickLeaveDaysAttribute()
    {
        // Si l'utilisateur a un solde de congés spécifique, l'utiliser
        if ($this->leaveBalance) {
            return $this->leaveBalance->sick_leave_days;
        }
        
        // Sinon, utiliser le solde par défaut de l'entreprise
        if ($this->company && $this->company->defaultLeaveBalance()) {
            return $this->company->defaultLeaveBalance()->sick_leave_days;
        }
        
        // Valeur par défaut
        return 12;
    }

    /**
     * Get the next leave date for the user
     * 
     * @return string|null
     */
    public function getNextLeaveDateAttribute()
    {
        $nextLeave = $this->leaves()
            ->where('start_date', '>=', now())
            ->where('status', 'approved')
            ->orderBy('start_date', 'asc')
            ->first();

        if (!$nextLeave) {
            return 'Aucun congé prévu';
        }

        $mois = [
            1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
            5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
            9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
        ];
        
        $jour = $nextLeave->start_date->day;
        $moisNum = $nextLeave->start_date->month;
        $annee = $nextLeave->start_date->year;
        
        return $jour . ' ' . $mois[$moisNum] . ' ' . $annee;
    }

    /**
     * Get the number of pending notes (expense reports) for the user
     * 
     * @return int
     */
    public function getPendingNotesAttribute()
    {
        if ($this->isAdmin() || $this->isHR()) {
            // Pour admin et RH, compter toutes les notes en attente
            return ExpenseReport::whereIn('status', ['submitted'])
                ->count();
        }

        // Pour les autres utilisateurs, compter leurs propres notes en attente
        return $this->expenseReports()
            ->whereIn('status', ['submitted'])
            ->count();
    }

    public function routeNotificationForMail()
    {
        Log::info('routeNotificationForMail appelé', [
            'user_id' => $this->id,
            'email' => $this->email
        ]);
        return $this->email;
    }
}
