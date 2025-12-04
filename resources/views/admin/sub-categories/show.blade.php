@extends('layouts.dashboard_admin')

@section('title', $subCategory->name . ' - Sub Kategori')

@section('page-title', 'Detail Sub Kategori')
@section('page-subtitle', 'Ringkasan informasi dan artikel dalam sub kategori ini')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2 text-sm">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.sub-categories.index') }}" class="text-[color:var(--muted)] hover:text-[color:var(--yellow-2)] transition-colors">
                    <i class="fa fa-folder-open mr-1"></i>Sub Kategori
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fa fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-[color:var(--text-dark)] font-medium">{{ $subCategory->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header / Hero -->
    <div class="bg-gradient-to-r from-amber-400 to-amber-500 rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center gap-6">
            <div class="flex-1 text-white">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-medium mb-3">
                    <i class="fa fa-folder"></i>
                    <span>{{ $subCategory->category->name ?? 'Tanpa Kategori' }}</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $subCategory->name }}</h1>
                <p class="text-white/80 text-sm mb-3">
                    Slug:
                    <code class="bg-black/20 px-2 py-0.5 rounded text-xs">{{ $subCategory->slug }}</code>
                </p>
                <div class="flex flex-wrap items-center gap-3 text-sm">
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/15 rounded-full">
                        <i class="fa fa-file-alt"></i>
                        <span>{{ $subCategory->articles->count() }} Artikel</span>
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/15 rounded-full">
                        <i class="fa fa-calendar-plus"></i>
                        <span>Dibuat: {{ $subCategory->created_at->format('d M Y') }}</span>
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/15 rounded-full">
                        <i class="fa fa-calendar-check"></i>
                        <span>Update: {{ $subCategory->updated_at->format('d M Y') }}</span>
                    </span>
                </div>
            </div>
            <div class="w-full md:w-44">
                <div class="w-full aspect-[4/3] rounded-xl bg-white/15 border border-white/30 overflow-hidden flex items-center justify-center">
                    @if($subCategory->image_url)
                        <img src="{{ $subCategory->image_url }}" alt="Thumbnail {{ $subCategory->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex flex-col items-center justify-center text-white/80 text-xs">
                            <i class="fa fa-image text-3xl mb-1"></i>
                            <span>Tidak ada thumbnail</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="mt-4 flex flex-wrap gap-3">
            <a href="{{ route('admin.sub-categories.edit', $subCategory) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white text-amber-700 text-sm font-semibold rounded-lg shadow-sm hover:bg-amber-50">
                <i class="fa fa-edit"></i>
                <span>Edit Sub Kategori</span>
            </a>
            <a href="{{ route('admin.sub-categories.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600/80 text-white text-sm font-semibold rounded-lg hover:bg-amber-700">
                <i class="fa fa-arrow-left"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Deskripsi & Artikel -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Deskripsi -->
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-6">
                <h2 class="text-lg font-semibold text-[color:var(--text-dark)] mb-3 flex items-center gap-2">
                    <i class="fa fa-align-left text-[color:var(--yellow-2)]"></i>
                    Deskripsi Sub Kategori
                </h2>
                @if($subCategory->description)
                    <div class="prose max-w-none text-sm text-[color:var(--text-dark)] leading-relaxed">
                        {!! nl2br(e($subCategory->description)) !!}
                    </div>
                @else
                    <p class="text-sm text-[color:var(--muted)] italic">
                        Belum ada deskripsi untuk sub kategori ini.
                    </p>
                @endif
            </div>

            <!-- Artikel Terkait -->
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-6">
                <h2 class="text-lg font-semibold text-[color:var(--text-dark)] mb-3 flex items-center gap-2">
                    <i class="fa fa-file-alt text-green-500"></i>
                    Artikel dalam Sub Kategori Ini
                </h2>

                @if($subCategory->articles->isEmpty())
                    <div class="flex items-start gap-3 text-sm text-[color:var(--muted)]">
                        <div class="flex-shrink-0 w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fa fa-info text-gray-500 text-xs"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-[color:var(--text-dark)] mb-1">Belum ada artikel terkait</p>
                            <p>
                                Artikel yang menggunakan sub kategori ini akan muncul di sini setelah dibuat.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="border border-gray-100 rounded-lg overflow-hidden">
                        <ul class="divide-y divide-gray-100">
                            @foreach($subCategory->articles as $article)
                                <li class="px-4 py-3 hover:bg-amber-50/60 transition-colors">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-1">
                                        <div>
                                            <p class="text-sm font-semibold text-[color:var(--text-dark)]">
                                                {{ $article->title ?? 'Tanpa Judul' }}
                                            </p>
                                            <p class="text-xs text-[color:var(--muted)]">
                                                Dibuat: {{ optional($article->created_at)->format('d M Y, H:i') ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Metadata -->
        <div class="space-y-6">
            <!-- Info ringkas -->
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-6">
                <h3 class="text-sm font-semibold text-[color:var(--text-dark)] mb-4 flex items-center gap-2">
                    <i class="fa fa-info-circle text-blue-500"></i>
                    Ringkasan
                </h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between gap-3">
                        <dt class="text-[color:var(--muted)]">Kategori Induk</dt>
                        <dd class="font-semibold text-[color:var(--text-dark)] text-right">
                            {{ $subCategory->category->name ?? 'Tanpa Kategori' }}
                        </dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-[color:var(--muted)]">Total Artikel</dt>
                        <dd class="font-semibold text-[color:var(--text-dark)]">
                            {{ $subCategory->articles->count() }}
                        </dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-[color:var(--muted)]">Dibuat</dt>
                        <dd class="text-right">
                            <div class="font-semibold text-[color:var(--text-dark)]">
                                {{ $subCategory->created_at->format('d F Y, H:i') }}
                            </div>
                            <div class="text-xs text-[color:var(--muted)]">
                                {{ $subCategory->created_at->diffForHumans() }}
                            </div>
                        </dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-[color:var(--muted)]">Terakhir Diupdate</dt>
                        <dd class="text-right">
                            <div class="font-semibold text-[color:var(--text-dark)]">
                                {{ $subCategory->updated_at->format('d F Y, H:i') }}
                            </div>
                            <div class="text-xs text-[color:var(--muted)]">
                                {{ $subCategory->updated_at->diffForHumans() }}
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Catatan -->
            <div class="bg-orange-50 border border-orange-200 rounded-xl p-5">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <i class="fa fa-exclamation-circle text-orange-600 text-xl"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-semibold text-orange-900">Catatan URL</h4>
                        <p class="text-sm text-orange-800">
                            Perubahan pada nama sub kategori atau kategori induk dapat mempengaruhi URL artikel yang menggunakan sub kategori ini.
                            Pastikan untuk mengkomunikasikan perubahan besar kepada tim konten.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection