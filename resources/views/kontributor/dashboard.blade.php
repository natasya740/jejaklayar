{{-- 
  ==============================================================
  🔹 Menggunakan layout sidebar BARU 🔹
  ==============================================================
--}}
@extends('layouts.kontributor')

@section('title', 'Dashboard Kontributor')

@push('styles')
  {{-- CSS khusus dashboard bisa ditambahkan di sini --}}
@endpush


@section('content')

    <!-- HEADER HALAMAN -->
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Selamat datang kembali, {{ Auth::user()->name }} 👋</p>
    </div>

    <!-- =============================================== -->
    <!-- 🔹 KARTU STATISTIK 🔹 -->
    <!-- =============================================== -->
    <div class="stats-grid">
        <!-- Stat Card 1 -->
        <div class="stat-card blue">
            <div class="icon-wrapper">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-info">
                {{-- TODO: Ganti angka 5 dengan data asli --}}
                <span class="value">5</span> 
                <span class="label">Total Artikel</span>
            </div>
        </div>
        
        <!-- Stat Card 2 -->
        <div class="stat-card yellow">
            <div class="icon-wrapper">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                {{-- TODO: Ganti angka 1 dengan data asli --}}
                <span class="value">1</span>
                <span class="label">Menunggu Validasi</span>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="stat-card green">
            <div class="icon-wrapper">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                {{-- TODO: Ganti angka 4 dengan data asli --}}
                <span class="value">4</span>
                <span class="label">Artikel Diterbitkan</span>
            </div>
        </div>
    </div>

    <!-- =============================================== -->
    <!-- 🔹 AREA KONTEN UTAMA (GRID) 🔹 -->
    <!-- =============================================== -->
    <div class="dashboard-grid">
        
        <!-- Kolom Kiri: Artikel Terbaru -->
        <div class="card">
            <div class="card-header">
                <h2>Artikel Terbaru Anda</h2>
            </div>
            <div class="card-body" style="padding: 0;"> {{-- Hapus padding agar tabel penuh --}}
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- TODO: Ganti ini dengan @foreach loop data artikel --}}
                        <tr>
                            <td>Asal Usul Bengkalis</td>
                            <td>Sejarah</td>
                            <td><span class="badge approved">Disetujui</span></td>
                        </tr>
                        <tr>
                            <td>Legenda Putri Tujuh</td>
                            <td>Cerita Rakyat</td>
                            <td><span class="badge pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>Upacara Tepuk Tepung Tawar</td>
                            <td>Budaya</td>
                            <td><span class="badge approved">Disetujui</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kolom Kanan: Aksi Cepat -->
        <div class="card">
            <div class="card-header">
                <h2>Aksi Cepat</h2>
            </div>
            <div class="card-body">
                <p style="margin-bottom: 15px;">Siap untuk membagikan cerita atau pengetahuan baru?</p>
                <a href="{{ route('kontributor.artikel.form') }}" class="btn btn-primary btn-full-width">
                    <i class="fas fa-plus"></i> Tulis Artikel Baru
                </a>
            </div>
        </div>

    </div>

@endsection