<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Kontributor') | Jejak Layar</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/kontributor.css') }}?v={{ time() }}">

    @stack('styles')
</head>
<body class="kontributor-body">

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('FOTO/Logo Header.png') }}" alt="Logo" class="logo"> 
            <span>Jejak Layar</span>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-title">MENU UTAMA</span>
            <a href="{{ route('kontributor.dashboard') }}" class="{{ request()->routeIs('kontributor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('kontributor.artikel.form') }}" class="{{ request()->routeIs('kontributor.artikel.form') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Artikel</span>
            </a>
            <a href="{{ route('kontributor.artikel.saya') }}" class="{{ request()->routeIs('kontributor.artikel.saya') ? 'active' : '' }}">
                <i class="fas fa-list-ul"></i>
                <span>Artikel Saya</span>
            </a>
            
            <span class="nav-title">AKUN</span>
            <a href="{{ route('kontributor.profil') }}" class="{{ request()->routeIs('kontributor.profil') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i>
                <span>Profil Saya</span>
            </a>
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
                    <span class="user-role">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </div>
            <a href="{{ route('logout') }}"
               class="logout-button"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>
    
    @stack('scripts')

</body>
</html>