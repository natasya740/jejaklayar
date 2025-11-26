<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'Dashboard Admin') - Jejak Layar</title>

    {{-- Vite / Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font & Icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- (copy seluruh :root + CSS sidebar/topbar dari layout asli kamu) --- */
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
            box-shadow: var(--shadow-sm);
            border-right: 1px solid rgba(2, 6, 23, 0.04);
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
            padding: .7rem .9rem;
            border-radius: .7rem;
            text-decoration: none;
            color: var(--text-dark);
            background: transparent;
            transition: transform .14s cubic-bezier(.2, .9, .2, 1), box-shadow .14s ease, background .12s ease;
            position: relative;
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
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(2, 6, 23, 0.06);
            background: rgba(255, 255, 255, 0.14);
        }

        aside#sidebar nav a.sidebar-active {
            background: rgba(2, 6, 23, 0.05);
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.08), 0 0 18px var(--active-glow);
            transform: translateY(-3px);
        }

        aside#sidebar nav a.sidebar-active i {
            filter: drop-shadow(0 6px 18px rgba(244, 180, 0, 0.12));
        }

        aside#sidebar nav a.sidebar-active::after {
            content: '';
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--yellow-1);
            box-shadow: 0 6px 16px rgba(244, 180, 0, 0.12);
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
            transition: transform .12s;
        }

        .sidebar-footer button:hover {
            transform: translateY(-3px);
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

        @keyframes icon-pulse {
            0% {
                transform: scale(1)
            }

            50% {
                transform: scale(1.06)
            }

            100% {
                transform: scale(1)
            }
        }

        aside#sidebar nav a:hover i {
            animation: icon-pulse .45s ease-in-out 1;
        }

        @media (max-width: 768px) {
            aside#sidebar {
                display: none;
            }

            #mobile-drawer {
                display: block;
            }

            .sidebar-brand img {
                width: 56px;
                height: 56px;
            }
        }

        aside#sidebar a.sidebar-active {
            z-index: 2;
        }

        /* ====== SIDEBAR BASE ====== */
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

            /* ANIMASI MASUK */
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

        /* ====== SHADOW GLOW RINGAN DI BELAKANG ====== */
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

        /* LOGO BRAND */
        .sidebar-brand img {
            transition: transform .4s ease, box-shadow .4s ease;
        }

        .sidebar-brand img:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        /* ====== SIDEBAR MENU ITEM ====== */
        aside#sidebar nav a {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .8rem .9rem;
            border-radius: 8px;
            cursor: pointer;

            /* ANIMASI */
            transition:
                background .18s ease,
                transform .18s ease,
                box-shadow .25s ease,
                filter .25s ease;
        }

        /* Hover: floating effect */
        aside#sidebar nav a:hover {
            background: rgba(255, 255, 255, 0.20);
            transform: translateY(-4px);
            box-shadow: 0 12px 26px rgba(0, 0, 0, 0.10);
        }

        /* Hover icon micro-bounce */
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

        /* ====== ACTIVE ITEM ====== */
        aside#sidebar nav a.sidebar-active {
            background: rgba(255, 255, 255, 0.95);
            color: var(--text-dark);
            transform: translateY(-3px);

            box-shadow:
                0 12px 32px rgba(255, 220, 80, 0.35),
                0 0 20px rgba(255, 200, 0, 0.4);

            /* glow ping effect */
            animation: activePulse 2s ease-in-out infinite;
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
                box-shadow: 0 12px 32px rgba(255, 220, 80, 0.35),
                    0 0 12px rgba(255, 200, 0, 0.2);
            }

            50% {
                box-shadow: 0 14px 40px rgba(255, 220, 80, 0.45),
                    0 0 20px rgba(255, 200, 0, 0.35);
            }

            100% {
                box-shadow: 0 12px 32px rgba(255, 220, 80, 0.35),
                    0 0 12px rgba(255, 200, 0, 0.2);
            }
        }

        /* ===== FOOTER LOGOUT BUTTON ===== */
        .sidebar-footer button {
            transition: all .25s ease;
        }

        .sidebar-footer button:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
        }

        /* ===== SCROLLBAR ===== */
        aside#sidebar::-webkit-scrollbar {
            width: 8px;
        }

        aside#sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.45);
            border-radius: 6px;
        }
    </style>
</head>

<body class="bg-[color:var(--bg-page)] text-[color:var(--text-dark)] antialiased">

    <div class="min-h-screen flex">

        <!-- SIDEBAR (desktop) -->
        <aside id="sidebar" class="hidden md:flex flex-col">
            <div class="sidebar-brand">
                <a href="{{ url('/') }}" class="flex items-center gap-3" aria-label="Beranda Jejak Layar">
                    <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar">
                    <div>
                        <div class="title">Jejak Layar Admin</div>
                        <div class="subtitle">Panel Administrasi</div>
                    </div>
                </a>
            </div>

            @include('layouts.partials.sidebar_admin')

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
                            <h1 class="page-title">@yield('page-title', 'Dashboard Admin')</h1>
                            <p class="page-sub">@yield('page-subtitle', 'Ringkasan aktivitas & moderasi')</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-sm text-[color:var(--muted)]">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[color:var(--text-dark)] shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
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
        <div class="absolute left-0 top-0 bottom-0 w-64 drawer-inner text-slate-900 p-4 overflow-y-auto">
            <div class="flex items-center gap-3 mb-6">
                <img src="{{ asset('images/Logo Header.png') }}" alt="logo" class="h-8 w-8">
                <span class="font-semibold">Jejak Layar</span>
            </div>

            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-3 py-2 rounded bg-white/5 hover:bg-white/8">Dashboard</a>
                <a href="{{ route('admin.artikel.show') }}" class="block px-3 py-2 rounded hover:bg-white/6">Kelola
                    Artikel</a>
                <a href="{{ route('admin.artikel.pending') }}"
                    class="block px-3 py-2 rounded hover:bg-white/6">Validasi</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded hover:bg-white/6">Pengguna</a>
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
