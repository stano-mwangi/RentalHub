<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Users can only view properties
Route::middleware(['auth', 'role:user'])->resource('properties', PropertyController::class)->only(['index', 'show']);

// Admins and superadmins can manage properties
Route::middleware(['auth', 'role:admin'])->resource('properties', PropertyController::class)->except(['index', 'show']);
// If you want superadmin to also access, add a similar route or adjust middleware accordingly

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    Route::middleware(['auth', 'superadmin'])->get('/homeSuperAdmin', [SuperAdminController::class, 'homeSuperAdmin']);

    Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('homeAdmin', [AdminController::class,'homeAdmin']);
    });

require __DIR__.'/auth.php';
