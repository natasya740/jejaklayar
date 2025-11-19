@extends('layouts.admin')

@section('title', 'Review Artikel')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.artikel.pending') }}" style="text-decoration: none; color: var(--color-text-muted); font-weight: 500;">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="dashboard-grid" style="grid-template-columns: 2fr 1fr;">
        
        <!-- KOLOM KIRI: KONTEN ARTIKEL -->
        <div class="card">
            <div class="card-body">
                <span class="badge" style="background: #e0f2fe; color: #0369a1; margin-bottom: 10px; display: inline-block;">
                    {{ $artikel->category->name }}
                </span>
                <h1 style="font-size: 2rem; margin-bottom: 10px; line-height: 1.3;">{{ $artikel->title }}</h1>
                <p style="color: var(--color-text-muted); margin-bottom: 20px;">
                    Oleh <strong>{{ $artikel->user->name }}</strong> • {{ $artikel->created_at->format('d M Y H:i') }}
                </p>

                @if($artikel->image)
                    <img src="{{ asset('storage/' . $artikel->image) }}" alt="Gambar Utama" 
                         style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 20px;">
                @endif

                <div style="line-height: 1.8; color: var(--color-text-body);">
                    {!! $artikel->content !!} {{-- Render HTML dari CKEditor --}}
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: PANEL AKSI -->
        <div class="card" style="height: fit-content;">
            <div class="card-header">
                <h2>Tindakan Admin</h2>
            </div>
            <div class="card-body">
                <p style="margin-bottom: 20px; font-size: 0.9rem; color: #666;">
                    Silakan periksa konten artikel ini. Pastikan tidak mengandung unsur SARA atau hoax sebelum menyetujui.
                </p>

                <!-- Form Approve -->
                <form action="{{ route('admin.artikel.approve', $artikel->id) }}" method="POST" style="margin-bottom: 15px;">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-full-width" style="background: #10b981;">
                        <i class="fas fa-check"></i> Setujui & Terbitkan
                    </button>
                </form>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

                <!-- Form Reject -->
                <form action="{{ route('admin.artikel.reject', $artikel->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 10px;">
                        <label style="font-weight: 600; display: block; margin-bottom: 5px;">Alasan Penolakan</label>
                        <textarea name="feedback" rows="4" placeholder="Berikan alasan agar kontributor bisa memperbaiki..." 
                                  style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-family: inherit;" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-full-width" style="background: #ef4444; color: white;">
                        <i class="fas fa-times"></i> Tolak Artikel
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection