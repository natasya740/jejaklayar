@extends('layouts.app')

@section('title', 'Beranda | Jejak Layar')

@push('styles')
<link rel="stylesheet" href="{{ asset('./css/kontributor.css') }}">
@endpush


@section('content')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Kontributor</h1>
    <p class="text-gray-700 mb-4">Selamat datang, {{ Auth::user()->name }} 👋</p>


  <!-- HEADER -->
  <header class="kontributor-header">
    <div class="brand">
      <img src="../FOTO/Logo Header.png" alt="Logo" class="logo">
      <h1>Kontributor</h1>
    </div>
    <nav class="nav-links" id="navLinks">
      <a href="kontributor_dashboard.html"><i class="fa fa-home"></i> Dashboard</a>
      <a href="artikel_form.html"><i class="fa fa-plus"></i> Tambah Artikel</a>
      <a href="artikel_saya.html"><i class="fa fa-list"></i> Artikel Saya</a>
      <a href="profile.html"><i class="fa fa-user"></i> Profil</a>
      <a href="../Backend/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </nav>
    <button class="menu-toggle" onclick="toggleMenu()">
      <i class="fa fa-bars"></i>
    </button>
  </header>

  <!-- MAIN -->
  <main class="container">
    <section class="profile-section">
      <h2>Identitas Kontributor</h2>
      <div class="profile-card">
        <img src="../FOTO/avatar.png" alt="Avatar" class="avatar">
        <div>
          <p><strong>Nama:</strong> Ahmad Fikri</p>
          <p><strong>Email:</strong> fikri@example.com</p>
          <p><strong>Status:</strong> Kontributor Aktif</p>
        </div>
      </div>
    </section>

    <section class="form-section">
      <h2>Input Konten Baru</h2>
      <form>
        <label>Judul</label>
        <input type="text" placeholder="Judul konten">
        <label>Kategori</label>
        <select>
          <option>Sejarah</option>
          <option>Budaya</option>
          <option>Cerita Rakyat</option>
          <option>Tokoh</option>
        </select>
        <label>Isi Konten</label>
        <textarea rows="6" placeholder="Tuliskan isi konten..."></textarea>
        <label>Upload Gambar</label>
        <input type="file">
        <button type="submit" class="btn">Kirim untuk Validasi</button>
      </form>
    </section>

    <section class="table-section">
      <h2>Riwayat Konten Saya</h2>
      <table>
        <thead>
          <tr>
            <th>Judul</th><th>Kategori</th><th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Legenda Putri Tujuh</td><td>Cerita Rakyat</td><td><span class="badge pending">Pending</span></td></tr>
          <tr><td>Asal Usul Bengkalis</td><td>Sejarah</td><td><span class="badge approved">Disetujui</span></td></tr>
        </tbody>
      </table>
    </section>
  </main>

  <script>
    function toggleMenu(){
      document.getElementById("navLinks").classList.toggle("open");
    }
  </script>
</body>
</html>
