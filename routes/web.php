<?php
// routes/web.php - ✅ FIXED & COMPLETE

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes (Breeze)
require __DIR__.'/auth.php';

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Main Dashboard (role-based)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ========== ADMIN ROUTES ==========
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        
        // Resources
        Route::resource('classes', \App\Http\Controllers\Admin\ClassController::class);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('locations', \App\Http\Controllers\Admin\LocationController::class);
        
        // ✅ NEW: Toggle Status Route
        Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])
             ->name('users.toggle-status');
    });
    
    // ========== DOSEN ROUTES ==========
    Route::middleware('role:dosen')->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dosenDashboard'])->name('dashboard');
        Route::resource('classes', \App\Http\Controllers\Dosen\ClassController::class);
    });
    
    // ========== MAHASISWA ROUTES ==========
    Route::middleware('role:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'mahasiswaDashboard'])->name('dashboard');
    });
});