<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Jejak Layar</title>

    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }

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

        .login-image-panel {
            background-image: url('{{ asset('images/Login1.png') }}');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .login-image-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);
        }
    </style>
</head>

<body class="antialiased text-gray-800">

    <div class="main-bg"></div>

    <div class="flex justify-center items-center min-h-screen p-4">

        <div class="flex w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden min-h-[650px]
                    transform transition-all hover:scale-[1.01] duration-500">

            {{-- Panel Kiri --}}
            <div class="hidden md:flex md:w-1/2 login-image-panel flex-col justify-between p-12 text-white">
                <div class="absolute inset-0 login-image-overlay"></div>

                <div class="relative z-10">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left bg-white/20 p-2 rounded-full"></i>
                        <span class="font-medium text-sm uppercase tracking-wider">Kembali ke Beranda</span>
                    </a>
                </div>

                <div class="relative z-10">
                    <h1 class="text-4xl font-bold mb-4 leading-tight">Panel Admin<br> Jejak Layar</h1>
                    <p class="text-gray-200 text-lg font-light leading-relaxed">
                        Kelola seluruh konten budaya dengan aman dan profesional.
                    </p>
                </div>
            </div>

            {{-- Panel Kanan: Form Login --}}
            <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center bg-white relative">

                <div class="md:hidden text-center mb-8">
                    <h2 class="text-2xl font-bold text-amber-500">Jejak Layar Admin</h2>
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Min.</h2>
                    <p class="text-gray-500">Masuk ke panel pengelolaan sistem.</p>
                </div>

                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r mb-6 text-sm shadow-sm animate-pulse">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.admin.post') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Admin</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-amber-500">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" required placeholder="admin@email"
                                class="w-full py-3.5 pl-12 pr-4 border border-gray-200 rounded-xl bg-gray-50
                                       focus:outline-none focus:border-amber-500 focus:ring-4
                                       focus:ring-amber-500/10 hover:bg-white transition-all">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Admin</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-amber-500">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="password" required placeholder="••••••••"
                                class="w-full py-3.5 pl-12 pr-12 border border-gray-200 rounded-xl bg-gray-50
                                       focus:outline-none focus:border-amber-500 focus:ring-4
                                       focus:ring-amber-500/10 hover:bg-white transition-all">
                            <span id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-4
                                                            cursor-pointer text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Login --}}
                    <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-xl
                               shadow-lg hover:shadow-amber-500/30 transform hover:-translate-y-0.5
                               transition-all duration-200">
                        Masuk Sebagai Admin
                    </button>

                </form>

                <div class="mt-6 text-center text-sm text-gray-500">
                    <span class="opacity-60">Login khusus untuk admin internal.</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        const toggle = document.getElementById('toggle-password');
        const input = document.getElementById('password');
        const icon = document.getElementById('eye-icon');

        toggle.addEventListener('click', () => {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye-slash', show);
            icon.classList.toggle('fa-eye', !show);
            icon.classList.toggle('text-amber-500', show);
        });
    </script>

</body>
</html>
