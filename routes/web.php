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
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\LeaveBalanceController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\TestMailController;
use App\Http\Controllers\Expense\ExpenseReportController;
use App\Http\Controllers\Expense\ExpenseLineController;
use App\Http\Controllers\Payroll\PayslipController;
use App\Http\Controllers\Payroll\SalaryAdvanceController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\NotificationController;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

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

// Route pour servir les fichiers storage (contournement du lien symbolique)
Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    
    if (!file_exists($file)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($file);
    
    return response()->file($file, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');


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
    Route::post('leaves/{leave}/submit', [LeaveController::class, 'submit'])->name('leaves.submit');
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
    Route::post('expense-reports/{expense_report}/submit', [ExpenseReportController::class, 'submit'])->name('expense-reports.submit');
    Route::post('expense-reports/{expense_report}/approve', [ExpenseReportController::class, 'approve'])->name('expense-reports.approve');
    Route::post('expense-reports/{expense_report}/reject', [ExpenseReportController::class, 'reject'])->name('expense-reports.reject');
    Route::post('expense-reports/{expense_report}/pay', [ExpenseReportController::class, 'pay'])->name('expense-reports.pay');
    Route::resource('expense-reports.expense-lines', ExpenseLineController::class)->shallow();
    Route::get('expense-lines/{expense_line}/receipt', [ExpenseLineController::class, 'downloadReceipt'])->name('expense-lines.receipt');

    // Routes pour les bulletins de paie des utilisateurs
    Route::get('payslips', [App\Http\Controllers\PayslipController::class, 'index'])->name('payslips.index');
    Route::get('payslips/{payslip}', [App\Http\Controllers\PayslipController::class, 'show'])->name('payslips.show');
    Route::get('payslips/{payslip}/generate-pdf', [App\Http\Controllers\PayslipController::class, 'generatePdf'])->name('payslips.generatePdf');

    // Routes pour les profils
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour les avances sur salaire
    Route::get('salary-advances', [SalaryAdvanceController::class, 'index'])->name('salary-advances.index');
    Route::get('salary-advances/create', [SalaryAdvanceController::class, 'create'])->name('salary-advances.create');
    Route::post('salary-advances', [SalaryAdvanceController::class, 'store'])->name('salary-advances.store');
    Route::get('salary-advances/{salaryAdvance}', [SalaryAdvanceController::class, 'show'])->name('salary-advances.show');
    Route::post('salary-advances/{salaryAdvance}/cancel', [SalaryAdvanceController::class, 'cancel'])->name('salary-advances.cancel');

    // Routes pour les notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.delete-all');
    Route::get('notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Routes pour les managers
    Route::middleware('role:manager')->name('manager.')->prefix('manager')->group(function () {
        Route::get('leaves', [\App\Http\Controllers\Manager\LeaveController::class, 'index'])->name('leaves.index');
        Route::post('leaves/{leave}/approve', [\App\Http\Controllers\Manager\LeaveController::class, 'approve'])->name('leaves.approve');
        Route::post('leaves/{leave}/reject', [\App\Http\Controllers\Manager\LeaveController::class, 'reject'])->name('leaves.reject');
    });

    // Routes pour les chefs de département
    Route::middleware('role:department_head')->name('head.')->prefix('head')->group(function () {
        Route::get('leaves', [\App\Http\Controllers\Head\LeaveController::class, 'index'])->name('leaves.index');
        Route::post('leaves/{leave}/approve', [\App\Http\Controllers\Head\LeaveController::class, 'approve'])->name('leaves.approve');
        Route::post('leaves/{leave}/reject', [\App\Http\Controllers\Head\LeaveController::class, 'reject'])->name('leaves.reject');
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
        Route::delete('leaves/{leave}', [AdminLeaveController::class, 'destroy'])->name('admin.leaves.destroy');

        // Gestion des contrats
        Route::get('contracts', [ContractController::class, 'index'])->name('contracts.index');
        Route::get('contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
        Route::put('contracts/{contract}', [ContractController::class, 'updateContract'])->name('contracts.update');

        // Paramètres de paie
        Route::resource('payroll-settings', PayrollSettingController::class);

        // Gestion des bulletins de paie
        Route::prefix('payslips')->name('payslips.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\PayslipController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\PayslipController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\PayslipController::class, 'store'])->name('store');
            
            // Nouvelles routes pour les actions en masse
            Route::get('/batch/validate', [App\Http\Controllers\Admin\PayslipController::class, 'batchValidateForm'])->name('batch-validate-form');
            Route::post('/batch/validate', [App\Http\Controllers\Admin\PayslipController::class, 'batchValidate'])->name('batch-validate');
            Route::get('/batch/pdf', [App\Http\Controllers\Admin\PayslipController::class, 'batchPdfForm'])->name('batch-pdf-form');
            Route::post('/batch/pdf', [App\Http\Controllers\Admin\PayslipController::class, 'batchPdf'])->name('batch-pdf');
            
            // Routes avec des paramètres
            Route::get('/{payslip}', [App\Http\Controllers\Admin\PayslipController::class, 'show'])->name('show');
            Route::get('/{payslip}/edit', [App\Http\Controllers\Admin\PayslipController::class, 'edit'])->name('edit');
            Route::put('/{payslip}', [App\Http\Controllers\Admin\PayslipController::class, 'update'])->name('update');
            Route::post('/{payslip}/validatePayslip', [App\Http\Controllers\Admin\PayslipController::class, 'validatePayslip'])->name('validatePayslip');
            Route::post('/{payslip}/mark-as-paid', [App\Http\Controllers\Admin\PayslipController::class, 'markAsPaid'])->name('markAsPaid');
            Route::get('/{payslip}/pdf', [App\Http\Controllers\Admin\PayslipController::class, 'generatePdf'])->name('generatePdf');
        });

        // Gestion des utilisateurs
        Route::resource('users', UserController::class);
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('users/api', [UserController::class, 'apiIndex'])->name('users.api');
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
        Route::get('departments/{department}/leave-balances', [LeaveBalanceController::class, 'getByCompany'])->name('departments.leave-balances');

        // Gestion des soldes de congés
        Route::resource('leave-balances', LeaveBalanceController::class);

        // Gestion de la société
        Route::get('company', [CompanyController::class, 'show'])->name('company.show');
        Route::get('company/create', [CompanyController::class, 'create'])->name('company.create');
        Route::post('company', [CompanyController::class, 'store'])->name('company.store');
        Route::get('company/edit', [CompanyController::class, 'edit'])->name('company.edit');
        Route::put('company', [CompanyController::class, 'update'])->name('company.update');
        
        // Routes pour les soldes de congés de la société
        Route::post('company/leave-balances', [CompanyController::class, 'storeLeaveBalance'])->name('company.leave-balances.store');
        Route::put('company/leave-balances/{leaveBalance}', [CompanyController::class, 'updateLeaveBalance'])->name('company.leave-balances.update');
        Route::delete('company/leave-balances/{leaveBalance}', [CompanyController::class, 'destroyLeaveBalance'])->name('company.leave-balances.destroy');
    });
});
