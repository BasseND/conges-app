<?php

use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LeaveController as AdminLeaveController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\PayrollSettingController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\TestMailController;
use App\Http\Controllers\Expense\ExpenseReportController;
use App\Http\Controllers\Expense\ExpenseLineController;
use App\Http\Controllers\Payroll\PayslipController;
use App\Http\Controllers\Payroll\SalaryAdvanceController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

// Routes protégées par l'authentification
Route::middleware('auth')->group(function () {
    // Mot de passe et déconnexion
    Route::get('confirmable-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirmable');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Routes protégées par l'authentification et la vérification email
Route::middleware(['auth', 'verified'])->group(function () {
    // Page d'accueil
    Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');
    
    // Route par défaut redirige vers les congés
    Route::get('/dashboard', function () {
        return redirect()->route('leaves.index');
    })->name('dashboard');

    // Page d'aide
    Route::get('/help', [HelpController::class, 'index'])->name('help.index');

    // Routes pour les congés (accessibles à tous les utilisateurs authentifiés)
    Route::get('leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::get('leaves/{leave}', [LeaveController::class, 'show'])->name('leaves.show');
    Route::get('leaves/{leave}/edit', [LeaveController::class, 'edit'])->name('leaves.edit');
    Route::put('leaves/{leave}', [LeaveController::class, 'update'])->name('leaves.update');
    Route::delete('leaves/{leave}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
    Route::get('leaves/download/{attachment}', [LeaveController::class, 'downloadAttachment'])->name('leaves.attachment.download');

    // Routes pour l'approbation des congés (accessibles uniquement aux managers et admins)
    Route::middleware('role:manager,admin')->group(function () {
        Route::get('pending-leaves', [LeaveApprovalController::class, 'pending'])->name('leaves.pending');
        Route::post('leaves/{leave}/approve', [LeaveApprovalController::class, 'approve'])->name('leaves.approve');
        Route::post('leaves/{leave}/reject', [LeaveApprovalController::class, 'reject'])->name('leaves.reject');
    });

    // Routes pour les notes de frais
    Route::resource('expense-reports', ExpenseReportController::class);
    Route::post('expense-reports/{expense_report}/approve', [ExpenseReportController::class, 'approve'])->name('expense-reports.approve');
    Route::post('expense-reports/{expense_report}/submit', [ExpenseReportController::class, 'submit'])->name('expense-reports.submit');
    Route::post('expense-reports/{expense_report}/reject', [ExpenseReportController::class, 'reject'])->name('expense-reports.reject');
    Route::post('expense-reports/{expense_report}/pay', [ExpenseReportController::class, 'pay'])->name('expense-reports.pay');
    Route::resource('expense-reports.lines', ExpenseLineController::class)->shallow();

    // Routes pour le profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour les bulletins de paie
    Route::get('payslips', [PayslipController::class, 'index'])->name('payslips.index');
    Route::get('payslips/{payslip}', [PayslipController::class, 'show'])->name('payslips.show');
    Route::get('payslips/{payslip}/download', [PayslipController::class, 'download'])->name('payslips.download');

    // Routes pour les avances sur salaire
    Route::get('salary-advances', [SalaryAdvanceController::class, 'index'])->name('salary-advances.index');
    Route::get('salary-advances/create', [SalaryAdvanceController::class, 'create'])->name('salary-advances.create');
    Route::post('salary-advances', [SalaryAdvanceController::class, 'store'])->name('salary-advances.store');
    Route::get('salary-advances/{salaryAdvance}', [SalaryAdvanceController::class, 'show'])->name('salary-advances.show');
    Route::post('salary-advances/{salaryAdvance}/cancel', [SalaryAdvanceController::class, 'cancel'])->name('salary-advances.cancel');

    // Routes pour les managers
    Route::middleware('role:manager')->name('manager.')->prefix('manager')->group(function () {
        Route::get('leaves', [LeaveController::class, 'managerIndex'])->name('leaves.index');
    });

    // Routes pour les chefs de département
    Route::middleware('role:department_head')->name('head.')->prefix('head')->group(function () {
        Route::get('leaves', [LeaveController::class, 'headIndex'])->name('leaves.index');
    });

    // Routes pour les administrateurs et RH
    Route::middleware('role:admin,hr')->name('admin.')->prefix('admin')->group(function () {
        // Statistiques
        Route::get('stats', [StatsController::class, 'index'])->name('stats.index');

        // Gestion des congés
        Route::get('leaves', [AdminLeaveController::class, 'index'])->name('leaves.index');
        Route::get('leaves/{leave}', [AdminLeaveController::class, 'show'])->name('leaves.show');
        Route::post('leaves/{leave}/approve', [AdminLeaveController::class, 'approve'])->name('leaves.approve');
        Route::post('leaves/{leave}/reject', [AdminLeaveController::class, 'reject'])->name('leaves.reject');
        Route::delete('leaves/{leave}', [AdminLeaveController::class, 'destroy'])->name('leaves.destroy');

        // Paramètres de paie
        Route::resource('payroll-settings', PayrollSettingController::class);

        // Gestion des utilisateurs
        Route::resource('users', UserController::class);
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        // Route::get('users/{user}', [UserController::class, 'edit'])->name('users.edit-profile-infos');
        
        // Document routes
        Route::post('/users/{user}/documents', [DocumentController::class, 'store'])->name('users.documents.store');
        Route::get('/users/{user}/documents/{document}/download', [DocumentController::class, 'download'])->name('users.documents.download');
        Route::delete('/users/{user}/documents/{document}', [DocumentController::class, 'destroy'])->name('users.documents.destroy');
        Route::patch('/users/{user}/documents/{document}/status', [DocumentController::class, 'updateStatus'])->name('users.documents.update-status');
        Route::get('/users/{user}/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('users.contracts.edit');
        Route::put('/users/{user}/contracts/{contract}', [ContractController::class, 'update'])->name('users.contracts.update');
       
        // Contract routes
        Route::post('/users/{user}/contracts', [ContractController::class, 'store'])->name('users.contracts.store');
        Route::get('/users/{user}/contracts/{contract}/download', [ContractController::class, 'download'])->name('users.contracts.download');
        Route::delete('/users/{user}/contracts/{contract}', [ContractController::class, 'destroy'])->name('users.contracts.destroy');

        // Gestion des départements
        Route::resource('departments', DepartmentController::class);
        Route::get('departments/{department}/teams', [TeamController::class, 'index'])->name('departments.teams.index');
        Route::post('departments/{department}/teams', [TeamController::class, 'store'])->name('departments.teams.store');
        Route::get('departments/{department}/teams/create', [TeamController::class, 'create'])->name('departments.teams.create');
        Route::get('departments/{department}/teams/{team}/edit', [TeamController::class, 'edit'])->name('departments.teams.edit');
        Route::put('departments/{department}/teams/{team}', [TeamController::class, 'update'])->name('departments.teams.update');
        Route::delete('departments/{department}/teams/{team}', [TeamController::class, 'destroy'])->name('departments.teams.destroy');
    });
});
