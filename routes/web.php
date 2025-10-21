<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\PustakaController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\SearchController;

// 🔹 Halaman beranda (pengunjung umum)
Route::get('/', [DashboardController::class, 'home'])->name('home');

// 🔹 Autentikasi manual
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔹 Fitur pencarian
Route::get('/search', [SearchController::class, 'index'])->name('search');

// 🔹 Halaman umum
Route::get('/budaya', [BudayaController::class, 'index'])->name('budaya');
Route::get('/pustaka', [PustakaController::class, 'index'])->name('pustaka');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');

// 🔹 Halaman kontributor (khusus user login)
Route::get('/kontributor', function () {
    if (!session()->has('user')) {
        return redirect()->route('login');
    }

    // ✅ tetap pakai view home, tapi nanti bagian konten home.blade.php
    // akan menampilkan form kontributor jika user sudah login
    return view('layouts.home');
})->name('kontributor');