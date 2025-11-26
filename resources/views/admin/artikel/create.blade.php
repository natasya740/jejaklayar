{{-- resources/views/admin/artikel/create.blade.php --}}
@extends('layouts.dashboard_admin')

@section('title','Buat Artikel Baru')

@section('head')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
  /* (CSS persis seperti versi Anda — disingkat di sini untuk ringkasan) */
  /* -- Animations, glow, inputs, buttons, tags, upload zone, thumbnails, ckeditor styles, tooltips, toasts, spinner, dsb -- */
  @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
  @keyframes slideInRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
  @keyframes glow { 0%,100% { box-shadow: 0 0 5px rgba(217,119,6,0.3);} 50% { box-shadow: 0 0 25px rgba(217,119,6,0.6), 0 0 40px rgba(217,119,6,0.3);} }
  @keyframes pulse { 0%,100% { transform: scale(1);} 50% { transform: scale(1.05); } }
  .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }
  .animate-slideInRight { animation: slideInRight 0.6s ease-out forwards; }
  .glow-card { transition: all .4s cubic-bezier(.4,0,.2,1); position: relative; }
  .glow-card::before { content: ''; position: absolute; inset: -2px; border-radius: .75rem; background: linear-gradient(135deg,#f59e0b,#d97706,#f59e0b); opacity:0; transition:opacity .4s; z-index:-1; background-size:200% 200%; }
  .glow-card:hover::before { opacity: .7; animation: glow 2s ease-in-out infinite; }
  .input-glow { transition: all .3s ease; border: 2px solid #e5e7eb; }
  .input-glow:focus { border-color:#f59e0b; box-shadow: 0 0 0 4px rgba(245,158,11,0.1), 0 0 20px rgba(245,158,11,0.2); outline:none; transform: translateY(-1px); }
  .btn-glow { position: relative; overflow:hidden; transition: all .3s ease; }
  .btn-glow::before { content:''; position:absolute; top:50%; left:50%; width:0; height:0; border-radius:50%; background: rgba(255,255,255,.3); transform: translate(-50%,-50%); transition: width .6s, height .6s; }
  .btn-glow:hover::before { width:300px; height:300px; }
  .tag-chip { animation: fadeInUp .3s ease; transition: all .2s ease; }
  .upload-zone { border: 3px dashed #e5e7eb; transition: all .3s ease; background: linear-gradient(135deg,#ffffff 0%, #fffbeb 100%); }
  .upload-zone:hover { border-color:#f59e0b; background: linear-gradient(135deg,#fffbeb 0%, #fef3c7 100%); box-shadow: 0 0 30px rgba(245,158,11,0.2); transform: scale(1.02); }
  .upload-zone.drag-over { border-color:#d97706; background:#fef3c7; box-shadow: 0 0 40px rgba(217,119,6,0.3); transform: scale(1.05); }
  .image-thumb { position: relative; overflow:hidden; transition: all .3s ease; border-radius: .75rem; background:#f9fafb; }
  .image-overlay { position:absolute; inset:0; background: linear-gradient(to top, rgba(0,0,0,.8), rgba(0,0,0,.3)); opacity:0; transition: opacity .3s ease; display:flex; flex-direction:column; justify-content:space-between; padding:.75rem; }
  .image-thumb:hover .image-overlay { opacity: 1; }
  .ck-editor__editable_inline { min-height: 550px !important; font-size: 18px; line-height: 1.8; padding: 2rem; font-family: "Segoe UI", Roboto, system-ui, -apple-system, "Helvetica Neue", Arial; background:#fff; color:#111827; transition: all .3s ease; }
  .ck-toolbar { border-radius: .75rem .75rem 0 0; padding:.75rem; border: 2px solid #e5e7eb; background: linear-gradient(135deg,#f9fafb 0%, #ffffff 100%); }
  .spinner { border: 3px solid #f3f4f6; border-top: 3px solid #f59e0b; border-radius: 50%; width:24px; height:24px; animation: spin .8s linear infinite; }
  @keyframes spin { 0% { transform: rotate(0deg);} 100% { transform: rotate(360deg);} }
  .toast { animation: slideInRight .5s ease; }
  /* scrollbar, tooltip, progress, etc... (retain your original rules) */
</style>
@endsection

@section('content')
<div class="max-w-[1400px] mx-auto p-6">

  {{-- Header Section (Hero + Preview) --}}
  <div class="mb-8 animate-fadeInUp">
    <div class="p-8 max-h-[75vh] overflow-y-auto">
      <article class="max-w-4xl mx-auto">
        <div class="mb-6">
          <h1 id="previewTitle" class="text-4xl font-bold text-gray-900 mb-3"></h1>
          <p id="previewMeta" class="text-sm text-gray-500 flex items-center gap-3">
            <span><i class="fas fa-folder"></i> <span id="previewCategory"></span></span>
            <span><i class="fas fa-tags"></i> <span id="previewTags"></span></span>
          </p>
        </div>

        <img id="previewHero" class="w-full rounded-2xl shadow-lg mb-6 hidden" src="" alt="Cover Image">

        <div id="previewExcerpt" class="text-lg text-gray-600 italic border-l-4 border-amber-500 pl-4 mb-6"></div>

        <div id="previewContent" class="prose prose-lg max-w-none"></div>
      </article>
    </div>

    <div class="bg-gradient-to-r from-gray-50 to-amber-50 p-6 border-t flex justify-between items-center">
      <div class="text-sm text-gray-600 flex items-center gap-2">
        <i class="fas fa-info-circle text-blue-500"></i>
        <span>Ini adalah preview. Klik <strong>Terbitkan Artikel</strong> untuk menyimpan.</span>
      </div>
      <div class="flex gap-3">
        <button id="closePreview2" class="px-6 py-3 bg-white hover:bg-gray-100 text-gray-700 rounded-xl transition-all font-semibold border-2 border-gray-200">
          Kembali ke Editor
        </button>
        <button id="publishFromPreview" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white rounded-xl transition-all font-bold btn-glow">
          <i class="fas fa-paper-plane"></i>
          Terbitkan Sekarang
        </button>
      </div>
    </div>
  </div>

  {{-- Success Toast --}}
  <div id="successToast" class="fixed top-6 right-6 z-50 hidden toast">
    <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4">
      <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
        <i class="fas fa-check-circle text-2xl"></i>
      </div>
      <div>
        <p class="font-bold text-lg">Berhasil!</p>
        <p class="text-sm text-white/90" id="toastMessage">Artikel telah disimpan</p>
      </div>
    </div>
  </div>

  {{-- Form --}}
  <form id="articleForm" action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="statusField" name="status" value="draft">
    <input type="hidden" id="bodyField" name="body_html">
    <input type="hidden" id="images_meta" name="images_meta">

    <div class="grid grid-cols-12 gap-6">
      {{-- Left Sidebar --}}
      <div class="col-span-12 lg:col-span-4 space-y-6">
        {{-- Kategori --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden glow-card animate-fadeInUp" style="animation-delay: 0.1s">
          <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-5">
            <h2 class="text-xl font-bold text-white flex items-center gap-3">
              <i class="fas fa-folder-open category-icon"></i>
              Kategori Artikel
            </h2>
          </div>
          <div class="p-6 space-y-4">
            <div class="helper-tooltip">
              <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Utama <span class="text-red-500">*</span></label>
              <span class="tooltip-text">Pilih antara Budaya atau Pustaka</span>
              <select id="topCategory" name="top_category" class="w-full p-4 input-glow rounded-xl font-semibold text-gray-700 bg-gradient-to-r from-white to-gray-50" required>
                <option value="">Pilih Kategori...</option>
                <option value="Budaya">🎭 Budaya</option>
                <option value="Pustaka">📚 Pustaka</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">Sub Kategori <span class="text-red-500">*</span></label>
              <select id="subcategory" name="subcategory" class="w-full p-4 input-glow rounded-xl font-semibold text-gray-700 bg-gradient-to-r from-white to-gray-50" required>
                <option value="">Pilih Sub Kategori...</option>
              </select>
            </div>

            <div id="suggestedTagsContainer" class="hidden">
              <label class="block text-sm font-bold text-gray-700 mb-2"><i class="fas fa-lightbulb text-yellow-500"></i> Tag yang Disarankan</label>
              <div id="suggestedTags" class="flex flex-wrap gap-2"></div>
            </div>
          </div>
        </div>

        {{-- Info Dasar --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden glow-card animate-fadeInUp" style="animation-delay: 0.2s">
          <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-5">
            <h2 class="text-xl font-bold text-white flex items-center gap-3">
              <i class="fas fa-info-circle category-icon"></i>
              Informasi Dasar
            </h2>
          </div>
          <div class="p-6 space-y-4">
            <div class="helper-tooltip">
              <label class="block text-sm font-bold text-gray-700 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
              <span class="tooltip-text">Buat judul yang menarik dan deskriptif</span>
              <input id="title" name="title" type="text" class="w-full p-4 input-glow rounded-xl font-bold text-xl text-gray-800" placeholder="Contoh: Sejarah Batik Nusantara" required>
              <div class="flex justify-between mt-2">
                <p class="text-xs text-gray-500"><i class="fas fa-keyboard"></i> <span id="titleCount">0</span>/100 karakter</p>
                <p class="text-xs text-green-600 hidden" id="titleOk"><i class="fas fa-check-circle"></i> Judul bagus!</p>
              </div>
            </div>

            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">Slug URL <span class="text-red-500">*</span></label>
              <div class="flex gap-2">
                <input id="slug" name="slug" type="text" class="flex-1 p-3 input-glow rounded-xl text-sm text-gray-600 font-mono" placeholder="otomatis-dari-judul" required>
                <button type="button" id="refreshSlug" class="px-4 py-3 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 rounded-xl transition-all">
                  <i class="fas fa-sync-alt text-gray-600"></i>
                </button>
              </div>
            </div>

            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">Ringkasan Singkat</label>
              <textarea id="excerpt" name="excerpt" rows="4" class="w-full p-4 input-glow rounded-xl resize-none text-gray-700" placeholder="Tulis ringkasan singkat untuk menarik pembaca..."></textarea>
              <p class="text-xs text-gray-500 mt-2"><span id="excerptCount">0</span>/200 karakter</p>
            </div>

            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">Tags / Label</label>
              <div id="tagContainer" class="flex flex-wrap gap-2 p-4 input-glow rounded-xl min-h-[80px] bg-gradient-to-r from-white to-amber-50">
                <input id="tagInput" type="text" class="flex-1 min-w-[140px] p-2 focus:outline-none bg-transparent" placeholder="Ketik tag lalu Enter...">
              </div>
              <p class="text-xs text-gray-500 mt-2"><i class="fas fa-tag text-amber-500"></i> Contoh: batik, tradisional, jawa, seni</p>
              <input type="hidden" id="tagsField" name="tags">
            </div>
          </div>
        </div>

        {{-- Media Upload --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden glow-card animate-fadeInUp" style="animation-delay: 0.3s">
          <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-5">
            <h2 class="text-xl font-bold text-white flex items-center gap-3">
              <i class="fas fa-images category-icon"></i>
              Galeri Media
            </h2>
          </div>
          <div class="p-6">
            <div class="upload-zone text-center p-10 rounded-2xl cursor-pointer" id="uploadZone">
              <input id="imageFiles" type="file" accept="image/*" multiple class="hidden">
              <div class="text-amber-500 mb-4"><i class="fas fa-cloud-upload-alt text-6xl"></i></div>
              <p class="font-bold text-gray-700 text-lg mb-2">Klik atau Drag & Drop</p>
              <p class="text-sm text-gray-500">Format: JPG, PNG, WebP</p>
              <p class="text-xs text-gray-400 mt-1">Maksimal 8 file • 5MB per file</p>
            </div>

            <div id="thumbsContainer" class="grid grid-cols-2 gap-4 mt-6"></div>

            <input type="hidden" id="coverImage" name="cover_image">
          </div>
        </div>
      </div>

      {{-- Right Column: Editor --}}
      <div class="col-span-12 lg:col-span-8 space-y-6">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden glow-card animate-slideInRight" style="animation-delay: 0.2s">
          <div class="bg-gradient-to-r from-teal-500 to-green-500 p-5">
            <div class="flex items-center justify-between">
              <h2 class="text-xl font-bold text-white flex items-center gap-3">
                <i class="fas fa-pen-fancy category-icon"></i>
                Editor Konten
              </h2>
              <div class="flex gap-3">
                <button type="button" id="fullscreenBtn" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all backdrop-blur">
                  <i class="fas fa-expand"></i>
                </button>
                <button type="button" id="openPreviewModal" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all backdrop-blur flex items-center gap-2">
                  <i class="fas fa-eye"></i>
                  Preview
                </button>
              </div>
            </div>
          </div>

          <div class="p-6">
            <textarea id="editor" name="body"></textarea>

            {{-- Editor Stats --}}
            <div class="mt-6 bg-gradient-to-r from-gray-50 to-blue-50 p-5 rounded-xl border-2 border-gray-100">
              <div class="flex items-center justify-between">
                <div class="flex gap-6">
                  <div class="flex items-center gap-2 text-sm text-gray-600"><i class="fas fa-font text-blue-500"></i><span class="font-semibold"><span id="wordCount">0</span> kata</span></div>
                  <div class="flex items-center gap-2 text-sm text-gray-600"><i class="fas fa-align-left text-green-500"></i><span class="font-semibold"><span id="charCount">0</span> karakter</span></div>
                  <div class="flex items-center gap-2 text-sm text-gray-600"><i class="fas fa-clock text-purple-500"></i><span class="font-semibold"><span id="readTime">0</span> menit baca</span></div>
                </div>
                <div class="save-indicator saved flex items-center gap-2 text-sm">
                  <div class="spinner hidden"></div>
                  <i class="fas fa-check-circle text-lg"></i>
                  <span class="font-semibold" id="saveIndicator">Tersimpan</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-4 justify-end animate-fadeInUp" style="animation-delay: 0.4s">
          <button type="button" id="saveDraft" class="px-8 py-4 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 rounded-xl font-bold transition-all flex items-center gap-3 shadow-lg btn-glow">
            <i class="fas fa-save text-xl"></i>
            Simpan Draft
          </button>
          <button type="button" id="publishBtn" class="px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white rounded-xl font-bold transition-all flex items-center gap-3 shadow-lg btn-glow relative overflow-hidden">
            <i class="fas fa-paper-plane text-xl"></i>
            <span class="relative z-10">Terbitkan Artikel</span>
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

{{-- Preview Modal --}}
<div id="previewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 modal-backdrop">
  <div class="w-[95%] max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden animate-fadeInUp">
    <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6">
      <div class="flex items-center justify-between">
        <h3 class="text-3xl font-bold text-white flex items-center gap-3"><i class="fas fa-eye"></i> Preview Artikel</h3>
        <button id="closePreview" class="text-white hover:bg-white/20 p-3 rounded-xl transition-all"><i class="fas fa-times text-2xl"></i></button>
      </div>
    </div>

    <div class="p-8 max-h-[70vh] overflow-y-auto">
      <article class="max-w-4xl mx-auto">
        <div class="mb-6">
          <h1 id="modalPreviewTitle" class="text-4xl font-bold text-gray-900 mb-3"></h1>
          <p id="modalPreviewMeta" class="text-sm text-gray-500 flex items-center gap-3">
            <span><i class="fas fa-folder"></i> <span id="modalPreviewCategory"></span></span>
            <span><i class="fas fa-tags"></i> <span id="modalPreviewTags"></span></span>
          </p>
        </div>

        <img id="modalPreviewHero" class="w-full rounded-2xl shadow-lg mb-6 hidden" src="" alt="Cover Image">

        <div id="modalPreviewExcerpt" class="text-lg text-gray-600 italic border-l-4 border-amber-500 pl-4 mb-6"></div>

        <div id="modalPreviewContent" class="prose prose-lg max-w-none"></div>
      </article>
    </div>

    <div class="bg-gradient-to-r from-gray-50 to-amber-50 p-6 border-t flex justify-between items-center">
      <div class="text-sm text-gray-600 flex items-center gap-2">
        <i class="fas fa-info-circle text-blue-500"></i>
        <span>Periksa kembali sebelum menerbitkan.</span>
      </div>
      <div class="flex gap-3">
        <button id="modalBackToEditor" class="px-6 py-3 bg-white hover:bg-gray-100 text-gray-700 rounded-xl transition-all font-semibold border-2 border-gray-200">
          Kembali ke Editor
        </button>
        <button id="modalPublishBtn" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-bold btn-glow">
          Terbitkan
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
/* ============================
   Variables & Config
   ============================ */
let editorInstance;
let tags = [];
let uploadedImages = [];
let autoSaveTimer;

const subcatsTop = {
  "Budaya": ["Seni", "Adat & Tradisi", "Pakaian", "Rumah Adat", "Makanan & Minuman Tradisional", "Tokoh Budaya"],
  "Pustaka": ["Cerita Rakyat", "Kamus Melayu", "Sejarah", "Dokumen", "Esai & Artikel"]
};

const suggestedBySub = {
  "Seni": ["musik","tari","teater","batik","kerajinan","ukiran","lukisan"],
  "Adat & Tradisi": ["upacara","ritual","festival","pernikahan","adat-istiadat"],
  "Pakaian": ["tenun","songket","batik","kebaya","sarung"],
  "Rumah Adat": ["arsitektur","rumah-tradisional","konstruksi","ornamen"],
  "Makanan & Minuman Tradisional": ["resep","jajanan","hidangan","kuliner","warisan"],
  "Tokoh Budaya": ["pejabat","budayawan","penggiat","seniman","maestro"],
  "Cerita Rakyat": ["legenda","mitos","narasi","dongeng","folklore"],
  "Kamus Melayu": ["definisi","istilah","bahasa","kosakata","etimologi"],
  "Sejarah": ["periode","kolonial","arsip","peristiwa","kemerdekaan"],
  "Dokumen": ["manuskrip","naskah","scan","arsip","koleksi"],
  "Esai & Artikel": ["opini","analisis","kritik","ulasan","kajian"]
};

/* ========== DOM elements ========== */
const topCategoryEl = document.getElementById('topCategory');
const subcatEl = document.getElementById('subcategory');
const titleEl = document.getElementById('title');
const slugEl = document.getElementById('slug');
const excerptEl = document.getElementById('excerpt');
const excerptCount = document.getElementById('excerptCount');
const titleCount = document.getElementById('titleCount');
const tagInput = document.getElementById('tagInput');
const tagContainer = document.getElementById('tagContainer');
const tagsField = document.getElementById('tagsField');
const statusField = document.getElementById('statusField');
const saveIndicator = document.getElementById('saveIndicator');

/* ========== Initialize CKEditor ========== */
ClassicEditor.create(document.querySelector('#editor'), {
  toolbar: {
    items: [
      'heading','|','bold','italic','underline','strikethrough','|',
      'fontFamily','fontSize','fontColor','fontBackground','|',
      'alignment','bulletedList','numberedList','outdent','indent','|',
      'blockQuote','insertTable','mediaEmbed','link','imageUpload','|',
      'undo','redo','|','removeFormat'
    ]
  },
  heading: {
    options: [
      { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
      { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
      { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
      { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
    ]
  },
  image: { toolbar: ['imageTextAlternative','imageStyle:full','imageStyle:side'] },
  table: { contentToolbar: ['tableColumn','tableRow','mergeTableCells'] },
  fontSize: { options: [9,11,13,'default',17,19,21] },
  fontFamily: {
    options: ['default','Arial, Helvetica, sans-serif','Georgia, serif','Times New Roman, Times, serif','Courier New, Courier, monospace','Verdana, Geneva, sans-serif']
  }
})
.then(editor => {
  editorInstance = editor;

  // load draft body if exists
  const draftHtml = localStorage.getItem('artikel_body');
  if (draftHtml) editor.setData(draftHtml);

  editor.model.document.on('change:data', () => {
    const html = editor.getData();
    document.getElementById('bodyField').value = html;
    updateSaveIndicator('saving');
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
      localStorage.setItem('artikel_body', html);
      updateSaveIndicator('saved');
      updateStats(html);
    }, 1500);
  });
})
.catch(err => console.error('CKEditor init error', err));

/* ========== Helpers ========== */
function updateSaveIndicator(status) {
  const indicatorText = document.getElementById('saveIndicator');
  const spinner = document.querySelector('.save-indicator .spinner');
  if (status === 'saving') {
    indicatorText.textContent = 'Menyimpan...';
    if (spinner) spinner.classList.remove('hidden');
  } else {
    indicatorText.textContent = 'Tersimpan';
    if (spinner) spinner.classList.add('hidden');
  }
}

function stripHtml(html) {
  const tmp = document.createElement('div'); tmp.innerHTML = html; return tmp.textContent || tmp.innerText || '';
}

function updateStats(html) {
  const text = stripHtml(html).trim();
  const words = text ? text.split(/\s+/).filter(w => w.length>0).length : 0;
  const chars = text.length;
  const readTime = Math.max(1, Math.ceil(words / 200));
  document.getElementById('wordCount').textContent = words;
  document.getElementById('charCount').textContent = chars;
  document.getElementById('readTime').textContent = readTime;
}

/* ========== Category & Suggested Tags ========== */
topCategoryEl.addEventListener('change', function() {
  const val = this.value;
  subcatEl.innerHTML = '<option value="">Pilih Sub Kategori...</option>';
  if (subcatsTop[val]) {
    subcatsTop[val].forEach(sub => {
      const opt = document.createElement('option'); opt.value=sub; opt.textContent=sub; subcatEl.appendChild(opt);
    });
  }
  document.getElementById('suggestedTagsContainer').classList.add('hidden');
  updateProgress();
});

subcatEl.addEventListener('change', () => renderSuggestedTags());

function renderSuggestedTags(){
  const container = document.getElementById('suggestedTagsContainer');
  const suggestedTags = document.getElementById('suggestedTags');
  const subcatValue = subcatEl.value;
  if (!subcatValue || !suggestedBySub[subcatValue]) {
    container.classList.add('hidden');
    return;
  }
  container.classList.remove('hidden');
  suggestedTags.innerHTML = '';
  suggestedBySub[subcatValue].forEach(tag => {
    const btn = document.createElement('button');
    btn.type='button';
    btn.className='suggested-tag px-3 py-2 rounded-lg bg-amber-100 text-amber-700 text-sm font-semibold hover:bg-amber-500 hover:text-white transition-all';
    btn.textContent = tag;
    btn.addEventListener('click', ()=> addTag(tag));
    suggestedTags.appendChild(btn);
  });
}

/* ========== Title & Slug ========== */
titleEl.addEventListener('input', function() {
  const val = this.value;
  titleCount.textContent = val.length;
  const titleOk = document.getElementById('titleOk');
  if (val.length >= 20 && val.length <= 80) titleOk.classList.remove('hidden'); else titleOk.classList.add('hidden');
  slugEl.value = slugify(val);
  localStorage.setItem('artikel_title', val);
  updateProgress();
});

document.getElementById('refreshSlug').addEventListener('click', function() {
  slugEl.value = slugify(titleEl.value || Date.now().toString());
});

function slugify(text) {
  return text.toString().normalize('NFKD').toLowerCase().trim()
    .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
}

/* ========== Excerpt ========== */
excerptEl.addEventListener('input', function(){ excerptCount.textContent = this.value.length; updateProgress(); });

/* ========== Tags ========== */
tagInput.addEventListener('keydown', function(e){
  if (e.key === 'Enter') { e.preventDefault(); addTag(this.value); }
});

function addTag(value) {
  value = (value||'').trim().toLowerCase();
  if (!value || tags.includes(value)) { tagInput.value=''; return; }
  tags.push(value);
  renderTags();
  tagInput.value='';
  updateProgress();
  localStorage.setItem('artikel_tags', JSON.stringify(tags));
}

function removeTag(index) {
  tags.splice(index,1); renderTags(); localStorage.setItem('artikel_tags', JSON.stringify(tags));
}

function renderTags() {
  Array.from(tagContainer.querySelectorAll('.tag-chip')).forEach(el => el.remove());
  tags.forEach((tag, index) => {
    const chip = document.createElement('div');
    chip.className = 'tag-chip inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-100 to-orange-100 text-amber-700 rounded-full text-sm font-semibold border-2 border-amber-200';
    chip.innerHTML = `<i class="fas fa-tag"></i><span>${tag}</span><button type="button" onclick="removeTag(${index})" class="hover:text-amber-900 transition-colors"><i class="fas fa-times"></i></button>`;
    tagContainer.insertBefore(chip, tagInput);
  });
  tagsField.value = tags.join(',');
}

/* ========== Image Upload & Thumbs ========== */
const uploadZone = document.getElementById('uploadZone');
const imageFiles = document.getElementById('imageFiles');
const thumbsContainer = document.getElementById('thumbsContainer');

uploadZone.addEventListener('click', () => imageFiles.click());
uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('drag-over'); });
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('drag-over'));
uploadZone.addEventListener('drop', async (e) => { e.preventDefault(); uploadZone.classList.remove('drag-over'); const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/')); await processImages(files); });

imageFiles.addEventListener('change', async function(){ await processImages(Array.from(this.files)); this.value=''; });

async function processImages(files) {
  const maxFiles = 8 - uploadedImages.length;
  for (const file of files.slice(0, maxFiles)) {
    if (file.size > 5 * 1024 * 1024) { showToast(`File ${file.name} terlalu besar (max 5MB)`, 'error'); continue; }
    const dataUrl = await readFileAsDataURL(file);
    const resized = await resizeImage(dataUrl, 1200, 0.85);
    uploadedImages.push({
      id: Date.now() + Math.random(),
      name: file.name,
      dataUrl: resized.dataUrl,
      sizeKB: Math.round(resized.size / 1024),
      caption: '',
      alt: '',
      cover: uploadedImages.length === 0,
      order: uploadedImages.length
    });
  }
  renderThumbs(); syncImagesMeta(); updateProgress();
}

function readFileAsDataURL(file) {
  return new Promise(resolve => { const reader = new FileReader(); reader.onload = e => resolve(e.target.result); reader.readAsDataURL(file); });
}

function resizeImage(dataUrl, maxWidth = 1200, quality = 0.85) {
  return new Promise(resolve => {
    const img = new Image();
    img.onload = () => {
      const scale = Math.min(1, maxWidth / img.width);
      const canvas = document.createElement('canvas');
      canvas.width = Math.round(img.width * scale);
      canvas.height = Math.round(img.height * scale);
      const ctx = canvas.getContext('2d');
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
      canvas.toBlob(blob => {
        const reader = new FileReader();
        reader.onload = () => resolve({ dataUrl: reader.result, size: blob.size });
        reader.readAsDataURL(blob);
      }, 'image/jpeg', quality);
    };
    img.src = dataUrl;
  });
}

function renderThumbs() {
  thumbsContainer.innerHTML = '';
  uploadedImages.forEach((img, index) => {
    const wrapper = document.createElement('div');
    wrapper.className = 'image-thumb';
    wrapper.dataset.id = img.id;
    wrapper.innerHTML = `
      <img src="${img.dataUrl}" alt="${img.alt || img.name}" class="w-full h-40 object-cover rounded-lg">
      <div class="image-overlay p-3 rounded-lg flex flex-col justify-between">
        <div class="flex justify-between items-start mb-2">
          <button type="button" class="cover-btn px-3 py-1 rounded-lg text-xs font-bold ${img.cover ? 'bg-amber-500 text-white cover-badge' : 'bg-white text-gray-700'}" title="Set sebagai cover">
            ${img.cover ? '<i class="fas fa-star"></i> Cover' : '<i class="far fa-star"></i> Set Cover'}
          </button>
          <button type="button" class="delete-btn px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-bold" title="Hapus">
            <i class="fas fa-trash"></i>
          </button>
        </div>
        <div class="space-y-2">
          <input type="text" class="caption-input w-full p-2 rounded-lg text-xs bg-white/90" placeholder="Caption..." value="${img.caption}">
          <input type="text" class="alt-input w-full p-2 rounded-lg text-xs bg-white/90" placeholder="Alt text..." value="${img.alt}">
          <p class="text-xs text-white font-semibold"><i class="fas fa-file-image"></i> ${img.sizeKB} KB</p>
        </div>
      </div>
    `;
    thumbsContainer.appendChild(wrapper);

    wrapper.querySelector('.cover-btn').addEventListener('click', () => {
      uploadedImages.forEach(u => u.cover = false); img.cover = true; renderThumbs(); syncImagesMeta();
    });
    wrapper.querySelector('.delete-btn').addEventListener('click', () => {
      uploadedImages = uploadedImages.filter(u => u.id !== img.id);
      if (!uploadedImages.some(u => u.cover) && uploadedImages.length > 0) uploadedImages[0].cover = true;
      renderThumbs(); syncImagesMeta(); updateProgress();
    });
    wrapper.querySelector('.caption-input').addEventListener('input', (e) => { img.caption = e.target.value; syncImagesMeta(); });
    wrapper.querySelector('.alt-input').addEventListener('input', (e) => { img.alt = e.target.value; syncImagesMeta(); });
  });

  if (thumbsContainer.children.length > 0) {
    Sortable.create(thumbsContainer, {
      animation: 150,
      ghostClass: 'opacity-50',
      onEnd: function(evt) {
        const moved = uploadedImages.splice(evt.oldIndex,1)[0];
        uploadedImages.splice(evt.newIndex,0,moved);
        uploadedImages.forEach((u,i) => u.order = i);
        renderThumbs();
        syncImagesMeta();
      }
    });
  }
}

function syncImagesMeta() {
  const meta = uploadedImages.map((u,i)=>({ id:u.id, name:u.name, dataUrl:u.dataUrl, caption:u.caption, alt:u.alt, cover:!!u.cover, order:u.order ?? i }));
  document.getElementById('images_meta').value = JSON.stringify(meta);
  localStorage.setItem('artikel_images', JSON.stringify(meta));
}

/* ========== Preview Modal & Publish ========== */
document.getElementById('openPreviewModal').addEventListener('click', openPreview);
document.getElementById('closePreview').addEventListener('click', closePreview);
document.getElementById('closePreview2').addEventListener('click', closePreview);
document.getElementById('modalBackToEditor').addEventListener('click', closePreview);
document.getElementById('modalPublishBtn').addEventListener('click', () => { closePreview(); publishArticle(); });
document.getElementById('publishFromPreview').addEventListener('click', () => { closePreview(); publishArticle(); });

function openPreview() {
  const title = titleEl.value || 'Judul belum diisi';
  const excerpt = excerptEl.value || 'Tidak ada ringkasan';
  const topCat = topCategoryEl.value || '';
  const subCat = subcatEl.value || '';
  const body = editorInstance ? editorInstance.getData() : '';

  // main hero preview (top)
  document.getElementById('previewTitle').textContent = title;
  document.getElementById('previewCategory').textContent = topCat + (subCat ? ' › ' + subCat : '');
  document.getElementById('previewTags').textContent = tags.length > 0 ? tags.join(', ') : 'Belum ada tag';
  document.getElementById('previewExcerpt').textContent = excerpt;
  document.getElementById('previewContent').innerHTML = body || '<p class="text-gray-400">Belum ada konten...</p>';

  // modal preview fields
  document.getElementById('modalPreviewTitle').textContent = title;
  document.getElementById('modalPreviewCategory').textContent = topCat + (subCat ? ' › ' + subCat : '');
  document.getElementById('modalPreviewTags').textContent = tags.length > 0 ? tags.join(', ') : 'Belum ada tag';
  document.getElementById('modalPreviewExcerpt').textContent = excerpt;
  document.getElementById('modalPreviewContent').innerHTML = body || '<p class="text-gray-400">Belum ada konten...</p>';

  const cover = uploadedImages.find(i => i.cover) || uploadedImages[0];
  const heroImg = document.getElementById('modalPreviewHero');
  const heroImgTop = document.getElementById('previewHero');
  if (cover) {
    heroImg.src = cover.dataUrl; heroImg.classList.remove('hidden');
    heroImgTop.src = cover.dataUrl; heroImgTop.classList.remove('hidden');
  } else {
    heroImg.classList.add('hidden'); heroImgTop.classList.add('hidden');
  }

  document.getElementById('previewModal').classList.remove('hidden');
  document.getElementById('previewModal').classList.add('flex');
}

function closePreview() {
  document.getElementById('previewModal').classList.add('hidden');
  document.getElementById('previewModal').classList.remove('flex');
}

/* ========== Save & Publish ========== */
document.getElementById('saveDraft').addEventListener('click', saveDraft);
document.getElementById('publishBtn').addEventListener('click', publishArticle);

function saveDraft() {
  const draft = {
    top_category: topCategoryEl.value,
    subcategory: subcatEl.value,
    title: titleEl.value,
    slug: slugEl.value,
    excerpt: excerptEl.value,
    tags: tags,
    body: editorInstance ? editorInstance.getData() : '',
    images: uploadedImages
  };
  localStorage.setItem('artikel_draft', JSON.stringify(draft));
  showToast('Draft berhasil disimpan!', 'success');
}

function publishArticle() {
  if (!validateForm()) return;
  statusField.value = 'published';
  document.getElementById('bodyField').value = editorInstance ? editorInstance.getData() : '';
  syncImagesMeta();
  document.getElementById('articleForm').submit();
}

function validateForm() {
  if (!topCategoryEl.value) { alert('Kategori utama wajib diisi!'); topCategoryEl.focus(); return false; }
  if (!subcatEl.value) { alert('Sub kategori wajib diisi!'); subcatEl.focus(); return false; }
  if (!titleEl.value.trim()) { alert('Judul artikel wajib diisi!'); titleEl.focus(); return false; }
  if (!slugEl.value.trim()) { alert('Slug URL wajib diisi!'); slugEl.focus(); return false; }
  const body = editorInstance ? editorInstance.getData() : '';
  if (!body || stripHtml(body).trim().length < 50) { alert('Konten artikel terlalu pendek! Minimal 50 karakter.'); return false; }
  return true;
}

/* ========== Progress (visual) ========== */
function updateProgress() {
  const steps = document.querySelectorAll('.step-indicator');
  const progressBars = document.querySelectorAll('.flex-1.h-1 > div');

  if (topCategoryEl.value && subcatEl.value) {
    if (steps[0]) steps[0].classList.add('completed');
    if (progressBars[0]) progressBars[0].style.width = '100%';
    if (steps[1]) steps[1].classList.add('active');
  }
  if (titleEl.value && slugEl.value && excerptEl.value) {
    if (steps[1]) steps[1].classList.add('completed');
    if (progressBars[1]) progressBars[1].style.width = '100%';
    if (steps[2]) steps[2].classList.add('active');
  }
  const body = editorInstance ? editorInstance.getData() : '';
  if (body && stripHtml(body).trim().length > 50) {
    if (steps[2]) steps[2].classList.add('completed');
    if (progressBars[2]) progressBars[2].style.width = '100%';
    if (steps[3]) steps[3].classList.add('active');
  }
  if (uploadedImages.length > 0) {
    if (steps[3]) steps[3].classList.add('completed');
  }
}

/* ========== Toast ========= */
function showToast(message, type='success') {
  const toast = document.getElementById('successToast');
  const toastMessage = document.getElementById('toastMessage');
  const toastBg = toast.querySelector('div');

  toastMessage.textContent = message;
  if (type === 'error') {
    toastBg.className = 'bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4';
  } else {
    toastBg.className = 'bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4';
  }
  toast.classList.remove('hidden');
  setTimeout(() => toast.classList.add('hidden'), 3000);
}

/* ========== Fullscreen Editor ========= */
document.getElementById('fullscreenBtn').addEventListener('click', () => {
  if (!editorInstance) return;
  const editable = editorInstance.ui.view.editable.element;
  const toolbar = document.querySelector('.ck-toolbar');
  if (!editable.classList.contains('fullscreen-mode')) {
    editable.classList.add('fullscreen-mode');
    editable.style.position = 'fixed'; editable.style.inset = '80px 20px 20px 20px'; editable.style.zIndex = '9999'; editable.style.background = '#fff';
    if (toolbar) { toolbar.style.position = 'fixed'; toolbar.style.top = '20px'; toolbar.style.left = '20px'; toolbar.style.right = '20px'; toolbar.style.zIndex = '10000'; }
    document.getElementById('fullscreenBtn').innerHTML = '<i class="fas fa-compress"></i>';
  } else {
    editable.classList.remove('fullscreen-mode');
    editable.style.position = ''; editable.style.inset = ''; editable.style.zIndex = '';
    if (toolbar) { toolbar.style.position = ''; toolbar.style.top = ''; toolbar.style.left = ''; toolbar.style.right = ''; toolbar.style.zIndex = ''; }
    document.getElementById('fullscreenBtn').innerHTML = '<i class="fas fa-expand"></i>';
  }
});

/* ========== Load Draft on Page Load ========== */
window.addEventListener('DOMContentLoaded', () => {
  const raw = localStorage.getItem('artikel_draft');
  if (raw) {
    try {
      const draft = JSON.parse(raw);
      if (draft.top_category) {
        topCategoryEl.value = draft.top_category;
        topCategoryEl.dispatchEvent(new Event('change'));
        setTimeout(() => { if (draft.subcategory) { subcatEl.value = draft.subcategory; subcatEl.dispatchEvent(new Event('change')); } }, 100);
      }
      if (draft.title) titleEl.value = draft.title;
      if (draft.slug) slugEl.value = draft.slug;
      if (draft.excerpt) excerptEl.value = draft.excerpt;
      if (draft.tags) { tags = draft.tags; renderTags(); }
      if (draft.images) { uploadedImages = draft.images; renderThumbs(); syncImagesMeta(); }
      updateProgress();
    } catch (e) {
      console.warn('Tidak dapat memuat draft:', e);
    }
  }
});
</script>
@endsection
