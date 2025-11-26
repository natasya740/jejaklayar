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
        // 1. Jika belum login -> redirect ke route login (jika request AJAX kembalikan JSON)
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            // jika ada route bernama 'login' gunakan itu, fallback ke '/login'
            return redirect()->guest(route('login', [], false) ?: '/login');
        }

        $user = Auth::user();

        // 2. Jika role cocok salah satu roles -> lanjut
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // 3. Jika role tidak cocok -> abort 403 atau kembalikan JSON jika AJAX
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden. You do not have access.'], 403);
        }

        abort(403, 'ANDA TIDAK MEMILIKI HAK AKSES.');
    }
}
