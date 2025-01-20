<?php

use App\Http\Controllers\Auth\CustomAuthController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveApprovalController;
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
    // Route par défaut redirige vers les congés
    Route::get('/', function () {
        return redirect()->route('leaves.index');
    });

    // Routes de gestion du compte
    Route::get('password/update', [CustomAuthController::class, 'showPasswordUpdateForm'])->name('password.update.form');
    Route::post('password/update', [CustomAuthController::class, 'updatePassword'])->name('password.update');
    Route::post('logout', [CustomAuthController::class, 'logout'])->name('logout');

    // Routes pour la gestion des congés (accessibles à tous les utilisateurs authentifiés)
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('leaves', LeaveController::class);
        Route::get('leaves/attachment/{attachment}', [LeaveController::class, 'downloadAttachment'])->name('leaves.attachment.download');
    });

    // Routes pour l'approbation des congés (accessibles uniquement aux managers et admins)
    Route::middleware('role:manager,admin')->group(function () {
        Route::get('pending-leaves', [LeaveApprovalController::class, 'pending'])->name('leaves.pending');
        Route::put('leaves/{leave}/approve', [LeaveApprovalController::class, 'approve'])->name('leaves.approve');
        Route::put('leaves/{leave}/reject', [LeaveApprovalController::class, 'reject'])->name('leaves.reject');
    });

    // Routes pour l'administration (accessibles uniquement aux admins)
    Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        Route::delete('leaves/{leave}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
        Route::get('leaves/{leave}/edit', [LeaveController::class, 'edit'])->name('leaves.edit');
        Route::put('leaves/{leave}', [LeaveController::class, 'update'])->name('leaves.update');
    });

    // Routes pour la gestion du 2FA
    Route::get('user/two-factor-authentication', function () {
        return view('auth.two-factor-settings');
    })->name('two-factor.show');
});

require __DIR__.'/auth.php';
