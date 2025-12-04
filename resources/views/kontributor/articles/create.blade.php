{{-- resources/views/kontributor/articles/create.blade.php --}}
@extends('layouts.dashboard_kontributor')

@section('title', 'Buat Artikel Baru')
@section('page-title', 'Buat Artikel')
@section('page-subtitle', 'Tulis artikel baru dan kirim untuk peninjauan')

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
                    <span class="text-[color:var(--text-dark)] font-medium">Buat Baru</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                <i class="fa fa-pencil-alt text-3xl text-white"></i>
            </div>
            <div class="text-white">
                <h2 class="text-2xl font-bold mb-1">Tulis Artikel Baru Anda</h2>
                <p class="text-white/80">Buat artikel budaya lokal dan kirimkan kepada tim editor untuk ditinjau</p>
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

    <form action="{{ route('kontributor.articles.store') }}" method="POST" enctype="multipart/form-data" id="articleForm">
        @csrf

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
                                value="{{ old('title') }}"
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
                                <span>Slug akan dibuat otomatis dari judul artikel</span>
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
                                    placeholder="Ringkasan singkat artikel (max 500 karakter)...">{{ old('excerpt') }}</textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-[color:var(--muted)] bg-white px-2 py-1 rounded">
                                    <span id="excerptCount">0</span> / 500
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
                            placeholder="Tulis konten artikel di sini...">{{ old('content') }}</textarea>
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
                            Upload Gambar <span class="text-[color:var(--muted)] font-normal">(Opsional)</span>
                        </label>
                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[color:var(--yellow-2)] transition-colors">
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
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>📝 Draft (Disimpan)</option>
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>⏳ Kirim untuk Ditinjau</option>
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
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    {{ old('sub_category_id') == $subCategory->id ? 'selected' : '' }}
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
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-[var(--shadow-sm)] p-5 space-y-3">
                    <button type="submit" id="submitBtn"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-[color:var(--yellow-1)] to-[color:var(--yellow-2)] text-[color:var(--text-dark)] font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <i class="fa fa-save"></i>
                        <span>💾 Simpan Artikel</span>
                    </button>
                    <a href="{{ route('kontributor.articles.index') }}"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 text-[color:var(--text-dark)] font-semibold rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <i class="fa fa-times-circle"></i>
                        <span>Batal</span>
                    </a>
                </div>
            </div>
        </div>
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
            setInterval(() => {
                const data = editor.getData();
                if (data) {
                    localStorage.setItem('article_draft', data);
                    console.log('💾 Draft tersimpan otomatis');
                }
            }, 30000);

            // Restore draft jika ada
            const draft = localStorage.getItem('article_draft');
            if (draft && !editor.getData()) {
                if (confirm('📄 Ditemukan draft tersimpan. Muat draft?')) {
                    editor.setData(draft);
                }
            }
        })
        .catch(error => {
            console.error('❌ Error loading CKEditor:', error);
            alert('Gagal memuat editor. Silakan refresh halaman.');
        });

    // Excerpt character counter
    const excerptTextarea = document.getElementById('excerpt');
    const excerptCount = document.getElementById('excerptCount');

    if (excerptTextarea && excerptCount) {
        excerptCount.textContent = excerptTextarea.value.length;

        excerptTextarea.addEventListener('input', function() {
            const count = this.value.length;
            excerptCount.textContent = count;

            if (count > 500) {
                this.value = this.value.substring(0, 500);
                excerptCount.textContent = 500;
            }
        });
    }

    // Image preview
    const imageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('imagePreview');
    const uploadPrompt = document.getElementById('uploadPrompt');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.querySelector('img').src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    uploadPrompt.classList.add('hidden');
                }
                reader.readAsDataURL(file);
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

            // Reset sub category
            subCategorySelect.value = '';

            subCategoryOptions.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                } else {
                    const optionCategory = option.getAttribute('data-category');
                    option.style.display = optionCategory === selectedCategory ? 'block' : 'none';
                }
            });
        });

        // Trigger on page load jika ada old value
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

    // Clear draft setelah submit berhasil
    document.getElementById('articleForm').addEventListener('submit', function() {
        localStorage.removeItem('article_draft');

        // Disable submit button to prevent double submit
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <span>⏳ Menyimpan...</span>';
    });
</script>
@endsection