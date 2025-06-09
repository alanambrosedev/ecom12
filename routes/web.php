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
        // Admin password verification
        Route::post('verify-password', [AdminController::class, 'verifyPassword'])->name('verify-password');
        // Display admin details
        Route::get('update-details', [AdminController::class, 'editDetails'])->name('update-details');
        // Update admin details
        Route::post('update-details', [AdminController::class, 'updateDetails'])->name('update-details.request');
        // Admin avatar delete
        Route::post('delete-admin-image', [AdminController::class, 'deleteProfileImage']);
        // Get subadmins list
        Route::get('subadmins', [AdminController::class, 'getSubadmins']);
        // Update subadmin Status
        Route::post('update-subadmin-status', [AdminController::class, 'UpdateSubadminStatus']);
        // Delete sub admin
        Route::post('delete-subadmin', [AdminController::class, 'deleteSubadmin']);
        // Get add edit subadmin form
        Route::get('add-edit-subadmin/{id?}', [AdminController::class, 'addEditSubadmin']);
        // Admin logout
        Route::get('logout', [AdminController::class, 'destroy'])->name('logout');
    });
});
