@extends('layouts.app')

@section('title', $article->title . ' - Jejak Layar')

@section('content')
<article class="article-detail" style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
    
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 2rem; font-size: 0.9rem; color: #6b7280;">
        <a href="{{ route('home') }}" style="color: #6b7280; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#d97706';" onmouseout="this.style.color='#6b7280';">Beranda</a>
        <span style="margin: 0 0.5rem;">›</span>
        <a href="{{ route('category.show', $article->category->slug) }}" style="color: #6b7280; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#d97706';" onmouseout="this.style.color='#6b7280';">{{ $article->category->name }}</a>
        <span style="margin: 0 0.5rem;">›</span>
        <a href="{{ route('subcategory.show', [$article->category->slug, $article->subCategory->slug]) }}" style="color: #6b7280; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#d97706';" onmouseout="this.style.color='#6b7280';">{{ $article->subCategory->name }}</a>
        <span style="margin: 0 0.5rem;">›</span>
        <strong style="color: #1f2937;">{{ Str::limit($article->title, 50) }}</strong>
    </nav>

    <!-- Main Content Container -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 3rem;">
        
        <!-- Article Content -->
        <div class="article-content-wrapper" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            
            <!-- Featured Image -->
            @if($article->featured_image)
                <div style="width: 100%; height: 450px; overflow: hidden; background: #f3f4f6;">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                         alt="{{ $article->title }}"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @endif

            <!-- Article Header -->
            <div style="padding: 3rem;">
                <!-- Category & Sub-category Badges -->
                <div style="display: flex; gap: 0.8rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                    <span style="background: #f4b400; color: white; padding: 0.5rem 1.2rem; border-radius: 25px; font-size: 0.85rem; font-weight: 700;">
                        {{ $article->category->name }}
                    </span>
                    <span style="background: #fef3c7; color: #d97706; padding: 0.5rem 1.2rem; border-radius: 25px; font-size: 0.85rem; font-weight: 700;">
                        {{ $article->subCategory->name }}
                    </span>
                </div>

                <!-- Title -->
                <h1 style="font-size: 2.5rem; font-weight: 800; color: #1f2937; line-height: 1.3; margin-bottom: 1.5rem;">
                    {{ $article->title }}
                </h1>

                <!-- Excerpt -->
                @if($article->excerpt)
                    <p style="font-size: 1.2rem; color: #6b7280; line-height: 1.7; margin-bottom: 2rem; font-style: italic; padding-left: 1.5rem; border-left: 4px solid #f4b400;">
                        {{ $article->excerpt }}
                    </p>
                @endif

                <!-- Meta Information -->
                <div style="display: flex; flex-wrap: wrap; gap: 2rem; padding: 1.5rem; background: #fffaf2; border-radius: 15px; margin-bottom: 3rem;">
                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                        <div style="width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, #fef3c7, #fde68a); display: flex; align-items: center; justify-content: center; font-weight: 700; color: #d97706;">
                            {{ strtoupper(substr($article->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Penulis</div>
                            <div style="font-weight: 700; color: #1f2937;">{{ $article->user->name }}</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                        <div style="width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, #fef3c7, #fde68a); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            📅
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Dipublikasi</div>
                            <div style="font-weight: 700; color: #1f2937;">{{ $article->published_at->format('d F Y') }}</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                        <div style="width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, #fef3c7, #fde68a); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            🕒
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Waktu Baca</div>
                            <div style="font-weight: 700; color: #1f2937;">{{ ceil(str_word_count(strip_tags($article->content)) / 200) }} menit</div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="article-body" style="font-size: 1.1rem; line-height: 1.9; color: #374151;">
                    {!! $article->content !!}
                </div>

                <!-- Files/Attachments -->
                @if($article->files && $article->files->count() > 0)
                    <div style="margin-top: 3rem; padding: 2rem; background: #fffaf2; border-radius: 15px; border: 2px dashed #fde68a;">
                        <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.8rem;">
                            <span style="font-size: 1.5rem;">📎</span> File Lampiran
                        </h3>
                        <div style="display: grid; gap: 1rem;">
                            @foreach($article->files as $file)
                                <a href="{{ asset('storage/' . $file->file_path) }}" 
                                   target="_blank"
                                   style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem; background: white; border-radius: 10px; text-decoration: none; transition: all 0.2s; border: 2px solid transparent;"
                                   onmouseover="this.style.borderColor='#f4b400'; this.style.transform='translateX(5px)';"
                                   onmouseout="this.style.borderColor='transparent'; this.style.transform='translateX(0)';">
                                    <div style="width: 50px; height: 50px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                        📄
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 700; color: #1f2937;">{{ $file->original_name ?? 'File' }}</div>
                                        <div style="font-size: 0.85rem; color: #9ca3af;">{{ strtoupper(pathinfo($file->file_path, PATHINFO_EXTENSION)) }}</div>
                                    </div>
                                    <div style="color: #d97706; font-weight: 700;">
                                        <i class="fas fa-download"></i> Unduh
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Share Buttons -->
                <div style="margin-top: 3rem; padding: 2rem; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 15px; text-align: center;">
                    <h4 style="font-size: 1.2rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">
                        📢 Bagikan Artikel Ini
                    </h4>
                    <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . url()->current()) }}" 
                           target="_blank"
                           style="padding: 0.8rem 1.5rem; background: #25D366; color: white; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s;"
                           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 15px rgba(37,211,102,0.3)';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           target="_blank"
                           style="padding: 0.8rem 1.5rem; background: #1877F2; color: white; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s;"
                           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 15px rgba(24,119,242,0.3)';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" 
                           target="_blank"
                           style="padding: 0.8rem 1.5rem; background: #1DA1F2; color: white; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s;"
                           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 15px rgba(29,161,242,0.3)';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Articles -->
    @if($relatedArticles->count() > 0)
        <div class="related-articles" style="margin-top: 4rem;">
            <h2 style="font-size: 2rem; font-weight: 800; color: #1f2937; margin-bottom: 2rem; text-align: center;">
                📚 Artikel Terkait
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
                @foreach($relatedArticles as $related)
                    <article class="related-card" 
                             style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s ease;"
                             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)';">
                        
                        @if($related->featured_image)
                            <div style="height: 180px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $related->featured_image) }}" 
                                     alt="{{ $related->title }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @else
                            <div style="height: 180px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                                📰
                            </div>
                        @endif

                        <div style="padding: 1.5rem;">
                            <h3 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin-bottom: 0.8rem; line-height: 1.4;">
                                <a href="{{ route('article.show', [$related->category->slug, $related->subCategory->slug, $related->slug]) }}" 
                                   style="text-decoration: none; color: inherit; transition: color 0.2s;"
                                   onmouseover="this.style.color='#d97706';"
                                   onmouseout="this.style.color='inherit';">
                                    {{ Str::limit($related->title, 60) }}
                                </a>
                            </h3>
                            <p style="color: #9ca3af; font-size: 0.8rem;">
                                <i class="fas fa-calendar"></i> {{ $related->published_at->format('d M Y') }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
</article>

<style>
    /* Article Body Styling */
    .article-body h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1f2937;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid #fde68a;
    }
    .article-body h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-top: 2rem;
        margin-bottom: 0.8rem;
    }
    .article-body p {
        margin-bottom: 1.5rem;
    }
    .article-body ul, .article-body ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    .article-body li {
        margin-bottom: 0.5rem;
    }
    .article-body blockquote {
        border-left: 4px solid #f4b400;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: #6b7280;
    }
    .article-body img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 2rem 0;
    }
    .article-body a {
        color: #f4b400;
        text-decoration: underline;
        transition: color 0.2s;
    }
    .article-body a:hover {
        color: #d97706;
    }

    @media (max-width: 768px) {
        .article-detail {
            padding: 1rem;
        }
        .article-content-wrapper > div {
            padding: 1.5rem !important;
        }
        h1 {
            font-size: 1.8rem !important;
        }
        .article-body {
            font-size: 1rem !important;
        }
    }
</style>
@endsection