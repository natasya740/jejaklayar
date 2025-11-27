<nav class="flex-1 overflow-y-auto px-2 pb-6" aria-label="Sidebar Navigation">
  <div class="px-2">

    {{-- ================= PANEL ================= --}}
    <div class="sidebar-section-title">Panel</div>

    <a href="{{ route('admin.dashboard') }}"
      class="{{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
      title="Dashboard">
      <i class="fa fa-tachometer-alt"></i>
      <span class="ml-3">Dashboard</span>
    </a>


    {{-- ================= KONTEN ================= --}}
    
    <div class="sidebar-section-title">Konten</div>

    <a href="#"
      class="{{ request()->routeIs('admin.article.show') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
      title="Kelola article">
      <i class="fa fa-file-alt"></i>
      <span class="ml-3">Kelola article</span>
    </a>

    {{-- Validasi article + badge pending --}}


    <a href="#"
      class="{{ request()->routeIs('admin.article.pending') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2 flex items-center justify-between"
      title="Validasi article">

      <div class="flex items-center">
        <i class="fa fa-check-circle"></i>
        <span class="ml-3">Validasi</span>
      </div>

    </a>




    {{-- Media Manager --}}
    <a href="{{ route('admin.media.index') }}"
      class="{{ request()->routeIs('admin.media.*') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
      title="Media Manager">
      <i class="fa fa-photo-video"></i>
      <span class="ml-3">Media</span>
    </a>

    {{-- Halaman Statis --}}
    <a href="{{ route('admin.pages.index') }}"
      class="{{ request()->routeIs('admin.pages.*') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
      title="Halaman Statis">
      <i class="fa fa-file"></i>
      <span class="ml-3">Halaman</span>
    </a>
    


    {{-- ================= PENGGUNA ================= --}}
    <div class="sidebar-section-title">Pengguna</div>

    <a href="{{ route('admin.users.index') }}"
      class="{{ request()->routeIs('admin.users.index') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
      title="Kelola Pengguna">
      <i class="fa fa-users-cog"></i>
      <span class="ml-3">Kelola Pengguna</span>
    </a>


    {{-- ================= SISTEM ================= --}}
    <div class="sidebar-section-title">Sistem</div>

    <a href="{{ route('admin.audit.index') }}"
      class="{{ request()->routeIs('admin.audit.*') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
      title="Audit Mini">
      <i class="fa fa-history"></i>
      <span class="ml-3">Audit Mini</span>
    </a>

  </div>
</nav>
