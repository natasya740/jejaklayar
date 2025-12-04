<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Kontributor\ArticleController as KontributorArticleController;
use App\Http\Controllers\Kontributor\DashboardController as KontributorDashboardController;
use App\Http\Controllers\Kontributor\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PustakaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TentangController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Umum (Publik) - Tanpa Login
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', function () {
    return view('home');
})->name('home');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Halaman Statis
Route::get('/budaya', [BudayaController::class, 'index'])->name('budaya');
Route::get('/pustaka', [PustakaController::class, 'index'])->name('pustaka');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');

// FAQ & Panduan
Route::get('/faq', [HelpController::class, 'faq'])->name('faq');
Route::get('/panduan', [HelpController::class, 'panduan'])->name('panduan');

// Kategori & Artikel Publik
Route::get('/kategori/{slug}', [PublicController::class, 'category'])->name('category.show');
Route::get('/kategori/{categorySlug}/{subCategorySlug}', [PublicController::class, 'subCategory'])->name('subcategory.show');
Route::get('/kategori/{categorySlug}/{subCategorySlug}/{articleSlug}', [PublicController::class, 'article'])->name('article.show');

/*
|--------------------------------------------------------------------------
| Autentikasi - Login, Register, Logout
|--------------------------------------------------------------------------
*/

// Login User Biasa
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginUser'])->name('login.post');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Reset Password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Login Admin/Team
Route::get('/team', [AuthController::class, 'showLoginAdmin'])->name('login.admin');
Route::post('/team', [AuthController::class, 'loginAdmin'])->name('login.admin.post');

/*
|--------------------------------------------------------------------------
| Dashboard User Umum (Setelah Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Kontributor Area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'checkrole:kontributor'])
    ->prefix('kontributor')
    ->name('kontributor.')
    ->group(function () {

        // Dashboard Kontributor
        Route::get('/dashboard', [KontributorDashboardController::class, 'index'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Profil Kontributor - PERBAIKAN ROUTE
        |--------------------------------------------------------------------------
        */
        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [ProfileController::class, 'update'])->name('update');
            Route::delete('/avatar', [ProfileController::class, 'deleteAvatar'])->name('delete-avatar');
        });

        // Shortcut route untuk profil (tanpa 'profil.' prefix)
        Route::get('/profil', [ProfileController::class, 'index'])->name('profil');

        /*
        |--------------------------------------------------------------------------
        | Artikel Kontributor
        |--------------------------------------------------------------------------
        */
        Route::prefix('articles')->name('articles.')->group(function () {
            // List artikel
            Route::get('/', [KontributorArticleController::class, 'index'])->name('index');

            // Create artikel
            Route::get('/create', [KontributorArticleController::class, 'create'])->name('create');
            Route::post('/', [KontributorArticleController::class, 'store'])->name('store');

            // Upload image untuk CKEditor
            Route::post('/upload-image', [KontributorArticleController::class, 'uploadImage'])->name('upload-image');

            // Get subcategories by category (AJAX)
            Route::get('/subcategories', [KontributorArticleController::class, 'getSubCategories'])->name('subcategories');

            // Show, Edit, Update, Delete artikel
            Route::get('/{article}', [KontributorArticleController::class, 'show'])->name('show');
            Route::get('/{article}/edit', [KontributorArticleController::class, 'edit'])->name('edit');
            Route::put('/{article}', [KontributorArticleController::class, 'update'])->name('update');
            Route::delete('/{article}', [KontributorArticleController::class, 'destroy'])->name('destroy');
        });
    });

/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'checkrole:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Categories Management
        |--------------------------------------------------------------------------
        */
        Route::resource('categories', CategoryController::class);

        /*
        |--------------------------------------------------------------------------
        | Sub Categories Management
        |--------------------------------------------------------------------------
        */
        Route::resource('sub-categories', SubCategoryController::class);
        Route::get('sub-categories-by-category/{category}', [SubCategoryController::class, 'getByCategory'])
            ->name('sub-categories.by-category');

        /*
        |--------------------------------------------------------------------------
        | Articles Management (Admin)
        |--------------------------------------------------------------------------
        */
        Route::resource('articles', ArticleController::class);

        // CKEditor Image Upload untuk Articles
        Route::post('articles/upload-image', [ArticleController::class, 'uploadImage'])
            ->name('articles.uploadImage');

        /*
        |--------------------------------------------------------------------------
        | Validasi Artikel dari Kontributor
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
        });

        /*
        |--------------------------------------------------------------------------
        | User Management (CRUD)
        |--------------------------------------------------------------------------
        */
        Route::resource('users', UserController::class)->except(['show']);

        // Toggle aktif/nonaktif user
        Route::post('users/{user}/toggle', [UserController::class, 'toggle'])
            ->name('users.toggle');

        /*
        |--------------------------------------------------------------------------
        | Media Manager
        |--------------------------------------------------------------------------
        */
        Route::prefix('media')->name('media.')->group(function () {
            Route::get('/', [AdminMediaController::class, 'index'])->name('index');
            Route::post('/upload', [AdminMediaController::class, 'upload'])->name('upload');
            Route::delete('/{media}', [AdminMediaController::class, 'destroy'])->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | Pages (Halaman Statis)
        |--------------------------------------------------------------------------
        */
        Route::resource('pages', AdminPageController::class)->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */
        Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');

        /*
        |--------------------------------------------------------------------------
        | System Logs
        |--------------------------------------------------------------------------
        */
        Route::get('/logs', [AdminController::class, 'logs'])->name('logs.index');
    });

/*
|--------------------------------------------------------------------------
| API Helper Routes
|--------------------------------------------------------------------------
*/

Route::prefix('api')->name('api.')->group(function () {
    // Get subkategori berdasarkan kategori
    Route::get('/kategori/{kategori}/subkategori', [KategoriController::class, 'getSubKategori'])
        ->name('subkategori')
        ->where('kategori', '[A-Za-z0-9\-\_]+');
});