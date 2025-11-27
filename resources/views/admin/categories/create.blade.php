{{-- resources/views/admin/categories/create.blade.php --}}
@extends('layouts.dashboard_admin')

@section('title', 'Tambah Kategori')

@section('page-title', 'Tambah Kategori')
@section('page-subtitle', 'Buat kategori baru untuk artikel')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2 text-sm">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.categories.index') }}" class="text-[color:var(--muted)] hover:text-[color:var(--yellow-2)] transition-colors">
                    <i class="fa fa-folder mr-1"></i>Kategori
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fa fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-[color:var(--text-dark)] font-medium">Tambah Baru</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                <i class="fa fa-plus-circle text-3xl text-white"></i>
            </div>
            <div class="text-white">
                <h2 class="text-2xl font-bold mb-1">Tambah Kategori Baru</h2>
                <p class="text-white/80">Buat kategori baru untuk mengorganisir artikel budaya lokal</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="p-6 space-y-6">
                <!-- Nama Kategori -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa fa-folder text-[color:var(--yellow-2)]"></i>
                        </div>
                        <input type="text" 
                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all @error('name') border-red-500 @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Contoh: Tari Tradisional"
                               required
                               autofocus>
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-[color:var(--muted)] flex items-center gap-1">
                        <i class="fa fa-info-circle"></i>
                        <span>Slug akan dibuat otomatis dari nama kategori</span>
                    </p>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                        Deskripsi <span class="text-[color:var(--muted)] font-normal">(Opsional)</span>
                    </label>
                    <div class="relative">
                        <textarea 
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all resize-none @error('description') border-red-500 @enderror" 
                            id="description" 
                            name="description" 
                            rows="5"
                            maxlength="500"
                            placeholder="Jelaskan tentang kategori ini...">{{ old('description') }}</textarea>
                        <div class="absolute bottom-3 right-3 text-xs text-[color:var(--muted)]">
                            <span id="charCount">0</span> / 500
                        </div>
                    </div>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <i class="fa fa-lightbulb text-blue-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-blue-900 mb-1">Tips Pembuatan Kategori</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Gunakan nama kategori yang jelas dan mudah dipahami</li>
                                <li>• Kategori membantu pengunjung menemukan artikel dengan lebih mudah</li>
                                <li>• Anda dapat menambahkan sub-kategori setelah kategori dibuat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row gap-3">
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] text-[color:var(--text-dark)] font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fa fa-save"></i>
                    <span>Simpan Kategori</span>
                </button>
                <a href="{{ route('admin.categories.index') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 text-[color:var(--text-dark)] font-semibold rounded-lg hover:bg-gray-50 transition-all duration-200">
                    <i class="fa fa-times-circle"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Help Card -->
    <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-6 mt-6">
        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] mb-4 flex items-center gap-2">
            <i class="fa fa-question-circle text-[color:var(--yellow-2)]"></i>
            Bantuan
        </h3>
        <div class="space-y-3 text-sm text-[color:var(--muted)]">
            <div class="flex gap-3">
                <i class="fa fa-check-circle text-green-500 mt-0.5"></i>
                <p>Nama kategori harus unik dan belum digunakan sebelumnya</p>
            </div>
            <div class="flex gap-3">
                <i class="fa fa-check-circle text-green-500 mt-0.5"></i>
                <p>Slug akan otomatis dibuat dari nama kategori (huruf kecil, tanpa spasi)</p>
            </div>
            <div class="flex gap-3">
                <i class="fa fa-check-circle text-green-500 mt-0.5"></i>
                <p>Deskripsi membantu menjelaskan jenis konten yang termasuk dalam kategori ini</p>
            </div>
            <div class="flex gap-3">
                <i class="fa fa-check-circle text-green-500 mt-0.5"></i>
                <p>Anda dapat menambahkan sub-kategori setelah kategori berhasil dibuat</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Character counter
    const textarea = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    
    if (textarea && charCount) {
        // Set initial count
        charCount.textContent = textarea.value.length;
        
        textarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            if (count > 500) {
                this.value = this.value.substring(0, 500);
                charCount.textContent = 500;
            }
        });
    }
</script>
@endpush
@endsection