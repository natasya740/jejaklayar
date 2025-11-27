{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('layouts.dashboard_admin')

@section('title', 'Edit Kategori')

@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'Perbarui informasi kategori')

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
                    <a href="{{ route('admin.categories.show', $category) }}" class="text-[color:var(--muted)] hover:text-[color:var(--yellow-2)] transition-colors">
                        {{ $category->name }}
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fa fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-[color:var(--text-dark)] font-medium">Edit</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="bg-gradient-to-r from-amber-400 to-amber-500 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                <i class="fa fa-edit text-3xl text-white"></i>
            </div>
            <div class="text-white">
                <h2 class="text-2xl font-bold mb-1">Edit Kategori</h2>
                <p class="text-white/80">Perbarui informasi: {{ $category->name }}</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] overflow-hidden">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">
                <!-- Current Slug Info -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fa fa-link text-amber-600"></i>
                                <span class="text-sm font-semibold text-amber-900">Slug Saat Ini</span>
                            </div>
                            <code class="text-sm bg-white px-3 py-1.5 rounded border border-amber-200 text-amber-900">{{ $category->slug }}</code>
                        </div>
                        <span class="px-3 py-1 bg-amber-600 text-white text-xs font-semibold rounded-full">Otomatis</span>
                    </div>
                </div>

                <!-- Nama Kategori -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-[color:var(--text-dark)] mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa fa-folder text-amber-500"></i>
                        </div>
                        <input type="text" 
                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $category->name) }}" 
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
                        <span>Slug akan diperbarui secara otomatis jika nama diubah</span>
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
                            id="description" 
                            name="description" 
                            rows="5"
                            maxlength="500"
                            placeholder="Jelaskan tentang kategori ini...">{{ old('description', $category->description) }}</textarea>
                        <div class="absolute bottom-3 right-3 text-xs text-[color:var(--muted)]">
                            <span id="charCount">{{ strlen($category->description ?? '') }}</span> / 500
                        </div>
                    </div>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Stats Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/80 text-sm mb-1">Sub Kategori</p>
                                <h3 class="text-3xl font-bold">{{ $category->subCategories->count() }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fa fa-folder-open text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/80 text-sm mb-1">Total Artikel</p>
                                <h3 class="text-3xl font-bold">{{ $category->articles->count() }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fa fa-file-alt text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Warning Box -->
                @if($category->articles->count() > 0)
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <i class="fa fa-exclamation-triangle text-orange-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-orange-900 mb-1">Perhatian!</h4>
                            <p class="text-sm text-orange-800">
                                Kategori ini memiliki <strong>{{ $category->articles->count() }} artikel</strong>. 
                                Perubahan nama akan mempengaruhi URL artikel yang terkait.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row gap-3">
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-400 to-amber-500 text-white font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fa fa-save"></i>
                    <span>Update Kategori</span>
                </button>
                <a href="{{ route('admin.categories.show', $category) }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-all duration-200">
                    <i class="fa fa-eye"></i>
                    <span>Lihat Detail</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 text-[color:var(--text-dark)] font-semibold rounded-lg hover:bg-gray-50 transition-all duration-200">
                    <i class="fa fa-times-circle"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Metadata Card -->
    <div class="bg-white rounded-xl shadow-[var(--shadow-sm)] p-6 mt-6">
        <h3 class="text-lg font-semibold text-[color:var(--text-dark)] mb-4 flex items-center gap-2">
            <i class="fa fa-clock text-[color:var(--yellow-2)]"></i>
            Informasi Metadata
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fa fa-calendar-plus text-green-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-[color:var(--muted)] mb-0.5">Dibuat Pada</p>
                    <p class="text-sm font-semibold text-[color:var(--text-dark)]">{{ $category->created_at->format('d F Y, H:i') }}</p>
                    <p class="text-xs text-[color:var(--muted)] mt-0.5">{{ $category->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa fa-calendar-check text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-[color:var(--muted)] mb-0.5">Terakhir Diupdate</p>
                    <p class="text-sm font-semibold text-[color:var(--text-dark)]">{{ $category->updated_at->format('d F Y, H:i') }}</p>
                    <p class="text-xs text-[color:var(--muted)] mt-0.5">{{ $category->updated_at->diffForHumans() }}</p>
                </div>
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