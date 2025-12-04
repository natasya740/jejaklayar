@extends('layouts.dashboard_admin')

@section('title', 'Tambah Sub Kategori')
@section('page-title', 'Tambah Sub Kategori')
@section('page-subtitle', 'Buat sub kategori baru untuk konten (Budaya & Pustaka)')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 text-sm">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.sub-categories.index') }}"
                        class="text-[color:var(--muted)] hover:text-[color:var(--yellow-2)] transition-colors">
                        <i class="fa fa-folder-open mr-1"></i>Sub Kategori
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <span class="text-[color:var(--text-dark)] font-medium">Tambah</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header Card -->
        <div class="bg-gradient-to-r from-amber-400 to-amber-500 rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa fa-plus text-3xl text-white"></i>
                </div>
                <div class="text-white">
                    <h2 class="text-2xl font-bold mb-1">Tambah Sub Kategori</h2>
                    <p class="text-white/80">Lengkapi informasi untuk membuat sub kategori baru.</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
            <form action="{{ route('admin.sub-categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-6">
                    <!-- Info Slug -->
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center">
                                <i class="fa fa-info text-amber-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-amber-900 mb-1">Slug Dibuat Otomatis</h3>
                                <p class="text-sm text-amber-800">
                                    Slug akan dibuat secara otomatis dari nama sub kategori (misalnya:
                                    <code class="bg-white/70 px-1.5 py-0.5 rounded text-xs">pakaian-tradisional</code>).
                                    Anda tidak perlu mengisi slug secara manual.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                            Kategori Induk <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa fa-folder text-blue-600"></i>
                            </div>
                            <select
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all appearance-none bg-white @error('category_id') border-red-500 @enderror"
                                id="category_id" name="category_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fa fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">
                                <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nama Sub Kategori -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                            Nama Sub Kategori <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa fa-folder-open text-amber-500"></i>
                            </div>
                            <input type="text"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                                id="name" name="name" value="{{ old('name') }}" required autofocus>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">
                                <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-sm text-[color:var(--muted)] flex items-center gap-1">
                            <i class="fa fa-info-circle"></i>
                            <span>Slug akan dibuat otomatis berdasarkan nama yang Anda isi.</span>
                        </p>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                            Deskripsi <span class="text-[color:var(--muted)] font-normal">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <textarea
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all resize-none @error('description') border-red-500 @enderror"
                                id="description" name="description" rows="5" maxlength="500"
                                placeholder="Jelaskan tentang sub kategori ini...">{{ old('description') }}</textarea>
                            <div class="absolute bottom-3 right-3 text-xs text-[color:var(--muted)]">
                                <span id="charCount">{{ strlen(old('description', '')) }}</span> / 500
                            </div>
                        </div>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Gambar Thumbnail -->
                    <div>
                        <label for="image" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                            Gambar Thumbnail <span class="text-[color:var(--muted)] font-normal">(Opsional)</span>
                        </label>
                        <div id="imagePreviewContainer"
                            class="grid grid-cols-1 md:grid-cols-[auto,1fr] gap-4 md:items-center" data-existing-image="">
                            <div
                                class="w-28 h-28 rounded-lg border border-dashed border-gray-300 flex items-center justify-center bg-gray-50 overflow-hidden">
                                <img id="imagePreview" src="" alt="Preview gambar thumbnail"
                                    class="w-full h-full object-cover hidden">
                                <div id="imagePreviewPlaceholder"
                                    class="flex flex-col items-center justify-center text-[color:var(--muted)] text-xs">
                                    <i class="fa fa-image text-2xl mb-1 text-gray-400"></i>
                                    <span>Belum ada gambar</span>
                                </div>
                            </div>
                            <div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa fa-upload text-amber-500"></i>
                                    </div>
                                    <input type="file" name="image" id="image" accept="image/*"
                                        class="block w-full pl-10 pr-4 py-3 text-sm text-[color:var(--text-dark)] border border-gray-200 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-white @error('image') border-red-500 @enderror">
                                </div>
                                <p class="mt-2 text-xs text-[color:var(--muted)] flex items-start gap-2">
                                    <i class="fa fa-info-circle mt-0.5"></i>
                                    <span>
                                        Format yang didukung: JPG, JPEG, PNG, WEBP. Maksimal 10MB (sesuai pengaturan
                                        server).
                                        Disarankan ukuran minimal 600x400 piksel agar tampilan thumbnail tetap tajam di
                                        daftar.
                                    </span>
                                </p>
                                @error('image')
                                    <p class="mt-2 text-sm text-red-600">
                                        <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-400 to-amber-500 text-white font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <i class="fa fa-save"></i>
                        <span>Simpan Sub Kategori</span>
                    </button>
                    <a href="{{ route('admin.sub-categories.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 text-[color:var(--text-dark)] font-semibold rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <i class="fa fa-times-circle"></i>
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Character counter untuk deskripsi
            const textarea = document.getElementById('description');
            const charCount = document.getElementById('charCount');

            if (textarea && charCount) {
                let value = textarea.value || '';
                if (value.length > 500) {
                    value = value.substring(0, 500);
                    textarea.value = value;
                }
                charCount.textContent = value.length;

                textarea.addEventListener('input', function() {
                    let text = textarea.value;

                    if (text.length > 500) {
                        text = text.substring(0, 500);
                        textarea.value = text;
                    }

                    charCount.textContent = text.length;
                });
            }

            // Preview gambar thumbnail
            const imageInput = document.getElementById('image');
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('imagePreviewPlaceholder');
            const container = document.getElementById('imagePreviewContainer');
            const existingImage = container ? (container.dataset.existingImage || '') : '';

            function showExistingOrPlaceholder() {
                if (!preview || !placeholder) return;

                if (existingImage) {
                    preview.src = existingImage;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                }
            }

            if (imageInput && preview && placeholder) {
                imageInput.addEventListener('change', function(event) {
                    const files = event.target.files;
                    const file = files && files[0];

                    if (!file) {
                        showExistingOrPlaceholder();
                        return;
                    }

                    if (!file.type.startsWith('image/')) {
                        showExistingOrPlaceholder();
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (!e.target) return;
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Tampilkan placeholder (tidak ada gambar awal)
            showExistingOrPlaceholder();
        });
    </script>
@endsection
