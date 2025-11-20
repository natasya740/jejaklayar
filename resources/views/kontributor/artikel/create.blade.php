@extends('layouts.dashboard') <!-- Menggunakan Layout Dashboard (Ada Sidebar) -->

@section('title', 'Tulis Artikel Baru')

@section('content')

<!-- Header Halaman -->
<div class="mb-8 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Tulis Artikel Baru</h2>
        <p class="text-gray-500 text-sm mt-1">Bagikan cerita budaya dan sejarah Bengkalis.</p>
    </div>
    <a href="{{ route('kontributor.artikel.saya') }}" class="text-sm text-indigo-600 hover:underline font-medium flex items-center gap-1">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- CDN CKEditor 5 (Classic) -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

<!-- Form Wrapper -->
<form action="{{ route('kontributor.artikel.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: EDITOR UTAMA (70%) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            
            <!-- Judul -->
            <div class="mb-6">
                <label class="block text-gray-700 text-xs font-bold uppercase mb-2 tracking-wide">Judul Artikel</label>
                <input type="text" 
                       name="judul" 
                       value="{{ old('judul') }}"
                       class="w-full text-2xl font-bold text-gray-800 border-b-2 border-gray-200 focus:border-indigo-500 focus:outline-none py-2 transition placeholder-gray-300" 
                       placeholder="Tulis judul yang menarik..." 
                       required>
                @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Editor -->
            <div class="prose max-w-none">
                <textarea name="isi" id="editor" placeholder="Mulai menulis ceritamu di sini...">{{ old('isi') }}</textarea>
            </div>
            @error('isi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- KOLOM KANAN: PENGATURAN (30%) -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Card Publish -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-bold text-gray-700 mb-4 border-b pb-2 text-sm">Publikasi</h3>
                
                <!-- Kategori -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kategori</label>
                    <select name="kategori_id" class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cover Image Upload -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Gambar Sampul</label>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50 transition cursor-pointer relative" id="upload-container">
                        <input type="file" name="image" id="image-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(event)">
                        
                        <div id="placeholder-content">
                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                            <p class="text-xs text-gray-500">Klik untuk upload</p>
                            <p class="text-[10px] text-gray-400 mt-1">JPG/PNG Max 2MB</p>
                        </div>
                        
                        <!-- Preview Image -->
                        <img id="preview-img" src="" class="hidden w-full h-32 object-cover rounded-md mt-2">
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition shadow-md flex justify-center items-center gap-2 text-sm">
                    <i class="fas fa-paper-plane"></i> Kirim Artikel
                </button>
                
                <a href="{{ route('kontributor.dashboard') }}" class="block text-center text-xs text-gray-500 mt-3 hover:underline">Batal</a>
            </div>

            <!-- Tips Penulisan (Opsional) -->
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                <h4 class="font-bold text-blue-700 text-xs mb-2 uppercase"><i class="fas fa-lightbulb mr-1"></i> Tips Penulis</h4>
                <ul class="text-xs text-blue-600 space-y-1 list-disc list-inside">
                    <li>Gunakan judul yang singkat & padat.</li>
                    <li>Tambahkan gambar sampul agar menarik.</li>
                    <li>Cek ejaan sebelum mengirim.</li>
                </ul>
            </div>

        </div>
    </div>
</form>

<!-- STYLE KHUSUS CKEDITOR (Agar Rapi) -->
<style>
    .ck-editor__editable_inline {
        min-height: 400px;
        border: 1px solid #e5e7eb !important;
        border-radius: 0 0 8px 8px !important;
        padding: 1rem !important;
    }
    .ck-toolbar {
        border: 1px solid #e5e7eb !important;
        border-radius: 8px 8px 0 0 !important;
        background-color: #f9fafb !important;
    }
</style>

<!-- SCRIPT -->
<script>
    // CKEditor
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo'],
            placeholder: 'Tulis ceritamu...'
        })
        .catch(error => console.error(error));

    // Preview Image
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview-img');
            var placeholder = document.getElementById('placeholder-content');
            output.src = reader.result;
            output.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection