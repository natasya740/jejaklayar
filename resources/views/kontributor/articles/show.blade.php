{{-- resources/views/kontributor/articles/show.blade.php --}}
@extends('layouts.dashboard_kontributor')

@section('title', 'Detail Artikel')
@section('page-title', 'Detail Artikel')
@section('page-subtitle', 'Lihat detail artikel Anda')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Breadcrumb --}}
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2 text-sm">
            <li class="inline-flex items-center">
                <a href="{{ route('kontributor.articles.index') }}" class="text-[color:var(--muted)] hover:text-[color:var(--yellow-2)] transition-colors">
                    <i class="fa fa-newspaper mr-1"></i>Artikel
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fa fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-[color:var(--text-dark)] font-medium">Detail</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fa fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fa fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Article Header --}}
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <h1 class="text-3xl font-bold text-[color:var(--text-dark)] leading-tight">
                            {{ $article->title }}
                        </h1>
                        <div>
                            @if($article->status === 'draft')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                    <i class="fa fa-edit"></i> Draft
                                </span>
                            @elseif($article->status === 'pending')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    <i class="fa fa-clock"></i> Menunggu Review
                                </span>
                            @elseif($article->status === 'published')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <i class="fa fa-check-circle"></i> Dipublikasikan
                                </span>
                            @elseif($article->status === 'archived')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="fa fa-times-circle"></i> Ditolak
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Meta Information --}}
                    <div class="flex flex-wrap items-center gap-4 text-sm text-[color:var(--muted)]">
                        <div class="flex items-center gap-2">
                            <i class="fa fa-folder text-[color:var(--yellow-2)]"></i>
                            <span>{{ $article->category->name }}</span>
                        </div>
                        @if($article->subCategory)
                            <div class="flex items-center gap-2">
                                <i class="fa fa-tag text-purple-600"></i>
                                <span>{{ $article->subCategory->name }}</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <i class="fa fa-calendar text-blue-600"></i>
                            <span>{{ $article->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($article->published_at)
                            <div class="flex items-center gap-2">
                                <i class="fa fa-globe text-green-600"></i>
                                <span>Publish: {{ $article->published_at->format('d M Y, H:i') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Excerpt --}}
                    @if($article->excerpt)
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg border-l-4 border-[color:var(--yellow-2)]">
                            <p class="text-[color:var(--muted)] italic">{{ $article->excerpt }}</p>
                        </div>
                    @endif
                </div>

                {{-- Featured Image --}}
                @if($article->featured_image)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-96 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <p class="text-white text-sm">
                                <i class="fa fa-image mr-1"></i> Gambar Unggulan
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Article Content --}}
                <div class="p-6">
                    <div class="prose max-w-none">
                        {!! $article->content !!}
                    </div>
                </div>
            </div>

            {{-- Additional Images from Content --}}
            @if($article->files->count() > 0)
                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-images text-purple-600"></i>
                            Gambar dalam Artikel ({{ $article->files->count() }})
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($article->files as $file)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $file->filepath) }}" 
                                         alt="Article image" 
                                         class="w-full h-32 object-cover rounded-lg border border-gray-200">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                        <a href="{{ asset('storage/' . $file->filepath) }}" 
                                           target="_blank"
                                           class="px-3 py-1 bg-white text-gray-800 rounded text-sm hover:bg-gray-100">
                                            <i class="fa fa-expand"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Action Buttons --}}
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                        <i class="fa fa-cogs text-blue-600"></i>
                        Aksi
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    {{-- Edit Button --}}
                    @if(in_array($article->status, ['draft', 'archived']))
                        <a href="{{ route('kontributor.articles.edit', $article) }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all shadow-md hover:shadow-lg">
                            <i class="fa fa-edit"></i>
                            <span>Edit Artikel</span>
                        </a>
                    @else
                        <div class="w-full px-4 py-3 bg-gray-100 text-gray-500 font-semibold rounded-lg text-center">
                            <i class="fa fa-lock mr-1"></i>
                            <span>Tidak Dapat Diedit</span>
                        </div>
                        <p class="text-xs text-[color:var(--muted)] text-center">
                            Artikel dengan status "{{ ucfirst($article->status) }}" tidak dapat diedit
                        </p>
                    @endif

                    {{-- Delete Button --}}
                    @if($article->status === 'draft')
                        <form action="{{ route('kontributor.articles.destroy', $article) }}" 
                              method="POST" 
                              id="deleteForm"
                              class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    onclick="confirmDelete()"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-all">
                                <i class="fa fa-trash"></i>
                                <span>Hapus Artikel</span>
                            </button>
                        </form>
                    @endif

                    {{-- Back Button --}}
                    <a href="{{ route('kontributor.articles.index') }}" 
                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-300 text-[color:var(--text-dark)] font-semibold rounded-lg hover:bg-gray-50 transition-all">
                        <i class="fa fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>

            {{-- Article Info --}}
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                        <i class="fa fa-info-circle text-blue-600"></i>
                        Informasi Artikel
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-start py-2 border-b border-gray-100">
                        <span class="text-sm text-[color:var(--muted)]">Status:</span>
                        <span class="text-sm font-semibold text-[color:var(--text-dark)]">
                            @if($article->status === 'draft')
                                📝 Draft
                            @elseif($article->status === 'pending')
                                ⏳ Menunggu Review
                            @elseif($article->status === 'published')
                                ✅ Dipublikasikan
                            @elseif($article->status === 'archived')
                                ❌ Ditolak
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between items-start py-2 border-b border-gray-100">
                        <span class="text-sm text-[color:var(--muted)]">Slug:</span>
                        <span class="text-sm font-mono text-[color:var(--text-dark)] text-right break-all">
                            {{ $article->slug }}
                        </span>
                    </div>

                    <div class="flex justify-between items-start py-2 border-b border-gray-100">
                        <span class="text-sm text-[color:var(--muted)]">Dibuat:</span>
                        <span class="text-sm font-semibold text-[color:var(--text-dark)]">
                            {{ $article->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-start py-2 border-b border-gray-100">
                        <span class="text-sm text-[color:var(--muted)]">Diperbarui:</span>
                        <span class="text-sm font-semibold text-[color:var(--text-dark)]">
                            {{ $article->updated_at->format('d M Y, H:i') }}
                        </span>
                    </div>

                    @if($article->published_at)
                        <div class="flex justify-between items-start py-2 border-b border-gray-100">
                            <span class="text-sm text-[color:var(--muted)]">Dipublikasikan:</span>
                            <span class="text-sm font-semibold text-[color:var(--text-dark)]">
                                {{ $article->published_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                    @endif

                    <div class="flex justify-between items-start py-2">
                        <span class="text-sm text-[color:var(--muted)]">Jumlah Karakter:</span>
                        <span class="text-sm font-semibold text-[color:var(--text-dark)]">
                            {{ strlen(strip_tags($article->content)) }} karakter
                        </span>
                    </div>
                </div>
            </div>

            {{-- Status Timeline --}}
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                        <i class="fa fa-history text-green-600"></i>
                        Timeline Status
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        {{-- Created --}}
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fa fa-plus text-blue-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-[color:var(--text-dark)]">Artikel Dibuat</p>
                                <p class="text-xs text-[color:var(--muted)]">
                                    {{ $article->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>

                        {{-- Updated --}}
                        @if($article->updated_at->ne($article->created_at))
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                        <i class="fa fa-edit text-yellow-600 text-sm"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-[color:var(--text-dark)]">Artikel Diperbarui</p>
                                    <p class="text-xs text-[color:var(--muted)]">
                                        {{ $article->updated_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Published --}}
                        @if($article->published_at)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fa fa-check text-green-600 text-sm"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-[color:var(--text-dark)]">
                                        @if($article->status === 'published')
                                            Artikel Dipublikasikan
                                        @elseif($article->status === 'pending')
                                            Dikirim untuk Review
                                        @endif
                                    </p>
                                    <p class="text-xs text-[color:var(--muted)]">
                                        {{ $article->published_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tips --}}
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl shadow-[var(--shadow-sm)] p-6 border border-blue-100">
                <h3 class="text-lg font-semibold text-[color:var(--text-dark)] mb-3 flex items-center gap-2">
                    <i class="fa fa-lightbulb text-yellow-500"></i>
                    Tips
                </h3>
                <ul class="space-y-2 text-sm text-[color:var(--muted)]">
                    <li class="flex items-start gap-2">
                        <i class="fa fa-check text-green-600 mt-1"></i>
                        <span>Artikel dengan status <strong>Draft</strong> dapat diedit dan dihapus kapan saja</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa fa-check text-green-600 mt-1"></i>
                        <span>Artikel <strong>Pending</strong> sedang menunggu review dari editor</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa fa-check text-green-600 mt-1"></i>
                        <span>Artikel <strong>Published</strong> sudah tayang di website</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa fa-check text-green-600 mt-1"></i>
                        <span>Artikel <strong>Ditolak</strong> dapat diedit dan dikirim ulang</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    if (confirm('⚠️ Apakah Anda yakin ingin menghapus artikel ini?\n\nArtikel yang dihapus tidak dapat dikembalikan!')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>

<style>
/* Prose styling untuk konten artikel */
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

.prose h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-top: 2.5rem;
    margin-bottom: 1.25rem;
    color: var(--text-dark);
    border-bottom: 2px solid var(--yellow-2);
    padding-bottom: 0.5rem;
}

.prose h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: var(--text-dark);
}

.prose h4 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: var(--text-dark);
}

.prose p {
    margin: 1rem 0;
}

.prose ul, .prose ol {
    margin: 1.5rem 0;
    padding-left: 2rem;
}

.prose li {
    margin: 0.75rem 0;
}

.prose blockquote {
    border-left: 4px solid var(--yellow-2);
    padding-left: 1.5rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
    background-color: #f9fafb;
    padding: 1rem 1.5rem;
    border-radius: 0 8px 8px 0;
}

.prose a {
    color: var(--yellow-2);
    text-decoration: underline;
}

.prose a:hover {
    color: var(--yellow-1);
}

.prose table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}

.prose table th {
    background-color: #f3f4f6;
    padding: 0.75rem;
    text-align: left;
    font-weight: 600;
    border: 1px solid #d1d5db;
}

.prose table td {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
}

.prose table tr:nth-child(even) {
    background-color: #f9fafb;
}

.prose strong {
    font-weight: 600;
    color: var(--text-dark);
}

.prose em {
    font-style: italic;
}

.prose code {
    background-color: #f3f4f6;
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-family: 'Courier New', monospace;
}

.prose pre {
    background-color: #1f2937;
    color: #f9fafb;
    padding: 1rem;
    border-radius: 8px;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.prose pre code {
    background-color: transparent;
    padding: 0;
    color: inherit;
}
</style>
@endsection