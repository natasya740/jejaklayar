<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jejak Layar</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Font dan Animasi -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fffaf2;
            transition: background-color 0.4s ease-in-out;
        }

        /* Tombol utama */
        .btn-primary {
            background-color: #f4b400;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #e09a00;
        }

        /* Efek transisi halaman */
        .page-transition {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .page-transition.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Navbar aktif */
        .nav-link {
            position: relative;
            transition: color 0.3s;
        }
        .nav-link.active {
            color: #b45309; /* kuning tua */
            font-weight: 700;
        }
        .nav-link::after {
            content: "";
            position: absolute;
            width: 0%;
            height: 2px;
            left: 0;
            bottom: -2px;
            background-color: #b45309;
            transition: width 0.3s;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    <!-- 🔸 Navbar -->
    <header class="bg-yellow-400 shadow sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            
            <!-- Logo -->
            <h1 class="text-2xl font-bold text-gray-900">Jejak Layar</h1>

            <!-- 🔍 Search Bar -->
            <form action="{{ route('search') }}" method="GET" class="relative flex-1 mx-10 max-w-md">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Cari budaya, pustaka..." 
                    class="w-full px-5 py-3 text-base rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-yellow-500 focus:outline-none shadow-sm"
                >
                <button type="submit" class="absolute right-4 top-3 text-gray-500 hover:text-yellow-600">🔍</button>
            </form>

            <!-- 🔸 Navigasi -->
            <nav class="space-x-6 text-gray-800 font-medium flex items-center">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('budaya') }}" class="nav-link {{ request()->routeIs('budaya') ? 'active' : '' }}">Budaya</a>
                <a href="{{ route('pustaka') }}" class="nav-link {{ request()->routeIs('pustaka') ? 'active' : '' }}">Pustaka</a>
                <a href="{{ route('tentang') }}" class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>

                @if(session()->has('user'))
                    <!-- Dropdown Profil -->
                    <div class="relative group">
                        <button class="nav-link font-semibold">
                            👤 {{ session('user')->nama }}
                        </button>
                        <div class="absolute hidden group-hover:block right-0 mt-2 bg-white shadow-lg rounded-lg border w-40">
                            <a href="{{ route('kontributor') }}" class="block px-4 py-2 hover:bg-yellow-100">Profil</a>
                            <a href="{{ route('logout') }}" class="block px-4 py-2 hover:bg-yellow-100">Logout</a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                @endif
            </nav>
        </div>
    </header>

    <!-- 🔸 Efek Transisi Halaman -->
    <main class="flex-grow page-transition" id="page-content">
        @yield('content')
    </main>

    <!-- 🔸 Footer -->
    <footer class="bg-yellow-500 text-gray-900 py-8 mt-10">
        <div class="container mx-auto grid md:grid-cols-3 gap-6 px-6 text-sm">
            
            <!-- Kolom 1 -->
            <div>
                <h3 class="font-bold mb-2">Jejak Layar</h3>
                <p>
                    Melayu Bengkalis dalam satu portal digital untuk semua generasi.<br>
                    Menjaga warisan budaya, mendekatkan generasi muda dengan sejarahnya.
                </p>
            </div>

            <!-- Kolom 2 -->
            <div>
                <h3 class="font-bold mb-2">Navigasi</h3>
                <ul class="space-y-1">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('budaya') }}">Budaya</a></li>
                    <li><a href="{{ route('pustaka') }}">Pustaka</a></li>
                    <li><a href="{{ route('tentang') }}">Tentang</a></li>
                </ul>
            </div>

            <!-- Kolom 3 -->
            <div class="text-center md:text-left">
                <h3 class="font-bold mb-2">Hubungi Kami</h3>
                <p>jejaklayar@gmail.com</p>
                <div class="flex justify-center md:justify-start gap-2 mt-3">
                    <a href="https://www.instagram.com/" target="_blank">
                        <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram" class="w-5 h-5 hover:opacity-80 transition">
                    </a>
                    <a href="https://wa.me/628123456789" target="_blank">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" class="w-5 h-5 hover:opacity-80 transition">
                    </a>
                    <a href="mailto:jejaklayar@gmail.com">
                        <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" class="w-5 h-5 hover:opacity-80 transition">
                    </a>
                </div>
            </div>

        </div>

        <div class="text-center text-xs text-gray-800 mt-6">
            © 2025 Jejak Layar — All Rights Reserved
        </div>
    </footer>

    <!-- 🔸 Script Transisi -->
    <script>
        // Efek transisi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.getElementById('page-content');
            page.classList.add('show');
        });

        // Efek klik navbar sebelum pindah halaman
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', e => {
                const href = link.getAttribute('href');
                if (href && !href.startsWith('#')) {
                    e.preventDefault();
                    const page = document.getElementById('page-content');
                    page.classList.remove('show');
                    setTimeout(() => window.location.href = href, 300);
                }
            });
        });
    </script>

</body>
</html>
