<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // ... (kode lain) ...

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        // ... (middleware lain) ...
        
        // 💡 DAFTARKAN MIDDLEWARE ANDA DI SINI
        'checkrole' => \App\Http\Middleware\CheckRole::class, 
    ];
}