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
        Route::post('update-password', [AdminController::class, 'updatePassword'])->name('update_password.request');
        // Admin Password Update Request
        Route::post('verify-password', [AdminController::class, 'verifyPassword'])->name('verify-password');
        //Display admin details
        Route::get('update-details', [AdminController::class, 'editDetails'])->name('update-details');
        Route::post('update-details', [AdminController::class, 'updateDetails'])->name('update-details.request');
        // Admin Logout
        Route::get('logout', [AdminController::class, 'destroy'])->name('logout');
    });
});
