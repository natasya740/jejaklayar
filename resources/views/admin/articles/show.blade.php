{{-- resources/views/admin/articles/show.blade.php --}}
@extends('layouts.dashboard_admin')

@section('title', 'Detail Artikel')
@section('page-title', 'Detail Artikel')
@section('page-subtitle', 'Lihat detail lengkap artikel')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2 text-sm">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.articles.index') }}" class="text-[color:var(--muted)] hover:text-[color:var(--yellow-2)] transition-colors">
                    <i class="fa fa-newspaper mr-1"></i>Artikel
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fa fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-[color:var(--text-dark)] font-medium">Detail Artikel</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="bg-gradient-to-r from-indigo-500 to-blue-600 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa fa-eye text-3xl text-white"></i>
                </div>
                <div class="text-white">
                    <h2 class="text-2xl font-bold mb-1">Detail Artikel</h2>
                    <p class="text-white/80">Informasi lengkap artikel</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.articles.edit', $article) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition-all">
                    <i class="fa fa-edit"></i>
                    <span>Edit</span>
                </a>
                <a href="{{ route('admin.articles.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-lg hover:bg-white/20 transition-all">
                    <i class="fa fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (2 columns) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Article Header -->
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1.5 rounded-full text-sm font-semibold
                            @if($article->status === 'published') bg-green-100 text-green-800
                            @elseif($article->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($article->status === 'draft') bg-gray-100 text-gray-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            @if($article->status === 'published') ✅
                            @elseif($article->status === 'pending') ⏳
                            @elseif($article->status === 'draft') 📝
                            @else 📦
                            @endif
                            {{ ucfirst($article->status) }}
                        </span>
                        
                        @if($article->category)
                        <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                            <i class="fa fa-folder mr-1"></i>{{ $article->category->name }}
                        </span>
                        @endif

                        @if($article->subCategory)
                        <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                            <i class="fa fa-folder-open mr-1"></i>{{ $article->subCategory->name }}
                        </span>
                        @endif
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-[color:var(--text-dark)] mb-3 leading-tight">
                        {{ $article->title }}
                    </h1>

                    <!-- Meta Info -->
                    <div class="flex flex-wrap items-center gap-4 text-sm text-[color:var(--muted)] mb-4 pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <i class="fa fa-user"></i>
                            <span>{{ $article->user->name ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa fa-calendar"></i>
                            <span>{{ $article->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($article->published_at)
                        <div class="flex items-center gap-2">
                            <i class="fa fa-globe"></i>
                            <span>Dipublikasi: {{ $article->published_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Slug Info -->
                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <p class="text-sm text-[color:var(--muted)] flex items-center gap-2">
                            <i class="fa fa-link"></i>
                            <span class="font-semibold">Slug:</span>
                            <code class="bg-white px-2 py-1 rounded text-[color:var(--text-dark)]">{{ $article->slug }}</code>
                        </p>
                    </div>

                    <!-- Excerpt -->
                    @if($article->excerpt)
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border-l-4 border-blue-500">
                        <h3 class="text-sm font-semibold text-[color:var(--text-dark)] mb-2 flex items-center gap-2">
                            <i class="fa fa-quote-left text-blue-600"></i>
                            Ringkasan
                        </h3>
                        <p class="text-[color:var(--muted)] leading-relaxed">{{ $article->excerpt }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Featured Image -->
            @if($article->featured_image)
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                        <i class="fa fa-image text-purple-600"></i>
                        Gambar Unggulan
                    </h3>
                </div>
                <div class="p-6">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                         alt="{{ $article->title }}" 
                         class="w-full rounded-lg shadow-md object-cover">
                </div>
            </div>
            @endif

            <!-- Article Content -->
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                        <i class="fa fa-file-alt text-green-600"></i>
                        Konten Artikel
                    </h3>
                </div>
                <div class="p-6">
                    <div class="prose prose-lg max-w-none">
                        {!! $article->content !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar (1 column) -->
        <div class="space-y-6">
            <!-- Article Statistics -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-[var(--shadow-sm)] p-5">
                <h4 class="font-semibold text-[color:var(--text-dark)] mb-4 flex items-center gap-2">
                    <i class="fa fa-chart-line text-blue-600"></i>
                    Statistik Artikel
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <div class="flex items-center gap-2">
                            <i class="fa fa-eye text-gray-500"></i>
                            <span class="text-sm text-[color:var(--muted)]">Views</span>
                        </div>
                        <span class="font-bold text-[color:var(--text-dark)]">0</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <div class="flex items-center gap-2">
                            <i class="fa fa-heart text-red-500"></i>
                            <span class="text-sm text-[color:var(--muted)]">Likes</span>
                        </div>
                        <span class="font-bold text-[color:var(--text-dark)]">0</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <div class="flex items-center gap-2">
                            <i class="fa fa-comment text-blue-500"></i>
                            <span class="text-sm text-[color:var(--muted)]">Comments</span>
                        </div>
                        <span class="font-bold text-[color:var(--text-dark)]">0</span>
                    </div>
                </div>
            </div>

            <!-- Article Info -->
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                        <i class="fa fa-info-circle text-indigo-600"></i>
                        Informasi Detail
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Author -->
                    <div>
                        <p class="text-xs text-[color:var(--muted)] mb-1">Penulis</p>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ substr($article->user->name ?? 'U', 0, 1) }}
                            </div>
                            <p class="font-semibold text-[color:var(--text-dark)]">{{ $article->user->name ?? 'Unknown' }}</p>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- Created Date -->
                    <div>
                        <p class="text-xs text-[color:var(--muted)] mb-1">Tanggal Dibuat</p>
                        <p class="font-semibold text-[color:var(--text-dark)]">
                            <i class="fa fa-calendar mr-1 text-gray-400"></i>
                            {{ $article->created_at->format('d M Y') }}
                        </p>
                        <p class="text-xs text-[color:var(--muted)] mt-1">
                            {{ $article->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <hr class="border-gray-100">

                    <!-- Updated Date -->
                    <div>
                        <p class="text-xs text-[color:var(--muted)] mb-1">Terakhir Diupdate</p>
                        <p class="font-semibold text-[color:var(--text-dark)]">
                            <i class="fa fa-clock mr-1 text-gray-400"></i>
                            {{ $article->updated_at->format('d M Y') }}
                        </p>
                        <p class="text-xs text-[color:var(--muted)] mt-1">
                            {{ $article->updated_at->diffForHumans() }}
                        </p>
                    </div>

                    @if($article->published_at)
                    <hr class="border-gray-100">

                    <!-- Published Date -->
                    <div>
                        <p class="text-xs text-[color:var(--muted)] mb-1">Tanggal Publikasi</p>
                        <p class="font-semibold text-[color:var(--text-dark)]">
                            <i class="fa fa-globe mr-1 text-gray-400"></i>
                            {{ $article->published_at->format('d M Y, H:i') }}
                        </p>
                        <p class="text-xs text-[color:var(--muted)] mt-1">
                            {{ $article->published_at->diffForHumans() }}
                        </p>
                    </div>
                    @endif

                    <hr class="border-gray-100">

                    <!-- Category -->
                    <div>
                        <p class="text-xs text-[color:var(--muted)] mb-1">Kategori</p>
                        @if($article->category)
                        <p class="font-semibold text-[color:var(--text-dark)]">
                            <i class="fa fa-folder mr-1 text-gray-400"></i>
                            {{ $article->category->name }}
                        </p>
                        @else
                        <p class="text-sm text-gray-400 italic">Tidak ada kategori</p>
                        @endif
                    </div>

                    @if($article->subCategory)
                    <hr class="border-gray-100">

                    <!-- Sub Category -->
                    <div>
                        <p class="text-xs text-[color:var(--muted)] mb-1">Sub Kategori</p>
                        <p class="font-semibold text-[color:var(--text-dark)]">
                            <i class="fa fa-folder-open mr-1 text-gray-400"></i>
                            {{ $article->subCategory->name }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 space-y-3">
                <a href="{{ route('admin.articles.edit', $article) }}" 
                   class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fa fa-edit"></i>
                    <span>Edit Artikel</span>
                </a>
                
                <a href="{{ route('admin.articles.index') }}" 
                   class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 text-[color:var(--text-dark)] font-semibold rounded-lg hover:bg-gray-50 transition-all duration-200">
                    <i class="fa fa-arrow-left"></i>
                    <span>Kembali ke Daftar</span>
                </a>

                <button type="button" 
                        onclick="if(confirm('Yakin ingin menghapus artikel ini?')) document.getElementById('deleteForm').submit();"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-all duration-200">
                    <i class="fa fa-trash"></i>
                    <span>Hapus Artikel</span>
                </button>
            </div>

            <!-- Share Options (Optional) -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow-[var(--shadow-sm)] p-5">
                <h4 class="font-semibold text-[color:var(--text-dark)] mb-3 flex items-center gap-2">
                    <i class="fa fa-share-alt text-green-600"></i>
                    Bagikan Artikel
                </h4>
                <div class="flex gap-2">
                    <button class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all text-sm">
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </button>
                    <button class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-all text-sm">
                        <i class="fab fa-twitter"></i>
                        <span>Twitter</span>
                    </button>
                    <button class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all text-sm">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <form id="deleteForm" action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>

<style>
/* Prose styling for article content */
.prose {
    color: #374151;
    line-height: 1.75;
}

.prose img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.prose h1 {
    font-size: 2rem;
    font-weight: 800;
    margin-top: 2.5rem;
    margin-bottom: 1.25rem;
    color: var(--text-dark);
}

.prose h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: var(--text-dark);
}

.prose h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: var(--text-dark);
}

.prose h4 {
    font-size: 1.125rem;
    font-weight: 600;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.prose p {
    margin: 1rem 0;
}

.prose ul, .prose ol {
    margin: 1rem 0;
    padding-left: 1.5rem;
}

.prose li {
    margin: 0.5rem 0;
}

.prose ul li {
    list-style-type: disc;
}

.prose ol li {
    list-style-type: decimal;
}

.prose a {
    color: #3b82f6;
    text-decoration: underline;
}

.prose a:hover {
    color: #2563eb;
}

.prose strong {
    font-weight: 700;
    color: var(--text-dark);
}

.prose em {
    font-style: italic;
}

.prose blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
    background-color: #f9fafb;
    padding: 1rem;
    border-radius: 0.5rem;
}

.prose code {
    background-color: #f3f4f6;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-family: 'Courier New', monospace;
    font-size: 0.9em;
    color: #dc2626;
}

.prose pre {
    background-color: #1f2937;
    color: #f9fafb;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.prose pre code {
    background-color: transparent;
    padding: 0;
    color: inherit;
}

.prose table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.prose table th {
    background-color: #f3f4f6;
    padding: 0.75rem;
    text-align: left;
    font-weight: 600;
    border: 1px solid #d1d5db;
    color: var(--text-dark);
}

.prose table td {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
}

.prose table tbody tr:nth-child(even) {
    background-color: #f9fafb;
}

.prose hr {
    margin: 2rem 0;
    border: none;
    border-top: 2px solid #e5e7eb;
}

.prose figure {
    margin: 1.5rem 0;
}

.prose figcaption {
    text-align: center;
    color: #6b7280;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    font-style: italic;
}
</style>
@endsection