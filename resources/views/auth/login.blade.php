<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jejak Layar</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Background Utama dengan Overlay Halus */
        .main-bg {
            background-image: url('{{ asset('images/Background.png') }}');
            background-size: cover;
            background-position: center;
            position: fixed;
            inset: 0;
            z-index: -1;
        }

        .main-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
        }

        /* Gambar Samping Login */
        .login-image-panel {
            background-image: url('{{ asset('images/Login.png') }}');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .login-image-overlay {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        }

        /* reCAPTCHA Styling */
        .g-recaptcha {
            transform: scale(0.95);
            transform-origin: 0 0;
        }

        @media (max-width: 400px) {
            .g-recaptcha {
                transform: scale(0.85);
                transform-origin: 0 0;
            }
        }
    </style>

    <!-- reCAPTCHA Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="antialiased text-gray-800">

    <!-- Background -->
    <div class="main-bg"></div>

    <div class="flex justify-center items-center min-h-screen p-4">

        <!-- Kartu Login -->
        <div
            class="flex w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden min-h-[700px] transform transition-all hover:scale-[1.01] duration-500">

            <!-- Bagian Kiri: Gambar & Branding (Hidden di HP) -->
            <div class="hidden md:flex md:w-1/2 login-image-panel flex-col justify-between p-12 text-white">
                <div class="absolute inset-0 login-image-overlay"></div>
                <div class="relative z-10">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left bg-white/20 p-2 rounded-full"></i>
                        <span class="font-medium text-sm uppercase tracking-wider">Kembali ke Beranda</span>
                    </a>
                </div>
                <div class="relative z-10">
                    <h1 class="text-4xl font-bold mb-4 leading-tight">Selamat Datang di<br> Jejak Layar</h1>
                    <p class="text-gray-200 text-lg font-light leading-relaxed">
                        Menjaga warisan dan budaya, mendekatkan generasi muda dengan sejarahnya.
                    </p>
                </div>
            </div>

            <!-- Bagian Kanan: Form Login -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white relative overflow-y-auto">
                <div class="md:hidden text-center mb-6">
                    <h2 class="text-2xl font-bold text-amber-500">Jejak Layar</h2>
                </div>
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Halo, Apa Kabar? 👋</h2>
                    <p class="text-gray-500">Masuk untuk mengelola konten dan profil Anda.</p>
                </div>

                <!-- Success Alert -->
                @if (session('success'))
                    <div
                        class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r mb-6 text-sm shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Status Alert (untuk reset password) -->
                @if (session('status'))
                    <div
                        class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-r mb-6 text-sm shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r mb-6 text-sm shadow-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Input Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-amber-500 transition-colors">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="nama@email.com" required
                                class="w-full py-3.5 pl-12 pr-4 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all bg-gray-50 hover:bg-white">
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-amber-500 transition-colors">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" placeholder="••••••••" required
                                class="w-full py-3.5 pl-12 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all bg-gray-50 hover:bg-white">

                            <!-- Toggle Eye Icon -->
                            <span
                                class="absolute inset-y-0 right-0 flex items-center pr-4 cursor-pointer text-gray-400 hover:text-gray-600 transition"
                                id="toggle-password">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 cursor-pointer text-gray-600 hover:text-gray-900">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                                class="w-4 h-4 rounded text-amber-500 focus:ring-amber-500 border-gray-300">
                            <span>Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}"
                            class="font-medium text-amber-600 hover:text-amber-700 hover:underline">Lupa Sandi?</a>
                    </div>

                    <!-- Divider -->
                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">atau masuk dengan email</span>
                        </div>
                    </div>

                    <!-- Google Login Button -->
                    <a href="{{ route('auth.google') }}"
                        class="w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-200 hover:border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-3.5 rounded-xl shadow-sm transition-all duration-200 mb-6">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        <span>Masuk dengan Google</span>
                    </a>

                    <!-- reCAPTCHA -->
                    <div class="pt-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Verifikasi Keamanan</label>
                        {!! NoCaptcha::renderJs('id') !!}
                        {!! NoCaptcha::display(['data-theme' => 'light']) !!}
                        @error('g-recaptcha-response')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-amber-500/30 transform hover:-translate-y-0.5 transition-all duration-200">
                        Masuk Sekarang
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}"
                        class="font-bold text-amber-600 hover:text-amber-700 hover:underline ml-1">Daftar Gratis</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Toggle Password -->
    <script>
        const toggleBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Ganti Icon
                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                    eyeIcon.classList.add('text-amber-500');
                } else {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                    eyeIcon.classList.remove('text-amber-500');
                }
            });
        }
    </script>
</body>

</html>
