{{-- resources/views/admin/artikels/pending.blade.php --}}
@extends('layouts.dashboard_admin')

@section('title', 'Artikel Pending')

@section('page-title', 'Artikel Pending')
@section('page-subtitle', 'Verifikasi dan kelola artikel yang menunggu persetujuan')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-[color:var(--text-dark)]">
                    <i class="fa fa-clock text-orange-500 mr-2"></i>Antrian Verifikasi Artikel
                </h2>
                <p class="text-sm text-[color:var(--muted)] mt-1">
                    {{ $artikels->total() }} artikel menunggu persetujuan Anda
                </p>
            </div>
            <a href="{{ route('admin.articles.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-[color:var(--text-dark)] font-semibold rounded-lg shadow-md hover:shadow-lg hover:bg-gray-200 transition-all duration-300">
                <i class="fa fa-arrow-left"></i>
                <span>Kembali ke Daftar Artikel</span>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div
                class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-orange-500 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-[color:var(--muted)] font-medium">Total Pending</p>
                        <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">
                            {{ $artikels->total() }}
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fa fa-clock text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-[color:var(--muted)] font-medium">Hari Ini</p>
                        <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">
                            {{ $todayPending ?? 0 }}
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fa fa-calendar-day text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-[color:var(--muted)] font-medium">Disetujui Bulan Ini</p>
                        <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">
                            {{ $approvedThisMonth ?? 0 }}
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fa fa-check-circle text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5 border-l-4 border-red-500 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-[color:var(--muted)] font-medium">Ditolak Bulan Ini</p>
                        <h3 class="text-3xl font-bold text-[color:var(--text-dark)] mt-1">
                            {{ $rejectedThisMonth ?? 0 }}
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fa fa-times-circle text-2xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div class="md:col-span-1">
                    <div class="relative">
                        <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[color:var(--muted)]"></i>
                        <input type="text" id="searchInput"
                            class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                            placeholder="Cari artikel...">
                    </div>
                </div>

                <!-- Filter Kontributor -->
                <div>
                    <select id="filterContributor"
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                        <option value="">Semua Kontributor</option>
                        @foreach ($contributors ?? [] as $contributor)
                            <option value="{{ $contributor->id }}">{{ $contributor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Kategori -->
                <div>
                    <select id="filterCategory"
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
            <!-- Card Header -->
            <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-yellow-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                        <i class="fa fa-list-check text-orange-500"></i>
                        Artikel Menunggu Verifikasi
                    </h3>
                    <span class="px-3 py-1 bg-orange-500 text-white text-sm font-semibold rounded-full">
                        {{ $artikels->total() }} Artikel
                    </span>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider w-16">
                                #</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider">
                                Artikel</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider hidden lg:table-cell">
                                Kontributor</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider hidden md:table-cell">
                                Kategori</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider hidden xl:table-cell">
                                Tanggal Upload</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-[color:var(--text-dark)] uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($artikels as $article)
                            <tr class="hover:bg-orange-50 transition-colors duration-150" 
                                data-contributor="{{ $article->user_id }}"
                                data-category="{{ $article->category_id }}">
                                <td class="px-6 py-4 text-sm font-medium text-[color:var(--muted)]">
                                    {{ $loop->iteration + ($artikels->currentPage() - 1) * $artikels->perPage() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        @if ($article->featured_image)
                                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                                alt="{{ $article->title }}"
                                                class="w-20 h-20 rounded-lg object-cover flex-shrink-0 shadow-sm border-2 border-orange-200">
                                        @else
                                            <div
                                                class="w-20 h-20 bg-gradient-to-br from-orange-400 to-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                                <i class="fa fa-newspaper text-white text-2xl"></i>
                                            </div>
                                        @endif
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-semibold text-[color:var(--text-dark)] line-clamp-2 mb-1">
                                                {{ $article->title }}
                                            </p>
                                            <p class="text-xs text-[color:var(--muted)] line-clamp-2 mb-2">
                                                {{ Str::limit(strip_tags($article->content ?? ''), 80) }}
                                            </p>
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                                    <i class="fa fa-clock text-xs mr-1"></i>
                                                    Pending
                                                </span>
                                                <span class="text-xs text-[color:var(--muted)]">
                                                    <i class="fa fa-eye mr-1"></i>{{ $article->views ?? 0 }} views
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md">
                                            {{ strtoupper(substr($article->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-[color:var(--text-dark)]">
                                                {{ $article->user->name ?? 'Unknown' }}
                                            </p>
                                            <p class="text-xs text-[color:var(--muted)]">
                                                {{ $article->user->email ?? '-' }}
                                            </p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                                <i class="fa fa-user-tag text-xs mr-1"></i>
                                                {{ ucfirst($article->user->role ?? 'kontributor') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <div class="space-y-1">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            <i class="fa fa-folder text-xs mr-1"></i>
                                            {{ $article->category->name ?? '-' }}
                                        </span>
                                        @if ($article->subCategory)
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                                <i class="fa fa-folder-open text-xs mr-1"></i>
                                                {{ $article->subCategory->name }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-[color:var(--muted)] hidden xl:table-cell">
                                    <div class="space-y-1">
                                        <p class="flex items-center gap-1">
                                            <i class="fa fa-calendar-alt"></i>
                                            {{ $article->created_at->format('d M Y') }}
                                        </p>
                                        <p class="flex items-center gap-1 text-xs">
                                            <i class="fa fa-clock"></i>
                                            {{ $article->created_at->format('H:i') }} WIB
                                        </p>
                                        <p class="text-xs text-orange-600 font-medium">
                                            {{ $article->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <!-- Tombol Lihat Detail -->
                                        <a href="{{ route('admin.articles.show', $article) }}"
                                            class="w-9 h-9 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-all duration-200 hover:scale-110 shadow-sm"
                                            title="Lihat Detail">
                                            <i class="fa fa-eye text-sm"></i>
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.articles.edit', $article) }}"
                                            class="w-9 h-9 flex items-center justify-center bg-amber-100 text-amber-600 rounded-lg hover:bg-amber-200 transition-all duration-200 hover:scale-110 shadow-sm"
                                            title="Edit Artikel">
                                            <i class="fa fa-edit text-sm"></i>
                                        </a>

                                        <!-- Tombol Terima/Approve -->
                                        <button type="button"
                                            onclick="showApproveModal('{{ $article->title }}', {{ $article->id }})"
                                            class="w-9 h-9 flex items-center justify-center bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-all duration-200 hover:scale-110 shadow-sm"
                                            title="Terima & Publikasikan">
                                            <i class="fa fa-check-circle text-sm"></i>
                                        </button>

                                        <!-- Tombol Tolak/Reject -->
                                        <button type="button"
                                            onclick="showRejectModal('{{ $article->title }}', {{ $article->id }})"
                                            class="w-9 h-9 flex items-center justify-center bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-200 hover:scale-110 shadow-sm"
                                            title="Tolak Artikel">
                                            <i class="fa fa-times-circle text-sm"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form id="delete-form-{{ $article->id }}"
                                            action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <button type="button"
                                            onclick="showDeleteModal('{{ $article->title }}', {{ $article->id }})"
                                            class="w-9 h-9 flex items-center justify-center bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-all duration-200 hover:scale-110 shadow-sm"
                                            title="Hapus Artikel">
                                            <i class="fa fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-24 h-24 bg-gradient-to-br from-orange-100 to-yellow-100 rounded-full flex items-center justify-center mb-4 shadow-inner">
                                            <i class="fa fa-check-double text-5xl text-orange-400"></i>
                                        </div>
                                        <p class="text-xl font-semibold text-[color:var(--text-dark)] mb-2">
                                            Tidak Ada Artikel Pending
                                        </p>
                                        <p class="text-sm text-[color:var(--muted)] mb-4">
                                            Semua artikel telah diverifikasi. Kerja bagus! 🎉
                                        </p>
                                        <a href="{{ route('admin.articles.index') }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] text-[color:var(--text-dark)] font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                                            <i class="fa fa-list"></i>
                                            <span>Lihat Semua Artikel</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            @if ($artikels->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-[color:var(--muted)]">
                            Menampilkan <span
                                class="font-semibold text-[color:var(--text-dark)]">{{ $artikels->firstItem() }}</span>
                            - <span
                                class="font-semibold text-[color:var(--text-dark)]">{{ $artikels->lastItem() }}</span>
                            dari <span
                                class="font-semibold text-[color:var(--text-dark)]">{{ $artikels->total() }}</span>
                            data
                        </div>
                        <div class="pagination-wrapper">
                            {{ $artikels->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL APPROVE --}}
    <div id="approveModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity duration-300"
            onclick="closeApproveModal()"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative transform transition-all duration-300 scale-95 opacity-0"
                id="approveModalContent">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-75"></div>
                        <div class="relative bg-gradient-to-br from-green-500 to-green-600 rounded-full p-4 shadow-lg">
                            <i class="fa fa-check-circle text-4xl text-white"></i>
                        </div>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 text-center mb-4">
                    Setujui & Publikasikan?
                </h3>
                <p class="text-gray-600 text-center mb-2">
                    Anda akan menyetujui artikel:
                </p>
                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                    <p class="text-lg font-semibold text-gray-800 text-center" id="approveArticleTitle"></p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-6">
                    <p class="text-sm text-green-700 text-center flex items-center justify-center gap-2">
                        <i class="fa fa-info-circle"></i>
                        <span>Artikel akan langsung dipublikasikan dan dapat dilihat publik</span>
                    </p>
                </div>

                <form id="approve-form" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="published">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Approval (Opsional)
                        </label>
                        <textarea name="approval_note" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Tambahkan catatan untuk kontributor..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeApproveModal()"
                            class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                            <i class="fa fa-times mr-2"></i>Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-200 hover:shadow-lg">
                            <i class="fa fa-check-circle mr-2"></i>Setujui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL REJECT --}}
    <div id="rejectModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity duration-300"
            onclick="closeRejectModal()"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative transform transition-all duration-300 scale-95 opacity-0"
                id="rejectModalContent">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-red-400 rounded-full animate-ping opacity-75"></div>
                        <div class="relative bg-gradient-to-br from-red-500 to-red-600 rounded-full p-4 shadow-lg">
                            <i class="fa fa-times-circle text-4xl text-white"></i>
                        </div>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 text-center mb-4">
                    Tolak Artikel?
                </h3>
                <p class="text-gray-600 text-center mb-2">
                    Anda akan menolak artikel:
                </p>
                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                    <p class="text-lg font-semibold text-gray-800 text-center" id="rejectArticleTitle"></p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-6">
                    <p class="text-sm text-red-600 text-center flex items-center justify-center gap-2">
                        <i class="fa fa-exclamation-circle"></i>
                        <span>Artikel akan dikembalikan ke status draft</span>
                    </p>
                </div>

                <form id="reject-form" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="draft">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="rejection_reason" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            placeholder="Jelaskan alasan penolakan artikel ini..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeRejectModal()"
                            class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                            <i class="fa fa-times mr-2"></i>Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-200 hover:shadow-lg">
                            <i class="fa fa-times-circle mr-2"></i>Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity duration-300"
            onclick="closeDeleteModal()"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative transform transition-all duration-300 scale-95 opacity-0"
                id="deleteModalContent">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gray-400 rounded-full animate-ping opacity-75"></div>
                        <div class="relative bg-gradient-to-br from-gray-500 to-gray-600 rounded-full p-4 shadow-lg">
                            <i class="fa fa-trash text-4xl text-white"></i>
                        </div>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 text-center mb-4">
                    Hapus Artikel?
                </h3>
                <p class="text-gray-600 text-center mb-2">
                    Anda akan menghapus artikel:
                </p>
                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                    <p class="text-lg font-semibold text-gray-800 text-center" id="deleteArticleTitle"></p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-6">
                    <p class="text-sm text-red-600 text-center flex items-center justify-center gap-2">
                        <i class="fa fa-exclamation-triangle"></i>
                        <span>Tindakan ini tidak dapat dibatalkan!</span>
                    </p>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                        <i class="fa fa-times mr-2"></i>Batal
                    </button>
                    <button type="button" onclick="confirmDelete()"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-lg font-semibold hover:from-gray-600 hover:to-gray-700 transition-all duration-200 hover:shadow-lg">
                        <i class="fa fa-trash mr-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
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
                background: linear-gradient(to right, #f97316, #fb923c);
                border-color: #f97316;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
            }

            .pagination-wrapper .page-item.active .page-link {
                background: linear-gradient(to right, #f97316, #fb923c);
                border-color: #f97316;
                color: white;
                box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
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

            #approveModal.show #approveModalContent,
            #rejectModal.show #rejectModalContent,
            #deleteModal.show #deleteModalContent {
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

            // APPROVE MODAL
            function showApproveModal(articleTitle, articleId) {
                selectedArticleId = articleId;
                document.getElementById('approveArticleTitle').textContent = articleTitle;
                document.getElementById('approve-form').action = `/admin/articles/${articleId}/update-status`;
                
                const modal = document.getElementById('approveModal');
                const modalContent = document.getElementById('approveModalContent');

                modal.classList.remove('hidden');
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';

                setTimeout(() => {
                    modalContent.style.opacity = '1';
                    modalContent.style.transform = 'scale(1) translateY(0)';
                }, 10);
            }

            function closeApproveModal() {
                const modal = document.getElementById('approveModal');
                const modalContent = document.getElementById('approveModalContent');

                modalContent.style.opacity = '0';
                modalContent.style.transform = 'scale(0.95) translateY(-20px)';

                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                    selectedArticleId = null;
                }, 300);
            }

            // REJECT MODAL
            function showRejectModal(articleTitle, articleId) {
                selectedArticleId = articleId;
                document.getElementById('rejectArticleTitle').textContent = articleTitle;
                document.getElementById('reject-form').action = `/admin/articles/${articleId}/update-status`;
                
                const modal = document.getElementById('rejectModal');
                const modalContent = document.getElementById('rejectModalContent');

                modal.classList.remove('hidden');
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';

                setTimeout(() => {
                    modalContent.style.opacity = '1';
                    modalContent.style.transform = 'scale(1) translateY(0)';
                }, 10);
            }

            function closeRejectModal() {
                const modal = document.getElementById('rejectModal');
                const modalContent = document.getElementById('rejectModalContent');

                modalContent.style.opacity = '0';
                modalContent.style.transform = 'scale(0.95) translateY(-20px)';

                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                    selectedArticleId = null;
                }, 300);
            }

            // DELETE MODAL
            function showDeleteModal(articleTitle, articleId) {
                selectedArticleId = articleId;
                document.getElementById('deleteArticleTitle').textContent = articleTitle;
                
                const modal = document.getElementById('deleteModal');
                const modalContent = document.getElementById('deleteModalContent');

                modal.classList.remove('hidden');
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';

                setTimeout(() => {
                    modalContent.style.opacity = '1';
                    modalContent.style.transform = 'scale(1) translateY(0)';
                }, 10);
            }

            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                const modalContent = document.getElementById('deleteModalContent');

                modalContent.style.opacity = '0';
                modalContent.style.transform = 'scale(0.95) translateY(-20px)';

                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                    selectedArticleId = null;
                }, 300);
            }

            function confirmDelete() {
                if (selectedArticleId) {
                    document.getElementById('delete-form-' + selectedArticleId).submit();
                }
            }

            // Close modal dengan ESC
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeApproveModal();
                    closeRejectModal();
                    closeDeleteModal();
                }
            });

            // FILTER FUNCTIONS
            document.getElementById('searchInput').addEventListener('input', filterArticles);
            document.getElementById('filterContributor').addEventListener('change', filterArticles);
            document.getElementById('filterCategory').addEventListener('change', filterArticles);

            function filterArticles() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const contributorFilter = document.getElementById('filterContributor').value;
                const categoryFilter = document.getElementById('filterCategory').value;
                const tableRows = document.querySelectorAll('tbody tr[data-contributor]');

                tableRows.forEach(row => {
                    const articleTitle = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                    const contributor = row.getAttribute('data-contributor');
                    const category = row.getAttribute('data-category');

                    let showRow = true;

                    if (searchTerm && !articleTitle.includes(searchTerm)) {
                        showRow = false;
                    }

                    if (contributorFilter && contributor !== contributorFilter) {
                        showRow = false;
                    }

                    if (categoryFilter && category !== categoryFilter) {
                        showRow = false;
                    }

                    row.style.display = showRow ? '' : 'none';
                });
            }
        </script>
    @endpush
@endsection