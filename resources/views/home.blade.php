@extends('layouts.app')
@section('title', 'Beranda | Jejak Layar')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
  /* Circular Gallery Styles */
  .circular-gallery-section {
    padding: 80px 0;
    background: transparent;
    overflow: hidden;
    position: relative;
  }
  
  .circular-gallery-section h2 {
    text-align: center;
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 1rem;
    font-weight: 700;
  }
  
  .circular-gallery-section .subtitle {
    text-align: center;
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 3rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }
  
  #circular-gallery-container {
    width: 100%;
    height: 600px;
    position: relative;
    cursor: grab;
    background: transparent;
  }
  
  #circular-gallery-container:active {
    cursor: grabbing;
  }
  
  #circular-gallery-container canvas {
    display: block;
    width: 100%;
    height: 100%;
    background: transparent;
  }

  /* Scroll Reveal Styles */
  .scroll-reveal {
    margin: 0;
    padding: 0;
    will-change: transform;
  }

  .scroll-reveal-text {
    font-size: clamp(2rem, 5vw, 4rem);
    font-weight: 700;
    line-height: 1.2;
    margin: 0;
    padding: 20px;
  }

  .scroll-reveal .word {
    display: inline-block;
    will-change: opacity, filter;
  }

  /* Apply scroll reveal to section titles */
  .section-title-reveal {
    perspective: 1000px;
    margin-bottom: 3rem;
  }

  .features .section-title,
  .promo h2 {
    transform-origin: 0% 50%;
  }
  
  @media (max-width: 768px) {
    .circular-gallery-section {
      padding: 60px 0;
    }
    
    .circular-gallery-section h2 {
      font-size: 2rem;
    }
    
    #circular-gallery-container {
      height: 450px;
    }

    .scroll-reveal-text {
      font-size: clamp(1.5rem, 4vw, 2.5rem);
    }
  }
</style>
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

<!-- Circular Gallery Section -->
<section class="circular-gallery-section">
  <div class="section-title-reveal">
    <h2 class="scroll-reveal-title" data-scroll-reveal>Galeri Visual</h2>
  </div>
  <p class="subtitle">Jelajahi koleksi foto dan momen bersejarah Melayu Bengkalis</p>
  <div id="circular-gallery-container" data-image-count="12"></div>
</section>

<!-- Koleksi -->
<section class="features">
  <div class="section-title-reveal">
    <h2 class="section-title scroll-reveal-title" data-scroll-reveal>Jelajahi Koleksi</h2>
  </div>
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
  <div class="section-title-reveal">
    <h2 class="scroll-reveal-title" data-scroll-reveal>Kenapa Jejak Layar?</h2>
  </div>
  <p>Kami mengumpulkan sumber Lokal, Arsip Visual, dan Cerita lisan untuk menjadi perpustakaan digital yang mudah diakses.</p>
</section>
@endsection

@push('scripts')
<!-- GSAP for Scroll Reveal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<!-- OGL Library (WebGL Framework) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ogl/0.0.102/ogl.js"></script>

<!-- Scroll Reveal Script -->
<script src="{{ asset('js/scroll-reveal.js') }}"></script>

<!-- Circular Gallery Script -->
<script src="{{ asset('js/circular-gallery.js') }}"></script>

<script>
  // Debug: Check if OGL is loaded
  console.log('OGL loaded:', typeof OGL !== 'undefined');
  console.log('GSAP loaded:', typeof gsap !== 'undefined');
  console.log('ScrollTrigger loaded:', typeof ScrollTrigger !== 'undefined');
</script>
@endpush