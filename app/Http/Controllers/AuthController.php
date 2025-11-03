<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===============================================
    // 1. LOGIN UMUM (Digunakan Kontributor/User Biasa)
    // ===============================================

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Mencoba otentikasi
        if (Auth::attempt($credentials)) {
            // Regenerasi sesi untuk menghindari session fixation
            $request->session()->regenerate();

            $userRole = Auth::user()->role;

            // Redirect berdasarkan peran setelah login sukses
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($userRole === 'kontributor') {
                return redirect()->route('kontributor.dashboard');
            } else {
                // Default redirect jika ada role lain
                return redirect()->route('home');
            }
        }

        // Gagal login
        return back()->with('error', 'Email atau password salah');
    }

    // ===============================================
    // 2. LOGIN KHUSUS ADMIN (Rute /team)
    // ===============================================

    public function showLoginAdmin()
    {
        // View yang dimuat adalah tampilan khusus Admin (admin/login.blade.php)
        return view('admin.login');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $userRole = Auth::user()->role;
            
            // Periksa: Hanya Admin yang boleh login melalui rute ini
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                // Jika login via /team tapi bukan Admin, tolak dan paksa logout.
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                // Kembali ke form login admin dengan pesan error
                return redirect()->route('login.admin')->with('error', 'Akses Ditolak. Login Khusus untuk Tim Admin.');
            }
        }

        // Gagal login
        return back()->with('error', 'Email atau password salah');
    }

    // ===============================================
    // 3. REGISTER & LOGOUT
    // ===============================================

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'kontributor', // Secara default, pengguna baru adalah Kontributor
        ]);

        return redirect()->route('login')->with('success', 'Registrasi Berhasil! Silakan Login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
