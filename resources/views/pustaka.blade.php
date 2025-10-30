@extends('layouts.app')

@section('title', 'Pustaka — Jejak Layar')

@section('content')

<link rel="stylesheet" href="{{ asset('css/pustaka.css') }}">

<!-- ✅ HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1>Pustaka Digital<br><span>Jejak Layar</span></h1>
        <p>Temukan arsip budaya Melayu dalam bentuk cerita rakyat, kamus, dokumen, dan referensi modern.</p>
    </div>
</section>

<!-- ✅ SEARCH & FILTER SECTION -->
<section class="filter-section">
  

    <div class="filter-btn">
        <button class="active" onclick="showSection('semua')">Semua</button>
        <button onclick="showSection('cerita')">Cerita Rakyat</button>
        <button onclick="showSection('kamus')">Kamus Melayu</button>
        <button onclick="showSection('sejarah')">Sejarah</button>
    </div>
</section>

<!-- ✅ CARD KOLEKSI -->
<section class="cards">
    <div class="card card-cerita">
        <img alt="Cerita Rakyat">
        <p>Cerita Rakyat</p>
    </div>

    <div class="card card-kamus">
        <img alt="Kamus Melayu">
        <p>Kamus Istilah Melayu</p>
    </div>

    <div class="card card-sejarah">
        <img alt="Arsip Budaya">
        <p>Arsip Budaya</p>
    </div>
</section>

<!-- ✅ SCRIPT FILTER -->
<script>
function showSection(section) {
    const cards = document.querySelectorAll('.cards .card');
    const buttons = document.querySelectorAll('.filter-btn button');

    // Reset semua
    cards.forEach(c => c.style.display = 'none');
    buttons.forEach(b => b.classList.remove('active'));

    // Tampilkan sesuai filter
    if (section === 'semua') {
        cards.forEach(c => c.style.display = 'block');
    } else {
        document.querySelectorAll('.card-' + section).forEach(c => {
            c.style.display = 'block';
        });
    }

    // Button active
    event.target.classList.add('active');
}
</script>

@endsection
