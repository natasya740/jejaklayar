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
use App\Http\Controllers\HomeController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/budaya', [BudayaController::class, 'index'])->name('budaya');
Route::get('/pustaka', [PustakaController::class, 'index'])->name('pustaka');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');
Route::get('/faq', [HelpController::class, 'faq'])->name('faq');
Route::get('/panduan', [HelpController::class, 'panduan'])->name('panduan');
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
| Google OAuth Routes (single declaration)
|--------------------------------------------------------------------------
| Pastikan route ini hanya ada satu kali dan methodnya GET.
*/
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

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
        Route::get('/dashboard', [KontributorDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [ProfileController::class, 'update'])->name('update');
            Route::delete('/avatar', [ProfileController::class, 'deleteAvatar'])->name('delete-avatar');
        });

        Route::get('/profil', [ProfileController::class, 'index'])->name('profil');

        Route::prefix('articles')->name('articles.')->group(function () {
            Route::get('/', [KontributorArticleController::class, 'index'])->name('index');
            Route::get('/create', [KontributorArticleController::class, 'create'])->name('create');
            Route::post('/', [KontributorArticleController::class, 'store'])->name('store');
            Route::post('/upload-image', [KontributorArticleController::class, 'uploadImage'])->name('upload-image');
            Route::get('/subcategories', [KontributorArticleController::class, 'getSubCategories'])->name('subcategories');
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
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        Route::resource('sub-categories', SubCategoryController::class);
        Route::get('sub-categories-by-category/{category}', [SubCategoryController::class, 'getByCategory'])
            ->name('sub-categories.by-category');
        Route::resource('articles', ArticleController::class);
        Route::post('articles/upload-image', [ArticleController::class, 'uploadImage'])
            ->name('articles.uploadImage');
        Route::prefix('artikel')->name('artikel.')->group(function () {
            Route::get('/pending', [AdminController::class, 'pendingArtikel'])->name('pending');
            Route::get('/{artikel}/review', [AdminController::class, 'reviewArtikel'])->name('review');
            Route::post('/{artikel}/approve', [AdminController::class, 'approveArtikel'])->name('approve');
            Route::post('/{artikel}/reject', [AdminController::class, 'rejectArtikel'])->name('reject');
        });
        Route::resource('users', UserController::class)->except(['show']);
        Route::post('users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
        Route::prefix('media')->name('media.')->group(function () {
            Route::get('/', [AdminMediaController::class, 'index'])->name('index');
            Route::post('/upload', [AdminMediaController::class, 'upload'])->name('upload');
            Route::delete('/{media}', [AdminMediaController::class, 'destroy'])->name('destroy');
        });
        Route::resource('pages', AdminPageController::class)->except(['show']);
        Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');
        Route::get('/logs', [AdminController::class, 'logs'])->name('logs.index');
    });

/*
|--------------------------------------------------------------------------
| API Helper Routes
|--------------------------------------------------------------------------
*/
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/kategori/{kategori}/subkategori', [KategoriController::class, 'getSubKategori'])
        ->name('subkategori')
        ->where('kategori', '[A-Za-z0-9\-\_]+');
});
