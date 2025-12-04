@extends('layouts.app')

@push('styles')
    {{-- Load CSS dengan urutan yang benar --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/budaya.css') }}?v={{ time() }}">
    {{-- Layer gaya tambahan untuk efek mewah & animasi halus --}}
   
@endpush

@section('content')
    <div class="bd-page">
        {{-- ===== HERO SECTION ===== --}}
        <section class="hero bd-hero">
            <div class="bd-hero-pattern" aria-hidden="true"></div>

            <div class="hero-content bd-hero-inner">
                <div class="bd-hero-text">
                    <p class="bd-hero-eyebrow">Jejak Sayar • Budaya</p>
                    <h1>
                        Budaya Melayu <span class="accent">Bengkalis</span>
                    </h1>
                    <div class="bd-hero-underline" aria-hidden="true"></div>

                    <p class="lead">
                        Selami kekayaan seni, adat, dan tradisi — dijaga, diceritakan, dan dipelajari bersama.
                    </p>

                    <div class="bd-hero-actions">
                        <a href="#kategori" class="btn primary bd-hero-cta">
                            Jelajahi Kategori
                        </a>
                        <a href="#mengenal-budaya" class="bd-hero-secondary">
                            Mengenal lebih dalam
                        </a>
                    </div>
                </div>

                {{-- Ornament dekoratif (bergerak pelan) --}}
                <div class="bd-hero-ornament" aria-hidden="true">
                    <svg viewBox="0 0 200 200" preserveAspectRatio="xMidYMid meet">
                        <defs>
                            <linearGradient id="g" x1="0" x2="1">
                                <stop offset="0" stop-color="#e8b84d" />
                                <stop offset="1" stop-color="#8B5E3C" />
                            </linearGradient>
                        </defs>
                        <circle cx="100" cy="100" r="80" fill="url(#g)" opacity="0.16" />
                        <circle cx="100" cy="100" r="58" fill="none" stroke="url(#g)" stroke-width="1.4"
                            opacity="0.7" />
                    </svg>
                </div>
            </div>

            <div class="bd-scroll-indicator" aria-hidden="true">
                <span class="bd-scroll-line"></span>
                <span class="bd-scroll-text">Gulir untuk melihat budaya</span>
            </div>
        </section>

        {{-- ===== INTRO (MENGENAL BUDAYA) ===== --}}
        <section id="mengenal-budaya" class="intro bd-intro">
            <div class="container">
                <h2 class="section-title">
                    Mengenal Budaya
                    <span class="section-title-accent"></span>
                </h2>
                <p class="section-sub">
                    Budaya Melayu Bengkalis adalah warisan hidup: seni, adat, pakaian, rumah tradisional, kuliner,
                    dan figur yang menjaga tradisi. Di sini kami merapikan arsip, menjelaskan konteks, dan
                    menghadirkan sumber belajar yang ramah semua umur.
                </p>
            </div>
        </section>

        {{-- ===== KATEGORI BUDAYA (SUB-KATEGORI DINAMIS) ===== --}}
        <section class="categories bd-kategori" id="kategori">
            <div class="container">
                <header class="bd-section-header">
                    <div>
                        <h2 class="section-title">
                            Kategori Budaya
                            <span class="section-title-accent"></span>
                        </h2>
                        <p class="bd-section-subtitle">
                            Pilih tema untuk menjelajahi artikel, foto, dan cerita yang tersimpan dalam tiap sub-kategori.
                        </p>
                    </div>
                </header>

                @php
                    /**
                     * Mapping slug sub-kategori ke meta tampilan khusus (judul, deskripsi, gambar fallback).
                     * Sesuaikan slug dengan data di database.
                     */
                    $subMeta = [
                        'seni' => [
                            'title' => 'Seni',
                            'description' => 'Musik, tari (zapin), dan teater tradisional yang memikat.',
                            'image' => 'Katalog seni.jpg',
                        ],
                        'adat-tradisi' => [
                            'title' => 'Adat & Tradisi',
                            'description' => 'Upacara, prosesi, dan aturan adat yang mengikat komunitas.',
                            'image' => 'Katalog adat 2.jpg',
                        ],
                        'pakaian' => [
                            'title' => 'Pakaian',
                            'description' => 'Busana yang melambangkan status, estetika, dan identitas.',
                            'image' => 'Katalog pakaian.jpg',
                        ],
                        'rumah-adat' => [
                            'title' => 'Rumah Adat',
                            'description' => 'Arsitektur panggung yang menyimpan filosofi hidup masyarakat pesisir.',
                            'image' => 'seni.png',
                        ],
                        'makanan-minuman-tradisional' => [
                            'title' => 'Makanan & Minuman Tradisional',
                            'description' => 'Resep dan hidangan yang diwariskan turun-temurun.',
                            'image' => 'Katalog makanan.jpg',
                        ],
                        'tokoh-budaya' => [
                            'title' => 'Tokoh Budaya',
                            'description' => 'Figur yang berperan penting dalam pelestarian budaya.',
                            'image' => 'seni.png',
                        ],
                    ];
                @endphp

                @if (isset($subCategories) && $subCategories->count() > 0)
                    <div class="grid-categories grid-cards bd-kategori-grid">
                        @foreach ($subCategories as $index => $subCat)
                            @php
                                // Ambil meta khusus berdasarkan slug, atau gunakan fallback dari DB
                                $meta = $subMeta[$subCat->slug] ?? null;

                                $title = $meta['title'] ?? $subCat->name;
                                $description =
                                    $meta['description'] ??
                                    ($subCat->description ?: 'Jelajahi lebih jauh kekayaan tema budaya ini.');

                                /**
                                 * Penentuan sumber gambar:
                                 * - Jika sub kategori punya thumbnail di database (kolom image), pakai file dari storage/public.
                                 * - Jika belum punya, gunakan fallback gambar statis di folder FOTO sesuai mapping $subMeta.
                                 */
                                if (!empty($subCat->image)) {
                                    // Path disimpan seperti "subcategories/xxxx.jpg" di disk "public"
                                    $imageUrl = asset('storage/' . $subCat->image);
                                } else {
                                    $fallbackImage = $meta['image'] ?? 'Katalog seni.jpg';
                                    $imageUrl = asset('FOTO/' . $fallbackImage);
                                }

                                // Tambahan kelas untuk variasi animasi per kartu
                                $cardAnimationClass = $index % 2 === 0 ? 'bd-card-left' : 'bd-card-right';
                            @endphp

                            {{-- Seluruh kartu bisa diklik, menuju halaman sub-kategori --}}
                            <a href="{{ route('subcategory.show', [$category->slug, $subCat->slug]) }}"
                                class="card card-category bd-card {{ $cardAnimationClass }}">
                                <img src="{{ $imageUrl }}" alt="{{ $title }}" class="card-img bd-card-img">
                                <div class="card-overlay bd-card-overlay"></div>

                                <div class="card-content card-body bd-card-body">
                                    <span class="card-badge bd-card-badge">
                                        {{ $category->name ?? 'Budaya' }}
                                    </span>

                                    <h3 class="bd-card-title">
                                        {{ $title }}
                                    </h3>
                                    <p class="bd-card-text">
                                        {{ $description }}
                                    </p>

                                    <span class="bd-card-link">
                                        Lihat detail
                                        <span class="bd-card-link-arrow" aria-hidden="true">↗</span>
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    {{-- State jika belum ada sub-kategori --}}
                    <div class="grid-categories-empty bd-grid-empty">
                        <p class="section-sub">
                            Sub-kategori untuk {{ $category->name ?? 'Budaya' }} akan segera hadir.
                        </p>
                    </div>
                @endif
            </div>
        </section>

        {{-- ===== QUOTES (ELEGANT ROTATING) ===== --}}
        <section class="bd-quote">
            <div class="container quote-inner">
                <div class="bd-quote-decor" aria-hidden="true"></div>
                <blockquote class="quote" aria-live="polite">
                    <span class="quote-mark" aria-hidden="true">“</span>
                    <span class="q-item show">Tak lapuk dek hujan, tak lekang dek panas.</span>
                    <span class="q-item">Di mana bumi dipijak, di situ langit dijunjung.</span>
                    <span class="q-item">Adat bersendi syarak, syarak bersendi Kitabullah.</span>
                </blockquote>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        /**
         * Script interaksi halaman Budaya:
         * - Animasi reveal on scroll menggunakan IntersectionObserver.
         * - Rotasi kutipan dengan transisi halus.
         */
        document.addEventListener('DOMContentLoaded', () => {
            // Reveal on scroll (Intersection Observer sederhana)
            const io = new IntersectionObserver(
                (entries) => {
                    entries.forEach((e) => {
                        if (e.isIntersecting) {
                            e.target.classList.add('in');
                        }
                    });
                }, {
                    threshold: 0.12,
                }
            );

            document
                .querySelectorAll(
                    '.card, .bd-hero-text, .bd-intro .container, .quote-inner'
                )
                .forEach((el) => io.observe(el));

            // Rotasi quotes
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
