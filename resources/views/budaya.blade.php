@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/budaya.css') }}">
@endpush

@section('content')
<!-- 🔸 Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Budaya Melayu Bengkalis</h1>
        <p>Selami kekayaan seni, adat, dan tradisi — dijaga, diceritakan, dan dipelajari bersama.</p>
        <a href="#kategori" class="btn-hero">Jelajahi Kategori</a>
    </div>
</section>

<!-- 🔸 Kategori Budaya -->
<section class="categories" id="kategori">
    <h2>Kategori Budaya</h2>

    <div class="grid-categories">
        @php
            $kategori = [
                ['judul' => 'Seni', 'deskripsi' => 'Musik, tari (zapin), dan teater tradisional yang memikat.', 'gambar' => 'seni.jpg'],
                ['judul' => 'Adat & Tradisi', 'deskripsi' => 'Upacara dan prosesi adat yang mengikat masyarakat.', 'gambar' => 'adat.jpg'],
                ['judul' => 'Pakaian', 'deskripsi' => 'Busana yang melambangkan status dan identitas.', 'gambar' => 'pakaian.jpg'],
                ['judul' => 'Rumah Adat', 'deskripsi' => 'Arsitektur panggung khas pesisir yang sarat makna.', 'gambar' => 'rumah_adat.jpg'],
                ['judul' => 'Makanan & Minuman Tradisional', 'deskripsi' => 'Hidangan khas turun-temurun.', 'gambar' => 'makanan.jpg'],
                ['judul' => 'Tokoh Budaya', 'deskripsi' => 'Figur pelestari nilai-nilai budaya.', 'gambar' => 'tokoh.jpg'],
            ];
        @endphp

        @foreach ($kategori as $item)
            <div class="card-category" style="background-image: url('{{ asset('images/'.$item['gambar']) }}')">
                <div class="card-content">
                    <h3>{{ $item['judul'] }}</h3>
                    <p>{{ $item['deskripsi'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- 🔸 Quote -->
<section class="quote">
    “Di mana bumi dipijak, di situ langit dijunjung.”
</section>

<!-- 🔸 Warisan -->
<section class="warisan">
    <h2>Warisan Melayu — Identitas Kita</h2>
    <p>Melestarikan masa lalu untuk masa depan yang lebih berakar.</p>
</section>
@endsection
