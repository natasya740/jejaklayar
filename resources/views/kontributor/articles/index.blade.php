{{-- resources/views/kontributor/articles/index.blade.php --}}
@extends('layouts.dashboard_kontributor')

@section('title', 'Artikel Saya')
@section('page-title', 'Artikel Saya')
@section('page-subtitle', 'Kelola artikel yang telah Anda buat')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[color:var(--text-dark)]">
                <i class="fa fa-file-alt text-amber-500 mr-2"></i>Daftar Artikel
            </h2>
            <p class="text-sm text-[color:var(--muted)] mt-1">
                Total {{ $articles->total() }} artikel
            </p>
        </div>
        <a href="{{ route('kontributor.articles.create') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-400 to-amber-500 text-white font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
            <i class="fa fa-plus-circle"></i>
            <span>Tulis Artikel Baru</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-medium">Total Artikel</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $articles->total() }}</h3>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-newspaper text-xl sm:text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-medium">Published</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $articles->where('status', 'published')->count() }}</h3>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-check-circle text-xl sm:text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-gray-500 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-medium">Draft</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $articles->where('status', 'draft')->count() }}</h3>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-gray-400 to-gray-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-file-alt text-xl sm:text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-amber-500 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-medium">Pending</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $articles->where('status', 'pending')->count() }}</h3>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-clock text-xl sm:text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-xl shadow-sm p-5">
        <form action="{{ route('kontributor.articles.index') }}" method="GET" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <!-- Search -->
                <div class="md:col-span-5">
                    <div class="relative">
                        <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" 
                               name="search"
                               id="searchInput"
                               value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all"
                               placeholder="Cari judul artikel...">
                    </div>
                </div>

                <!-- Filter Status -->
                <div class="md:col-span-3">
                    <select name="status"
                            id="filterStatus" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <!-- Filter Category -->
                <div class="md:col-span-3">
                    <select name="category"
                            id="filterCategory" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Button Actions -->
                <div class="md:col-span-1 flex gap-2">
                    <button type="submit" 
                            class="flex-1 px-4 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-all duration-200 font-medium">
                        <i class="fa fa-filter"></i>
                    </button>
                    <a href="{{ route('kontributor.articles.index') }}" 
                       class="flex-1 px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-medium text-center">
                        <i class="fa fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Articles Table/Cards -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Card Header -->
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Semua Artikel</h3>
        </div>

        @if($articles->count() > 0)
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Artikel</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($articles as $article)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 text-sm font-medium text-gray-500">
                                    {{ $loop->iteration + ($articles->currentPage() - 1) * $articles->perPage() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        @if($article->featured_image)
                                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                                 alt="{{ $article->title }}"
                                                 class="w-16 h-16 rounded-lg object-cover flex-shrink-0 shadow-sm">
                                        @else
                                            <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                                <i class="fa fa-newspaper text-white text-xl"></i>
                                            </div>
                                        @endif
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-semibold text-gray-800 line-clamp-2 mb-1">
                                                {{ $article->title }}
                                            </p>
                                            @if($article->excerpt)
                                                <p class="text-xs text-gray-500 line-clamp-1">
                                                    {{ Str::limit($article->excerpt, 60) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            <i class="fa fa-folder text-xs mr-1"></i>
                                            {{ $article->category->name ?? '-' }}
                                        </span>
                                        @if($article->subCategory)
                                            <br>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                                <i class="fa fa-folder-open text-xs mr-1"></i>
                                                {{ $article->subCategory->name }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($article->status === 'published')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <i class="fa fa-check-circle text-xs mr-1"></i>
                                            Published
                                        </span>
                                    @elseif($article->status === 'draft')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            <i class="fa fa-file-alt text-xs mr-1"></i>
                                            Draft
                                        </span>
                                    @elseif($article->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                            <i class="fa fa-clock text-xs mr-1"></i>
                                            Pending
                                        </span>
                                    @elseif($article->status === 'archived')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            <i class="fa fa-archive text-xs mr-1"></i>
                                            Archived
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <i class="fa fa-calendar-alt mr-1"></i>
                                    {{ $article->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('kontributor.articles.show', $article->id) }}" 
                                           class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-all duration-200 hover:scale-110"
                                           title="Lihat Detail">
                                            <i class="fa fa-eye text-sm"></i>
                                        </a>
                                        
                                        @if(in_array($article->status, ['draft', 'archived']))
                                            <a href="{{ route('kontributor.articles.edit', $article->id) }}" 
                                               class="w-8 h-8 flex items-center justify-center bg-amber-100 text-amber-600 rounded-lg hover:bg-amber-200 transition-all duration-200 hover:scale-110"
                                               title="Edit Artikel">
                                                <i class="fa fa-edit text-sm"></i>
                                            </a>
                                        @endif

                                        @if($article->status == 'draft')
                                            <form id="delete-form-{{ $article->id }}" 
                                                  action="{{ route('kontributor.articles.destroy', $article->id) }}" 
                                                  method="POST" 
                                                  style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            
                                            <button type="button"
                                                    onclick="showDeleteModal('{{ $article->title }}', {{ $article->id }})"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-200 hover:scale-110"
                                                    title="Hapus Artikel">
                                                <i class="fa fa-trash text-sm"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-100">
                @foreach($articles as $article)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex gap-3 mb-3">
                            @if($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                     alt="{{ $article->title }}"
                                     class="w-20 h-20 rounded-lg object-cover flex-shrink-0 shadow-sm">
                            @else
                                <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <i class="fa fa-newspaper text-white text-2xl"></i>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-800 line-clamp-2 mb-1">
                                    {{ $article->title }}
                                </h4>
                                @if($article->excerpt)
                                    <p class="text-xs text-gray-500 line-clamp-2">
                                        {{ Str::limit($article->excerpt, 80) }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                <i class="fa fa-folder text-xs mr-1"></i>
                                {{ $article->category->name ?? '-' }}
                            </span>
                            @if($article->subCategory)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                    <i class="fa fa-folder-open text-xs mr-1"></i>
                                    {{ $article->subCategory->name }}
                                </span>
                            @endif
                            
                            @if($article->status === 'published')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fa fa-check-circle text-xs mr-1"></i>
                                    Published
                                </span>
                            @elseif($article->status === 'draft')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                    <i class="fa fa-file-alt text-xs mr-1"></i>
                                    Draft
                                </span>
                            @elseif($article->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                    <i class="fa fa-clock text-xs mr-1"></i>
                                    Pending
                                </span>
                            @elseif($article->status === 'archived')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fa fa-archive text-xs mr-1"></i>
                                    Archived
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                <i class="fa fa-calendar-alt mr-1"></i>
                                {{ $article->created_at->format('d M Y') }}
                            </span>
                            
                            <div class="flex items-center gap-2">
                                <a href="{{ route('kontributor.articles.show', $article->id) }}" 
                                   class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-all duration-200"
                                   title="Lihat Detail">
                                    <i class="fa fa-eye text-sm"></i>
                                </a>
                                
                                @if(in_array($article->status, ['draft', 'archived']))
                                    <a href="{{ route('kontributor.articles.edit', $article->id) }}" 
                                       class="w-8 h-8 flex items-center justify-center bg-amber-100 text-amber-600 rounded-lg hover:bg-amber-200 transition-all duration-200"
                                       title="Edit Artikel">
                                        <i class="fa fa-edit text-sm"></i>
                                    </a>
                                @endif

                                @if($article->status == 'draft')
                                    <button type="button"
                                            onclick="showDeleteModal('{{ $article->title }}', {{ $article->id }})"
                                            class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-200"
                                            title="Hapus Artikel">
                                        <i class="fa fa-trash text-sm"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Footer -->
            @if($articles->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-600">
                            Menampilkan <span class="font-semibold text-gray-800">{{ $articles->firstItem() }}</span> 
                            - <span class="font-semibold text-gray-800">{{ $articles->lastItem() }}</span> 
                            dari <span class="font-semibold text-gray-800">{{ $articles->total() }}</span> artikel
                        </div>
                        <div class="pagination-wrapper">
                            {{ $articles->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="p-16 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fa fa-inbox text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-lg font-semibold text-gray-800 mb-2">Belum ada artikel</p>
                    <p class="text-sm text-gray-500 mb-4">Mulai berbagi pengetahuan dengan menulis artikel pertama Anda</p>
                    <a href="{{ route('kontributor.articles.create') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-400 to-amber-500 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                        <i class="fa fa-plus-circle"></i>
                        <span>Tulis Artikel Pertama</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- MODAL POP-UP KONFIRMASI HAPUS --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop Blur -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity duration-300" onclick="closeDeleteModal()"></div>
    
    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <!-- Icon Warning dengan Animasi -->
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <div class="absolute inset-0 bg-red-400 rounded-full animate-ping opacity-75"></div>
                    <div class="relative bg-gradient-to-br from-red-500 to-red-600 rounded-full p-4 shadow-lg">
                        <i class="fa fa-exclamation-triangle text-4xl text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <h3 class="text-2xl font-bold text-gray-800 text-center mb-4">
                Yakin Ingin Menghapus?
            </h3>

            <!-- Message -->
            <p class="text-gray-600 text-center mb-2">
                Anda akan menghapus artikel:
            </p>
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <p class="text-lg font-semibold text-gray-800 text-center break-words" id="articleTitle">
                    <!-- Nama artikel akan muncul disini -->
                </p>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-6">
                <p class="text-sm text-red-600 text-center flex items-center justify-center gap-2">
                    <i class="fa fa-exclamation-circle"></i>
                    <span>Tindakan ini tidak dapat dibatalkan!</span>
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" 
                        class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                    <i class="fa fa-times mr-2"></i>Batal
                </button>
                <button onclick="confirmDelete()" 
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-200 hover:shadow-lg">
                    <i class="fa fa-trash mr-2"></i>Hapus
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Line Clamp Utilities */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Custom Pagination Styles */
    .pagination-wrapper nav {
        display: flex;
        gap: 0.5rem;
    }

    .pagination-wrapper .pagination {
        display: flex;
        gap: 0.25rem;
        align-items: center;
    }

    .pagination-wrapper .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        background-color: white;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .pagination-wrapper .page-link:hover {
        background: linear-gradient(to right, #fbbf24, #f59e0b);
        border-color: #f59e0b;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(to right, #fbbf24, #f59e0b);
        border-color: #f59e0b;
        color: white;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }

    .pagination-wrapper .page-item.disabled .page-link {
        background-color: #f3f4f6;
        border-color: #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
    }

    /* Modal Animation */
    #deleteModal.show #modalContent {
        animation: modalSlideIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
    }

    @keyframes modalSlideIn {
        0% {
            opacity: 0;
            transform: scale(0.8) translateY(-50px);
        }
        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Ping Animation for Modal Icon */
    @keyframes ping {
        75%, 100% {
            transform: scale(2);
            opacity: 0;
        }
    }

    .animate-ping {
        animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
</style>
@endpush

@push('scripts')
<script>
    let selectedArticleId = null;

    // Fungsi untuk menampilkan modal delete
    function showDeleteModal(articleTitle, articleId) {
        selectedArticleId = articleId;
        document.getElementById('articleTitle').textContent = articleTitle;
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('modalContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
        
        // Trigger animation
        setTimeout(() => {
            modalContent.style.opacity = '1';
            modalContent.style.transform = 'scale(1) translateY(0)';
        }, 10);
    }

    // Fungsi untuk menutup modal
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('modalContent');
        
        modalContent.style.opacity = '0';
        modalContent.style.transform = 'scale(0.95) translateY(-20px)';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto'; // Enable scrolling
            selectedArticleId = null;
        }, 300);
    }

    // Fungsi untuk konfirmasi hapus
    function confirmDelete() {
        if(selectedArticleId) {
            document.getElementById('delete-form-' + selectedArticleId).submit();
        }
    }

    // Close modal dengan tombol ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('deleteModal');
            if (!modal.classList.contains('hidden')) {
                closeDeleteModal();
            }
        }
    });

    // Auto-submit form when filters change (optional)
    document.getElementById('filterStatus').addEventListener('change', function() {
        // Uncomment if you want auto-submit
        // document.getElementById('filterForm').submit();
    });

    document.getElementById('filterCategory').addEventListener('change', function() {
        // Uncomment if you want auto-submit
        // document.getElementById('filterForm').submit();
    });
</script>
@endpush
@endsection