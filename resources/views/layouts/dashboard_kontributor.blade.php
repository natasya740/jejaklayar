<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','Dashboard') - Jejak Layar</title>

  {{-- Vite / Tailwind --}}
  @vite(['resources/css/app.css','resources/js/app.js'])

  {{-- Font & Icons --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      /* Palette: kuning (aksen) + putih (latar) */
      --yellow-1: #fcd34d;    /* primary accent (muted) */
      --yellow-2: #f4b400;    /* gradient warmer tone */
      --sidebar-grad: linear-gradient(180deg,var(--yellow-1) 0%,var(--yellow-2) 100%);
      --bg-page: #FAFBFF;     /* soft off-white for page */
      --text-dark: #071027;   /* near-black for readability */
      --muted: rgba(7,16,39,0.6);
      --shadow-sm: 0 6px 20px rgba(2,6,23,0.06);
      --active-glow: rgba(244,180,0,0.18);
    }

    /* base */
    body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, Arial; background: var(--bg-page); color: var(--text-dark); -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale; }

    /* Sidebar (yellow + white scheme) */
    aside#sidebar {
      min-width: 18rem;
      background: var(--sidebar-grad);
      display:flex;
      flex-direction:column;
      box-shadow: var(--shadow-sm);
      border-right: 1px solid rgba(2,6,23,0.04);
    }

    .sidebar-brand {
      display:flex;
      align-items:center;
      gap:.75rem;
      padding:1rem;
      border-bottom: 1px solid rgba(2,6,23,0.04);
    }
    .sidebar-brand img { width:78px; height:78px; object-fit:contain; border-radius:10px; box-shadow: 0 6px 20px rgba(2,6,23,0.06); }
    .sidebar-brand .title { font-weight:700; color:var(--text-dark); font-size:1.05rem; }
    .sidebar-brand .subtitle { font-size:.72rem; color:var(--muted); margin-top:2px; }

    /* nav items */
    aside#sidebar nav { padding: .75rem; display:flex; flex-direction:column; gap:.25rem; overflow:auto; }
    aside#sidebar nav a {
      display:flex; align-items:center; gap:.75rem; padding:.7rem .9rem; border-radius:.7rem;
      text-decoration:none; color:var(--text-dark); background: transparent;
      transition: transform .14s cubic-bezier(.2,.9,.2,1), box-shadow .14s ease, background .12s ease;
      position:relative;
    }
    aside#sidebar nav a i { width:1.2rem; text-align:center; color: rgba(3,16,38,0.9); font-size:1.05rem; }
    aside#sidebar nav a span { font-weight:600; color: rgba(3,16,38,0.95); }

    /* hover micro-interaction */
    aside#sidebar nav a:hover {
      transform: translateY(-3px);
      box-shadow: 0 16px 40px rgba(2,6,23,0.06);
      background: rgba(255,255,255,0.14); /* faint white overlay to soften */
    }

    /* active style: subtle dark overlay + glow */
    aside#sidebar nav a.sidebar-active {
      background: rgba(2,6,23,0.05);
      box-shadow: 0 10px 30px rgba(2,6,23,0.08), 0 0 18px var(--active-glow);
      transform: translateY(-3px);
    }
    aside#sidebar nav a.sidebar-active i { filter: drop-shadow(0 6px 18px rgba(244,180,0,0.12)); }
    aside#sidebar nav a.sidebar-active::after {
      content:''; position:absolute; right:12px; top:50%; transform:translateY(-50%); width:8px; height:8px; border-radius:50%; background:var(--yellow-1); box-shadow: 0 6px 16px rgba(244,180,0,0.12);
    }

    /* section title */
    .sidebar-section-title { margin:.5rem .5rem; font-size:.68rem; color:var(--muted); font-weight:700; letter-spacing:.06em; text-transform:uppercase; }

    /* logout & footer area */
    .sidebar-footer { margin-top:auto; padding: .75rem; border-top:1px solid rgba(2,6,23,0.03); }
    .sidebar-footer button { width:100%; display:flex; align-items:center; gap:.6rem; padding:.6rem .8rem; border-radius:.6rem; background:#fff; color:var(--text-dark); font-weight:600; border:none; box-shadow:0 6px 20px rgba(2,6,23,0.06); transition: transform .12s; }
    .sidebar-footer button:hover { transform: translateY(-3px); }

    /* main area */
    .topbar { background:#fff; border-bottom:1px solid rgba(2,6,23,0.04); }
    .page-title { font-size:1.5rem; font-weight:700; color:var(--text-dark); }
    .page-sub { color:var(--muted); font-size:.94rem; }

    /* mobile drawer: keep yellow accent but readable */
    #mobile-drawer .drawer-inner { background: linear-gradient(180deg,var(--yellow-1),#fff); color:var(--text-dark); padding:1rem; }

    .focus-ring:focus { outline: 3px solid rgba(244,180,0,0.14); outline-offset:3px; border-radius:.5rem; }

    /* micro icon animation */
    @keyframes icon-pulse { 0%{transform:scale(1)}50%{transform:scale(1.06)}100%{transform:scale(1)} }
    aside#sidebar nav a:hover i { animation: icon-pulse .45s ease-in-out 1; }

    /* responsive */
    @media (max-width: 768px) {
      aside#sidebar { display:none; }
      #mobile-drawer { display:block; }
      .sidebar-brand img { width:56px; height:56px; }
    }

    /* small specificity to override tailwind where necessary */
    aside#sidebar a.sidebar-active { z-index:2; }
  </style>
</head>
<body class="bg-[color:var(--bg-page)] text-[color:var(--text-dark)] antialiased">

  <div class="min-h-screen flex">

    <!-- SIDEBAR (desktop) -->
    <aside id="sidebar" class="hidden md:flex flex-col">
      <div class="sidebar-brand">
        <a href="{{ url('/') }}" class="flex items-center gap-3" aria-label="Beranda Jejak Layar">
          {{-- Besar logo: ubah width/height di CSS .sidebar-brand img --}}
          <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar">
          <div>
            <div class="title">Jejak Layar</div>
            <div class="subtitle">Koleksi Budaya Nusantara</div>
          </div>
        </a>
      </div>

      <nav class="flex-1 overflow-y-auto px-2 pb-6" aria-label="Sidebar Navigation">
        {{-- Home --}}
        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'sidebar-active' : '' }} rounded-lg focus-ring" title="Beranda">
          <i class="fa fa-home"></i><span class="ml-3">Beranda</span>
        </a>

        <div class="sidebar-section-title">Kontributor</div>

        {{-- Dashboard --}}
        <a href="{{ url('/kontributor/dashboard') }}" class="{{ request()->is('kontributor/dashboard') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2" title="Dashboard Kontributor">
          <i class="fa fa-chart-line"></i><span class="ml-3">Dashboard</span>
        </a>

        {{-- Tulis Artikel --}}
        <a href="{{ url('/kontributor/artikel/baru') }}" class="{{ request()->is('kontributor/artikel*') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2" title="Tulis Artikel">
          <i class="fa fa-pen-nib"></i><span class="ml-3">Tulis Artikel</span>
        </a>

        {{-- Artikel Saya --}}
        <a href="{{ url('/kontributor/artikel/show') }}" class="{{ request()->is('kontributor/artikel') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2" title="Artikel Saya">
          <i class="fa fa-file-alt"></i><span class="ml-3">Artikel Saya</span>
        </a>

        {{-- Profil Saya --}}
        <a href="{{ url('/kontributor/profil') }}" class="{{ request()->is('kontributor/profil') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2" title="Profil Saya">
          <i class="fa fa-user"></i><span class="ml-3">Profil Saya</span>
        </a>

        {{-- Admin (only visible for admin) --}}
        @if(auth()->check() && auth()->user()->role === 'admin')
          <div class="sidebar-section-title">Admin</div>
          <a href="{{ url('/admin') }}" class="{{ request()->is('admin*') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2" title="Admin Panel">
            <i class="fa fa-cog"></i><span class="ml-3">Admin Panel</span>
          </a>
        @endif

      </nav>

      <div class="sidebar-footer border-t border-[rgba(2,6,23,0.03)]">
        <form action="{{ route('logout') }}" method="POST" class="px-4 py-3">
          @csrf
          <button type="submit" class="w-full flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold bg-white/90 hover:bg-white transition">
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
            <button id="btn-open-sidebar" class="md:hidden p-2 rounded bg-white shadow-sm" aria-label="Buka menu">
              <i class="fa fa-bars"></i>
            </button>

            <div>
              <h1 class="page-title">@yield('page-title','Dashboard')</h1>
              <p class="page-sub">@yield('page-subtitle')</p>
            </div>
          </div>

          <div class="flex items-center gap-4">
            <div class="text-sm text-[color:var(--muted)]">{{ auth()->user()->name ?? 'Pengguna' }}</div>
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[color:var(--text-dark)] shadow-sm">
              {{ strtoupper(substr(auth()->user()->name ?? 'U',0,1)) }}
            </div>
          </div>
        </div>
      </header>

      <!-- PAGE -->
      <main class="p-6 flex-1 overflow-y-auto">
        <div class="max-w-7xl mx-auto">
          @includeWhen(session('success'), 'components.flash', ['type'=>'success','message'=>session('success')])
          @includeWhen(session('error'), 'components.flash', ['type'=>'error','message'=>session('error')])
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
        <a href="{{ url('/') }}" class="block px-3 py-2 rounded bg-white/5 hover:bg-white/8">Beranda</a>
        <a href="{{ url('./kontributor/dashboard') }}" class="block px-3 py-2 rounded hover:bg-white/6">Dashboard</a>
        <a href="{{ url('/kontributor/artikel/baru') }}" class="block px-3 py-2 rounded hover:bg-white/6">Tulis Artikel</a>
        <a href="{{ url('/kontributor/artikel') }}" class="block px-3 py-2 rounded hover:bg-white/6">Artikel Saya</a>
        <a href="{{ url('/profile') }}" class="block px-3 py-2 rounded hover:bg-white/6">Profil Saya</a>
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
    if(openBtn){
      openBtn.addEventListener('click', ()=> drawer.classList.remove('hidden'));
      backdrop.addEventListener('click', ()=> drawer.classList.add('hidden'));
    }

    // Close drawer on ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !drawer.classList.contains('hidden')) {
        drawer.classList.add('hidden');
      }
    });
  </script>
</body>
</html>
