<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Jejak Layar')</title>

  <!-- CSS Tailwind (tetap boleh dipakai buat dashboard/admin) -->
@vite('resources/css/app.css')

<!-- CSS utama kamu -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

  {{-- ✅ CSS tambahan untuk halaman tertentu --}}
  @stack('styles')

  {{-- FontAwesome & Font --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen flex flex-col">

  {{-- 🔸 Header --}}
<header class="site-header">
  <div class="header-left">
    <a href="{{ route('home') }}" class="logo-link">
      <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar" class="logo">
    </a>
  </div>

  <div class="header-center">
    <form class="search-bar" action="{{ route('search') }}" method="GET">
      <input type="search" name="q" placeholder="Cari: judul, tokoh, kata kunci..." />
    </form>
  </div>

  <div class="header-right">
    <nav class="main-nav">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
      <a href="{{ route('budaya') }}" class="{{ request()->routeIs('budaya') ? 'active' : '' }}">Budaya</a>
      <a href="{{ route('pustaka') }}" class="{{ request()->routeIs('pustaka') ? 'active' : '' }}">Pustaka</a>
      <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>
      <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
    </nav>
  </div>
</header>
  {{-- 🔸 Konten utama --}}
  <main class="flex-grow page-transition" id="page-content">
      @yield('content')
  </main>

  {{-- 🔸 Footer --}}
<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-col">
      <h3 class="footer-brand">Jejak Layar</h3>
      <p>Melayu Bengkalis dalam satu portal digital untuk semua generasi.
      Menjaga warisan budaya, mendekatkan generasi muda dengan sejarahnya.</p>
    </div>

    <div class="footer-col">
      <h3>Navigasi</h3>
      <ul>
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('budaya') }}">Budaya</a></li>
        <li><a href="{{ route('pustaka') }}">Pustaka</a></li>
        <li><a href="{{ route('tentang') }}">Tentang</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h3>Hubungi Kami</h3>
      <p><a href="mailto:jejaklayar@gmail.com">jejaklayar@gmail.com</a></p>
      <p><a href="tel:+628123456789">+62 812-3456-789</a></p>
      <div class="socials">
        <a href="https://instagram.com/" target="_blank">
          <img src="{{ asset('images/instagram.png') }}" alt="Instagram">
        </a>
        <a href="https://wa.me/628123456789" target="_blank">
          <img src="{{ asset('images/whatsapp.png') }}" alt="WhatsApp">
        </a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2025 Jejak Layar — All Rights Reserved</p>
  </div>
</footer>
