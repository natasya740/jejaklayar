<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

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
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'g-recaptcha-response.required' => 'Silakan verifikasi bahwa Anda bukan robot.',
            'g-recaptcha-response.captcha' => 'Verifikasi captcha gagal. Silakan coba lagi.',
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
        return view('auth.login');
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'g-recaptcha-response' => ['required', 'captcha'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'g-recaptcha-response.required' => 'Silakan verifikasi bahwa Anda bukan robot.',
            'g-recaptcha-response.captcha' => 'Verifikasi captcha gagal. Silakan coba lagi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $request->session()->regenerate();

        $userRole = strtolower(optional(Auth::user())->role ?? '');

        if ($userRole === 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun admin tidak dapat login di halaman ini. Silakan gunakan halaman login admin.',
            ])->onlyInput('email');
        }

        return redirect()->intended(route('kontributor.dashboard'));
    }

    // ---------------------------
    // LOGIN ADMIN (FORM /team)
    // ---------------------------
    public function showLoginAdmin()
    {
        return view('auth.admin_login');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'g-recaptcha-response' => ['required', 'captcha'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'g-recaptcha-response.required' => 'Silakan verifikasi bahwa Anda bukan robot.',
            'g-recaptcha-response.captcha' => 'Verifikasi captcha gagal. Silakan coba lagi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $userRole = strtolower(optional(Auth::user())->role ?? '');

        if ($userRole !== 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda tidak memiliki akses admin.',
            ])->onlyInput('email');
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    // ---------------------------
    // GOOGLE OAUTH
    // ---------------------------

    /**
     * Redirect ke halaman login Google
     * PENTING: Tidak menggunakan stateless() agar session OAuth berfungsi dengan baik
     */
    public function redirectToGoogle()
    {
        try {
            // tambahkan scope jika butuh informasi extra
            return Socialite::driver('google')->scopes(['openid', 'profile', 'email'])->redirect();
        } catch (\Exception $e) {
            Log::error('Google OAuth Redirect Error: '.$e->getMessage(), [
                'file' => $e->getFile() ?? null,
                'line' => $e->getLine() ?? null,
            ]);

            return redirect()->route('login')->withErrors([
                'email' => 'Terjadi kesalahan saat menghubungkan ke Google. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Handle callback dari Google
     * Menggunakan session normal (bukan stateless) untuk menghindari InvalidStateException
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            // untuk debugging, log query param yg masuk (HATI-HATI: jangan log token/personal data di prod)
            Log::debug('Google callback query', ['query' => $request->query()]);

            // Dapatkan user dari Google (menggunakan session untuk state verification)
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada berdasarkan google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if (! $user) {
                // Cek apakah email sudah terdaftar (user existing yang belum link Google)
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    // Link akun existing dengan Google
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);

                    Log::info('Google account linked to existing user: '.$user->email);
                } else {
                    // Buat user baru
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                        'password' => null,
                        'role' => 'kontributor',
                    ]);

                    Log::info('New user created via Google OAuth: '.$user->email);
                }
            } else {
                if ($user->avatar !== $googleUser->getAvatar()) {
                    $user->update(['avatar' => $googleUser->getAvatar()]);
                }
            }

            if (strtolower($user->role) === 'admin') {
                Log::warning('Admin attempted to login via Google: '.$user->email);

                return redirect()->route('login')->withErrors([
                    'email' => 'Akun admin tidak dapat login menggunakan Google. Silakan gunakan halaman login admin.',
                ]);
            }

            // Login user dengan remember me aktif
            Auth::login($user, true);
            Log::info('User logged in via Google: '.$user->email);

            return redirect()->intended(route('kontributor.dashboard'));

        } catch (InvalidStateException $e) {
            // Error ini terjadi jika state OAuth tidak cocok (session expired atau cookie/session bermasalah)
            Log::error('Google OAuth Invalid State: '.$e->getMessage(), ['request' => $request->all()]);

            return redirect()->route('login')->withErrors([
                'email' => 'Sesi login Google telah kedaluwarsa atau tidak valid. Silakan coba lagi.',
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Google OAuth Client Error: '.$e->getMessage());

            return redirect()->route('login')->withErrors([
                'email' => 'Gagal mengambil data dari Google. Silakan coba lagi atau hubungi administrator.',
            ]);
        } catch (\Exception $e) {
            Log::error('Google OAuth General Error: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->withErrors([
                'email' => 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi atau gunakan login biasa.',
            ]);
        }
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
        $request->validate([
            'email' => 'required|email',
            'g-recaptcha-response' => ['required', 'captcha'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'g-recaptcha-response.required' => 'Silakan verifikasi bahwa Anda bukan robot.',
            'g-recaptcha-response.captcha' => 'Verifikasi captcha gagal. Silakan coba lagi.',
        ]);

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
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'g-recaptcha-response' => ['required', 'captcha'],
        ], [
            'g-recaptcha-response.required' => 'Silakan verifikasi bahwa Anda bukan robot.',
            'g-recaptcha-response.captcha' => 'Verifikasi captcha gagal. Silakan coba lagi.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
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
