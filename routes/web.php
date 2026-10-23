<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AuditLogController as AdminAuditLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('landing');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('login.store');
});

Route::middleware(['auth', 'active'])->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->middleware('throttle:6,1')
        ->name('profile.password.update');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/accounts/{account}', [AccountController::class, 'show'])->name('accounts.show');
    Route::get('/accounts/{account}/statement.pdf', [DocumentController::class, 'statement'])->name('documents.statement');

    Route::get('/beneficiaries', [BeneficiaryController::class, 'index'])->name('beneficiaries.index');
    Route::post('/beneficiaries', [BeneficiaryController::class, 'store'])->name('beneficiaries.store');
    Route::patch('/beneficiaries/{beneficiary}', [BeneficiaryController::class, 'update'])->name('beneficiaries.update');
    Route::post('/beneficiaries/{beneficiary}/deactivate', [BeneficiaryController::class, 'deactivate'])->name('beneficiaries.deactivate');

    Route::get('/transfers/create', [TransferController::class, 'create'])->name('transfers.create');
    Route::post('/transfers/preview', [TransferController::class, 'preview'])
        ->middleware('throttle:20,1')
        ->name('transfers.preview');
    Route::get('/transfers/review', [TransferController::class, 'review'])->name('transfers.review');
    Route::post('/transfers/confirm', [TransferController::class, 'confirm'])
        ->middleware('throttle:20,1')
        ->name('transfers.confirm');
    Route::get('/transfers/{transfer}/receipt', [TransferController::class, 'receipt'])->name('transfers.receipt');
    Route::get('/transfers/{transfer}/receipt.pdf', [DocumentController::class, 'receipt'])->name('documents.receipt');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Admin Tools & Audit Logs (Phase 14)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('/accounts/{account}/toggle-status', [AdminUserController::class, 'toggleAccountStatus'])->name('accounts.toggle-status');
        Route::get('/audit-logs', [AdminAuditLogController::class, 'index'])->name('audit-logs.index');
    });
});
