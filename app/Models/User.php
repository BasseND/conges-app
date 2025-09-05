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
use App\Models\LeaveTransaction;
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

    // Constantes pour l'état civil
    const MARITAL_STATUS_MARRIED = 'marié';
    const MARITAL_STATUS_SINGLE = 'célibataire';
    const MARITAL_STATUS_WIDOWED = 'veuf';

    // Constantes pour le statut professionnel
    const EMPLOYMENT_STATUS_CIVIL_SERVANT = 'fonctionnaire';
    const EMPLOYMENT_STATUS_PERMANENT_CONTRACT = 'contractuel_cdi';
    const EMPLOYMENT_STATUS_FIXED_TERM_CONTRACT = 'contractuel_cdd';

    // Constantes pour les catégories
    const CATEGORY_EXECUTIVE = 'cadre';
    const CATEGORY_SUPERVISOR = 'agent_de_maitrise';
    const CATEGORY_EMPLOYEE = 'employe';
    const CATEGORY_WORKER = 'ouvrier';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'marital_status',
        'employment_status',
        'children_count',
        'phone',
        'email',
        'password',
        'role',
        'employee_id',
        'matricule',
        'affectation',
        'category',
        'section',
        'service',
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
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the notifications created by the user.
     */
    public function createdNotifications()
    {
        return $this->hasMany(Notification::class, 'created_by');
    }

    /**
     * Get the leave transactions for the user.
     */
    public function leaveTransactions()
    {
        return $this->hasMany(LeaveTransaction::class);
    }

    /**
     * Get the leave transactions created by the user.
     */
    public function createdLeaveTransactions()
    {
        return $this->hasMany(LeaveTransaction::class, 'created_by');
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
        // Les admins et RH peuvent gérer tous les congés
        if ($this->isAdmin() || $this->isHR()) {
            return true;
        }
        
        // Les chefs de département peuvent gérer les congés de leur département (mais pas leurs propres congés)
        if ($this->isDepartmentHead()) {
            return $this->department_id === $user->department_id && $this->id !== $user->id;
        }
        
        // Les managers peuvent gérer les congés des membres de leurs équipes (mais pas leurs propres congés)
        if ($this->isManager()) {
            // Ne peut pas gérer ses propres congés
            if ($this->id === $user->id) {
                return false;
            }
            // Vérifier si l'utilisateur fait partie d'une équipe gérée par ce manager
            return $user->teams()->whereHas('manager', function ($query) {
                $query->where('id', $this->id);
            })->exists();
        }
        
        return false;
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
     * @return float
     */
    public function getRemainingDaysAttribute()
    {
        return LeaveTransaction::getCurrentBalance($this->id, 'annual');
    }

    /**
     * Get the remaining maternity leave days for the user
     * 
     * @return float
     */
    public function getRemainingMaternityDaysAttribute()
    {
        return LeaveTransaction::getCurrentBalance($this->id, 'maternity');
    }

    /**
     * Get the remaining paternity leave days for the user
     * 
     * @return float
     */
    public function getRemainingPaternityDaysAttribute()
    {
        return LeaveTransaction::getCurrentBalance($this->id, 'paternity');
    }

    /**
     * Get the remaining special leave days for the user
     * 
     * @return float
     */
    public function getRemainingSpecialDaysAttribute()
    {
        return LeaveTransaction::getCurrentBalance($this->id, 'special');
    }

    /**
     * Get the remaining sick leave days for the user
     * 
     * @return float
     */
    public function getRemainingSickDaysAttribute()
    {
        return LeaveTransaction::getCurrentBalance($this->id, 'sick');
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
        
        // Sinon, vérifier si le département a un solde par défaut
        if ($this->department && $this->department->leaveBalance) {
            return $this->department->leaveBalance->annual_leave_days;
        }
        
        // Sinon, utiliser le solde par défaut de l'entreprise
        if ($this->company && $this->company->defaultLeaveBalance()) {
            return $this->company->defaultLeaveBalance()->annual_leave_days;
        }
        
        // Valeur par défaut
        return 25;
    }



    /**
     * Get the maternity leave days for the user (from leave balance)
     * 
     * @return int
     */
    public function getMaternityLeaveDaysAttribute()
    {
        // Si l'utilisateur a un solde de congés spécifique, l'utiliser
        if ($this->leaveBalance) {
            return $this->leaveBalance->maternity_leave_days;
        }
        
        // Sinon, vérifier si le département a un solde par défaut
        if ($this->department && $this->department->leaveBalance) {
            return $this->department->leaveBalance->maternity_leave_days;
        }
        
        // Sinon, utiliser le solde par défaut de l'entreprise
        if ($this->company && $this->company->defaultLeaveBalance()) {
            return $this->company->defaultLeaveBalance()->maternity_leave_days;
        }
        
        // Valeur par défaut (16 semaines = 112 jours)
        return 112;
    }

    /**
     * Get the paternity leave days for the user (from leave balance)
     * 
     * @return int
     */
    public function getPaternityLeaveDaysAttribute()
    {
        // Si l'utilisateur a un solde de congés spécifique, l'utiliser
        if ($this->leaveBalance) {
            return $this->leaveBalance->paternity_leave_days;
        }
        
        // Sinon, vérifier si le département a un solde par défaut
        if ($this->department && $this->department->leaveBalance) {
            return $this->department->leaveBalance->paternity_leave_days;
        }
        
        // Sinon, utiliser le solde par défaut de l'entreprise
        if ($this->company && $this->company->defaultLeaveBalance()) {
            return $this->company->defaultLeaveBalance()->paternity_leave_days;
        }
        
        // Valeur par défaut (25 jours)
        return 25;
    }

    /**
     * Get the special leave days for the user (from leave balance)
     * 
     * @return int
     */
    public function getSpecialLeaveDaysAttribute()
    {
        // Si l'utilisateur a un solde de congés spécifique, l'utiliser
        if ($this->leaveBalance) {
            return $this->leaveBalance->special_leave_days;
        }
        
        // Sinon, vérifier si le département a un solde par défaut
        if ($this->department && $this->department->leaveBalance) {
            return $this->department->leaveBalance->special_leave_days;
        }
        
        // Sinon, utiliser le solde par défaut de l'entreprise
        if ($this->company && $this->company->defaultLeaveBalance()) {
            return $this->company->defaultLeaveBalance()->special_leave_days;
        }
        
        // Valeur par défaut
        return 5;
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

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get marital status options
     *
     * @return array
     */
    public static function getMaritalStatusOptions()
    {
        return [
            self::MARITAL_STATUS_MARRIED => 'Marié(e)',
            self::MARITAL_STATUS_SINGLE => 'Célibataire',
            self::MARITAL_STATUS_WIDOWED => 'Veuf/Veuve'
        ];
    }

    /**
     * Get employment status options
     *
     * @return array
     */
    public static function getEmploymentStatusOptions()
    {
        return [
            self::EMPLOYMENT_STATUS_CIVIL_SERVANT => 'Fonctionnaire',
            self::EMPLOYMENT_STATUS_PERMANENT_CONTRACT => 'Contractuel - CDI',
            self::EMPLOYMENT_STATUS_FIXED_TERM_CONTRACT => 'Contractuel - CDD'
        ];
    }

    /**
     * Get category options
     *
     * @return array
     */
    public static function getCategoryOptions()
    {
        return [
            self::CATEGORY_EXECUTIVE => 'Cadre',
            self::CATEGORY_SUPERVISOR => 'Agent de maîtrise',
            self::CATEGORY_EMPLOYEE => 'Employé',
            self::CATEGORY_WORKER => 'Ouvrier'
        ];
    }

    /**
     * Get formatted marital status
     *
     * @return string
     */
    public function getFormattedMaritalStatusAttribute()
    {
        $options = self::getMaritalStatusOptions();
        return $options[$this->marital_status] ?? $this->marital_status;
    }

    /**
     * Get formatted employment status
     *
     * @return string
     */
    public function getFormattedEmploymentStatusAttribute()
    {
        $options = self::getEmploymentStatusOptions();
        return $options[$this->employment_status] ?? $this->employment_status;
    }

    /**
     * Get formatted category
     *
     * @return string
     */
    public function getFormattedCategoryAttribute()
    {
        $options = self::getCategoryOptions();
        return $options[$this->category] ?? $this->category;
    }

    /**
     * Get marital status label
     *
     * @return string
     */
    public function getMaritalStatusLabel()
    {
        $options = self::getMaritalStatusOptions();
        return $options[$this->marital_status] ?? 'Non renseigné';
    }

    /**
     * Get employment status label
     *
     * @return string
     */
    public function getEmploymentStatusLabel()
    {
        $options = self::getEmploymentStatusOptions();
        return $options[$this->employment_status] ?? 'Non renseigné';
    }

    /**
     * Get category label
     *
     * @return string
     */
    public function getCategoryLabel()
    {
        $options = self::getCategoryOptions();
        return $options[$this->category] ?? 'Non renseigné';
    }
}
