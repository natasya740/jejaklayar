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

// 💡 LOGOUT HARUS POST, tapi kita sediakan rute GET untuk pemicu FORM (untuk link <a>)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ===============================================
// 🔹 Autentikasi KHUSUS ADMIN (Rute /team)
// ===============================================
// Rute Login Admin
Route::get('/team', [AuthController::class, 'showLoginAdmin'])->name('login.admin'); 
Route::post('/team', [AuthController::class, 'loginAdmin'])->name('login.admin.post'); 


// ===============================================
// 🔸 AREA KONTRIBUTOR (Terlindungi)
// ===============================================
Route::middleware(['auth', 'role:kontributor'])->group(function () {
    Route::get('/kontributor/dashboard', [KontributorController::class, 'index'])->name('kontributor.dashboard');
    Route::get('/kontributor/upload', [KontributorController::class, 'showUploadForm'])->name('kontributor.upload');
    Route::post('/kontributor/upload', [KontributorController::class, 'storeContent'])->name('kontributor.store');
    Route::get('/kontributor/status', [KontributorController::class, 'viewStatus'])->name('kontributor.status');
});


// ===============================================
// 🔸 AREA ADMIN (Terlindungi)
// ===============================================
// Harus memiliki role 'admin'
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard khusus admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard'); 
    
    // Rute admin lainnya...
    // Route::get('/admin/users', [AdminController::class, 'userList'])->name('admin.user_list');
    
    // Form input konten
    Route::get('/admin/artikel/upload', [AdminController::class, 'showUploadForm'])->name('admin.artikel_form');
    Route::post('/admin/artikel/upload', [AdminController::class, 'storeArtikel'])->name('admin.artikel_store');
    
    // Kelola artikel
    Route::get('/admin/artikel/kelola', [AdminController::class, 'listArticles'])->name('admin.artikel_list');
});