@extends('layouts.app')

@section('title', 'Beranda | Jejak Layar')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush


@section('content')

<!-- Hero Section -->
<section id="beranda" class="hero">
  <div class="hero-inner">
    <h1 class="hero-title">Jelajahi <span class="accent">Budaya & Sejarah</span> Melayu Bengkalis</h1>
    <p class="hero-sub" id="typing-text" aria-live="polite"></p>

    <div class="hero-ctas">
      <a href="{{ route('budaya') }}" class="btn primary">Jelajahi Budaya</a>
      <a href="{{ route('pustaka') }}" class="btn secondary">Masuk Pustaka</a>
    </div>

    <div class="hero-quick">
      <a href="{{ route('pustaka') }}">Sejarah</a>
      <a href="{{ route('pustaka') }}">Cerita Rakyat</a>
      <a href="{{ route('pustaka') }}">Foto Arsip</a>
    </div>
  </div>
</section>

<!-- Koleksi -->
<section class="features">
  <h2 class="section-title">Jelajahi Koleksi</h2>

  <div class="features-grid">
    <article class="card">
      <div class="card-icon">🎭</div>
      <h3>Budaya</h3>
      <p>Musik, tarian, pakaian adat, dan tradisi hidup yang memperkaya identitas Melayu.</p>
      <a href="{{ route('budaya') }}" class="card-cta">Lihat Budaya →</a>
    </article>

    <article class="card">
      <div class="card-icon">📚</div>
      <h3>Pustaka Digital</h3>
      <p>Koleksi naskah, artikel, dan dokumen yang bisa dibaca dan diunduh untuk belajar mendalam.</p>
      <a href="{{ route('pustaka') }}" class="card-cta">Masuk Pustaka →</a>
    </article>

    <article class="card">
      <div class="card-icon">📖</div>
      <h3>Cerita Interaktif</h3>
      <p>Cerita rakyat, kuis singkat, dan media ringan yang bikin belajar jadi menyenangkan.</p>
      <a href="{{ route('pustaka') }}" class="card-cta">Baca Cerita →</a>
    </article>
  </div>
</section>

<!-- Promo -->
<section id="promo" class="promo">
  <h2>Kenapa Jejak Layar?</h2>
  <p>Kami mengumpulkan sumber Lokal, Arsip Visual, dan Cerita lisan untuk menjadi perpustakaan digital yang mudah diakses.</p>
</section>

<!-- Our Team -->
<section id="team">
  <h2>Our Team</h2>
  <p class="team-slogan">
    "Menjaga Warisan dan Budaya, Mendekatkan Generasi Muda dengan Sejarahnya"
  </p>

  <div class="team-grid">
    <div class="member">
      <div class="frame"></div>
      <div class="photo">
        <img src="{{ asset('images/irfan iswandi.png') }}" alt="Irfan Iswandi">
      </div>
      <h3>Irfan Iswandi</h3>
    </div>

    <div class="member">
      <div class="frame"></div>
      <div class="photo">
        <img src="{{ asset('images/team2.png') }}" alt="Masnidar Akmi">
      </div>
      <h3>Masnidar Akmi</h3>
    </div>

    <div class="member">
      <div class="frame"></div>
      <div class="photo">
        <img src="{{ asset('images/team3.png') }}" alt="Natasya">
      </div>
      <h3>Natasya</h3>
    </div>
  </div>
</section>

@endsection
