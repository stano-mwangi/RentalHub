<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Admin\AdminPropertyController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\SuperAdminController;

/*
|--------------------------------------------------------------------------
| Public Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Public Property Viewing (Users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::resource('properties', PropertyController::class)
        ->only(['index', 'show']);
});

/*
|--------------------------------------------------------------------------
| Admin Property Management
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::resource('properties', AdminPropertyController::class);
    });

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/homeAdmin', [AdminController::class, 'homeAdmin'])->name('homeAdmin');
    });
/*
|--------------------------------------------------------------------------
| Super Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'superadmin'])->group(function () {

    Route::get('/homeSuperAdmin', [SuperAdminController::class, 'homeSuperAdmin'])
        ->name('superadmin.dashboard');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';