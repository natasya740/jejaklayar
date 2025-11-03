<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  ...$roles (Ini akan menampung semua role yg diizinkan, misal: 'superadmin', 'admin')
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika user tidak login, lempar ke halaman login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Cek apakah role user ada di dalam daftar $roles yang diizinkan
        if (!in_array(Auth::user()->role, $roles)) {
            // Jika tidak, tolak akses
            return abort(403, 'AKSES DITOLAK. ANDA TIDAK MEMILIKI HAK AKSES.');
        }

        // Jika punya, izinkan user melanjutkan
        return $next($request);
    }
}