<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jejak Layar')</title>

    <!-- Tailwind -->
    @vite('resources/css/app.css')

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        /* --- CSS Bawaan Anda --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fffaf2;
            transition: background-color 0.4s ease-in-out;
        }

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

        .nav-link {
            position: relative;
            transition: color 0.3s;
        }

        .nav-link.active {
            color: #b45309;
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

        footer {
            background-color: #fcd34d;
            color: #1f2937;
        }

        footer .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem;
        }

        footer h3 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        footer a {
            color: #1f2937;
            text-decoration: none;
        }

        footer a:hover {
            color: #92400e;
        }

        .footer-socials img {
            width: 22px;
            height: 22px;
            transition: transform 0.3s, opacity 0.3s;
        }

        .footer-socials img:hover {
            opacity: 0.8;
            transform: scale(1.1);
        }

        .footer-bottom {
            text-align: center;
            padding: 1rem;
            font-size: 0.85rem;
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        
        /* === ⬇️ CSS UNTUK DROPDOWN MENU (SOLUSI) ⬇️ === */
        .user-menu {
             position: relative;
             /* Menambahkan ini agar menu sejajar dengan link nav lain */
             display: flex;
             align-items: center;
        }
        .user-menu .nav-link { /* Mengatur tombol toggle */
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .user-menu .profile-img {
            width:35px;
            height:35px;
            border-radius:50%;
            object-fit:cover;
        }
        .user-menu-dropdown {
            position:absolute; 
            background:#fff; 
            min-width:180px; 
            border-radius:8px; 
            box-shadow:0 4px 12px rgba(0,0,0,0.1); 
            padding:10px; 
            display:none; /* Di-toggle oleh JS */
            top:50px; /* Jarak dari atas */
            right:0; 
            z-index:100;
            border: 1px solid #eee;
        }
        .user-menu-dropdown a,
        .user-menu-dropdown button {
            display:block; 
            padding:8px 12px; 
            text-decoration:none; 
            color: #333;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            font: inherit;
            font-family: 'Poppins', sans-serif; /* Pastikan font sama */
            font-size: 0.95rem;
            border-radius: 6px; 
        }
        .user-menu-dropdown a:hover,
        .user-menu-dropdown button:hover {
            background: #f4f4f4;
        }
        .user-menu-dropdown .logout-btn {
            color: red; /* Tombol logout berwarna merah */
        }
        /* === ⬆️ BATAS AKHIR CSS DROPDOWN ⬆️ === */

    </style>

    @stack('styles')
</head>

<body class="min-h-screen flex flex-col">

    {{-- ✅ Header --}}
    <header class="site-header">
        <div class="header-left">
            <a href="{{ route('home') }}" class="logo-link">
                <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar" class="logo">
            </a>
        </div>

        <div class="header-center">
            <form class="search-bar" action="{{ route('search') }}" method="GET">
                <input type="search" name="q" placeholder="Cari: judul, tokoh, kata kunci...">
            </form>
        </div>

        <nav class="header-right main-nav">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('budaya') }}" class="nav-link {{ request()->routeIs('budaya') ? 'active' : '' }}">Budaya</a>
            <a href="{{ route('pustaka') }}" class="nav-link {{ request()->routeIs('pustaka') ? 'active' : '' }}">Pustaka</a>
            <a href="{{ route('tentang') }}" class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>
        

            {{-- ✅ Jika user belum login (guest) tampilkan tombol Login --}}
            @guest
                <a href="{{ route('login') }}" class="btn-login nav-link">Login</a>
            @endguest

            {{-- === ⬇️ BLOK @AUTH YANG SUDAH DIPERBAIKI ⬇️ === --}}
            @auth
                <div class="user-menu">
                    {{-- Tombol Toggle Dropdown --}}
                    <a href="#" class="nav-link user-toggle" id="user-menu-toggle">
                        <img src="{{ asset('images/profile.png') }}" alt="Profil" class="profile-img">
                        <span class="username">{{ Auth::user()->nama }} ▼</span>
                    </a>

                    {{-- Dropdown Menu --}}
                    <div class="user-menu-dropdown" id="user-menu-dropdown">
                        
                        {{-- Cek Peran Pengguna --}}
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                        @elseif (Auth::user()->role === 'kontributor')
                            <a href="{{ route('kontributor.dashboard') }}">Dashboard Kontributor</a>
                        @endif
                        
                        <a href="#">Profil Saya</a>

                        {{-- Form Logout --}}
                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="logout-btn">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
            {{-- === ⬆️ BATAS AKHIR BLOK @AUTH ⬆️ === --}}

        </nav>
    </header>

    {{-- ✅ Konten Halaman --}}
    <main class="flex-grow page-transition" id="page-content">
        @yield('content')
    </main>

    {{-- ✅ Footer --}}
    <footer>
        <div class="container">
            <div>
                <h3>Jejak Layar</h3>
                <p>Melayu Bengkalis dalam satu portal digital untuk semua generasi.</p>
                <p>Menjaga warisan budaya, mendekatkan generasi muda dengan sejarahnya.</p>
            </div>

            <div>
                <h3>Navigasi</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('budaya') }}">Budaya</a></li>
                    <li><a href="{{ route('pustaka') }}">Pustaka</a></li>
                    <li><a href="{{ route('tentang') }}">Tentang</a></li>
                    <li><a href="/hubungi">Hubungi Kami</a></li>
                </ul>
            </div>

            <div>
                <h3>Hubungi Kami</h3>

                <div class="footer-socials">
                    <a href="#">
                        <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram">
                    </a>
                    <a href="#">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp">
                    </a>
                    <a href="mailto:jejaklayar@gmail.com">
                        <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email">
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            © 2025 Jejak Layar — All Rights Reserved
        </div>
    </footer>

    <!-- ✅ Script transition DAN LOGIKA DROPDOWN -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- Logika transisi halaman (sudah ada) ---
            const pageContent = document.getElementById('page-content');
            if(pageContent) {
                pageContent.classList.add('show');
            }

            // === ⬇️ JAVASCRIPT UNTUK DROPDOWN MENU (SOLUSI) ⬇️ ===
            
            // --- Logika Dropdown User Menu ---
            const userToggle = document.getElementById('user-menu-toggle');
            const userDropdown = document.getElementById('user-menu-dropdown');

            if (userToggle && userDropdown) {
                userToggle.addEventListener('click', (e) => {
                    e.preventDefault(); // Mencegah link '#' berpindah halaman
                    // Toggle tampilan dropdown
                    userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
                });
            }

            // --- Sembunyikan dropdown jika klik di luar area menu ---
            document.addEventListener('click', function(event) {
                const userMenu = document.querySelector('.user-menu');
                // Cek apakah userMenu ada DAN target klik BUKAN bagian dari userMenu
                if (userMenu && !userMenu.contains(event.target)) {
                    if(userDropdown) {
                        userDropdown.style.display = 'none'; // Sembunyikan dropdown
                    }
                }
            });
            // === ⬆️ BATAS AKHIR JAVASCRIPT DROPDOWN ⬆️ ===

        });
    </script>
    
    @stack('scripts') <!-- Untuk JS spesifik halaman -->

</body>
</html>