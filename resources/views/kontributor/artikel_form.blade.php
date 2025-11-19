@extends('layouts.app')

@section('title', 'Buat Artikel Baru')

@push('scripts')
<!-- TinyMCE Script (Gunakan API Key Anda jika ada, atau biarkan no-api-key untuk dev) -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Inisialisasi TinyMCE
    tinymce.init({
        selector: '#editor', // Pastikan ID ini cocok dengan textarea
        height: 400,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family:Poppins,Helvetica,Arial,sans-serif; font-size:14px }'
    });

    // Logika Dropdown Bertingkat (Kategori)
    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.getElementById('cat-wrapper');
        const finalInput = document.getElementById('kategori_id');

        if (wrapper) {
            wrapper.addEventListener('change', (e) => {
                if(e.target.tagName !== 'SELECT') return;
                
                const id = e.target.value;
                const level = parseInt(e.target.dataset.level);

                // Hapus dropdown anak yang mungkin sudah ada sebelumnya
                let nextLevel = level + 1;
                let nextSelect = document.getElementById(`cat_${nextLevel}`);
                while(nextSelect) {
                    nextSelect.remove();
                    nextLevel++;
                    nextSelect = document.getElementById(`cat_${nextLevel}`);
                }

                // Set nilai kategori_id ke pilihan terakhir
                finalInput.value = id; 

                if(!id) return;

                // Fetch subkategori via API
                fetch(`/api/kategori/${id}/subkategori`)
                    .then(r => r.json())
                    .then(data => {
                        if(data.length > 0) {
                            const sel = document.createElement('select');
                            sel.id = `cat_${level+1}`;
                            sel.dataset.level = level+1;
                            // Gunakan class Tailwind yang sama
                            sel.className = "w-full p-3 border border-gray-300 rounded-lg mb-3 focus:ring-amber-500 focus:border-amber-500";
                            
                            let options = '<option value="">-- Pilih Sub Kategori --</option>';
                            data.forEach(c => {
                                options += `<option value="${c.id}">${c.nama}</option>`;
                            });
                            sel.innerHTML = options;
                            
                            wrapper.appendChild(sel);
                        }
                    })
                    .catch(err => console.error('Error fetching subcategories:', err));
            });
        }
    });
</script>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        
        <!-- Header Form -->
        <div class="bg-amber-500 p-6 text-white">
            <h2 class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-pen-nib"></i> Tulis Artikel Baru
            </h2>
            <p class="text-amber-100 text-sm mt-1">Bagikan wawasan budaya Anda kepada dunia.</p>
        </div>

        <div class="p-8">
            <form action="{{ route('kontributor.artikel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Input Judul -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Artikel</label>
                    <input type="text" name="judul" required 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition-all"
                        placeholder="Contoh: Sejarah Tari Zapin di Riau">
                </div>

                <!-- Input Kategori (Dropdown Bertingkat) -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <div id="cat-wrapper" class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <select id="cat_1" data-level="1" class="w-full p-3 border border-gray-300 rounded-lg mb-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">-- Pilih Kategori Utama --</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Input hidden untuk menyimpan ID kategori terakhir yang dipilih -->
                    <input type="hidden" name="kategori_id" id="kategori_id" required>
                </div>

                <!-- Editor Konten (TinyMCE) -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Konten</label>
                    <textarea id="editor" name="isi"></textarea>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('kontributor.dashboard') }}" class="px-6 py-3 rounded-lg text-gray-600 font-medium hover:bg-gray-100 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-amber-500/30 transform hover:-translate-y-0.5 transition-all">
                        <i class="fas fa-paper-plane mr-2"></i> Terbitkan Artikel
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection