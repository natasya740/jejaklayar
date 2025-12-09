<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // ---------------------------
    // REGISTER
    // ---------------------------
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', 
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'kontributor',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // ---------------------------
    // LOGIN (Kontributor / umum)
    // ---------------------------
    public function showLogin()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    /**
     * loginUser - proses login untuk kontributor / user umum
     * Menolak akun admin di halaman ini (minta pindah ke /team)
     */
    public function loginUser(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
        'g-recaptcha-response' => ['required', 'captcha'], // Validasi reCAPTCHA
    ]);

    $remember = $request->filled('remember');

    if (! Auth::attempt($credentials, $remember)) {
        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.']
        ]);
    }

    $request->session()->regenerate();

    $userRole = strtolower(optional(Auth::user())->role ?? '');

    // Jika akun admin mencoba masuk lewat form kontributor -> tolak
    if ($userRole === 'admin') {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->withErrors([
            'email' => 'Akun admin tidak dapat login di halaman ini. Silakan gunakan halaman login admin.'
        ])->onlyInput('email');
    }

    // Redirect untuk kontributor (atau role lain selain admin)
    return redirect()->intended(route('kontributor.dashboard'));
}
    // ---------------------------
    // LOGIN ADMIN (FORM /team)
    // ---------------------------
    public function showLoginAdmin()
    {
        return view('auth.admin_login'); // resources/views/auth/admin_login.blade.php
    }

    /**
     * loginAdmin - proses login khusus admin
     * Menolak akun non-admin di halaman ini
     */
    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        $remember = $request->filled('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.'
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $userRole = strtolower(optional(Auth::user())->role ?? '');

        if ($userRole !== 'admin') {
            // jika bukan admin, langsung logout dan tolak akses
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda tidak memiliki akses admin.'
            ])->onlyInput('email');
        }

        // sukses: admin diarahkan ke dashboard admin
        return redirect()->intended(route('admin.dashboard'));
    }

    // ---------------------------
    // LOGOUT (shared)
    // ---------------------------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // ---------------------------
    // FORGOT / RESET PASSWORD
    // ---------------------------
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function (User $user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET || $status === Password::RESET_LINK_SENT) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}
