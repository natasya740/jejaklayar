{{-- resources/views/kontributor/articles/edit.blade.php --}}
@extends('layouts.dashboard_kontributor')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel')
@section('page-subtitle', 'Perbarui artikel Anda dan kirim ulang untuk peninjauan')

@section('content')
<div class="max-w-6xl mx-auto">
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
                    <span class="text-[color:var(--text-dark)] font-medium">Edit Artikel</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                <i class="fa fa-edit text-3xl text-white"></i>
            </div>
            <div class="text-white">
                <h2 class="text-2xl font-bold mb-1">Edit Artikel Anda</h2>
                <p class="text-white/80">Perbarui konten artikel dan kirimkan kembali untuk peninjauan</p>
            </div>
        </div>
    </div>

    {{-- Status Alert --}}
    @if($article->status === 'rejected' && $article->rejection_reason)
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fa fa-exclamation-triangle text-red-500 text-xl"></i>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-semibold text-red-800 mb-1">Artikel Ditolak</h3>
                <p class="text-sm text-red-700">{{ $article->rejection_reason }}</p>
                <p class="text-xs text-red-600 mt-2">Silakan perbaiki artikel sesuai catatan di atas dan kirim ulang.</p>
            </div>
        </div>
    </div>
    @elseif($article->status === 'pending')
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fa fa-clock text-blue-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-blue-800 mb-1">Artikel Sedang Ditinjau</h3>
                <p class="text-sm text-blue-700">Artikel Anda sedang dalam proses peninjauan oleh editor.</p>
            </div>
        </div>
    </div>
    @elseif($article->status === 'published')
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fa fa-check-circle text-green-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-green-800 mb-1">Artikel Telah Dipublikasikan</h3>
                <p class="text-sm text-green-700">Artikel Anda telah dipublikasikan dan dapat dilihat oleh publik.</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Error Messages --}}
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <ul class="list-disc pl-6 space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('kontributor.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" id="articleForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-file-alt text-[color:var(--yellow-2)]"></i>
                            Informasi Dasar
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <label for="title" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Judul Artikel <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all @error('title') border-red-500 @enderror"
                                id="title"
                                name="title"
                                value="{{ old('title', $article->title) }}"
                                placeholder="Masukkan judul artikel..."
                                required
                                autofocus>
                            @error('title')
                            <p class="mt-2 text-sm text-red-600">
                                <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                            <p class="mt-2 text-sm text-[color:var(--muted)] flex items-center gap-1">
                                <i class="fa fa-info-circle"></i>
                                <span>Slug akan diperbarui otomatis jika judul diubah</span>
                            </p>
                        </div>

                        <div>
                            <label for="excerpt" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Ringkasan <span class="text-[color:var(--muted)] font-normal">(Opsional, maks 500 karakter)</span>
                            </label>
                            <div class="relative">
                                <textarea
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all resize-none @error('excerpt') border-red-500 @enderror"
                                    id="excerpt"
                                    name="excerpt"
                                    rows="3"
                                    maxlength="500"
                                    placeholder="Ringkasan singkat artikel (max 500 karakter)...">{{ old('excerpt', $article->excerpt) }}</textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-[color:var(--muted)] bg-white px-2 py-1 rounded">
                                    <span id="excerptCount">{{ strlen(old('excerpt', $article->excerpt ?? '')) }}</span> / 500
                                </div>
                            </div>
                            @error('excerpt')
                            <p class="mt-2 text-sm text-red-600">
                                <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-pen-fancy text-purple-600"></i>
                            Konten Artikel
                        </h3>
                    </div>
                    <div class="p-6">
                        <label for="editor" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                            Konten <span class="text-red-500">*</span>
                        </label>
                        <textarea id="editor" name="content" class="w-full border border-gray-200 rounded-lg"
                            placeholder="Tulis konten artikel di sini...">{{ old('content', $article->content) }}</textarea>
                        @error('content')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                        @enderror
                        <p class="text-xs text-[color:var(--muted)] mt-2">
                            💡 Tips: Gunakan heading, bold, list, dan gambar untuk membuat artikel lebih menarik
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-image text-purple-600"></i>
                            Gambar Unggulan
                        </h3>
                    </div>
                    <div class="p-6">
                        <label for="featured_image" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                            Upload Gambar Baru <span class="text-[color:var(--muted)] font-normal">(Opsional)</span>
                        </label>

                        @if($article->featured_image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-[color:var(--muted)] mb-2">Gambar saat ini:</p>
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $article->featured_image) }}"
                                    alt="Current featured image"
                                    class="h-48 rounded-lg shadow-md object-cover">
                                <div class="mt-2">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="remove_featured_image" value="1" class="form-checkbox text-red-600 rounded" id="removeImageCheckbox">
                                        <span class="ml-2 text-sm text-red-600">Hapus gambar ini</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[color:var(--yellow-2)] transition-colors" id="uploadArea">
                            <div class="space-y-2 text-center">
                                <div id="imagePreview" class="hidden mb-4">
                                    <img src="" alt="Preview" class="mx-auto h-48 rounded-lg shadow-md object-cover">
                                    <button type="button" onclick="removePreview()" class="mt-2 text-sm text-red-600 hover:text-red-800">
                                        <i class="fa fa-times-circle"></i> Hapus
                                    </button>
                                </div>
                                <div id="uploadPrompt">
                                    <i class="fa fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="featured_image"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-[color:var(--yellow-2)] hover:text-[color:var(--yellow-1)] focus-within:outline-none">
                                            <span>Upload file baru</span>
                                            <input id="featured_image"
                                                name="featured_image"
                                                type="file"
                                                class="sr-only"
                                                accept="image/*">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG, WEBP hingga 2MB</p>
                                </div>
                            </div>
                        </div>
                        @error('featured_image')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <button type="button" onclick="togglePreview()"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all">
                            <i class="fa fa-eye"></i>
                            <span>👁️ Preview Artikel</span>
                        </button>
                    </div>
                    <div id="previewSection" class="hidden p-6 bg-gray-50">
                        <h3 class="font-semibold text-lg mb-3 text-[color:var(--text-dark)]">Preview:</h3>
                        <div id="previewContent" class="prose max-w-none bg-white p-6 rounded-lg"></div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-clipboard-check text-blue-600"></i>
                            Status Artikel
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all appearance-none bg-white @error('status') border-red-500 @enderror"
                                id="status"
                                name="status"
                                required>
                                <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>📝 Draft (Disimpan)</option>
                                <option value="pending" {{ old('status', $article->status) === 'pending' ? 'selected' : '' }}>⏳ Kirim untuk Ditinjau</option>
                            </select>
                            @error('status')
                            <p class="mt-2 text-sm text-red-600">
                                <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                            <p class="mt-2 text-xs text-[color:var(--muted)]">
                                Pilih 'Kirim untuk Ditinjau' untuk mengirim artikel ke editor.
                            </p>
                        </div>

                        {{-- Info Status --}}
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-xs text-[color:var(--muted)] mb-1">Status saat ini:</p>
                            @if($article->status === 'draft')
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                <i class="fa fa-circle text-gray-500 mr-1 text-[8px]"></i> Draft
                            </span>
                            @elseif($article->status === 'pending')
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                <i class="fa fa-circle text-blue-500 mr-1 text-[8px]"></i> Pending
                            </span>
                            @elseif($article->status === 'published')
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                <i class="fa fa-circle text-green-500 mr-1 text-[8px]"></i> Published
                            </span>
                            @elseif($article->status === 'rejected')
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                <i class="fa fa-circle text-red-500 mr-1 text-[8px]"></i> Rejected
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-folder text-green-600"></i>
                            Kategori
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all appearance-none bg-white @error('category_id') border-red-500 @enderror"
                                id="category_id"
                                name="category_id"
                                required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="mt-2 text-sm text-red-600">
                                <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div>
                            <label for="sub_category_id" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Sub Kategori <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--yellow-2)] focus:border-transparent transition-all appearance-none bg-white @error('sub_category_id') border-red-500 @enderror"
                                id="sub_category_id"
                                name="sub_category_id"
                                required>
                                <option value="">-- Pilih Sub Kategori --</option>
                                @foreach($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}"
                                    data-category="{{ $subCategory->category_id }}"
                                    {{ old('sub_category_id', $article->sub_category_id) == $subCategory->id ? 'selected' : '' }}
                                    style="display: none;">
                                    {{ $subCategory->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('sub_category_id')
                            <p class="mt-2 text-sm text-red-600">
                                <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Article Metadata Info --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-[var(--shadow-sm)] p-5">
                    <h4 class="text-sm font-semibold text-[color:var(--text-dark)] mb-3 flex items-center gap-2">
                        <i class="fa fa-info-circle text-blue-600"></i>
                        Informasi Artikel
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-[color:var(--muted)]">Dibuat:</span>
                            <span class="font-medium text-[color:var(--text-dark)]">{{ $article->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[color:var(--muted)]">Terakhir diubah:</span>
                            <span class="font-medium text-[color:var(--text-dark)]">{{ $article->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($article->published_at)
                        <div class="flex justify-between">
                            <span class="text-[color:var(--muted)]">Dipublikasikan:</span>
                            <span class="font-medium text-[color:var(--text-dark)]">{{ $article->published_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between pt-2 border-t border-blue-200">
                            <span class="text-[color:var(--muted)]">Total views:</span>
                            <span class="font-semibold text-blue-600">
                                <i class="fa fa-eye mr-1"></i>{{ number_format($article->views ?? 0) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-[var(--shadow-sm)] p-5 space-y-3">
                    <button type="submit" id="submitBtn"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] text-[color:var(--text-dark)] font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <i class="fa fa-save"></i>
                        <span>💾 Update Artikel</span>
                    </button>
                    <a href="{{ route('kontributor.articles.index') }}"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 text-[color:var(--text-dark)] font-semibold rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <i class="fa fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>

                    {{-- Delete Button --}}
                    @if($article->status === 'draft' || $article->status === 'rejected')
                    <button type="button" onclick="confirmDelete()"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-50 border border-red-200 text-red-600 font-semibold rounded-lg hover:bg-red-100 transition-all duration-200">
                        <i class="fa fa-trash-alt"></i>
                        <span>Hapus Artikel</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </form>

    {{-- Delete Form (hidden) --}}
    @if($article->status === 'draft' || $article->status === 'rejected')
    <form id="deleteForm" action="{{ route('kontributor.articles.destroy', $article->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
    @endif
</div>

{{-- CKEditor 5 CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<style>
    /* CKEditor custom styling */
    .ck-editor__editable {
        min-height: 500px;
        max-height: 800px;
    }

    .ck-content {
        font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
        line-height: 1.6;
    }

    /* Preview styling */
    .prose {
        color: #374151;
        line-height: 1.75;
    }

    .prose img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
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

    .prose ul,
    .prose ol {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .prose li {
        margin: 0.5rem 0;
    }

    .prose blockquote {
        border-left: 4px solid var(--yellow-2);
        padding-left: 1rem;
        margin: 1rem 0;
        font-style: italic;
        color: #6b7280;
    }

    .prose table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
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
</style>

<script>
    let editorInstance;

    // Custom Upload Adapter untuk CKEditor
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
        }

        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }

        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("kontributor.articles.upload-image") }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.responseType = 'json';
        }

        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${file.name}.`;

            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;

                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }

                resolve({
                    default: response.url
                });
            });

            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }

        _sendRequest(file) {
            const data = new FormData();
            data.append('upload', file);
            this.xhr.send(data);
        }
    }

    // Plugin untuk register custom adapter
    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    // Initialize CKEditor dengan Custom Upload Adapter
    ClassicEditor
        .create(document.querySelector('#editor'), {
            extraPlugins: [MyCustomUploadAdapterPlugin],

            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'link', 'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'uploadImage', 'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ],
                shouldNotGroupWhenFull: true
            },

            image: {
                toolbar: [
                    'imageTextAlternative', '|',
                    'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                    'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight'
                ],
                styles: [
                    'inline', 'block', 'side', 'alignLeft', 'alignCenter', 'alignRight'
                ]
            },

            table: {
                contentToolbar: [
                    'tableColumn', 'tableRow', 'mergeTableCells',
                    'tableCellProperties', 'tableProperties'
                ]
            },

            heading: {
                options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    }
                ]
            }
        })
        .then(editor => {
            editorInstance = editor;
            console.log('✅ CKEditor berhasil dimuat');

            // Auto-save ke localStorage setiap 30 detik
            const articleId = '{{ $article->id }}';
            const storageKey = `article_edit_${articleId}`;

            setInterval(() => {
                const data = editor.getData();
                if (data) {
                    localStorage.setItem(storageKey, data);
                    console.log('💾 Draft edit tersimpan otomatis');
                }
            }, 30000);

            // Restore draft jika ada
            const draft = localStorage.getItem(storageKey);
            const originalContent = {!! json_encode(old('content', $article->content)) !!};
            
            if (draft && draft !== originalContent) {
                if (confirm('📄 Ditemukan draft edit tersimpan. Muat draft?')) {
                    editor.setData(draft);
                }
            }

            // Setup change detection SETELAH editor ready
            setupChangeDetection();
        })
        .catch(error => {
            console.error('❌ Error loading CKEditor:', error);
            alert('Gagal memuat editor. Silakan refresh halaman.');
        });

    // Excerpt character counter
    const excerptTextarea = document.getElementById('excerpt');
    const excerptCount = document.getElementById('excerptCount');

    if (excerptTextarea && excerptCount) {
        excerptTextarea.addEventListener('input', function() {
            const count = this.value.length;
            excerptCount.textContent = count;

            if (count > 500) {
                this.value = this.value.substring(0, 500);
                excerptCount.textContent = 500;
            }
        });
    }

    // Image preview untuk upload gambar baru
    const imageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('imagePreview');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const removeImageCheckbox = document.getElementById('removeImageCheckbox');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.querySelector('img').src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    uploadPrompt.classList.add('hidden');

                    // Uncheck remove image jika user upload gambar baru
                    if (removeImageCheckbox) {
                        removeImageCheckbox.checked = false;
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Handle remove image checkbox
    if (removeImageCheckbox) {
        removeImageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Clear file input jika user centang hapus gambar
                if (imageInput) {
                    imageInput.value = '';
                    imagePreview.classList.add('hidden');
                    uploadPrompt.classList.remove('hidden');
                }
            }
        });
    }

    function removePreview() {
        imagePreview.classList.add('hidden');
        uploadPrompt.classList.remove('hidden');
        imageInput.value = '';
    }

    // Filter sub categories based on selected category
    const categorySelect = document.getElementById('category_id');
    const subCategorySelect = document.getElementById('sub_category_id');

    if (categorySelect && subCategorySelect) {
        categorySelect.addEventListener('change', function() {
            const selectedCategory = this.value;
            const subCategoryOptions = subCategorySelect.querySelectorAll('option');
            const currentSubCategory = '{{ old("sub_category_id", $article->sub_category_id) }}';

            // Reset sub category hanya jika kategori berubah
            const previousCategory = subCategorySelect.querySelector(`option[value="${currentSubCategory}"]`)?.getAttribute('data-category');

            if (selectedCategory !== previousCategory) {
                subCategorySelect.value = '';
            }

            subCategoryOptions.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                } else {
                    const optionCategory = option.getAttribute('data-category');
                    option.style.display = optionCategory === selectedCategory ? 'block' : 'none';
                }
            });
        });

        // Trigger on page load untuk menampilkan sub kategori yang sesuai
        if (categorySelect.value) {
            categorySelect.dispatchEvent(new Event('change'));
        }
    }

    // Toggle preview
    function togglePreview() {
        const previewSection = document.getElementById('previewSection');
        const previewContent = document.getElementById('previewContent');

        if (previewSection.classList.contains('hidden')) {
            const content = editorInstance.getData();
            const title = document.getElementById('title').value;
            const excerpt = document.getElementById('excerpt').value;

            let previewHTML = '';

            if (title) {
                previewHTML += `<h1 class="text-3xl font-bold mb-4">${title}</h1>`;
            }
            if (excerpt) {
                previewHTML += `<p class="text-gray-600 italic mb-6">${excerpt}</p>`;
            }
            previewHTML += `<div class="border-t pt-4">${content}</div>`;

            previewContent.innerHTML = previewHTML;
            previewSection.classList.remove('hidden');
        } else {
            previewSection.classList.add('hidden');
        }
    }

    // Confirm delete function
    function confirmDelete() {
        if (confirm('⚠️ Apakah Anda yakin ingin menghapus artikel ini?\n\nArtikel yang dihapus tidak dapat dikembalikan.')) {
            document.getElementById('deleteForm').submit();
        }
    }

    // Clear draft setelah submit berhasil
    document.getElementById('articleForm').addEventListener('submit', function() {
        const articleId = '{{ $article->id }}';
        const storageKey = `article_edit_${articleId}`;
        localStorage.removeItem(storageKey);

        // Reset flag perubahan
        formChanged = false;

        // Disable submit button to prevent double submit
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <span>⏳ Mengupdate...</span>';
    });

    // Warning sebelum leave page jika ada perubahan
    let formChanged = false;
    const form = document.getElementById('articleForm');

    function setupChangeDetection() {
        // Setup untuk form elements
        const formElements = form.querySelectorAll('input, textarea, select');
        
        formElements.forEach(element => {
            // Skip CKEditor textarea karena akan dihandle terpisah
            if (element.id !== 'editor') {
                element.addEventListener('change', function() {
                    formChanged = true;
                });
            }
        });

        // CKEditor change detection
        if (editorInstance) {
            editorInstance.model.document.on('change:data', () => {
                formChanged = true;
            });
        }
    }

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    });
</script>
@endsection