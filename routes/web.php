<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    // Login route for admin
    Route::get('/login', [AdminController::class, 'create'])->name('admin.login');
    // Dashboard route for admin
    Route::resource('/dashboard', AdminController::class)->only(['index']);

});
