@extends('layouts.app')

@section('title', 'Pustaka — Jejak Layar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/pustaka.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

<!-- ✅ HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1>Pustaka Digital<br><span>Jejak Layar</span></h1>
        <p>Temukan arsip budaya Melayu dalam bentuk cerita rakyat, kamus, dokumen, dan referensi modern</p>
    </div>
</section>

<!-- ✅ SEARCH & FILTER SECTION -->
<section class="filter-section">
    <input 
        type="text" 
        id="searchInput" 
        placeholder="🔍 Cari cerita, kamus, atau dokumen..." 
        aria-label="Kotak pencarian pustaka"
    >

    <div class="filter-btn">
        <button class="active" onclick="filterCards('semua')" aria-pressed="true">
            Semua Koleksi
        </button>
        <button onclick="filterCards('cerita')" aria-pressed="false">
            Cerita Rakyat
        </button>
        <button onclick="filterCards('kamus')" aria-pressed="false">
            Kamus Melayu
        </button>
        <button onclick="filterCards('sejarah')" aria-pressed="false">
            Arsip Sejarah
        </button>
    </div>
</section>

<!-- ✅ CARDS SECTION -->
<section class="cards" id="cardsContainer">
    
    <!-- Card 1: Cerita Rakyat -->
    <div class="card card-cerita" data-category="cerita" data-title="cerita rakyat">
        <img src="{{ asset('images/pustaka/cerita-rakyat.jpg') }}" alt="Cerita Rakyat Melayu">
        <div class="card-content">
            <p>Cerita Rakyat</p>
            <span class="card-badge">45 Cerita</span>
        </div>
    </div>

    <!-- Card 2: Kamus Melayu -->
    <div class="card card-kamus" data-category="kamus" data-title="kamus melayu istilah">
        <img src="{{ asset('images/pustaka/kamus-melayu.jpg') }}" alt="Kamus Istilah Melayu">
        <div class="card-content">
            <p>Kamus Istilah Melayu</p>
            <span class="card-badge">1200+ Istilah</span>
        </div>
    </div>

    <!-- Card 3: Arsip Budaya -->
    <div class="card card-sejarah" data-category="sejarah" data-title="arsip budaya sejarah">
        <img src="{{ asset('images/pustaka/arsip-budaya.jpg') }}" alt="Arsip Budaya Melayu">
        <div class="card-content">
            <p>Arsip Budaya</p>
            <span class="card-badge">89 Dokumen</span>
        </div>
    </div>

    <!-- Card 4: Pantun Melayu (Additional) -->
    <div class="card card-cerita" data-category="cerita" data-title="pantun melayu">
        <img src="{{ asset('images/pustaka/pantun.jpg') }}" alt="Pantun Melayu">
        <div class="card-content">
            <p>Pantun Melayu</p>
            <span class="card-badge">150+ Pantun</span>
        </div>
    </div>

    <!-- Card 5: Pepatah & Peribahasa -->
    <div class="card card-kamus" data-category="kamus" data-title="pepatah peribahasa">
        <img src="{{ asset('images/pustaka/pepatah.jpg') }}" alt="Pepatah dan Peribahasa">
        <div class="card-content">
            <p>Pepatah & Peribahasa</p>
            <span class="card-badge">300+ Pepatah</span>
        </div>
    </div>

    <!-- Card 6: Naskah Kuno -->
    <div class="card card-sejarah" data-category="sejarah" data-title="naskah kuno dokumen">
        <img src="{{ asset('images/pustaka/naskah-kuno.jpg') }}" alt="Naskah Kuno">
        <div class="card-content">
            <p>Naskah Kuno</p>
            <span class="card-badge">67 Naskah</span>
        </div>
    </div>

</section>

<!-- ✅ JAVASCRIPT FUNCTIONALITY -->
<script>
    // Filter Cards Function
    function filterCards(category) {
        const cards = document.querySelectorAll('.card');
        const buttons = document.querySelectorAll('.filter-btn button');
        
        // Reset all buttons
        buttons.forEach(btn => {
            btn.classList.remove('active');
            btn.setAttribute('aria-pressed', 'false');
        });
        
        // Set active button
        event.target.classList.add('active');
        event.target.setAttribute('aria-pressed', 'true');
        
        // Filter cards with smooth animation
        cards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            
            if (category === 'semua' || cardCategory === category) {
                card.style.display = 'block';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                }, 50);
            } else {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
    }
    
    // Search Functionality
    const searchInput = document.getElementById('searchInput');
    
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.card');
        
        cards.forEach(card => {
            const title = card.getAttribute('data-title').toLowerCase();
            const text = card.textContent.toLowerCase();
            
            if (title.includes(searchTerm) || text.includes(searchTerm)) {
                card.style.display = 'block';
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
            } else {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
        
        // If search is empty, show all cards
        if (searchTerm === '') {
            cards.forEach(card => {
                card.style.display = 'block';
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
            });
        }
    });
    
    // Initialize smooth transitions
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.style.transition = 'all 0.3s ease';
        });
    });
    
    // Card Click Handler (Optional - untuk navigasi)
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            const title = this.querySelector('p').textContent;
            
            // Anda bisa redirect ke halaman detail
            // window.location.href = `/pustaka/${category}`;
            
            console.log(`Clicked: ${title} (${category})`);
            // alert(`Membuka: ${title}`);
        });
    });
</script>

@endsection