<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  ...string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Cek apakah peran pengguna diizinkan
        foreach ($roles as $role) {
            if (Auth::user()->role == $role) {
                // Jika diizinkan, lanjutkan ke Controller
                return $next($request);
            }
        }

        // 3. Jika tidak diizinkan, tampilkan halaman error
        abort(403, 'ANDA TIDAK MEMILIKI HAK AKSES.');
    }
}