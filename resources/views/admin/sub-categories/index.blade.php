{{-- resources/views/admin/sub-categories/index.blade.php --}}
@extends('layouts.dashboard_admin')

@section('title', 'Daftar Sub Kategori')

@section('page-title', 'Daftar Sub Kategori')
@section('page-subtitle', 'Kelola sub kategori artikel budaya lokal')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[color:var(--text-dark)]">
                <i class="fa fa-folder-open text-[color:var(--yellow-2)] mr-2"></i>Manajemen Sub Kategori
            </h2>
            <p class="text-sm text-[color:var(--muted)] mt-1">Total {{ $subCategories->total() }} sub kategori terdaftar</p>
        </div>
        <a href="{{ route('admin.sub-categories.create') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] text-[color:var(--text-dark)] font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
            <i class="fa fa-plus-circle"></i>
            <span>Tambah Sub Kategori</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-[color:var(--yellow-2)] hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[color:var(--muted)] font-medium">Total Sub Kategori</p>
                    <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">{{ $subCategories->total() }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-folder-open text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[color:var(--muted)] font-medium">Kategori Induk</p>
                    <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">{{ $subCategories->unique('category_id')->count() }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-folder text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[color:var(--muted)] font-medium">Total Artikel</p>
                    <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">{{ $subCategories->sum('articles_count') }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa fa-file-alt text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
        <!-- Card Header with Search -->
        <div class="p-5 border-b border-gray-100">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <h3 class="text-lg font-semibold text-[color:var(--text-dark)]">Semua Sub Kategori</h3>
                <div class="w-full lg:w-80">
                    <div class="relative">
                        <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[color:var(--muted)]"></i>
                        <input type="text" 
                               id="searchInput"
                               class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all"
                               placeholder="Cari sub kategori...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider w-16">#</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider hidden lg:table-cell">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider">Sub Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider hidden md:table-cell">Slug</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider hidden lg:table-cell">Artikel</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider hidden xl:table-cell">Tanggal</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($subCategories as $subCategory)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm font-medium text-[color:var(--muted)]">
                                {{ $loop->iteration + ($subCategories->currentPage() - 1) * $subCategories->perPage() }}
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    <i class="fa fa-folder text-xs mr-1"></i>
                                    {{ $subCategory->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] rounded-lg flex items-center justify-center shadow-sm">
                                        <i class="fa fa-folder-open text-white"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-semibold text-[color:var(--text-dark)] truncate">{{ $subCategory->name }}</p>
                                        @if($subCategory->description)
                                            <p class="text-xs text-[color:var(--muted)] truncate mt-0.5">{{ Str::limit($subCategory->description, 50) }}</p>
                                        @else
                                            <p class="text-xs text-[color:var(--muted)] lg:hidden mt-0.5">
                                                <i class="fa fa-folder text-xs mr-1"></i>{{ $subCategory->category->name }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <code class="px-2 py-1 bg-gray-100 text-[color:var(--text-dark)] text-xs rounded font-mono">{{ $subCategory->slug }}</code>
                            </td>
                            <td class="px-6 py-4 text-center hidden lg:table-cell">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    {{ $subCategory->articles_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[color:var(--muted)] hidden xl:table-cell">
                                <i class="fa fa-calendar-alt mr-1"></i>{{ $subCategory->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.sub-categories.show', $subCategory) }}" 
                                       class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-all duration-200 hover:scale-110"
                                       title="Detail">
                                        <i class="fa fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.sub-categories.edit', $subCategory) }}" 
                                       class="w-8 h-8 flex items-center justify-center bg-amber-100 text-amber-600 rounded-lg hover:bg-amber-200 transition-all duration-200 hover:scale-110"
                                       title="Edit">
                                        <i class="fa fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.sub-categories.destroy', $subCategory) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus sub kategori ini?')"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-200 hover:scale-110"
                                                title="Hapus">
                                            <i class="fa fa-trash text-sm"></i>
                                        </button>
                                    </form>
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
                                    <p class="text-lg font-semibold text-[color:var(--text-dark)] mb-2">Belum ada sub kategori</p>
                                    <p class="text-sm text-[color:var(--muted)] mb-4">Mulai dengan menambahkan sub kategori pertama Anda</p>
                                    <a href="{{ route('admin.sub-categories.create') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] text-[color:var(--text-dark)] font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                                        <i class="fa fa-plus-circle"></i>
                                        <span>Tambah Sub Kategori Pertama</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if($subCategories->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-[color:var(--muted)]">
                        Menampilkan <span class="font-semibold text-[color:var(--text-dark)]">{{ $subCategories->firstItem() }}</span> 
                        - <span class="font-semibold text-[color:var(--text-dark)]">{{ $subCategories->lastItem() }}</span> 
                        dari <span class="font-semibold text-[color:var(--text-dark)]">{{ $subCategories->total() }}</span> data
                    </div>
                    <div class="pagination-wrapper">
                        {{ $subCategories->links() }}
                    </div>
                </div>
            </div>
        @endif
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
</style>
@endpush

@push('scripts')
<script>
    // Simple Search Filter
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const subCategoryName = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const categoryName = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const slug = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
            
            if (subCategoryName.includes(searchTerm) || categoryName.includes(searchTerm) || slug.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection