<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create()
    {
        return view('auth.login'); // Pastikan Anda punya file ini
    }

    /**
     * Menangani permintaan login.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // === 💡 INI ADALAH LOGIKA REDIRECT BERDASARKAN PERAN 💡 ===
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'kontributor') {
            return redirect()->route('kontributor.dashboard');
        }

        // Jika tidak punya peran di atas, arahkan ke beranda
        return redirect()->route('home');
    }

    /**
     * Menghancurkan sesi (logout).
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}