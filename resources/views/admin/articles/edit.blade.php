{{-- resources/views/admin/articles/edit.blade.php --}}
@extends('layouts.dashboard_admin')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel')
@section('page-subtitle', 'Perbarui artikel dengan editor lengkap')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2 text-sm">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.articles.index') }}" class="text-[color:var(--muted)] hover:text-[color:var(--yellow-2)] transition-colors">
                    <i class="fa fa-newspaper mr-1"></i>Artikel
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fa fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-[color:var(--text-dark)] font-medium">Edit: {{ Str::limit($article->title, 30) }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                <i class="fa fa-edit text-3xl text-white"></i>
            </div>
            <div class="text-white">
                <h2 class="text-2xl font-bold mb-1">Edit Artikel</h2>
                <p class="text-white/80">Perbarui konten artikel: <strong>{{ $article->title }}</strong></p>
            </div>
        </div>
    </div>

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

    {{-- Success Messages --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" id="articleForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content (Left - 2 columns) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information Card -->
                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-file-alt text-[color:var(--yellow-2)]"></i>
                            Informasi Dasar
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Judul Artikel <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('title') border-red-500 @enderror" 
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
                                <span>Slug saat ini: <code class="bg-gray-100 px-2 py-0.5 rounded">{{ $article->slug }}</code></span>
                            </p>
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <label for="excerpt" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Ringkasan <span class="text-[color:var(--muted)] font-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <textarea 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none @error('excerpt') border-red-500 @enderror" 
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

                <!-- Content Card with CKEditor -->
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

                <!-- Featured Image Card -->
                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-image text-purple-600"></i>
                            Gambar Unggulan
                        </h3>
                    </div>
                    <div class="p-6">
                        <!-- Current Image Preview -->
                        @if($article->featured_image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-sm font-semibold text-[color:var(--text-dark)] mb-2">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                 alt="Current Featured Image" 
                                 class="h-48 rounded-lg shadow-md object-cover">
                            <p class="text-xs text-[color:var(--muted)] mt-2">
                                <i class="fa fa-info-circle"></i> Upload gambar baru untuk mengganti
                            </p>
                        </div>
                        @endif

                        <label for="featured_image" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                            Upload Gambar Baru <span class="text-[color:var(--muted)] font-normal">(Opsional)</span>
                        </label>
                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 transition-colors">
                            <div class="space-y-2 text-center">
                                <div id="imagePreview" class="hidden mb-4">
                                    <img src="" alt="Preview" class="mx-auto h-48 rounded-lg shadow-md">
                                    <button type="button" onclick="removePreview()" class="mt-2 text-sm text-red-600 hover:text-red-800">
                                        <i class="fa fa-times-circle"></i> Hapus Preview
                                    </button>
                                </div>
                                <div id="uploadPrompt">
                                    <i class="fa fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="featured_image" 
                                               class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                            <span>Upload file</span>
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

                <!-- Preview Section -->
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

            <!-- Sidebar (Right - 1 column) -->
            <div class="space-y-6">
                <!-- Article Info -->
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl shadow-[var(--shadow-sm)] p-5">
                    <h4 class="font-semibold text-[color:var(--text-dark)] mb-3 flex items-center gap-2">
                        <i class="fa fa-info-circle text-blue-600"></i>
                        Info Artikel
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-[color:var(--muted)]">Dibuat:</span>
                            <span class="font-medium">{{ $article->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[color:var(--muted)]">Diupdate:</span>
                            <span class="font-medium">{{ $article->updated_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[color:var(--muted)]">Penulis:</span>
                            <span class="font-medium">{{ $article->user->name ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[color:var(--muted)]">Status:</span>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($article->status === 'published') bg-green-100 text-green-800
                                @elseif($article->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($article->status === 'draft') bg-gray-100 text-gray-800
                                @else bg-purple-100 text-purple-800
                                @endif">
                                {{ ucfirst($article->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Publish Settings Card -->
                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-cog text-blue-600"></i>
                            Pengaturan
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all appearance-none bg-white @error('status') border-red-500 @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>📝 Draft</option>
                                <option value="pending" {{ old('status', $article->status) === 'pending' ? 'selected' : '' }}>⏳ Pending Review</option>
                                <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>✅ Published</option>
                                <option value="archived" {{ old('status', $article->status) === 'archived' ? 'selected' : '' }}>📦 Archived</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Published Date -->
                        <div>
                            <label for="published_at" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Tanggal Publikasi <span class="text-[color:var(--muted)] font-normal">(Opsional)</span>
                            </label>
                            <input type="datetime-local" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('published_at') border-red-500 @enderror" 
                                   id="published_at" 
                                   name="published_at" 
                                   value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                            @error('published_at')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-[color:var(--muted)]">
                                Kosongkan untuk menggunakan waktu saat ini
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Category Card -->
                <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] flex items-center gap-2">
                            <i class="fa fa-folder text-green-600"></i>
                            Kategori
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all appearance-none bg-white @error('category_id') border-red-500 @enderror" 
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

                        <!-- Sub Category -->
                        <div>
                            <label for="sub_category_id" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                                Sub Kategori <span class="text-[color:var(--muted)] font-normal">(Opsional)</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all appearance-none bg-white @error('sub_category_id') border-red-500 @enderror" 
                                    id="sub_category_id" 
                                    name="sub_category_id">
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

                <!-- Action Buttons -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-[var(--shadow-sm)] p-5 space-y-3">
                    <button type="submit" id="submitBtn"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <i class="fa fa-save"></i>
                        <span>💾 Update Artikel</span>
                    </button>
                    <a href="{{ route('admin.articles.index') }}" 
                       class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 text-[color:var(--text-dark)] font-semibold rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <i class="fa fa-times-circle"></i>
                        <span>Batal</span>
                    </a>
                    <button type="button" 
                            onclick="if(confirm('Yakin ingin menghapus artikel ini?')) document.getElementById('deleteForm').submit();"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-all duration-200">
                        <i class="fa fa-trash"></i>
                        <span>Hapus Artikel</span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Delete Form -->
    <form id="deleteForm" action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
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

.prose ul, .prose ol {
    margin: 1rem 0;
    padding-left: 1.5rem;
}

.prose li {
    margin: 0.5rem 0;
}

.prose blockquote {
    border-left: 4px solid #3b82f6;
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

// Custom Upload Adapter untuk CKEditor menggunakan UploadImageController
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
        // Gunakan route dari UploadImageController
        xhr.open('POST', '{{ route("admin.articles.uploadImage") }}', true);
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

            // Response dari UploadImageController: { url: "/storage/..." }
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
        // Field name sesuai dengan UploadImageController: 'image'
        data.append('image', file);
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
                'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'
            ]
        },
        
        table: {
            contentToolbar: [
                'tableColumn', 'tableRow', 'mergeTableCells',
                'tableCellProperties', 'tableProperties'
            ]
        },
        
        heading: {
            options: [