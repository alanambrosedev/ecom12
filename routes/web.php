<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Login
    Route::get('login', [AdminController::class, 'create'])->name('login');
    Route::post('login', [AdminController::class, 'store'])->name('login.request');

    Route::middleware('admin')->group(function () {

        // Dashboard route for admin
        Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
        // Admin Password Update
        Route::get('update-password', [AdminController::class, 'edit'])->name('update_password');
        // Admin Password Update Request
        Route::post('verify-password', [AdminController::class, 'verifyPassword'])->name('verify-password');
        // Admin Logout
        Route::get('logout', [AdminController::class, 'destroy'])->name('logout');
    });
});
