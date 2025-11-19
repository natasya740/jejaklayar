@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    <div class="page-header">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, {{ Auth::user()->name }}. Berikut adalah ringkasan aktivitas.</p>
    </div>

    <!-- STATISTIK -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="icon-wrapper"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <span class="value">{{ $totalUsers }}</span>
                <span class="label">Total Pengguna</span>
            </div>
        </div>
        <div class="stat-card yellow">
            <div class="icon-wrapper"><i class="fas fa-hourglass-half"></i></div>
            <div class="stat-info">
                <span class="value">{{ $pendingArtikel }}</span>
                <span class="label">Perlu Validasi</span>
            </div>
        </div>
        <div class="stat-card green">
            <div class="icon-wrapper"><i class="fas fa-check-double"></i></div>
            <div class="stat-info">
                <span class="value">{{ $publishedArtikel }}</span>
                <span class="label">Artikel Tayang</span>
            </div>
        </div>
    </div>

    <!-- TABEL ARTIKEL TERBARU (YANG PERLU VALIDASI) -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Artikel Menunggu Validasi</h2>
            <a href="{{ route('admin.artikel.pending') }}" class="btn btn-primary" style="font-size: 0.8rem; padding: 8px 15px;">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingArtikelsList as $artikel)
                        <tr>
                            <td>{{ $artikel->title }}</td>
                            <td>{{ $artikel->user->name ?? 'Anonim' }}</td>
                            <td>{{ $artikel->category->name ?? '-' }}</td>
                            <td>{{ $artikel->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.artikel.review', $artikel->id) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.8rem;">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: #999;">
                                Tidak ada artikel yang perlu divalidasi saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection