<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\AuditController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('kategori', CategoryController::class)->except(['show']);
Route::resource('tag', TagController::class)->except(['show']);

Route::get('media', [MediaController::class,'index'])->name('media.index');
Route::post('media/upload', [MediaController::class,'upload'])->name('media.upload');
Route::delete('media/{media}', [MediaController::class,'destroy'])->name('media.destroy');

Route::resource('pages', PageController::class)->except(['show']);
Route::get('audit', [AuditController::class,'index'])->name('audit.index');


class KategoriController extends Controller
{
    public function getSubKategori(Kategori $kategori)
    {
        return response()->json($kategori->children);
    }
}