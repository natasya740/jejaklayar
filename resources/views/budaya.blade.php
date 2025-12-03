@extends('layouts.app')

@push('styles')
    {{-- Load CSS dengan urutan yang benar --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/budaya.css') }}?v={{ time() }}">
@endpush

@section('content')
    {{-- ===== HERO SECTION ===== --}}
    <section class="hero bd-hero">
        <div class="hero-content bd-hero-inner">
            <div class="bd-hero-text">
                <h1>Budaya Melayu <span class="accent">Bengkalis</span></h1>
                <p class="lead">Selami kekayaan seni, adat, dan tradisi — dijaga, diceritakan, dan dipelajari bersama.</p>
                <a href="#kategori" class="btn primary">Jelajahi Kategori</a>
            </div>

            {{-- Ornament dekoratif (opsional) --}}
            <div class="bd-hero-ornament" aria-hidden="true">
                <svg viewBox="0 0 200 200" preserveAspectRatio="xMidYMid meet">
                    <defs>
                        <linearGradient id="g" x1="0" x2="1">
                            <stop offset="0" stop-color="#e8b84d"/>
                            <stop offset="1" stop-color="#8B5E3C"/>
                        </linearGradient>
                    </defs>
                    <circle cx="100" cy="100" r="80" fill="url(#g)" opacity="0.08"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- ===== INTRO (MENGENAL BUDAYA) ===== --}}
    <section class="intro bd-intro">
        <div class="container">
            <h2 class="section-title">Mengenal Budaya</h2>
            <p class="section-sub">
                Budaya Melayu Bengkalis adalah warisan hidup: seni, adat, pakaian, rumah tradisional, kuliner, dan figur
                yang menjaga tradisi. Di sini kami merapikan arsip, menjelaskan konteks, dan menghadirkan sumber belajar
                yang ramah semua umur.
            </p>
        </div>
    </section>

    {{-- ===== KATEGORI BUDAYA ===== --}}
    <section class="categories bd-kategori" id="kategori">
        <div class="container">
            <h2 class="section-title">Kategori Budaya</h2>

            <div class="grid-categories grid-cards">
                @php
                    $kategori = [
                        [
                            'judul' => 'Seni',
                            'deskripsi' => 'Musik, tari (zapin), dan teater tradisional yang memikat.',
                            'gambar' => 'Katalog seni.jpg',
                            'link' => '#',
                        ],
                        [
                            'judul' => 'Adat & Tradisi',
                            'deskripsi' => 'Upacara, prosesi, dan aturan adat yang mengikat komunitas.',
                            'gambar' => 'Katalog adat 2.jpg',
                            'link' => '#',
                        ],
                        [
                            'judul' => 'Pakaian',
                            'deskripsi' => 'Busana yang melambangkan status, estetika, dan identitas.',
                            'gambar' => 'Katalog pakaian.jpg',
                            'link' => '#',
                        ],
                        [
                            'judul' => 'Rumah Adat',
                            'deskripsi' => 'Arsitektur panggung yang menyimpan filosofi hidup masyarakat pesisir.',
                            'gambar' => 'seni.png',
                            'link' => '#',
                        ],
                        [
                            'judul' => 'Makanan & Minuman Tradisional',
                            'deskripsi' => 'Resep dan hidangan yang diwariskan turun-temurun.',
                            'gambar' => 'Katalog makanan.jpg',
                            'link' => '#',
                        ],
                        [
                            'judul' => 'Tokoh Budaya',
                            'deskripsi' => 'Figur yang berperan penting dalam pelestarian budaya.',
                            'gambar' => 'seni.png',
                            'link' => '#',
                        ],
                    ];
                @endphp

                @foreach ($kategori as $item)
                    {{-- Menggunakan tag <a> agar seluruh kartu bisa diklik --}}
                    <a href="{{ $item['link'] }}" class="card card-category">
                        <img src="{{ asset('FOTO/' . $item['gambar']) }}" 
                             alt="{{ $item['judul'] }}" 
                             class="card-img">
                        <div class="card-overlay"></div>
                        <div class="card-content card-body">
                            <h3>{{ $item['judul'] }}</h3>
                            <p>{{ $item['deskripsi'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== QUOTES (ELEGANT ROTATING) ===== --}}
    <section class="bd-quote">
        <div class="container quote-inner">
            <blockquote class="quote" aria-live="polite">
                <span class="q-item show">"Tak lapuk dek hujan, tak lekang dek panas."</span>
                <span class="q-item">"Di mana bumi dipijak, di situ langit dijunjung."</span>
                <span class="q-item">"Adat bersendi syarak, syarak bersendi Kitabullah."</span>
            </blockquote>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Reveal on scroll (simple intersection observer)
            const io = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('in');
                    }
                });
            }, { 
                threshold: 0.12 
            });

            // Observe elements untuk animasi reveal
            document.querySelectorAll('.card, .bd-hero-text, .bd-intro .container, .quote-inner').forEach(el => {
                io.observe(el);
            });

            // Rotating quotes
            const items = document.querySelectorAll('.q-item');
            let qi = 0;
            
            setInterval(() => {
                items.forEach((item, idx) => {
                    item.classList.toggle('show', idx === qi);
                });
                qi = (qi + 1) % items.length;
            }, 4300);
        });
    </script>
@endpush