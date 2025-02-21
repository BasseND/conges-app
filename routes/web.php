<?php

use App\Http\Controllers\Auth\CustomAuthController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LeaveController as AdminLeaveController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\TestMailController;
use App\Http\Controllers\Expense\ExpenseReportController;
use App\Http\Controllers\Expense\ExpenseLineController;
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
    Route::get('login', [CustomAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [CustomAuthController::class, 'login']);
    Route::get('register', [CustomAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [CustomAuthController::class, 'register']);
    Route::get('forgot-password', [CustomAuthController::class, 'showPasswordResetForm'])->name('password.request');
});



// Routes protégées par l'authentification et la vérification email
Route::middleware(['auth', 'verify.email'])->group(function () {

    // Route Home page (welcome.blade.php)
    Route::get('/', function () {
        return view('welcome');
    });
    // Route par défaut redirige vers les congés
    Route::get('/leaves', function () {
        return redirect()->route('leaves.index');
    });

    // Page d'aide
    Route::get('/help', [HelpController::class, 'index'])->name('help.index');

    // Routes de gestion du compte
    Route::get('password/update', [CustomAuthController::class, 'showPasswordUpdateForm'])->name('password.update.form');
    Route::post('password/update', [CustomAuthController::class, 'updatePassword'])->name('password.update');
    Route::post('logout', [CustomAuthController::class, 'logout'])->name('logout');

    // Routes pour les congés (accessibles à tous les utilisateurs authentifiés)
    Route::resource('leaves', LeaveController::class);
    Route::get('leaves/download/{attachment}', [LeaveController::class, 'downloadAttachment'])->name('leaves.attachment.download');
    Route::delete('leaves/{leave}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
    Route::get('leaves/{leave}/edit', [LeaveController::class, 'edit'])->name('leaves.edit');
    Route::put('leaves/{leave}', [LeaveController::class, 'update'])->name('leaves.update');

    // Routes pour l'approbation des congés (accessibles uniquement aux managers et admins)
    Route::middleware('role:manager,admin')->group(function () {
        Route::get('pending-leaves', [LeaveApprovalController::class, 'pending'])->name('leaves.pending');
        Route::put('leaves/{leave}/approve', [LeaveApprovalController::class, 'approve'])->name('leaves.approve');
        Route::put('leaves/{leave}/reject', [LeaveApprovalController::class, 'reject'])->name('leaves.reject');
    });

    Route::middleware(['auth'])->group(function () {
        // Route::get('/', function () {
        //     return view('leaves.index');
        // })->name('Leaves.index');
        //Route::get('/', [LeaveController::class, 'index'])->name('leaves.index');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Routes pour les congés
        //Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
        Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
        Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
        Route::get('/leaves/{leave}', [LeaveController::class, 'show'])->name('leaves.show');
        Route::get('/leaves/{leave}/edit', [LeaveController::class, 'edit'])->name('leaves.edit');
        Route::put('/leaves/{leave}', [LeaveController::class, 'update'])->name('leaves.update');
        Route::delete('/leaves/{leave}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
        Route::get('/leaves/{leave}/attachment/{attachment}/download', [LeaveController::class, 'downloadAttachment'])->name('leaves.download-attachment');
        // Route::put('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
        // Route::put('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');

        // Routes pour la gestion des congés par les managers
        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('/manager/leaves', [App\Http\Controllers\Manager\LeaveController::class, 'index'])
                 ->name('manager.leaves.index');
            Route::put('/manager/leaves/{leave}/approve', [App\Http\Controllers\Manager\LeaveController::class, 'approve'])
                 ->name('manager.leaves.approve');
            Route::put('/manager/leaves/{leave}/reject', [App\Http\Controllers\Manager\LeaveController::class, 'reject'])
                 ->name('manager.leaves.reject');
        });

        // Routes pour la gestion des congés par Head
        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('head/leaves', [App\Http\Controllers\Head\LeaveController::class, 'index'])->name('head.leaves.index');
            Route::put('/head/leaves/{leave}/approve', [App\Http\Controllers\Head\LeaveController::class, 'approve'])
                 ->name('head.leaves.approve');
            Route::put('/head/leaves/{leave}/reject', [App\Http\Controllers\Head\LeaveController::class, 'reject'])
                 ->name('head.leaves.reject');
        });

        // Routes pour l'administration
        Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
            // Redirection du tableau de bord vers les statistiques
            Route::redirect('/', '/admin/stats')->name('dashboard');

            // Routes pour les congés
            Route::prefix('leaves')->name('leaves.')->group(function () {
                Route::get('/', [AdminLeaveController::class, 'index'])->name('index');
                Route::put('/{leave}/approve', [AdminLeaveController::class, 'approve'])->name('approve');
                Route::put('/{leave}/reject', [AdminLeaveController::class, 'reject'])->name('reject');
            });

            // Routes pour les statistiques
            Route::prefix('stats')->name('stats.')->group(function () {
                Route::get('/', [StatsController::class, 'index'])->name('index');
            });

            // Routes pour la gestion des utilisateurs
            Route::resource('users', UserController::class);

            // Routes pour la gestion des départements
            Route::resource('departments', DepartmentController::class);

            // Routes pour les équipes
            Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
            Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
            Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
            Route::delete('teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');

            Route::post('/teams/{team}/members', [TeamController::class, 'addMembers'])
                ->name('admin.teams.members.add');
            Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
            Route::get('/departments/{department}/managers', [TeamController::class, 'getManagersByDepartment'])->name('departments.managers');
            Route::get('/departments/{department}/teams', [TeamController::class, 'getTeamsByDepartment'])->name('departments.teams');
        });

        // Routes pour les rapports d'expenses (accessibles à tous les utilisateurs authentifiés)
        Route::middleware(['auth', 'verified'])->group(function () {
            // Expense Reports
            Route::get('expense-reports', [ExpenseReportController::class, 'index'])->name('expense-reports.index');
            Route::get('expense-reports/create', [ExpenseReportController::class, 'create'])->name('expense-reports.create');
            Route::post('expense-reports', [ExpenseReportController::class, 'store'])->name('expense-reports.store');
            Route::get('expense-reports/{id}', [ExpenseReportController::class, 'show'])->name('expense-reports.show');
            Route::get('expense-reports/{id}/edit', [ExpenseReportController::class, 'edit'])->name('expense-reports.edit');
            Route::put('expense-reports/{id}', [ExpenseReportController::class, 'update'])->name('expense-reports.update');
        
            // Actions custom pour changer le statut
            Route::patch('expense-reports/{id}/submit', [ExpenseReportController::class, 'submit'])->name('expense-reports.submit');
            Route::patch('expense-reports/{id}/approve', [ExpenseReportController::class, 'approve'])->name('expense-reports.approve');
            Route::patch('expense-reports/{id}/reject', [ExpenseReportController::class, 'reject'])->name('expense-reports.reject');
            Route::delete('expense-reports/{id}', [ExpenseReportController::class, 'destroy'])->name('expense-reports.destroy');
        
            // Expense Lines (routes imbriquées)
            Route::post('expense-reports/{reportId}/lines', [ExpenseLineController::class, 'store'])->name('expense-lines.store');
            Route::get('expense-reports/{reportId}/lines/{lineId}/edit', [ExpenseLineController::class, 'edit'])->name('expense-lines.edit');
            Route::put('expense-reports/{reportId}/lines/{lineId}', [ExpenseLineController::class, 'update'])->name('expense-lines.update');
            Route::delete('expense-reports/{reportId}/lines/{lineId}', [ExpenseLineController::class, 'destroy'])->name('expense-lines.destroy');
        });


    });
});

require __DIR__.'/auth.php';
