@extends('layouts.app')

@section('title', $subCategory->name . ' - ' . $category->name . ' - Jejak Layar')

@section('content')
<div class="subcategory-page" style="max-width: 1400px; margin: 0 auto; padding: 2rem;">
    
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 2rem; font-size: 0.9rem; color: #6b7280;">
        <a href="{{ route('home') }}" style="color: #6b7280; text-decoration: none;">Beranda</a>
        <span style="margin: 0 0.5rem;">›</span>
        <a href="{{ route('category.show', $category->slug) }}" style="color: #6b7280; text-decoration: none;">{{ $category->name }}</a>
        <span style="margin: 0 0.5rem;">›</span>
        <strong style="color: #1f2937;">{{ $subCategory->name }}</strong>
    </nav>

    <!-- Header Sub-Kategori -->
    <div class="subcategory-header" style="text-align: center; margin-bottom: 3rem; padding: 3rem 2rem; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
        <div style="display: inline-flex; align-items: center; gap: 1rem; background: white; padding: 0.8rem 1.5rem; border-radius: 50px; margin-bottom: 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <span style="font-size: 0.9rem; color: #6b7280;">{{ $category->name }}</span>
        </div>
        
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #1f2937; margin-bottom: 1rem;">{{ $subCategory->name }}</h1>
        
        @if($subCategory->description)
            <p style="font-size: 1.1rem; color: #4b5563; max-width: 700px; margin: 0 auto;">{{ $subCategory->description }}</p>
        @endif
        
        <div style="margin-top: 1.5rem; font-size: 0.9rem; color: #6b7280;">
            <i class="fas fa-newspaper"></i> <strong>{{ $articles->total() }}</strong> artikel dalam sub-kategori ini
        </div>
    </div>

    <!-- Daftar Artikel -->
    @if($articles->count() > 0)
        <div class="articles-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
            @foreach($articles as $article)
                <article class="article-card" 
                         style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s ease; border: 2px solid transparent;"
                         onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'; this.style.borderColor='#f4b400';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)'; this.style.borderColor='transparent';">
                    
                    <!-- Gambar Featured -->
                    @if($article->featured_image)
                        <div style="height: 220px; overflow: hidden; background: #f3f4f6; position: relative;">
                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                 alt="{{ $article->title }}"
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                                 onmouseover="this.style.transform='scale(1.05)';"
                                 onmouseout="this.style.transform='scale(1)';">
                            
                            <!-- Status Badge -->
                            <span style="position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.95); color: #d97706; padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; backdrop-filter: blur(5px);">
                                <i class="fas fa-check-circle"></i> Published
                            </span>
                        </div>
                    @else
                        <div style="height: 220px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); display: flex; align-items: center; justify-content: center; font-size: 4rem;">
                            📰
                        </div>
                    @endif

                    <!-- Content -->
                    <div style="padding: 1.5rem;">
                        <!-- Judul -->
                        <h3 style="font-size: 1.2rem; font-weight: 700; color: #1f2937; margin-bottom: 0.8rem; line-height: 1.4;">
                            <a href="{{ route('article.show', [$category->slug, $subCategory->slug, $article->slug]) }}" 
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
                            <span style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-user"></i> 
                                <span>{{ $article->user->name }}</span>
                            </span>
                            <span style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-calendar"></i> 
                                <span>{{ $article->published_at->format('d M Y') }}</span>
                            </span>
                        </div>

                        <!-- Read More Button -->
                        <a href="{{ route('article.show', [$category->slug, $subCategory->slug, $article->slug]) }}"
                           style="display: block; text-align: center; margin-top: 1rem; padding: 0.7rem; background: #fef3c7; color: #d97706; border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.2s;"
                           onmouseover="this.style.background='#f4b400'; this.style.color='white';"
                           onmouseout="this.style.background='#fef3c7'; this.style.color='#d97706';">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 3rem; display: flex; justify-content: center;">
            {{ $articles->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div style="font-size: 5rem; margin-bottom: 1.5rem;">📭</div>
            <h3 style="font-size: 1.8rem; color: #6b7280; font-weight: 700; margin-bottom: 0.5rem;">Belum ada artikel</h3>
            <p style="color: #9ca3af; margin-bottom: 2rem; font-size: 1.1rem;">Artikel dalam sub-kategori ini akan segera hadir.</p>
            <a href="{{ route('category.show', $category->slug) }}" 
               style="display: inline-block; padding: 0.8rem 2rem; background: #f4b400; color: white; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s;"
               onmouseover="this.style.background='#d97706'; this.style.transform='translateY(-2px)';"
               onmouseout="this.style.background='#f4b400'; this.style.transform='translateY(0)';">
                <i class="fas fa-arrow-left"></i> Kembali ke {{ $category->name }}
            </a>
        </div>
    @endif
</div>

<style>
    /* Pagination styling */
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