@extends('layouts.dashboard_kontributor')

{{-- 
|--------------------------------------------------------------------------
| Pengaturan Judul Halaman dan Subtitle
|--------------------------------------------------------------------------
| 
| Mengisi yield('title') di <title> HTML dan yield('page-title') di Topbar.
|
--}}

@section('title', 'Dashboard Kontributor')

@section('page-title', 'Dashboard Kontributor')

{{-- Opsional: Jika layout Anda memiliki section 'page-subtitle' --}}
@section('page-subtitle', 'Ringkasan dan statistik Anda')


{{-- 
|--------------------------------------------------------------------------
| Konten Utama Halaman
|--------------------------------------------------------------------------
| 
| Semua konten spesifik halaman diletakkan di dalam section 'content'.
| Ini akan mengisi area @yield('content') di layout.
|
--}}
@section('content')

    {{-- STATISTIK/KARTU RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        
        {{-- Card 1: Total Artikel --}}
        <div class="card p-6 bg-white shadow-premium rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Artikel</p>
                    {{-- Ganti '42' dengan variabel data Anda, misalnya: {{ $total_articles }} --}}
                    <p class="text-3xl font-bold mt-1 text-primary-dark">42</p>
                </div>
                <i class="fa fa-file-alt text-4xl text-primary-light"></i>
            </div>
        </div>

        {{-- Card 2: Artikel Dipublikasi --}}
        <div class="card p-6 bg-white shadow-premium rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Dipublikasi</p>
                    {{-- Ganti '30' dengan variabel data Anda, misalnya: {{ $published_articles }} --}}
                    <p class="text-3xl font-bold mt-1 text-green-600">30</p>
                </div>
                <i class="fa fa-check-circle text-4xl text-green-300"></i>
            </div>
        </div>

        {{-- Card 3: Menunggu Review --}}
        <div class="card p-6 bg-white shadow-premium rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Menunggu Review</p>
                    {{-- Ganti '12' dengan variabel data Anda, misalnya: {{ $pending_articles }} --}}
                    <p class="text-3xl font-bold mt-1 text-yellow-600">12</p>
                </div>
                <i class="fa fa-hourglass-half text-4xl text-yellow-300"></i>
            </div>
        </div>
    </div>
    
    {{-- AKSI CEPAT --}}
    <div class="card bg-white shadow-premium rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Aksi Cepat</h2>
        {{-- Ganti '#'' dengan route yang sebenarnya --}}
        <a href="{{ route('kontributor.articles.create') }}" class="btn btn-primary bg-primary-dark hover:bg-primary text-white font-medium py-2 px-4 rounded transition duration-200 inline-flex items-center">
            <i class="fa fa-pen-nib mr-2"></i> Tulis Artikel Baru
        </a>
    </div>

    {{-- Contoh Tabel Terbaru --}}
    <div class="mt-6 card bg-white shadow-premium rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Artikel Terbaru Anda</h2>
        {{-- Tempatkan Tabel Daftar Artikel di sini --}}
        <p class="text-gray-500">Tabel data atau grafik akan ditampilkan di sini.</p>
    </div>

@endsection