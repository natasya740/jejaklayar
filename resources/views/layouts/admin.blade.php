<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin') | Jejak Layar</title>

    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- CSS Modern (Menggunakan file yang sama dengan kontributor agar efisien & konsisten) -->
    <link rel="stylesheet" href="{{ asset('css/kontributor.css') }}?v={{ time() }}">

    @stack('styles')
</head>
<body class="kontributor-body"> <!-- Class body sama -->

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- SIDEBAR ADMIN -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('FOTO/Logo Header.png') }}" alt="Logo" class="logo"> 
            <span>Admin Panel</span>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-title">UTAMA</span>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <span class="nav-title">MANAJEMEN KONTEN</span>
            <a href="{{ route('admin.artikel.pending') }}" class="{{ request()->routeIs('admin.artikel.pending') ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                <span>Validasi Artikel</span>
                {{-- Badge notifikasi jika ada artikel pending (opsional, logika di view composer) --}}
            </a>
            <a href="#" class=""> {{-- Nanti bisa ditambah rute list semua artikel --}}
                <i class="fas fa-newspaper"></i>
                <span>Semua Artikel</span>
            </a>

            <span class="nav-title">AKUN</span>
            <a href="{{ route('home') }}" class="nav-link-external">
                <i class="fas fa-globe"></i>
                <span>Lihat Situs Publik</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <img src="{{ asset('FOTO/avatar.png') }}" alt="Avatar" class="avatar">
                <div class="user-details">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="logout-button"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="main-content">
        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #10b981;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    @stack('scripts')

</body>
</html>