<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Jejak Layar</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
        }
        
        /* Background Utama (Sama dengan Login) */
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
            backdrop-filter: blur(3px);
        }

        /* Panel Gambar Samping */
        .register-image-panel {
            background-image: url('{{ asset('images/login.png') }}');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .register-image-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        }
    </style>
</head>
<body class="antialiased text-gray-800">

    <div class="main-bg"></div>

    <div class="flex justify-center items-center min-h-screen p-4 py-10">
        
        <!-- Kartu Register -->
        <div class="flex w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden min-h-[700px] transform transition-all hover:scale-[1.005] duration-500">
            
            <!-- Bagian Kiri: Gambar & Branding (Hidden di HP) -->
            <div class="hidden md:flex md:w-5/12 register-image-panel flex-col justify-between p-12 text-white">
                <div class="absolute inset-0 register-image-overlay"></div>
                
                <div class="relative z-10">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left bg-white/20 p-2 rounded-full"></i>
                        <span class="font-medium text-sm uppercase tracking-wider">Kembali</span>
                    </a>
                </div>

                <div class="relative z-10">
                    <h1 class="text-4xl font-bold mb-4 leading-tight">Bergabunglah<br>Bersama Kami</h1>
                    <p class="text-gray-200 text-lg font-light leading-relaxed">
                        Jadilah bagian dari pelestari budaya dan bagikan cerita inspiratif Anda kepada dunia.
                    </p>
                </div>
            </div>

            <!-- Bagian Kanan: Form Register -->
            <div class="w-full md:w-7/12 p-8 md:p-16 flex flex-col justify-center bg-white relative">
                
                <!-- Header Mobile -->
                <div class="md:hidden text-center mb-6">
                    <h2 class="text-2xl font-bold text-amber-500">Jejak Layar</h2>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru 🚀</h2>
                    <p class="text-gray-500">Lengkapi data diri Anda untuk memulai kontribusi.</p>
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

                <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-amber-500 transition-colors">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="name" placeholder="Nama Lengkap Anda" required 
                                class="w-full py-3 pl-12 pr-4 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all bg-gray-50 hover:bg-white">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-amber-500 transition-colors">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" placeholder="nama@email.com" required 
                                class="w-full py-3 pl-12 pr-4 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all bg-gray-50 hover:bg-white">
                        </div>
                    </div>

                    <!-- Password & Konfirmasi (Grid 2 Kolom di Desktop) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-amber-500 transition-colors">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" id="password" name="password" placeholder="••••••••" required 
                                    class="w-full py-3 pl-12 pr-10 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all bg-gray-50 hover:bg-white">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-400 hover:text-gray-600" id="toggle-pass">
                                    <i class="fas fa-eye text-sm" id="eye-pass"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ulangi Sandi</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-amber-500 transition-colors">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required 
                                    class="w-full py-3 pl-12 pr-10 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all bg-gray-50 hover:bg-white">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-400 hover:text-gray-600" id="toggle-conf">
                                    <i class="fas fa-eye text-sm" id="eye-conf"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Register -->
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-amber-500/30 transform hover:-translate-y-0.5 transition-all duration-200 mt-4">
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:text-amber-700 hover:underline ml-1">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Toggle Password -->
    <script>
        function setupToggle(btnId, inputId, iconId) {
            const btn = document.getElementById(btnId);
            const inp = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if(btn && inp && icon) {
                btn.addEventListener('click', () => {
                    const type = inp.getAttribute('type') === 'password' ? 'text' : 'password';
                    inp.setAttribute('type', type);
                    
                    if (type === 'text') {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                        icon.classList.add('text-amber-500');
                    } else {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                        icon.classList.remove('text-amber-500');
                    }
                });
            }
        }

        setupToggle('toggle-pass', 'password', 'eye-pass');
        setupToggle('toggle-conf', 'password_confirmation', 'eye-conf');
    </script>
</body>
</html>