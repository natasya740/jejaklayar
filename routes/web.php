<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\UploadImageController; // <- added

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KontributorController;
use App\Http\Controllers\PustakaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\Kontributor\ProfileController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Umum (Publik)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/search',   [SearchController::class, 'index'])->name('search');
Route::get('/budaya',   [BudayaController::class, 'index'])->name('budaya');
Route::get('/pustaka',  [PustakaController::class, 'index'])->name('pustaka');
Route::get('/tentang',  [TentangController::class, 'index'])->name('tentang');

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

        // Profil kontributor (show + update)
        Route::get('/profil', [ProfileController::class, 'show'])->name('profil');
        Route::post('/profil/update', [ProfileController::class, 'update'])->name('profil.update');

        Route::prefix('artikel')->name('artikel.')->group(function () {
            Route::get('/', [KontributorController::class, 'indexArticles'])->name('index');

            // form create (kontributor)
            Route::get('/baru', [KontributorController::class, 'showArticleForm'])->name('create');

            // store artikel (kontributor)
            Route::post('/store', [KontributorController::class, 'storeContent'])->name('store');

            // show article (by id)
            Route::get('/{artikel}', [KontributorController::class, 'showArticle'])->name('show')
                ->whereNumber('artikel');
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

        // Artikel Admin
        Route::prefix('artikel')->name('artikel.')->group(function () {
            // create & store
            Route::get('/create', [AdminController::class, 'createArtikel'])->name('create');
            Route::post('/store', [AdminController::class, 'storeArtikel'])->name('store');

            // *** Upload image endpoint untuk editor/tombol "Sisipkan Foto" ***
            // Ini akan men-define nama route -> admin.artikel.upload_image
            Route::post('/upload-image', [UploadImageController::class, 'upload'])->name('upload_image');

            Route::get('/show', [AdminController::class, 'indexArtikel'])->name('show');
            Route::get('/pending', [AdminController::class, 'pendingArtikel'])->name('pending');

            // actions on a specific artikel
            Route::get('/{artikel}/review', [AdminController::class, 'reviewArtikel'])->name('review')
                ->whereNumber('artikel');

            Route::get('/{artikel}/edit', [AdminController::class, 'editArtikel'])->name('edit')
                ->whereNumber('artikel');
            Route::put('/{artikel}', [AdminController::class, 'updateArtikel'])->name('update')
                ->whereNumber('artikel');

            Route::delete('/{artikel}', [AdminController::class, 'destroyArtikel'])->name('destroy')
                ->whereNumber('artikel');

            Route::patch('/{artikel}/approve', [AdminController::class, 'approveArtikel'])->name('approve')
                ->whereNumber('artikel');
            Route::patch('/{artikel}/reject', [AdminController::class, 'rejectArtikel'])->name('reject')
                ->whereNumber('artikel');
        });

        // Kategori & Tag
        Route::resource('kategori', AdminCategoryController::class)->except(['show']);
        Route::resource('tag', AdminTagController::class)->except(['show']);

        // Media
        Route::get('media', [AdminMediaController::class, 'index'])->name('media.index');
        Route::post('media/upload', [AdminMediaController::class, 'upload'])->name('media.upload');
        Route::delete('media/{media}', [AdminMediaController::class, 'destroy'])->name('media.destroy');

        // Pages
        Route::resource('pages', AdminPageController::class)->except(['show']);

        // Mini audit
        Route::get('audit', [AuditController::class, 'index'])->name('audit.index');

        // Pengguna & Logs
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
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
