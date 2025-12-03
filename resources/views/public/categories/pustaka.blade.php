@extends('layouts.app')

@section('title', 'Pustaka — Jejak Layar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pustaka.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
@endpush

@section('content')

<!-- ✅ HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1>Pustaka Digital<br><span>Jejak Layar</span></h1>
        <p>{{ $category->description ?? 'Temukan arsip budaya Melayu dalam bentuk cerita rakyat, kamus, dokumen, dan referensi modern' }}</p>
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
        @foreach($subCategories as $index => $subCat)
            <button 
                onclick="filterCards('{{ $subCat->slug }}')" 
                aria-pressed="false"
                data-category="{{ $subCat->slug }}">
                {{ $subCat->name }}
            </button>
        @endforeach
    </div>
</section>

<!-- ✅ CARDS SECTION -->
<section class="cards" id="cardsContainer">
    @foreach($subCategories as $subCat)
        <a href="{{ route('subcategory.show', [$category->slug, $subCat->slug]) }}" 
           class="card card-{{ $subCat->slug }}" 
           data-category="{{ $subCat->slug }}" 
           data-title="{{ strtolower($subCat->name) }}">
            
            @if($subCat->image)
                <img src="{{ asset('storage/' . $subCat->image) }}" alt="{{ $subCat->name }}">
            @else
                <img src="{{ asset('images/pustaka/' . $subCat->slug . '.jpg') }}" 
                     alt="{{ $subCat->name }}"
                     onerror="this.src='{{ asset('images/pustaka/default.jpg') }}'">
            @endif
            
            <div class="card-content">
                <p>{{ $subCat->name }}</p>
                <span class="card-badge">{{ $subCat->articles_count }} {{ $subCat->articles_count > 1 ? 'Artikel' : 'Artikel' }}</span>
            </div>
        </a>
    @endforeach
</section>

<!-- ✅ ARTIKEL TERBARU (Optional) -->
@if($articles->count() > 0)
<section class="latest-articles" style="padding: 4rem 2rem; background: #f9fafb; max-width: 1400px; margin: 0 auto;">
    <h2 style="text-align: center; font-size: 2rem; font-weight: 700; color: #1f2937; margin-bottom: 2rem;">
        Artikel Terbaru
    </h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
        @foreach($articles->take(6) as $article)
            <article style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                @if($article->featured_image)
                    <div style="height: 180px; overflow: hidden;">
                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                             alt="{{ $article->title }}"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @endif

                <div style="padding: 1.5rem;">
                    @if($article->subCategory)
                        <span style="background: #fef3c7; color: #d97706; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                            {{ $article->subCategory->name }}
                        </span>
                    @endif

                    <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0.8rem 0;">
                        <a href="{{ route('article.show', [$category->slug, $article->subCategory->slug, $article->slug]) }}" 
                           style="color: #1f2937; text-decoration: none;">
                            {{ $article->title }}
                        </a>
                    </h3>

                    @if($article->excerpt)
                        <p style="color: #6b7280; font-size: 0.9rem; line-height: 1.5;">
                            {{ Str::limit($article->excerpt, 100) }}
                        </p>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

@endsection

@push('scripts')
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
    
    // Card Hover Effects
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.boxShadow = '0 12px 30px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
        });
    });
</script>
@endpush