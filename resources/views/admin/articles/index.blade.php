{{-- resources/views/admin/articles/index.blade.php --}}
@extends('layouts.dashboard_admin')

@section('title', 'Daftar Artikel')

@section('page-title', 'Daftar Artikel')
@section('page-subtitle', 'Kelola artikel budaya lokal')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[color:var(--text-dark)]">
                <i class="fa fa-newspaper text-[color:var(--yellow-2)] mr-2"></i>Manajemen Artikel
            </h2>
            <p class="text-sm text-[color:var(--muted)] mt-1">Total {{ $articles->total() }} artikel terdaftar</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] text-[color:var(--text-dark)] font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
            <i class="fa fa-plus-circle"></i>
            <span>Tambah Artikel</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-[color:var(--yellow-2)] hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[color:var(--muted)] font-medium">Total Artikel</p>
                    <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">{{ $articles->total() }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-newspaper text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[color:var(--muted)] font-medium">Published</p>
                    <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">{{ $articles->where('status', 'published')->count() }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-check-circle text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-orange-500 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[color:var(--muted)] font-medium">Draft</p>
                    <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">{{ $articles->where('status', 'draft')->count() }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-file-alt text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-red-500 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[color:var(--muted)] font-medium">Pending</p>
                    <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">{{ $articles->where('status', 'pending')->count() }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-clock text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <div class="relative">
                    <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[color:var(--muted)]"></i>
                    <input type="text" 
                           id="searchInput"
                           class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all"
                           placeholder="Cari artikel...">
                </div>
            </div>

            <!-- Filter Status -->
            <div>
                <select id="filterStatus" 
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all">
                    <option value="">Semua Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    <option value="pending">Pending</option>
                </select>
            </div>

            <!-- Filter Category -->
            <div>
                <select id="filterCategory" 
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
        <!-- Card Header -->
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-[color:var(--text-dark)]">Semua Artikel</h3>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider w-16">#</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider">Artikel</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider hidden lg:table-cell">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider hidden md:table-cell">Penulis</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider hidden xl:table-cell">Tanggal</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($articles as $article)
                        <tr class="hover:bg-gray-50 transition-colors duration-150" 
                            data-status="{{ $article->status }}" 
                            data-category="{{ $article->category_id }}">
                            <td class="px-6 py-4 text-sm font-medium text-[color:var(--muted)]">
                                {{ $loop->iteration + ($articles->currentPage() - 1) * $articles->perPage() }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    @if($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                             alt="{{ $article->title }}"
                                             class="w-16 h-16 rounded-lg object-cover flex-shrink-0 shadow-sm">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <i class="fa fa-newspaper text-white text-xl"></i>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-semibold text-[color:var(--text-dark)] line-clamp-2 mb-1">
                                            {{ $article->title }}
                                        </p>
                                        <p class="text-xs text-[color:var(--muted)] line-clamp-1">
                                            {{ Str::limit(strip_tags($article->content ?? ''), 60) }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <div class="space-y-1">
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
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                        {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <span class="text-sm text-[color:var(--text-dark)]">{{ $article->user->name ?? 'Unknown' }}</span>
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
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                        <i class="fa fa-clock text-xs mr-1"></i>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-[color:var(--muted)] hidden xl:table-cell">
                                <i class="fa fa-calendar-alt mr-1"></i>{{ $article->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.articles.show', $article) }}" 
                                       class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-all duration-200 hover:scale-110"
                                       title="Detail">
                                        <i class="fa fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.articles.edit', $article) }}" 
                                       class="w-8 h-8 flex items-center justify-center bg-amber-100 text-amber-600 rounded-lg hover:bg-amber-200 transition-all duration-200 hover:scale-110"
                                       title="Edit">
                                        <i class="fa fa-edit text-sm"></i>
                                    </a>
                                    
                                    {{-- Form Hidden untuk Delete --}}
                                    <form id="delete-form-{{ $article->id }}" 
                                          action="{{ route('admin.articles.destroy', $article) }}" 
                                          method="POST" 
                                          style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    
                                    {{-- Tombol Hapus dengan Pop-up --}}
                                    <button type="button"
                                            onclick="showDeleteModal('{{ $article->title }}', {{ $article->id }})"
                                            class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-200 hover:scale-110"
                                            title="Hapus">
                                        <i class="fa fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fa fa-inbox text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-lg font-semibold text-[color:var(--text-dark)] mb-2">Belum ada artikel</p>
                                    <p class="text-sm text-[color:var(--muted)] mb-4">Mulai dengan menambahkan artikel pertama Anda</p>
                                    <a href="{{ route('admin.articles.create') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] text-[color:var(--text-dark)] font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                                        <i class="fa fa-plus-circle"></i>
                                        <span>Tambah Artikel Pertama</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if($articles->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-[color:var(--muted)]">
                        Menampilkan <span class="font-semibold text-[color:var(--text-dark)]">{{ $articles->firstItem() }}</span> 
                        - <span class="font-semibold text-[color:var(--text-dark)]">{{ $articles->lastItem() }}</span> 
                        dari <span class="font-semibold text-[color:var(--text-dark)]">{{ $articles->total() }}</span> data
                    </div>
                    <div class="pagination-wrapper">
                        {{ $articles->links() }}
                    </div>
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
                <p class="text-lg font-semibold text-gray-800 text-center" id="articleTitle">
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
        color: var(--text-dark);
        background-color: white;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .pagination-wrapper .page-link:hover {
        background: linear-gradient(to right, var(--yellow-1), var(--yellow-2));
        border-color: var(--yellow-2);
        color: var(--text-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(244, 180, 0, 0.2);
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(to right, var(--yellow-1), var(--yellow-2));
        border-color: var(--yellow-2);
        color: var(--text-dark);
        box-shadow: 0 4px 12px rgba(244, 180, 0, 0.3);
    }

    .pagination-wrapper .page-item.disabled .page-link {
        background-color: #f3f4f6;
        border-color: #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
    }

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

    // Search Filter
    document.getElementById('searchInput').addEventListener('input', function(e) {
        filterArticles();
    });

    // Status Filter
    document.getElementById('filterStatus').addEventListener('change', function(e) {
        filterArticles();
    });

    // Category Filter
    document.getElementById('filterCategory').addEventListener('change', function(e) {
        filterArticles();
    });

    function filterArticles() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('filterStatus').value;
        const categoryFilter = document.getElementById('filterCategory').value;
        const tableRows = document.querySelectorAll('tbody tr[data-status]');
        
        tableRows.forEach(row => {
            const articleTitle = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const status = row.getAttribute('data-status');
            const category = row.getAttribute('data-category');
            
            let showRow = true;
            
            // Search filter
            if (searchTerm && !articleTitle.includes(searchTerm)) {
                showRow = false;
            }
            
            // Status filter
            if (statusFilter && status !== statusFilter) {
                showRow = false;
            }
            
            // Category filter
            if (categoryFilter && category !== categoryFilter) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }
</script>
@endpush
@endsection