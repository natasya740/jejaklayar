<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Tampilkan form login admin
     */
    public function showLoginForm()
    {
        // Pastikan file: resources/views/admin_login.blade.php
        return view('admin_login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            // ✅ Pastikan hanya admin yang bisa masuk dashboard
            if (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin') {
                $request->session()->regenerate();
                return redirect()->route('admin.home');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Anda tidak memiliki akses sebagai admin.']);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Halaman utama (dashboard) admin
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.home', compact('user'));
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
