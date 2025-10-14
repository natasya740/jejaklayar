<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rute ini digunakan untuk endpoint API (kalau nanti kamu butuh).
| Untuk sekarang bisa dibiarkan sederhana seperti ini.
|
*/

Route::get('/test', function () {
    return response()->json(['message' => 'API berjalan dengan baik!']);
});
