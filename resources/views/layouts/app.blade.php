<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jejak Layar')</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* BASE */
        html, body { height: 100%; margin: 0; }
        * { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fffaf2;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main { flex: 1; padding-top: 80px; }

        /* SPLASH */
        #logo-splash {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #ffd000 0%, #fef3c7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.8s;
        }
        #logo-splash.fade-out { opacity: 0; pointer-events: none; }
        .splash-logo { max-width: 280px; filter: drop-shadow(0 8px 20px rgba(0,0,0,0.08)); }

        /* HEADER */
        .site-header {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 0.8rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            inset-inline: 0;
            top: 0;
            z-index: 100;
        }
        .logo { height: 45px; transition: transform 0.25s; }
        .logo:hover { transform: scale(1.05); }

        /* SEARCH */
        .search-bar input {
            background: #f3f4f6;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            width: 300px;
            outline: none;
        }
        .search-bar input:focus {
            box-shadow: 0 0 0 3px rgba(244, 180, 0, 0.15);
            background: #fff;
        }

        /* NAV */
        .main-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .nav-link {
            text-decoration: none;
            color: #374151;
            font-weight: 500;
            padding: 5px 0;
        }
        .nav-link:hover, .nav-link.active { color: #d97706; }

        /* ===== AVATAR SIZE - FORCED WITH !important ===== */
        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
        }
        .user-avatar-wrapper {
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .user-avatar-wrapper:hover {
            transform: scale(1.08);
        }
        
        /* ✅ UKURAN AVATAR DIPERBESAR DENGAN !important */
        .profile-img {
            width: 50px !important;
            height: 50px !important;
            min-width: 50px !important;
            min-height: 50px !important;
            max-width: 50px !important;
            max-height: 50px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            border: 4px solid #f4b400 !important;
            box-shadow: 0 3px 10px rgba(244, 180, 0, 0.4) !important;
            transition: all 0.3s ease !important;
            cursor: pointer !important;
            display: block !important;
        }
        .profile-img:hover {
            border-color: #d97706 !important;
            box-shadow: 0 5px 15px rgba(244, 180, 0, 0.6) !important;
        }

        /* Online indicator */
        .online-indicator {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 14px;
            height: 14px;
            background: #10b981;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
        }

        /* Dropdown */
        .user-menu-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            min-width: 260px;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            display: none;
            z-index: 1000;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-header {
            padding: 20px;
            border-bottom: 1px solid #f3f4f6;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 16px 16px 0 0;
        }
        .dropdown-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dropdown-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }
        .dropdown-user-details h4 {
            font-weight: 700;
            font-size: 1rem;
            color: #1f2937;
            margin: 0;
        }
        .dropdown-user-details p {
            font-size: 0.75rem;
            color: #6b7280;
            margin: 0;
        }
        .dropdown-user-role {
            display: inline-block;
            padding: 2px 8px;
            background: rgba(245, 158, 11, 0.2);
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #d97706;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .dropdown-menu-items { padding: 8px 0; }
        .user-menu-dropdown a,
        .user-menu-dropdown button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            text-decoration: none;
            color: #4b5563;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .user-menu-dropdown a:hover,
        .user-menu-dropdown button:hover {
            background: #fffaf2;
            color: #d97706;
            padding-left: 25px;
        }
        .logout-btn {
            color: #ef4444 !important;
            border-top: 1px solid #f3f4f6;
            margin-top: 5px;
        }
        .logout-btn:hover {
            background: #fef2f2 !important;
            color: #dc2626 !important;
        }

        /* FOOTER */
        footer.site-footer {
            background: #fcd34d;
            color: #1f2937;
            padding-top: 4rem;
            margin-top: auto;
        }
        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem 2rem;
        }
        .footer-bottom {
            text-align: center;
            padding: 2rem 0;
            font-size: 0.85rem;
            color: #4b5563;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* BUTTONS */
        .btn-primary {
            background: #f4b400;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            main { padding-top: 70px; }
            .logo { height: 38px; }
            .search-bar input { width: 160px; padding: 8px 15px; }
            .profile-img {
                width: 44px !important;
                height: 44px !important;
                min-width: 44px !important;
                min-height: 44px !important;
            }
        }
        @media (max-width: 480px) {
            .profile-img {
                width: 42px !important;
                height: 42px !important;
                min-width: 42px !important;
                min-height: 42px !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="logo-splash">
        <img src="{{ asset('images/LogoJejakLayar.png') }}" alt="Jejak Layar" class="splash-logo">
    </div>

    <header class="site-header">
        <div class="header-left">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar" class="logo">
            </a>
        </div>

        <div class="header-center">
            <form class="search-bar" action="{{ route('search') }}" method="GET">
                <input type="search" name="q" placeholder="Cari: judul, tokoh, kata kunci..." value="{{ request('q') }}">
            </form>
        </div>

        <nav class="header-right main-nav">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>

            @if(isset($globalCategories) && $globalCategories->count() > 0)
                @foreach($globalCategories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="nav-link {{ request()->is('kategori/'.$cat->slug.'*') ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            @else
                <a href="{{ route('budaya') }}" class="nav-link">Budaya</a>
                <a href="{{ route('pustaka') }}" class="nav-link">Pustaka</a>
            @endif

            <a href="{{ route('tentang') }}" class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>

            @guest
                <a href="{{ route('login') }}" class="btn-primary">Login</a>
            @endguest

            @auth
            <div class="user-menu">
                <div class="user-avatar-wrapper" id="user-menu-toggle" role="button" tabindex="0" aria-label="User Menu">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/profile/' . Auth::user()->avatar) }}"
                             alt="{{ Auth::user()->name }}" 
                             class="profile-img"
                             style="width: 50px !important; height: 50px !important; min-width: 50px !important; min-height: 50px !important;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f59e0b&color=fff&bold=true"
                             alt="{{ Auth::user()->name }}" 
                             class="profile-img"
                             style="width: 50px !important; height: 50px !important; min-width: 50px !important; min-height: 50px !important;">
                    @endif
                    <span class="online-indicator"></span>
                </div>

                <div class="user-menu-dropdown" id="user-menu-dropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-user-info">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/profile/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="dropdown-avatar">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f59e0b&color=fff&bold=true" alt="{{ Auth::user()->name }}" class="dropdown-avatar">
                            @endif
                            <div class="dropdown-user-details">
                                <h4>{{ Auth::user()->name }}</h4>
                                <p>{{ Auth::user()->email }}</p>
                                <span class="dropdown-user-role">
                                    <i class="fa fa-shield-alt"></i> {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dropdown-menu-items">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                            </a>
                        @elseif(Auth::user()->role === 'kontributor')
                            <a href="{{ route('kontributor.dashboard') }}">
                                <i class="fas fa-pencil-alt"></i> Dashboard Kontributor
                            </a>
                        @endif
                        <a href="{{ route('kontributor.profil') }}">
                            <i class="fas fa-user-circle"></i> Profil Saya
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col">
                <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar" style="height:50px;margin-bottom:15px;">
                <p>Melayu Bengkalis dalam satu portal digital untuk semua generasi.</p>
            </div>
            <div class="footer-col">
                <h3>JELAJAHI</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('budaya') }}">Budaya</a></li>
                    <li><a href="{{ route('pustaka') }}">Pustaka Digital</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Jejak Layar — All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Splash
            const splash = document.getElementById('logo-splash');
            if (splash) {
                setTimeout(() => {
                    splash.classList.add('fade-out');
                    setTimeout(() => splash.style.display = 'none', 800);
                }, 500);
            }

            // User dropdown
            const userToggle = document.getElementById('user-menu-toggle');
            const userDropdown = document.getElementById('user-menu-dropdown');
            
            if (userToggle && userDropdown) {
                userToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isShown = userDropdown.style.display === 'block';
                    userDropdown.style.display = isShown ? 'none' : 'block';
                });
                
                document.addEventListener('click', (e) => {
                    if (!userToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.style.display = 'none';
                    }
                });
                
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && userDropdown.style.display === 'block') {
                        userDropdown.style.display = 'none';
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>