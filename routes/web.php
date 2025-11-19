<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\PustakaController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\KontributorController; 
use App\Http\Controllers\KategoriController;

// ===============================================
// 🔹 Halaman Beranda & Umum (tanpa login)
// ===============================================
Route::get('/', [DashboardController::class, 'home'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/budaya', [BudayaController::class, 'index'])->name('budaya');
Route::get('/pustaka', [PustakaController::class, 'index'])->name('pustaka');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');


// ===============================================
// 🔹 Autentikasi UMUM (Kontributor & User)
// ===============================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ===============================================
// 🔐 RUTE LUPA PASSWORD (KRITIS)
// ===============================================
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


// ===============================================
// 🔹 Autentikasi KHUSUS ADMIN (Rute /team)
// ===============================================
Route::get('/team', [AuthController::class, 'showLoginAdmin'])->name('login.admin'); 
Route::post('/team', [AuthController::class, 'loginAdmin'])->name('login.admin.post'); 


// ===============================================
// 🔸 AREA KONTRIBUTOR (Terlindungi)
// ===============================================
Route::middleware(['auth', 'checkrole:kontributor'])
    ->prefix('kontributor') // Tambahkan prefix agar rute lebih ringkas
    ->name('kontributor.') // Tambahkan name prefix agar pemanggilan route lebih mudah
    ->controller(KontributorController::class) // 🔹 PERBAIKAN UTAMA
    ->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        
        Route::get('/artikel/baru', 'showArticleForm')->name('artikel.form');
        Route::post('/artikel/store', 'storeContent')->name('artikel.store');
        Route::get('/artikel-saya', 'viewStatus')->name('artikel.saya');
        
        Route::get('/profil', 'showProfil')->name('profil');
        Route::post('/profil', 'updateProfil')->name('profil.update');
    });


// ===============================================
// 🔸 AREA ADMIN (Terlindungi)
// ===============================================
// ===============================================
// 🔸 AREA ADMIN (Terlindungi)
// ===============================================
Route::middleware(['auth', 'checkrole:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->controller(AdminController::class)
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', 'index')->name('dashboard');

        // Monitoring Artikel
        Route::get('/artikel/pending', 'pendingArtikel')->name('artikel.pending');
        Route::get('/artikel/{id}/review', 'reviewArtikel')->name('artikel.review');

        // Aksi (Tombol Approve/Reject)
        Route::patch('/artikel/{id}/approve', 'approveArtikel')->name('artikel.approve');
        Route::patch('/artikel/{id}/reject', 'rejectArtikel')->name('artikel.reject');
    });

// ===============================================
// 🌎 RUTE API (Untuk JavaScript Dropdown)
// ===============================================
Route::get('/api/kategori/{kategori}/subkategori', [KategoriController::class, 'getSubKategori'])->name('api.subkategori');