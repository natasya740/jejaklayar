<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\PustakaController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController; // ✅ Tambahan

// ============================
// 🔹 Halaman Beranda utama
// ============================
Route::get('/', [DashboardController::class, 'home'])->name('home');

// ============================
// 🔹 Auth umum (user biasa)
// ============================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================
// 🔹 Halaman umum (tanpa login)
// ============================
Route::get('/budaya', [BudayaController::class, 'index'])->name('budaya');
Route::get('/pustaka', [PustakaController::class, 'index'])->name('pustaka');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');

// ============================
// 🔹 Dashboard untuk user biasa
// ============================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ============================
// 🔸 ADMIN AREA (/team)
// ============================
Route::get('/team', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/team/login', [AdminController::class, 'login'])->name('admin.login.submit');

// Dashboard khusus admin (harus login)
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware('auth')
    ->name('admin.dashboard');
