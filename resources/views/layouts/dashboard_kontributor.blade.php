<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'Dashboard Kontributor') - Jejak Layar</title>

    {{-- Vite / Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font & Icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --yellow-1: #fcd34d;
            --yellow-2: #f4b400;
            --sidebar-grad: linear-gradient(180deg, var(--yellow-1) 0%, var(--yellow-2) 100%);
            --bg-page: #FAFBFF;
            --text-dark: #071027;
            --muted: rgba(7, 16, 39, 0.6);
            --shadow-sm: 0 6px 20px rgba(2, 6, 23, 0.06);
            --active-glow: rgba(244, 180, 0, 0.18);
        }

        body {
            font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
            background: var(--bg-page);
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        aside#sidebar {
            min-width: 18rem;
            background: var(--sidebar-grad);
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.10);
            border-right: 1px solid rgba(255, 255, 255, 0.25);
            position: sticky;
            top: 0;
            height: 100vh;
            padding-bottom: 20px;
            overflow-y: auto;
            animation: sidebarFade 0.55s ease forwards;
            transform: translateX(-18px);
            opacity: 0;
        }

        @keyframes sidebarFade {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        aside#sidebar::after {
            content: "";
            position: absolute;
            right: -25px;
            top: 0;
            width: 80px;
            height: 100%;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.06), transparent);
            filter: blur(18px);
            pointer-events: none;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1rem;
            border-bottom: 1px solid rgba(2, 6, 23, 0.04);
        }

        .sidebar-brand img {
            width: 78px;
            height: 78px;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(2, 6, 23, 0.06);
            transition: transform .4s ease, box-shadow .4s ease;
        }

        .sidebar-brand img:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .sidebar-brand .title {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 1.05rem;
        }

        .sidebar-brand .subtitle {
            font-size: .72rem;
            color: var(--muted);
            margin-top: 2px;
        }

        aside#sidebar nav {
            padding: .75rem;
            display: flex;
            flex-direction: column;
            gap: .25rem;
            overflow: auto;
        }

        aside#sidebar nav a {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .8rem .9rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-dark);
            background: transparent;
            transition: background .18s ease, transform .18s ease, box-shadow .25s ease, filter .25s ease;
            position: relative;
            cursor: pointer;
        }

        aside#sidebar nav a i {
            width: 1.2rem;
            text-align: center;
            color: rgba(3, 16, 38, 0.9);
            font-size: 1.05rem;
        }

        aside#sidebar nav a span {
            font-weight: 600;
            color: rgba(3, 16, 38, 0.95);
        }

        aside#sidebar nav a:hover {
            background: rgba(255, 255, 255, 0.20);
            transform: translateY(-4px);
            box-shadow: 0 12px 26px rgba(0, 0, 0, 0.10);
        }

        aside#sidebar nav a:hover i {
            animation: iconPop .45s ease;
        }

        @keyframes iconPop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.25);
            }

            100% {
                transform: scale(1);
            }
        }

        aside#sidebar nav a.sidebar-active {
            background: rgba(255, 255, 255, 0.95);
            color: var(--text-dark);
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(255, 220, 80, 0.35), 0 0 20px rgba(255, 200, 0, 0.4);
            animation: activePulse 2s ease-in-out infinite;
            z-index: 2;
        }

        aside#sidebar nav a.sidebar-active::after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
            background: linear-gradient(180deg, var(--yellow-2), var(--yellow-1));
            box-shadow: 0 0 18px rgba(255, 200, 40, 0.5);
        }

        @keyframes activePulse {
            0% {
                box-shadow: 0 12px 32px rgba(255, 220, 80, 0.35), 0 0 12px rgba(255, 200, 0, 0.2);
            }

            50% {
                box-shadow: 0 14px 40px rgba(255, 220, 80, 0.45), 0 0 20px rgba(255, 200, 0, 0.35);
            }

            100% {
                box-shadow: 0 12px 32px rgba(255, 220, 80, 0.35), 0 0 12px rgba(255, 200, 0, 0.2);
            }
        }

        .sidebar-section-title {
            margin: .5rem .5rem;
            font-size: .68rem;
            color: var(--muted);
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: .75rem;
            border-top: 1px solid rgba(2, 6, 23, 0.03);
        }

        .sidebar-footer button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .6rem .8rem;
            border-radius: .6rem;
            background: #fff;
            color: var(--text-dark);
            font-weight: 600;
            border: none;
            box-shadow: 0 6px 20px rgba(2, 6, 23, 0.06);
            transition: all .25s ease;
        }

        .sidebar-footer button:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
        }

        aside#sidebar::-webkit-scrollbar {
            width: 8px;
        }

        aside#sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.45);
            border-radius: 6px;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid rgba(2, 6, 23, 0.04);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .page-sub {
            color: var(--muted);
            font-size: .94rem;
        }

        .focus-ring:focus {
            outline: 3px solid rgba(244, 180, 0, 0.14);
            outline-offset: 3px;
            border-radius: .5rem;
        }

        @media (max-width: 768px) {
            aside#sidebar {
                display: none;
            }

            .sidebar-brand img {
                width: 56px;
                height: 56px;
            }
        }
    </style>
</head>

<body class="bg-[color:var(--bg-page)] text-[color:var(--text-dark)] antialiased">

    <div class="min-h-screen flex">

        <!-- SIDEBAR (desktop) -->
        <aside id="sidebar" class="hidden md:flex flex-col">
            <div class="sidebar-brand">
                <a href="{{ url('/') }}" class="flex items-center gap-3" aria-label="Beranda Jejak Layar">
                    <img src="{{ asset('images/LogoJejakLayar.png') }}" alt="Jejak Layar">
                    <div>
                        <div class="title">Jejak Layar</div>
                        <div class="subtitle">Panel Kontributor</div>
                    </div>
                </a>
            </div>

            <!-- SIDEBAR NAVIGATION -->
            <nav class="flex-1 overflow-y-auto px-2 pb-6" aria-label="Sidebar Navigation">
                <div class="px-2">

                    {{-- ================= MENU KONTRIBUTOR ================= --}}
                    <div class="sidebar-section-title">Menu Utama</div>

                    <a href="{{ route('kontributor.dashboard') }}"
                        class="{{ request()->routeIs('kontributor.dashboard') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
                        title="Dashboard">
                        <i class="fa fa-home"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>

                    <a href="{{ route('kontributor.artikel.create') }}"
                        class="{{ request()->routeIs('kontributor.artikel.create') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
                        title="Upload Artikel">
                        <i class="fa fa-plus-circle"></i>
                        <span class="ml-3">Upload Artikel</span>
                    </a>

                    <a href="{{ route('kontributor.artikel.index') }}"
                        class="{{ request()->routeIs('kontributor.artikel.index') || request()->routeIs('kontributor.artikel.edit') || request()->routeIs('kontributor.artikel.show') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
                        title="Artikel Saya">
                        <i class="fa fa-file-alt"></i>
                        <span class="ml-3">Artikel Saya</span>
                    </a>

                    {{-- ================= PROFIL ================= --}}
                    <div class="sidebar-section-title">Profil</div>

                    <a href="{{ route('kontributor.profil.edit') }}"
                        class="{{ request()->routeIs('kontributor.profil.edit') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
                        title="Edit Profil">
                        <i class="fa fa-user-circle"></i>
                        <span class="ml-3">Edit Profil</span>
                    </a>

                    {{-- ================= LAINNYA ================= --}}
                    <div class="sidebar-section-title">Lainnya</div>

                    <a href="{{ route('kontributor.artikel.index') }}"
                        class="rounded-lg focus-ring mt-2"
                        title="Lihat Artikel Publik">
                        <i class="fa fa-globe"></i>
                        <span class="ml-3">Lihat Artikel Publik</span>
                    </a>

                </div>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" class="px-4 py-3">
                    @csrf
                    <button type="submit" title="Logout">
                        <i class="fa fa-sign-out-alt"></i><span class="ml-2">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- TOPBAR -->
            <header class="topbar">
                <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button id="btn-open-sidebar" class="md:hidden p-2 rounded bg-white shadow-sm"
                            aria-label="Buka menu">
                            <i class="fa fa-bars"></i>
                        </button>

                        <div>
                            <h1 class="page-title">@yield('page-title', 'Dashboard Kontributor')</h1>
                            <p class="page-sub">@yield('page-subtitle', 'Kelola artikel dan profil Anda')</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-sm text-[color:var(--muted)]">{{ auth()->user()->name ?? 'Kontributor' }}</div>
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center text-white shadow-sm font-semibold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- PAGE -->
            <main class="p-6 flex-1 overflow-y-auto">
                <div class="max-w-7xl mx-auto">
                    @includeWhen(session('success'), 'components.flash', [
                        'type' => 'success',
                        'message' => session('success'),
                    ])
                    @includeWhen(session('error'), 'components.flash', [
                        'type' => 'error',
                        'message' => session('error'),
                    ])
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- MOBILE DRAWER --}}
    <div id="mobile-drawer" class="fixed inset-0 z-50 md:hidden hidden" aria-hidden="true">
        <div id="drawer-backdrop" class="absolute inset-0 bg-black/40"></div>
        <div
            class="absolute left-0 top-0 bottom-0 w-64 bg-gradient-to-b from-yellow-300 to-yellow-400 text-slate-900 p-4 overflow-y-auto">
            <div class="flex items-center gap-3 mb-6">
                <img src="{{ asset('images/LogoJejakLayar.png') }}" alt="logo" class="h-8 w-8">
                <span class="font-semibold">Jejak Layar</span>
            </div>

            <nav class="space-y-1">
                <a href="{{ route('kontributor.dashboard') }}"
                    class="block px-3 py-2 rounded bg-white/5 hover:bg-white/8">Dashboard</a>
                <a href="{{ route('kontributor.artikel.create') }}" 
                    class="block px-3 py-2 rounded hover:bg-white/6">Upload Artikel</a>
                <a href="{{ route('kontributor.artikel.index') }}"
                    class="block px-3 py-2 rounded hover:bg-white/6">Artikel Saya</a>
                <a href="{{ route('kontributor.profil.edit') }}"
                    class="block px-3 py-2 rounded hover:bg-white/6">Edit Profil</a>
                <a href="{{ route('kontributor.artikel.index') }}"
                    class="block px-3 py-2 rounded hover:bg-white/6">Lihat Artikel Publik</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded text-rose-500">Keluar</button>
                </form>
            </nav>
        </div>
    </div>

    <script>
        // Mobile drawer toggle
        const drawer = document.getElementById('mobile-drawer');
        const openBtn = document.getElementById('btn-open-sidebar');
        const backdrop = document.getElementById('drawer-backdrop');
        if (openBtn) {
            openBtn.addEventListener('click', () => drawer.classList.remove('hidden'));
            backdrop.addEventListener('click', () => drawer.classList.add('hidden'));
        }
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !drawer.classList.contains('hidden')) {
                drawer.classList.add('hidden');
            }
        });
    </script>
</body>

</html>