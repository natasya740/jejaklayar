{{-- resources/views/admin/sub-categories/show.blade.php --}}
@extends('layouts.dashboard_admin')

@section('title', 'Detail Sub Kategori')

@section('page-title', 'Detail Sub Kategori')
@section('page-subtitle', 'Informasi lengkap sub kategori')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
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

    <!-- Header Card -->
    <div class="bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] rounded-xl shadow-lg p-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa fa-folder-open text-3xl text-white"></i>
                </div>
                <div class="text-white">
                    <h2 class="text-2xl font-bold mb-1">{{ $subCategory->name }}</h2>
                    <p class="text-white/80">Detail lengkap sub kategori</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.sub-categories.edit', $subCategory) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white text-[color:var(--text-dark)] font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fa fa-edit"></i>
                    <span>Edit</span>
                </a>
                <a href="{{ route('admin.sub-categories.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-lg border-2 border-white hover:bg-white/30 transition-all duration-200">
                    <i class="fa fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Info (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Sub Category Information -->
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                        <i class="fa fa-info-circle text-[color:var(--yellow-2)]"></i>
                        Informasi Sub Kategori
                    </h3>
                </div>
                <div class="p-0">
                    <table class="w-full">
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-[color:var(--muted)] w-1/3">
                                    <i class="fa fa-folder mr-2"></i>Kategori Induk
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.categories.show', $subCategory->category) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 text-blue-800 rounded-lg text-sm font-semibold hover:bg-blue-200 transition-colors">
                                        <i class="fa fa-folder text-xs"></i>
                                        {{ $subCategory->category->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-[color:var(--muted)]">
                                    <i class="fa fa-tag mr-2"></i>Nama Sub Kategori
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-[color:var(--text-dark)]">
                                    {{ $subCategory->name }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-[color:var(--muted)]">
                                    <i class="fa fa-link mr-2"></i>Slug
                                </td>
                                <td class="px-6 py-4">
                                    <code class="px-3 py-1.5 bg-gray-100 text-[color:var(--text-dark)] text-sm rounded-lg font-mono">{{ $subCategory->slug }}</code>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-[color:var(--muted)]">
                                    <i class="fa fa-align-left mr-2"></i>Deskripsi
                                </td>
                                <td class="px-6 py-4 text-sm text-[color:var(--text-dark)]">
                                    @if($subCategory->description)
                                        {{ $subCategory->description }}
                                    @else
                                        <span class="text-[color:var(--muted)] italic">Tidak ada deskripsi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-[color:var(--muted)]">
                                    <i class="fa fa-calendar-plus mr-2"></i>Dibuat Pada
                                </td>
                                <td class="px-6 py-4 text-sm text-[color:var(--text-dark)]">
                                    {{ $subCategory->created_at->format('d F Y, H:i') }}
                                    <span class="text-[color:var(--muted)] text-xs ml-2">({{ $subCategory->created_at->diffForHumans() }})</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-[color:var(--muted)]">
                                    <i class="fa fa-calendar-check mr-2"></i>Terakhir Diupdate
                                </td>
                                <td class="px-6 py-4 text-sm text-[color:var(--text-dark)]">
                                    {{ $subCategory->updated_at->format('d F Y, H:i') }}
                                    <span class="text-[color:var(--muted)] text-xs ml-2">({{ $subCategory->updated_at->diffForHumans() }})</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm mb-1">Total Artikel</p>
                        <h3 class="text-5xl font-bold">{{ $subCategory->articles->count() }}</h3>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fa fa-file-alt text-4xl"></i>
                    </div>
                </div>
                <p class="text-white/70 text-sm">Artikel menggunakan sub kategori ini</p>
                @if($subCategory->articles->count() > 0)
                    <a href="{{ route('admin.articles.index', ['sub_category' => $subCategory->id]) }}" 
                       class="inline-flex items-center gap-1 text-white hover:text-white/80 text-sm font-semibold mt-3">
                        Lihat Semua Artikel
                        <i class="fa fa-arrow-right text-xs"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Right Column - Related Data (1/3 width) -->
        <div class="space-y-6">
            <!-- Articles List -->
            <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-file-alt text-green-600"></i>
                            Artikel
                        </h3>
                        <span class="px-2.5 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                            {{ $subCategory->articles->count() }}
                        </span>
                    </div>
                </div>
                <div class="p-4 max-h-[600px] overflow-y-auto">
                    @forelse($subCategory->articles->take(10) as $article)
                        <a href="{{ route('admin.articles.show', $article) }}" 
                           class="block p-3 mb-2 rounded-lg hover:bg-gray-50 hover:shadow-md transition-all duration-200 group">
                            <h4 class="text-sm font-semibold text-[color:var(--text-dark)] mb-2 group-hover:text-[color:var(--yellow-2)] transition-colors line-clamp-2">
                                {{ $article->title }}
                            </h4>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-[color:var(--muted)] flex items-center gap-1">
                                    <i class="fa fa-clock"></i>
                                    {{ $article->created_at->diffForHumans() }}
                                </span>
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full font-medium">
                                    {{ $article->status ?? 'Published' }}
                                </span>
                            </div>
                        </a>
                        @if(!$loop->last)
                            <div class="border-b border-gray-100 my-2"></div>
                        @endif
                    @empty
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fa fa-file-alt text-3xl text-gray-400"></i>
                            </div>
                            <p class="text-sm text-[color:var(--muted)] mb-3">Belum ada artikel</p>
                            <a href="{{ route('admin.articles.create') }}" 
                               class="inline-flex items-center gap-1 text-sm text-green-600 hover:text-green-700 font-medium">
                                <i class="fa fa-plus-circle"></i>
                                <span>Buat Artikel</span>
                            </a>
                        </div>
                    @endforelse

                    @if($subCategory->articles->count() > 10)
                        <a href="{{ route('admin.articles.index', ['sub_category' => $subCategory->id]) }}" 
                           class="block mt-4 text-center py-2 text-sm font-semibold text-green-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors">
                            Lihat Semua {{ $subCategory->articles->count() }} Artikel
                            <i class="fa fa-arrow-right ml-1"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-[var(--shadow-sm)] p-5">
                <h3 class="text-lg font-semibold text-[color:var(--text-dark)] mb-4 flex items-center gap-2">
                    <i class="fa fa-bolt text-[color:var(--yellow-2)]"></i>
                    Aksi Cepat
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.sub-categories.edit', $subCategory) }}" 
                       class="flex items-center gap-3 p-3 bg-white rounded-lg hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <i class="fa fa-edit text-amber-600"></i>
                        </div>
                        <span class="text-sm font-semibold text-[color:var(--text-dark)]">Edit Sub Kategori</span>
                    </a>
                    <a href="{{ route('admin.categories.show', $subCategory->category) }}" 
                       class="flex items-center gap-3 p-3 bg-white rounded-lg hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fa fa-folder text-blue-600"></i>
                        </div>
                        <span class="text-sm font-semibold text-[color:var(--text-dark)]">Lihat Kategori Induk</span>
                    </a>
                    <a href="{{ route('admin.articles.create') }}" 
                       class="flex items-center gap-3 p-3 bg-white rounded-lg hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fa fa-file-plus text-green-600"></i>
                        </div>
                        <span class="text-sm font-semibold text-[color:var(--text-dark)]">Buat Artikel Baru</span>
                    </a>
                    <form action="{{ route('admin.sub-categories.destroy', $subCategory) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus sub kategori ini beserta semua artikel yang terkait?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center gap-3 p-3 bg-white rounded-lg hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 text-left">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fa fa-trash text-red-600"></i>
                            </div>
                            <span class="text-sm font-semibold text-red-600">Hapus Sub Kategori</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection