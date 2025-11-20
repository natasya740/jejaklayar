<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- NAVBAR PUBLIK (Menu Atas) -->
    <nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <i class="fas fa-ship text-amber-600 text-2xl"></i>
                    <span class="font-bold text-xl text-gray-800">Jejak Layar</span>
                </div>

                <!-- Menu Tengah -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-amber-600 font-medium transition">Beranda</a>
                    <a href="{{ route('budaya') }}" class="text-gray-600 hover:text-amber-600 font-medium transition">Budaya</a>
                    <a href="{{ route('pustaka') }}" class="text-gray-600 hover:text-amber-600 font-medium transition">Pustaka</a>
                    <a href="{{ route('tentang') }}" class="text-gray-600 hover:text-amber-600 font-medium transition">Tentang</a>
                </div>

                <!-- Tombol Login/Dashboard (Logika Aman) -->
                <div class="flex items-center gap-3">
                    @auth
                        <!-- Jika SUDAH Login: Tampilkan Tombol Dashboard -->
                        <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('kontributor.dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full font-medium hover:bg-indigo-700 transition text-sm">
                            Dashboard
                        </a>
                    @else
                        <!-- Jika BELUM Login: Tampilkan Tombol Masuk -->
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-amber-500 text-white px-5 py-2 rounded-full font-medium hover:bg-amber-600 transition text-sm shadow-lg shadow-amber-200">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- KONTEN -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold mb-4">Jejak Layar</h3>
            <p class="text-slate-400 max-w-lg mx-auto mb-8">Menjaga warisan dan budaya, mendekatkan generasi muda dengan sejarahnya melalui teknologi digital.</p>
            <div class="text-sm text-slate-600">
                &copy; {{ date('Y') }} Jejak Layar. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>