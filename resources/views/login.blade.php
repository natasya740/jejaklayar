<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jejak Layar</title>
    
    <!-- Memuat Vite (Tailwind CSS) -->
    @vite('resources/css/app.css')
    
    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            
            /* Mengambil gambar dari public/images/Background.png */
            /* Pastikan Anda memiliki gambar bernama 'Background.png' di folder public/images/ */
            background-image: url('{{ asset('images/Background.png') }}');
            
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed; /* Membuat background tetap */
        }
        
        /* Overlay gelap agar form lebih terbaca */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            /* Anda bisa mengatur kegelapan overlay di sini (mis: 0.3 = 30% gelap) */
            background-color: rgba(0, 0, 0, 0.577); 
            z-index: -1; /* Menempatkan overlay di belakang konten */
        }

        body { font-family: 'Poppins', sans-serif; }
        
        /* === ⬇️ PERBAIKAN GAMBAR LOGIN ANDA DI SINI ⬇️ === */
        .bg-login-image {
            /* Menggunakan file 'login.png' Anda dari folder public/images/ */
            background-image: url('{{ asset('images/login.png') }}'); 
            background-size: cover;
            background-position: center;
        }
    
    </style>
</head>
<body class="bg-white-50">
    <div class="flex justify-center items-center min-h-screen p-4">
        <!-- Card Login (bg-white) -->
        <div class="flex w-full max-w-4xl shadow-2xl rounded-lg overflow-hidden bg-white">
            
            <!-- Kolom Kiri: Branding & Gambar (Ini yang diubah) -->
            <div class="hidden md:block md:w-1/2 bg-login-image relative">
                <div class="absolute inset-0 bg-black opacity-0"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-12">
                    <a href="{{ route('home') }}" class="mb-4">
                        <h1 class="text-white text-4xl font-bold">Jejak Layar</h1>
                    </a>
                    <p class="text-white text-lg opacity-90">
                        Melestarikan masa lalu untuk masa depan yang lebih berakar.
                    </p>
                </div>
            </div>

            <!-- Kolom Kanan: Form Login -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
                <p class="text-gray-600 mb-6">Login untuk melanjutkan ke dashboard Anda.</p>

                <!-- Menampilkan Error Validasi (jika ada) -->
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded-lg mb-4 text-sm" role="alert">
                        <strong>Login Gagal!</strong>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </span>
                            <input type="email" id="email" name="email" placeholder="contoh@gmail.com" required 
                                   class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>

                    <!-- Input Password (Dengan Tombol Mata) -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-gray-400"></i>
                            </span>
                            <input type="password" id="password" name="password" placeholder="••••••••" required 
                                    class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
        
                    <!-- 💡 INI KODE TOMBOL MATA (HTML) 💡 -->
                            <span class="absolute inset-y-0 right-0 flex items-center pr-4 cursor-pointer" id="toggle-password">
                                <i class="fas fa-eye text-gray-400" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>

                    
                    
                    <button type="submit" 
                            class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-semibold text-lg transition duration-300 shadow-md hover:shadow-lg">
                        Login
                    </button>
                    <p class="text-center mt-4 text-sm">Belum punya akun? Ayo <a href="{{ route('register') }}" class="text-yellow-600">Daftar</a></p>
                </form>
            </div>
        </div>
    </div>

<!-- 💡 JAVASCRIPT UNTUK TOMBOL MATA 💡 -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('toggle-password');
        const eyeIcon = document.getElementById('eye-icon');

        if (toggleButton && passwordInput && eyeIcon) {
            toggleButton.addEventListener('click', function() {
                // Cek tipe input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Ganti ikon mata
                if (type === 'password') {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                } else {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            });
        }
    });
</script>
</body>
</html>