<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Guest Route
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Staff Route
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Segment Member
    Route::get('members', [MemberController::class, 'index'])->name('members.index');

    Route::middleware('can:access-admin')->group(function () {
        Route::get('members/create', [MemberController::class, 'create'])->name('members.create');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    });

    Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');

    Route::middleware('can:access-admin')->group(function () {
        Route::get('members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
        Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
        Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
    });

    // Segment Billing & Invoice
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

    Route::middleware('can:access-admin')->group(function () {
        Route::post('/billing/generate', [InvoiceController::class, 'triggerGenerate'])->name('billing.trigger-generate');
        Route::post('/billing/mass-suspend', [InvoiceController::class, 'triggerMassSuspend'])->name('billing.mass-suspend');
        Route::post('/payments/{invoice}', [PaymentController::class, 'store'])->name('payments.store');
    });
});
