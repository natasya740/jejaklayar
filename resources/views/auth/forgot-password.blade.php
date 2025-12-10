<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Jejak Layar</title>
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

        <!-- Kartu Forgot Password -->
        <div
            class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all hover:scale-[1.01] duration-500">

            <!-- Header -->
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                    <i class="fas fa-key text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">Lupa Kata Sandi?</h1>
                <p class="text-amber-100 text-sm mt-2">Jangan khawatir, kami akan bantu Anda</p>
            </div>

            <!-- Form -->
            <div class="p-8">

                <!-- Success Alert -->
                @if (session('status'))
                    <div
                        class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r mb-6 text-sm shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('status') }}
                        </div>
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

                <p class="text-gray-600 text-sm mb-6">
                    Masukkan alamat email yang terdaftar. Kami akan mengirimkan link untuk mengatur ulang kata sandi
                    Anda.
                </p>

                <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
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

                    <!-- reCAPTCHA -->
                    <div class="pt-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Verifikasi Keamanan</label>
                        {!! NoCaptcha::renderJs('id') !!}
                        {!! NoCaptcha::display(['data-theme' => 'light']) !!}
                        @error('g-recaptcha-response')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Kirim -->
                    <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-amber-500/30 transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Link Reset
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-amber-600 transition">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
