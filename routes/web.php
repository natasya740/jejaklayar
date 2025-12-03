<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Kontributor\ProfileController;
use App\Http\Controllers\KontributorController;
use App\Http\Controllers\PustakaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TentangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HelpController;

Route::get('/faq', [HelpController::class, 'faq'])->name('faq');
Route::get('/panduan', [HelpController::class, 'panduan'])->name('panduan');

/*
|--------------------------------------------------------------------------
| Halaman Umum (Publik)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/budaya', [BudayaController::class, 'index'])->name('budaya');
Route::get('/pustaka', [PustakaController::class, 'index'])->name('pustaka');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');

/*
|--------------------------------------------------------------------------
| Dashboard User (hanya setelah login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginUser'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Reset Password
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Admin login (team)
Route::get('/team', [AuthController::class, 'showLoginAdmin'])->name('login.admin');
Route::post('/team', [AuthController::class, 'loginAdmin'])->name('login.admin.post');

/*
|--------------------------------------------------------------------------
| Kontributor Area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkrole:kontributor'])
    ->prefix('kontributor')
    ->name('kontributor.')
    ->group(function () {

        Route::get('/dashboard', [KontributorController::class, 'index'])->name('dashboard');

        // Profil kontributor
        Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
        Route::post('/profil/update', [ProfileController::class, 'update'])->name('profil.update');

        // Artikel kontributor
        Route::prefix('artikel')->name('artikel.')->group(function () {
            Route::get('/', [KontributorController::class, 'indexArticles'])->name('index');
            Route::get('/baru', [KontributorController::class, 'showArticleForm'])->name('create');
            Route::post('/store', [KontributorController::class, 'storeContent'])->name('store');
            Route::get('/{artikel}', [KontributorController::class, 'showArticle'])->name('show')
                ->whereNumber('artikel');
        });
    });

/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkrole:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Categories Routes
        Route::resource('categories', CategoryController::class);

        // Sub Categories Routes
        Route::resource('sub-categories', SubCategoryController::class);
        Route::get('sub-categories-by-category/{category}', [SubCategoryController::class, 'getByCategory'])
            ->name('sub-categories.by-category');

        // Articles Routes (RESOURCE - UTAMA untuk CRUD)
        Route::resource('articles', ArticleController::class);

        // CKEditor Image Upload untuk Articles
        Route::post('articles/upload-image', [ArticleController::class, 'uploadImage'])
            ->name('articles.uploadImage');

        // Media Manager
        Route::get('media', [AdminMediaController::class, 'index'])->name('media.index');
        Route::post('media/upload', [AdminMediaController::class, 'upload'])->name('media.upload');
        Route::delete('media/{media}', [AdminMediaController::class, 'destroy'])->name('media.destroy');

        // Pages (Halaman Statis)
        Route::resource('pages', AdminPageController::class)->except(['show']);

        // Audit
        Route::get('audit', [AuditController::class, 'index'])->name('audit.index');

        /*
        |--------------------------------------------------------------------------
        | Validasi Artikel (GUNAKAN AdminController)
        |--------------------------------------------------------------------------
        */
        Route::prefix('artikel')->name('artikel.')->group(function () {
            // Halaman daftar artikel pending
            Route::get('/pending', [AdminController::class, 'pendingArtikel'])->name('pending');

            // Halaman review artikel
            Route::get('/{artikel}/review', [AdminController::class, 'reviewArtikel'])->name('review');

            // Approve artikel (POST method)
            Route::post('/{artikel}/approve', [AdminController::class, 'approveArtikel'])->name('approve');

            // Reject artikel (POST method)
            Route::post('/{artikel}/reject', [AdminController::class, 'rejectArtikel'])->name('reject');
        }); // <- pastikan grup artikel ditutup DI SINI

        /*
        |--------------------------------------------------------------------------
        | Admin User Management (CRUD + Toggle)
        |--------------------------------------------------------------------------
        |
        | Resource routes untuk users diletakkan di luar group artikel.
        */
        Route::resource('users', UserController::class)->except(['show']);

        // Toggle aktif/nonaktif
        Route::post('users/{user}/toggle', [UserController::class, 'toggle'])
            ->name('users.toggle');

        // Jika Anda masih membutuhkan route logs di AdminController:
        Route::get('/logs', [AdminController::class, 'logs'])->name('logs.index');
    });

/*
|--------------------------------------------------------------------------
| API Helper
|--------------------------------------------------------------------------
*/
Route::get('/api/kategori/{kategori}/subkategori', [KategoriController::class, 'getSubKategori'])
    ->name('api.subkategori')
    ->where('kategori', '[A-Za-z0-9\-\_]+');
