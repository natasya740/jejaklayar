@extends('layouts.app')

@section('title', 'Pencarian: ' . $query . ' - Jejak Layar')

@section('content')
<div class="search-page" style="max-width: 1400px; margin: 0 auto; padding: 2rem;">
    
    <!-- Search Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.2rem; font-weight: 800; color: #1f2937; margin-bottom: 1rem;">
            🔍 Hasil Pencarian
        </h1>
        <p style="font-size: 1.2rem; color: #6b7280;">
            Menampilkan hasil untuk: <strong style="color: #f4b400;">"{{ $query }}"</strong>
        </p>
        <p style="font-size: 0.95rem; color: #9ca3af; margin-top: 0.5rem;">
            Ditemukan <strong>{{ $articles->total() }}</strong> artikel
        </p>
    </div>

    @if($articles->count() > 0)
        <!-- Results Grid -->
        <div class="search-results" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
            @foreach($articles as $article)
                <article class="search-result-card" 
                         style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s ease; border: 2px solid transparent;"
                         onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'; this.style.borderColor='#f4b400';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)'; this.style.borderColor='transparent';">
                    
                    <!-- Featured Image -->
                    @if($article->featured_image)
                        <div style="height: 200px; overflow: hidden; background: #f3f4f6;">
                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                 alt="{{ $article->title }}"
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                                 onmouseover="this.style.transform='scale(1.05)';"
                                 onmouseout="this.style.transform='scale(1)';">
                        </div>
                    @else
                        <div style="height: 200px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                            📰
                        </div>
                    @endif

                    <!-- Content -->
                    <div style="padding: 1.5rem;">
                        <!-- Category & Sub-category -->
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.8rem; flex-wrap: wrap;">
                            @if($article->category)
                                <span style="background: #fef3c7; color: #d97706; padding: 0.25rem 0.7rem; border-radius: 15px; font-size: 0.7rem; font-weight: 600;">
                                    {{ $article->category->name }}
                                </span>
                            @endif
                            @if($article->subCategory)
                                <span style="background: #f3f4f6; color: #6b7280; padding: 0.25rem 0.7rem; border-radius: 15px; font-size: 0.7rem; font-weight: 600;">
                                    {{ $article->subCategory->name }}
                                </span>
                            @endif
                        </div>

                        <!-- Title -->
                        <h3 style="font-size: 1.2rem; font-weight: 700; color: #1f2937; margin-bottom: 0.8rem; line-height: 1.4;">
                            <a href="{{ route('article.show', [$article->category->slug, $article->subCategory->slug, $article->slug]) }}" 
                               style="text-decoration: none; color: inherit; transition: color 0.2s;"
                               onmouseover="this.style.color='#d97706';"
                               onmouseout="this.style.color='inherit';">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        @if($article->excerpt)
                            <p style="color: #6b7280; font-size: 0.9rem; line-height: 1.6; margin-bottom: 1rem;">
                                {{ Str::limit($article->excerpt, 120) }}
                            </p>
                        @endif

                        <!-- Meta Info -->
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: #9ca3af; padding-top: 1rem; border-top: 1px solid #f3f4f6;">
                            <span><i class="fas fa-user"></i> {{ $article->user->name }}</span>
                            <span><i class="fas fa-calendar"></i> {{ $article->published_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 3rem; display: flex; justify-content: center;">
            {{ $articles->appends(['q' => $query])->links() }}
        </div>
    @else
        <!-- No Results -->
        <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <div style="font-size: 5rem; margin-bottom: 1.5rem;">🔍</div>
            <h3 style="font-size: 1.8rem; color: #6b7280; font-weight: 700; margin-bottom: 1rem;">Tidak ada hasil ditemukan</h3>
            <p style="color: #9ca3af; margin-bottom: 2rem; font-size: 1.1rem;">
                Maaf, kami tidak menemukan artikel yang cocok dengan pencarian <strong>"{{ $query }}"</strong>
            </p>
            
            <!-- Search Tips -->
            <div style="max-width: 600px; margin: 0 auto; text-align: left; background: #fffaf2; padding: 2rem; border-radius: 15px; border-left: 4px solid #f4b400;">
                <h4 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                    💡 Tips Pencarian:
                </h4>
                <ul style="color: #6b7280; line-height: 1.8; padding-left: 1.5rem;">
                    <li>Periksa ejaan kata kunci Anda</li>
                    <li>Coba gunakan kata kunci yang lebih umum</li>
                    <li>Gunakan kata kunci yang berbeda</li>
                    <li>Kurangi jumlah kata kunci</li>
                </ul>
            </div>

            <a href="{{ route('home') }}" 
               style="display: inline-block; margin-top: 2rem; padding: 0.8rem 2rem; background: #f4b400; color: white; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s;"
               onmouseover="this.style.background='#d97706'; this.style.transform='translateY(-2px)';"
               onmouseout="this.style.background='#f4b400'; this.style.transform='translateY(0)';">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
        </div>
    @endif
</div>

<style>
    .pagination {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
    }
    .pagination li a,
    .pagination li span {
        padding: 0.5rem 1rem;
        background: white;
        border: 2px solid #f3f4f6;
        border-radius: 8px;
        color: #6b7280;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }
    .pagination li a:hover {
        background: #fef3c7;
        border-color: #f4b400;
        color: #d97706;
    }
    .pagination li.active span {
        background: #f4b400;
        border-color: #f4b400;
        color: white;
    }
</style>
@endsection