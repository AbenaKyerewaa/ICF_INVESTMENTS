<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('landing');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'active'])->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/accounts/{account}', [AccountController::class, 'show'])->name('accounts.show');
    Route::get('/beneficiaries', [BeneficiaryController::class, 'index'])->name('beneficiaries.index');
    Route::post('/beneficiaries', [BeneficiaryController::class, 'store'])->name('beneficiaries.store');
    Route::patch('/beneficiaries/{beneficiary}', [BeneficiaryController::class, 'update'])->name('beneficiaries.update');
    Route::post('/beneficiaries/{beneficiary}/deactivate', [BeneficiaryController::class, 'deactivate'])->name('beneficiaries.deactivate');
    Route::get('/transfers/create', [TransferController::class, 'create'])->name('transfers.create');
    Route::post('/transfers/preview', [TransferController::class, 'preview'])->name('transfers.preview');
    Route::get('/transfers/review', [TransferController::class, 'review'])->name('transfers.review');
    Route::post('/transfers/confirm', [TransferController::class, 'confirm'])->name('transfers.confirm');
    Route::get('/transfers/{transfer}/receipt', [TransferController::class, 'receipt'])->name('transfers.receipt');
    Route::get('/transfers/{transfer}/receipt.pdf', [DocumentController::class, 'receipt'])->name('documents.receipt');
    Route::get('/accounts/{account}/statement.pdf', [DocumentController::class, 'statement'])->name('documents.statement');
});
