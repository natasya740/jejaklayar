<div class="sidebar">
  <div class="sidebar-brand">
    <img src="{{ asset('FOTO/Logo Header.png') }}" alt="Jejak Layar" class="logo">
  </div>
  <nav class="sidebar-nav">
    {{-- 💡 MENGGUNAKAN LARAVEL ROUTE --}}
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa fa-home"></i> Dashboard</a>
    <p class="menu-title">📂 Konten</p>
    <a href="{{ route('kontributor.upload') }}" class="nav-link {{ request()->routeIs('kontributor.upload') ? 'active' : '' }}"><i class="fa fa-plus"></i> Input Konten</a>
    <a href="{{ route('admin.artikel_list') }}" class="nav-link {{ request()->routeIs('admin.artikel_list') ? 'active' : '' }}"><i class="fa fa-eye"></i> View & Manage</a>
    <p class="menu-title">👥 Pengguna</p>
    <a href="{{ route('admin.user_kontributor') }}" class="nav-link {{ request()->routeIs('admin.user_kontributor') ? 'active' : '' }}"><i class="fa fa-user"></i> Sukarelawan</a>
    <a href="{{ route('admin.user_admin') }}" class="nav-link {{ request()->routeIs('admin.user_admin') ? 'active' : '' }}"><i class="fa fa-user-shield"></i> Admin</a>
    <p class="menu-title">⚙️ Lainnya</p>
    <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="fa fa-cog"></i> Pengaturan</a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="fa fa-sign-out-alt"></i> Logout</a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
  </nav>
</div>
