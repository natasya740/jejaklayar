@extends('layouts.app')

@section('title', $category->name . ' - Jejak Layar')

@section('content')
<div class="category-page" style="max-width: 1400px; margin: 0 auto; padding: 2rem;">
    
    <!-- Header Kategori -->
    <div class="category-header" style="text-align: center; margin-bottom: 3rem; padding: 3rem 2rem; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #1f2937; margin-bottom: 1rem;">{{ $category->name }}</h1>
        @if($category->description)
            <p style="font-size: 1.1rem; color: #4b5563; max-width: 700px; margin: 0 auto;">{{ $category->description }}</p>
        @endif
        <div style="margin-top: 1.5rem; font-size: 0.9rem; color: #6b7280;">
            <i class="fas fa-newspaper"></i> <strong>{{ $articles->total() }}</strong> artikel tersedia
        </div>
    </div>

    <!-- Sub-kategori -->
    @if($subCategories->count() > 0)
    <div class="subcategories-section" style="margin-bottom: 3rem;">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem; border-left: 5px solid #f4b400; padding-left: 1rem;">
            <i class="fas fa-folder-open" style="color: #f4b400;"></i> Sub-Kategori
        </h2>
        
        <div class="subcategory-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
            @foreach($subCategories as $subCat)
                <a href="{{ route('subcategory.show', [$category->slug, $subCat->slug]) }}" 
                   class="subcategory-card" 
                   style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); text-decoration: none; transition: all 0.3s ease; border: 2px solid transparent; display: block;"
                   onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'; this.style.borderColor='#f4b400';"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)'; this.style.borderColor='transparent';">
                    
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            📂
                        </div>
                        <h3 style="font-size: 1.2rem; font-weight: 700; color: #1f2937; margin: 0;">{{ $subCat->name }}</h3>
                    </div>
                    
                    @if($subCat->description)
                        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5;">
                            {{ Str::limit($subCat->description, 100) }}
                        </p>
                    @endif
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #f3f4f6;">
                        <span style="color: #f4b400; font-weight: 600; font-size: 0.85rem;">
                            <i class="fas fa-file-alt"></i> {{ $subCat->articles_count }} artikel
                        </span>
                        <span style="color: #d97706; font-weight: 600;">
                            Lihat <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Semua Artikel dalam Kategori -->
    <div class="articles-section">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem; border-left: 5px solid #f4b400; padding-left: 1rem;">
            <i class="fas fa-newspaper" style="color: #f4b400;"></i> Semua Artikel
        </h2>

        @if($articles->count() > 0)
            <div class="articles-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
                @foreach($articles as $article)
                    <article class="article-card" 
                             style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s ease; border: 2px solid transparent;"
                             onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'; this.style.borderColor='#f4b400';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)'; this.style.borderColor='transparent';">
                        
                        <!-- Gambar -->
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
                            <!-- Sub-kategori Badge -->
                            @if($article->subCategory)
                                <span style="background: #fef3c7; color: #d97706; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; margin-bottom: 0.8rem;">
                                    {{ $article->subCategory->name }}
                                </span>
                            @endif

                            <!-- Judul -->
                            <h3 style="font-size: 1.2rem; font-weight: 700; color: #1f2937; margin-bottom: 0.8rem; line-height: 1.4;">
                                <a href="{{ route('article.show', [$category->slug, $article->subCategory->slug, $article->slug]) }}" 
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
                {{ $articles->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📭</div>
                <h3 style="font-size: 1.5rem; color: #6b7280; font-weight: 600;">Belum ada artikel</h3>
                <p style="color: #9ca3af; margin-top: 0.5rem;">Artikel dalam kategori ini akan segera hadir.</p>
            </div>
        @endif
    </div>
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