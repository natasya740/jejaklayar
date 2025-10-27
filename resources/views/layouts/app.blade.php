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

    {{-- ✅ Jika user sudah login tampilkan profil & nama --}}
    @auth
        <div class="user-info" style="display:flex;align-items:center;gap:10px;">
            <img src="{{ asset('images/profile.png') }}" alt="Profil"
                 class="profile-img"
                 style="width:35px;height:35px;border-radius:50%;object-fit:cover;">
            <span class="username">{{ Auth::user()->nama }}</span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background:none;border:none;color:red;cursor:pointer;">
                    Logout
                </button>
            </form>
        </div>
    @endauth
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
                <p><a href="mailto:jejaklayar@gmail.com">jejaklayar@gmail.com</a></p>

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

    <!-- ✅ Script transition -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('page-content').classList.add('show');
        });
    </script>

</body>
</html>
