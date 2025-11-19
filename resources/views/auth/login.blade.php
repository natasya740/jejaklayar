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
            background: rgba(0, 0, 0, 0.4); /* Gelapkan background agar kartu menonjol */
            backdrop-filter: blur(3px); /* Efek blur dikit biar estetik */
        }

        /* Gambar Samping Login */
        .login-image-panel {
            background-image: url('{{ asset('images/login.png') }}'); 
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .login-image-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        }
    </style>
</head>
<body class="antialiased text-gray-800">

    <!-- Background -->
    <div class="main-bg"></div>

    <div class="flex justify-center items-center min-h-screen p-4">
        
        <!-- Kartu Login -->
        <div class="flex w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden min-h-[650px] transform transition-all hover:scale-[1.01] duration-500">
            
            <!-- Bagian Kiri: Gambar & Branding (Hidden di HP) -->
            <div class="hidden md:flex md:w-1/2 login-image-panel flex-col justify-between p-12 text-white">
                <div class="absolute inset-0 login-image-overlay"></div>
                
                <!-- Logo di Kiri Atas -->
                <div class="relative z-10">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left bg-white/20 p-2 rounded-full"></i>
                        <span class="font-medium text-sm uppercase tracking-wider">Kembali ke Beranda</span>
                    </a>
                </div>

                <!-- Teks di Bawah -->
                <div class="relative z-10">
                    <h1 class="text-4xl font-bold mb-4 leading-tight">Selamat Datang di<br> Jejak Layar</h1>
                    <p class="text-gray-200 text-lg font-light leading-relaxed">
                        Menjaga warisan dan budaya, mendekatkan generasi muda dengan sejarahnya.
                    </p>
                </div>
            </div>

            <!-- Bagian Kanan: Form Login -->
            <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center bg-white relative">
                
                <!-- Logo Mobile (Hanya muncul di HP) -->
                <div class="md:hidden text-center mb-8">
                    <h2 class="text-2xl font-bold text-amber-500">Jejak Layar</h2>
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Halo, Apa Kabar? 👋</h2>
                    <p class="text-gray-500">Masuk untuk mengelola konten dan profil Anda.</p>
                </div>

                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r mb-6 text-sm shadow-sm animate-pulse">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error) 
                                <li>{{ $error }}</li> 
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Input Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-amber-500 transition-colors">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" placeholder="nama@email.com" required 
                                class="w-full py-3.5 pl-12 pr-4 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all bg-gray-50 hover:bg-white">
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-amber-500 transition-colors">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" placeholder="••••••••" required 
                                class="w-full py-3.5 pl-12 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all bg-gray-50 hover:bg-white">
                            
                            <!-- Toggle Eye Icon -->
                            <span class="absolute inset-y-0 right-0 flex items-center pr-4 cursor-pointer text-gray-400 hover:text-gray-600 transition" id="toggle-password">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 cursor-pointer text-gray-600 hover:text-gray-900">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-amber-500 focus:ring-amber-500 border-gray-300">
                            <span>Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="font-medium text-amber-600 hover:text-amber-700 hover:underline">Lupa Sandi?</a>
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-amber-500/30 transform hover:-translate-y-0.5 transition-all duration-200">
                        Masuk Sekarang
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:text-amber-700 hover:underline ml-1">Daftar Gratis</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Toggle Password -->
    <script>
        const toggleBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if(toggleBtn){
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