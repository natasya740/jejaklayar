<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Jejak Layar</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

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
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
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

        <!-- Kartu Reset Password -->
        <div
            class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all hover:scale-[1.01] duration-500">

            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                    <i class="fas fa-shield-alt text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">Reset Kata Sandi</h1>
                <p class="text-green-100 text-sm mt-2">Buat kata sandi baru untuk akun Anda</p>
            </div>

            <!-- Form -->
            <div class="p-8">

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

                <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Hidden Token -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Input Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-green-500 transition-colors">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email', request()->email) }}"
                                placeholder="nama@email.com" required
                                class="w-full py-3.5 pl-12 pr-4 border border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all bg-gray-50 hover:bg-white">
                        </div>
                    </div>

                    <!-- Input Password Baru -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-green-500 transition-colors">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" placeholder="Minimal 8 karakter"
                                required
                                class="w-full py-3.5 pl-12 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all bg-gray-50 hover:bg-white">
                            <span
                                class="absolute inset-y-0 right-0 flex items-center pr-4 cursor-pointer text-gray-400 hover:text-gray-600 transition"
                                id="toggle-password">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Input Konfirmasi Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-green-500 transition-colors">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Ulangi kata sandi baru" required
                                class="w-full py-3.5 pl-12 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all bg-gray-50 hover:bg-white">
                            <span
                                class="absolute inset-y-0 right-0 flex items-center pr-4 cursor-pointer text-gray-400 hover:text-gray-600 transition"
                                id="toggle-password-confirm">
                                <i class="fas fa-eye" id="eye-icon-confirm"></i>
                            </span>
                        </div>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="pt-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Verifikasi Keamanan</label>
                        {!! NoCaptcha::renderJs('id') !!}
                        {!! NoCaptcha::display(['data-theme' => 'light']) !!}
                        @error('g-recaptcha-response')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Reset -->
                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-green-500/30 transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class="fas fa-check mr-2"></i>
                        Perbarui Kata Sandi
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-green-600 transition">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Toggle Password -->
    <script>
        // Toggle Password
        const toggleBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                    eyeIcon.classList.add('text-green-500');
                } else {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                    eyeIcon.classList.remove('text-green-500');
                }
            });
        }

        // Toggle Password Confirmation
        const toggleBtnConfirm = document.getElementById('toggle-password-confirm');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const eyeIconConfirm = document.getElementById('eye-icon-confirm');

        if (toggleBtnConfirm) {
            toggleBtnConfirm.addEventListener('click', function() {
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);
                if (type === 'text') {
                    eyeIconConfirm.classList.remove('fa-eye');
                    eyeIconConfirm.classList.add('fa-eye-slash');
                    eyeIconConfirm.classList.add('text-green-500');
                } else {
                    eyeIconConfirm.classList.remove('fa-eye-slash');
                    eyeIconConfirm.classList.add('fa-eye');
                    eyeIconConfirm.classList.remove('text-green-500');
                }
            });
        }
    </script>
</body>

</html>
