<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\PustakaController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KontributorController; // 💡 Tambahan

// 🔹 Halaman beranda (pengunjung umum)
Route::get('/', [DashboardController::class, 'home'])->name('home');

// 🔹 Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔹 Halaman umum
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/budaya', [BudayaController::class, 'index'])->name('budaya');
Route::get('/pustaka', [PustakaController::class, 'index'])->name('pustaka');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');


// 🔹 Rute Terlindungi (Membutuhkan Login)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kontributor
    Route::get('/kontributor', [KontributorController::class, 'index'])->name('kontributor');
});