{{-- resources/views/admin/artikel/create.blade.php --}}
@extends('layouts.dashboard_admin')

@section('title', 'Tulis Naskah Baru')

@section('head')
{{-- CKEditor 5 CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
{{-- FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
    /* --- ANIMASI --- */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes zoomIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    @keyframes checkmark { 0% { stroke-dashoffset: 50; } 100% { stroke-dashoffset: 0; } }
    @keyframes checkmark-circle { 0% { stroke-dashoffset: 166; } 100% { stroke-dashoffset: 0; } }
    @keyframes checkmark-fill { 0% { box-shadow: 0 0 0 0 #10b981; } 100% { box-shadow: 0 0 0 30px rgba(16, 185, 129, 0); } }

    .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }
    .animate-zoomIn { animation: zoomIn 0.4s ease-out forwards; }

    /* --- TEMA ADAT MELAYU (Songket & Warisan) --- */
    :root {
        --melayu-emerald: #064e3b; /* Hijau Zamrud Tua */
        --melayu-gold: #d97706;    /* Emas Raja */
        --melayu-gold-light: #fbbf24;
        --melayu-maroon: #881337;  /* Merah Hati */
        --melayu-cream: #fffbeb;   /* Warna Kertas Lama */
    }

    /* Motif Songket Halus */
    .bg-songket {
        background-color: var(--melayu-emerald);
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fbbf24' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Input Styling Modern tapi Klasik */
    .input-melayu {
        transition: all 0.3s ease;
        border: 1px solid #d1d5db;
        background-color: #fff;
    }
    .input-melayu:focus {
        border-color: var(--melayu-gold);
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.2);
        outline: none;
    }

    /* --- EDITOR ALA MS WORD --- */
    .document-editor {
        background-color: #f3f4f6; /* Abu-abu meja */
        padding: 40px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    /* Kertas Putih */
    .ck-editor__editable_inline {
        min-height: 800px !important; /* Panjang kertas A4 */
        width: 100%;
        max-width: 850px; /* Lebar kertas A4 proporsional */
        margin: 0 auto;
        background-color: #ffffff !important;
        border: 1px solid #d1d5db !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 40px 50px !important; /* Margin kertas */
        font-family: 'Georgia', 'Times New Roman', serif; /* Font Serif untuk kesan naskah */
        font-size: 18px;
        line-height: 1.8;
        color: #1f2937;
    }

    .ck-editor__editable_inline:focus {
        border-color: var(--melayu-gold) !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }

    /* Toolbar menempel di atas kertas */
    .ck-toolbar {
        border: 1px solid #d1d5db !important;
        border-radius: 8px 8px 0 0 !important;
        background: #f9fafb !important;
        max-width: 850px;
        margin: 0 auto !important;
    }

    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        border-color: #d1d5db !important;
    }

    /* --- UPLOAD ZONE --- */
    .upload-zone {
        border: 2px dashed #d1d5db;
        transition: all 0.3s ease;
        background: #f9fafb;
    }
    .upload-zone:hover, .upload-zone.drag-over {
        border-color: var(--melayu-gold);
        background: #fffbeb; /* Cream */
        transform: scale(1.01);
    }

    /* --- MODAL SUKSES --- */
    .checkmark-svg {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #fff;
        stroke-miterlimit: 10;
        margin: 10% auto;
        box-shadow: inset 0px 0px 0px #10b981;
        animation: checkmark-fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }
    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #10b981;
        fill: none;
        animation: checkmark-circle 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: checkmark 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }
    
    /* Tombol Aksi */
    .btn-gold {
        background: linear-gradient(to right, #d97706, #b45309);
        color: white;
    }
    .btn-gold:hover {
        background: linear-gradient(to right, #b45309, #92400e);
        box-shadow: 0 10px 15px -3px rgba(217, 119, 6, 0.3);
    }
</style>
@endsection

@section('content')
<div class="w-full max-w-7xl mx-auto p-6 min-h-screen">

    {{-- HEADER --}}
    <div class="mb-8 bg-yellow-300 rounded-2xl p-9 text-black/75 shadow-xl relative overflow-hidden border-b-4 border-amber-400 animate-fadeInUp">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-serif font-bold flex items-center gap-3">
                    <i class="fas fa-scroll text-amber-400"></i>
                    Penulisan Naskah Budaya & Sejarah
                </h1>
                <p class="text-black/80 mt-2">Bagikan warisan, lestarikan budaya. Tulis dengan hati.</p>
            </div>
            <div class="flex gap-3">
                <span class="px-4 py-2 bg-gray-500/10 rounded-lg text-sm border border-white/20 backdrop-blur-sm">
                    <i class="fas fa-user-edit mr-2"></i> Mode Penulis
                </span>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-20 w-64 h-64 bg-amber-400 opacity-10 rounded-full blur-3xl"></div>
    </div>

    <form id="articleForm" action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="statusField" name="status" value="draft">
        <input type="hidden" id="bodyField" name="body_html">
        <input type="hidden" id="images_meta" name="images_meta">

        <div class="grid grid-cols-12 gap-8">
            
            {{-- KOLOM KIRI: KONFIGURASI (Sticky) --}}
            <div class="col-span-12 lg:col-span-4 space-y-6">
                
                {{-- CARD 1: KATEGORI (Wajib Diisi Dulu) --}}
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden animate-fadeInUp" style="animation-delay: 0.1s">
                    <div class="bg-gradient-to-r from-emerald-800 to-emerald-700 p-4 text-white">
                        <h3 class="font-bold flex items-center gap-2"><i class="fas fa-compass text-amber-400"></i> Langkah 1: Klasifikasi</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Ranah (Kategori) <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="top_category" value="Budaya" class="peer hidden" required>
                                    <div class="p-4 rounded-lg border-2 border-gray-200 text-center hover:bg-emerald-50 peer-checked:border-emerald-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-800 transition-all">
                                        <i class="fas fa-masks-theater text-2xl mb-2"></i>
                                        <div class="font-bold">Budaya</div>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="top_category" value="Sejarah" class="peer hidden">
                                    <div class="p-4 rounded-lg border-2 border-gray-200 text-center hover:bg-amber-50 peer-checked:border-amber-600 peer-checked:bg-amber-50 peer-checked:text-amber-800 transition-all">
                                        <i class="fas fa-monument text-2xl mb-2"></i>
                                        <div class="font-bold">Sejarah</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div id="subcatWrapper" class="opacity-50 pointer-events-none transition-all duration-300">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Spesifikasi (Sub-Kategori) <span class="text-red-500">*</span></label>
                            <select id="subcategory" name="subcategory" class="w-full p-3 input-melayu rounded-lg" required>
                                <option value="">-- Pilih Kategori Utama Dahulu --</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Wajib dipilih agar konten terorganisir.</p>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: MEDIA GALLERY --}}
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden animate-fadeInUp" style="animation-delay: 0.2s">
                    <div class="bg-gradient-to-r from-rose-800 to-rose-700 p-4 text-white flex justify-between items-center">
                        <h3 class="font-bold flex items-center gap-2"><i class="fas fa-images text-amber-400"></i> Galeri Media</h3>
                        <span class="text-xs bg-white/20 px-2 py-1 rounded">Klik foto untuk sisipkan</span>
                    </div>
                    <div class="p-4">
                        <div id="uploadZone" class="upload-zone rounded-lg p-6 text-center cursor-pointer mb-4">
                            <input type="file" id="imageFiles" multiple accept="image/*" class="hidden">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm font-bold text-gray-600">Klik / Tarik Foto ke Sini</p>
                            <p class="text-xs text-gray-400">Max 5MB per foto</p>
                        </div>

                        {{-- Area Thumbnail --}}
                        <div id="thumbsContainer" class="grid grid-cols-2 gap-2 max-h-[300px] overflow-y-auto pr-1">
                            <div class="col-span-2 text-center py-4 text-gray-400 text-sm italic border rounded bg-gray-50">
                                Belum ada foto diunggah
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: META INFO --}}
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden animate-fadeInUp" style="animation-delay: 0.3s">
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Judul Naskah</label>
                            <input type="text" id="title" name="title" class="w-full p-3 input-melayu rounded-lg font-serif font-bold text-lg" placeholder="Judul yang memikat..." required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Slug URL</label>
                            <input type="text" id="slug" name="slug" class="w-full p-2 bg-gray-100 rounded text-sm text-gray-600 border border-gray-200" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Ringkasan Singkat</label>
                            <textarea name="excerpt" rows="3" class="w-full p-3 input-melayu rounded-lg text-sm" placeholder="Untuk tampilan di kartu depan..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex flex-col gap-3 sticky top-6">
                    <button type="button" id="publishBtn" class="w-full py-4 btn-gold rounded-xl font-bold text-lg shadow-lg transform transition hover:-translate-y-1 flex justify-center items-center gap-2">
                        <i class="fas fa-paper-plane"></i> TERBITKAN SEKARANG
                    </button>
                    <button type="button" id="saveDraft" class="w-full py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition flex justify-center items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Draf
                    </button>
                </div>

            </div>

            {{-- KOLOM KANAN: EDITOR MS WORD (Utama) --}}
            <div class="col-span-12 lg:col-span-8 animate-fadeInUp" style="animation-delay: 0.2s">
                <div class="document-editor shadow-2xl">
                    <div class="mb-4 flex justify-between items-center px-4">
                        <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">Halaman Editor</span>
                        <div class="text-xs text-gray-400" id="editorStats">0 Kata | 0 Menit Baca</div>
                    </div>
                    
                    {{-- AREA TEXTAREA CKEDITOR --}}
                    <textarea id="editor" name="body">
                        <h2>Pendahuluan</h2>
                        <p>Mulai tuliskan kisah budaya atau sejarah di sini...</p>
                    </textarea>

                    <div class="mt-4 text-center text-gray-400 text-sm italic">
                        <i class="fas fa-info-circle"></i> Tips: Taruh kursor di paragraf yang diinginkan, lalu klik foto di galeri kiri untuk menyisipkannya.
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

{{-- MODAL SUKSES (Overlay) --}}
<div id="successModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-emerald-900/90 backdrop-blur-md">
    <div class="text-center text-white animate-zoomIn p-8">
        <div class="checkmark-svg">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>
        <h2 class="text-4xl font-serif font-bold mb-2 text-amber-400 mt-6">Terima Kasih</h2>
        <p class="text-xl text-emerald-100">Kontribusi Anda sangat berharga bagi budaya kita.</p>
        <div class="mt-8">
            <div class="w-64 h-2 bg-emerald-800 rounded-full mx-auto overflow-hidden">
                <div class="h-full bg-amber-400 animate-[shimmer_2s_infinite]" style="width: 100%"></div>
            </div>
            <p class="text-sm mt-2 opacity-70">Sedang menerbitkan...</p>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    /* 1. INISIALISASI CKEDITOR SUPER BUILD (FITUR LENGKAP) */
    CKEDITOR.ClassicEditor.create(document.querySelector('#editor'), {
        // --- Toolbar Lengkap (Seperti MS Word) ---
        toolbar: {
            items: [
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', 'removeFormat', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'undo', 'redo',
                '-', // Baris Baru
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'horizontalLine', '|',
                'specialCharacters', 'pageBreak'
            ],
            shouldNotGroupWhenFull: true
        },
        // --- Konfigurasi Heading ---
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraf Normal', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Judul Besar (H1)', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Sub Judul (H2)', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Sub Bab (H3)', class: 'ck-heading_heading3' }
            ]
        },
        // --- Konfigurasi Font ---
        fontFamily: {
            options: [
                'default',
                'Times New Roman, Times, serif',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
        },
        fontSize: {
            options: [ 10, 12, 14, 'default', 18, 20, 22, 24, 28, 30, 36 ],
            supportAllValues: true
        },
        // --- Menghapus Plugin yang tidak perlu/berbayar agar tidak error ---
        removePlugins: [
            'CKBox', 'CKFinder', 'EasyImage', 'RealTimeCollaborativeComments', 
            'RealTimeCollaborativeTrackChanges', 'RealTimeCollaborativeRevisionHistory', 
            'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 
            'RevisionHistory', 'Pagination', 'WProofreader', 'MathType'
        ],
        placeholder: 'Mulai ketik naskah di sini...'
    }).then(editor => {
        window.editor = editor; // Simpan ke window agar bisa diakses fungsi insert gambar
        
        // Hitung kata realtime
        editor.model.document.on('change:data', () => {
            const data = editor.getData();
            const text = data.replace(/<[^>]*>/g, '').trim();
            const words = text ? text.split(/\s+/).length : 0;
            document.getElementById('editorStats').innerText = `${words} Kata | Estimasi ${Math.ceil(words/200)} Menit Baca`;
        });
    }).catch(err => {
        console.error('Gagal memuat editor:', err);
    });


    /* 2. DATA KATEGORI (Budaya & Sejarah) */
    const categoriesData = {
        "Budaya": ["Seni Tari", "Seni Musik", "Adat Istiadat", "Pakaian Adat", "Kuliner Tradisional", "Senjata Tradisional"],
        "Sejarah": ["Kerajaan Hindu-Buddha", "Kerajaan Islam", "Masa Kolonial", "Perjuangan Kemerdekaan", "Biografi Tokoh"]
    };

    /* 3. LOGIKA FORM DINAMIS */
    document.querySelectorAll('input[name="top_category"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const subWrapper = document.getElementById('subcatWrapper');
            const subSelect = document.getElementById('subcategory');
            
            subWrapper.classList.remove('opacity-50', 'pointer-events-none');
            subSelect.innerHTML = '<option value="">-- Pilih Spesifikasi --</option>';
            
            const list = categoriesData[this.value];
            if(list) {
                list.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item;
                    opt.innerText = item;
                    subSelect.appendChild(opt);
                });
            }
        });
    });

    // Auto Slug dari Judul
    document.getElementById('title').addEventListener('input', function() {
        const slug = this.value.toLowerCase().trim().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-');
        document.getElementById('slug').value = slug;
    });

    /* 4. LOGIKA GAMBAR (UPLOAD & SISIP) */
    let uploadedImages = [];
    const imageInput = document.getElementById('imageFiles');
    const thumbsContainer = document.getElementById('thumbsContainer');
    const uploadZone = document.getElementById('uploadZone');

    // Klik zona upload untuk buka file manager
    uploadZone.addEventListener('click', () => imageInput.click());

    // Saat file dipilih
    imageInput.addEventListener('change', function() {
        Array.from(this.files).forEach(file => {
            if(file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = { id: Date.now() + Math.random(), src: e.target.result, name: file.name };
                    uploadedImages.push(img);
                    renderImages();
                    // Simpan data gambar ke input hidden agar terkirim ke server
                    document.getElementById('images_meta').value = JSON.stringify(uploadedImages);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Render Thumbnail di Sidebar
    function renderImages() {
        if(uploadedImages.length === 0) {
            thumbsContainer.innerHTML = '<div class="col-span-2 text-center py-6 text-gray-400 text-xs italic bg-gray-50 rounded border border-dashed">Belum ada foto</div>';
            return;
        }
        thumbsContainer.innerHTML = '';
        uploadedImages.forEach(img => {
            const div = document.createElement('div');
            div.className = 'relative group h-24 border rounded-lg overflow-hidden cursor-pointer shadow-sm';
            div.innerHTML = `
                <img src="${img.src}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/60 hidden group-hover:flex flex-col items-center justify-center gap-2 transition">
                    <button type="button" class="bg-emerald-500 hover:bg-emerald-600 text-white px-2 py-1 rounded text-[10px] font-bold" onclick="insertImageToEditor('${img.id}')">
                        <i class="fas fa-plus"></i> SISIPKAN
                    </button>
                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-[10px]" onclick="removeImage('${img.id}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            thumbsContainer.appendChild(div);
        });
    }

    // Fungsi: Sisipkan Gambar ke Editor (Posisi Kursor)
    window.insertImageToEditor = function(id) {
        const img = uploadedImages.find(i => i.id == id);
        if (window.editor && img) {
            // Template HTML Gambar yang rapi
            const content = `
                <figure class="image" style="display:block; margin: 20px auto; text-align:center;">
                    <img src="${img.src}" alt="${img.name}" style="max-width:100%; height:auto; border-radius:8px; box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                    <figcaption style="text-align:center; color:#666; font-style:italic; font-size:14px; margin-top:5px;">${img.name}</figcaption>
                </figure>
                <p>&nbsp;</p>
            `;
            // Masukkan ke editor
            const viewFragment = window.editor.data.processor.toView(content);
            const modelFragment = window.editor.data.toModel(viewFragment);
            window.editor.model.insertContent(modelFragment);
        }
    };

    // Hapus Gambar dari Galeri
    window.removeImage = function(id) {
        if(confirm('Hapus foto ini dari galeri?')) {
            uploadedImages = uploadedImages.filter(i => i.id != id);
            renderImages();
            document.getElementById('images_meta').value = JSON.stringify(uploadedImages);
        }
    };

    /* 5. SUBMIT & ANIMASI */
    document.getElementById('publishBtn').addEventListener('click', function() {
        const form = document.getElementById('articleForm');
        
        // Validasi HTML5
        if(!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Cek Konten Editor
        const content = window.editor.getData();
        if(!content) {
            alert('Isi konten naskah terlebih dahulu!');
            return;
        }

        // Masukkan data ke input hidden
        document.getElementById('bodyField').value = content;
        document.getElementById('statusField').value = 'published';

        // Tampilkan Modal Animasi Sukses
        const modal = document.getElementById('successModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Submit form setelah animasi selesai (2 detik)
        setTimeout(() => {
            form.submit();
        }, 2000);
    });

    // Simpan Draf
    document.getElementById('saveDraft').addEventListener('click', function() {
        document.getElementById('bodyField').value = window.editor.getData();
        document.getElementById('articleForm').submit();
    });
</script>
@endsection