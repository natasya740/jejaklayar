{{-- resources/views/articles/create.blade.php --}}
@extends('layouts.dashboard_kontributor') {{-- ganti layout jika beda --}}

@section('title','Buat Artikel Baru')

@section('content')
<div class="max-w-7xl mx-auto p-6">
  <div class="bg-white shadow rounded-lg overflow-hidden grid grid-cols-12">
    {{-- kiri: form --}}
    <div class="col-span-5 p-6 border-r">
      <h2 class="text-2xl font-bold mb-4">Buat Artikel Baru</h2>

      <form id="articleForm" action="#" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Judul --}}
        <label class="block text-sm font-medium text-gray-700">Judul</label>
        <input id="title" name="title" type="text" class="mt-2 w-full p-3 border rounded" placeholder="Masukkan judul..." required>

        {{-- Slug --}}
        <label class="block text-sm font-medium text-gray-700 mt-4">Slug</label>
        <input id="slug" name="slug" type="text" class="mt-2 w-full p-2 border rounded text-sm" placeholder="slug-otomatis-atau-edit" required>

        {{-- Kategori & Subkategori --}}
        <div class="flex gap-3 mt-4">
          <div class="w-1/2">
            <label class="text-sm font-medium">Kategori</label>
            <select id="category" name="category" class="mt-2 w-full p-2 border rounded">
              <option value="">-- Pilih Kategori --</option>
              {{-- contoh statik. Ganti dengan loop dari backend --}}
              <option value="Sejarah">Sejarah</option>
              <option value="Seni & Budaya">Seni & Budaya</option>
              <option value="Arsitektur">Arsitektur</option>
            </select>
          </div>
          <div class="w-1/2">
            <label class="text-sm font-medium">Sub Kategori</label>
            <select id="subcategory" name="subcategory" class="mt-2 w-full p-2 border rounded">
              <option value="">-- Pilih Subkategori --</option>
            </select>
          </div>
        </div>

        {{-- Tags --}}
        <label class="block text-sm font-medium text-gray-700 mt-4">Tags</label>
        <div class="mt-2 flex gap-2 flex-wrap items-center" id="tagContainer">
          <input id="tagInput" type="text" class="p-2 rounded border" placeholder="Tuliskan tag lalu Enter" />
        </div>
        <input type="hidden" id="tagsField" name="tags" value="">

        {{-- Gambar upload --}}
        <label class="block text-sm font-medium text-gray-700 mt-4">Gambar (pilih beberapa)</label>
        <div class="mt-2 p-3 border-dashed border rounded text-sm">
          <input id="imageFiles" type="file" accept="image/*" multiple class="hidden">
          <button type="button" id="pickImages" class="px-4 py-2 bg-amber-600 text-white rounded">Pilih / Upload</button>
          <p class="text-xs text-gray-500 mt-2">Preview & compress otomatis, klik image untuk masukkan ke konten. Pilih salah satu sebagai cover.</p>

          <div id="thumbs" class="grid grid-cols-3 gap-3 mt-3"></div>
        </div>

        {{-- Buttons --}}
        <div class="mt-6 flex gap-2">
          <button id="saveDraft" type="button" class="px-4 py-2 bg-gray-100 rounded border">Simpan Draft</button>
          <button id="publish" type="button" class="px-4 py-2 bg-amber-600 text-white rounded">Terbitkan</button>
        </div>

        {{-- hidden input untuk konten HTML --}}
        <input type="hidden" id="bodyField" name="body">
        <input type="hidden" id="coverImage" name="cover_image">
      </form>
    </div>

    {{-- kanan: editor & preview --}}
    <div class="col-span-7 p-6">
      <div class="flex items-center justify-between mb-4">
        <div class="flex gap-2 items-center">
          <button type="button" class="px-3 py-2 border rounded" onclick="exec('bold')"><strong>B</strong></button>
          <button type="button" class="px-3 py-2 border rounded" onclick="exec('italic')"><em>I</em></button>
          <button type="button" class="px-3 py-2 border rounded" onclick="exec('underline')"><u>U</u></button>
          <button type="button" class="px-3 py-2 border rounded" onclick="insertLink()">Link</button>
          <button type="button" class="px-3 py-2 border rounded" onclick="document.getElementById('imageFiles').click()">Gambar</button>
        </div>

        <div class="text-sm text-gray-500">Status: <strong id="statusLabel">Draft</strong></div>
      </div>

      <div id="editor" contenteditable="true" class="min-h-[420px] p-4 border rounded prose" style="outline:none;">
        <h2>Mulai menulis...</h2>
        <p></p>
      </div>

      <div class="mt-6">
        <label class="block text-sm font-medium text-gray-700">Preview</label>
        <div id="preview" class="mt-3 p-4 border rounded bg-white">
          <h1 id="previewTitle" class="text-2xl font-bold mb-2">Judul Artikel</h1>
          <div id="previewBody" class="prose"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="text-xs text-gray-400 mt-3">Placeholder image (contoh): <code>/mnt/data/b2891f9d-6a0d-427e-84de-628e14e34475.png</code></div>
</div>

{{-- Styles minimal (tailwind assumed), jika belum pakai tailwind, sesuaikan CSS --}}
@endsection

@section('scripts')
<script>
/* ========== kategori -> subkategori statik contoh ========== */
const subcats = {
  "Sejarah": ["Perang & Konflik","Periode Kolonial","Tokoh"],
  "Seni & Budaya": ["Tari","Musik","Pakaian"],
  "Arsitektur": ["Rumah Adat","Candi","Kota"]
};
const categoryEl = document.getElementById('category');
const subcatEl = document.getElementById('subcategory');
categoryEl?.addEventListener('change', e => {
  const val = e.target.value;
  subcatEl.innerHTML = '<option value=\"\">-- Pilih Subkategori --</option>';
  if (subcats[val]) {
    for (const s of subcats[val]) {
      const opt = document.createElement('option'); opt.value = s; opt.textContent = s;
      subcatEl.appendChild(opt);
    }
  }
});

/* ========== slug otomatis ========== */
const titleEl = document.getElementById('title');
const slugEl = document.getElementById('slug');
titleEl?.addEventListener('input', e => {
  const v = e.target.value;
  slugEl.value = slugify(v);
  document.getElementById('previewTitle').textContent = v || 'Judul Artikel';
});
function slugify(text){ return text.toString().normalize('NFKD').toLowerCase().trim().replace(/\s+/g,'-').replace(/[^a-z0-9\-]/g,'').replace(/\-+/g,'-'); }

/* ========== tags chips ========== */
const tagInput = document.getElementById('tagInput');
const tagContainer = document.getElementById('tagContainer');
const tagsField = document.getElementById('tagsField');
let tags = [];
tagInput?.addEventListener('keydown', e => {
  if (e.key === 'Enter') {
    e.preventDefault();
    addTag(tagInput.value);
  }
});
function addTag(v){
  v = v.trim(); if(!v) return;
  if (!tags.includes(v)) {
    tags.push(v);
    renderTags();
  }
  tagInput.value='';
}
function removeTag(idx){
  tags.splice(idx,1); renderTags();
}
function renderTags(){
  tagContainer.innerHTML = '';
  for (let i=0;i<tags.length;i++){
    const span = document.createElement('span');
    span.className = 'bg-amber-100 text-amber-700 px-3 py-1 rounded-full flex items-center gap-2 text-sm';
    span.innerHTML = `${tags[i]} <button onclick="removeTag(${i})" class="ml-1 text-amber-600">✕</button>`;
    tagContainer.appendChild(span);
  }
  tagContainer.appendChild(tagInput);
  tagsField.value = tags.join(',');
}

/* ========== image upload, preview + compress via canvas ========== */
const pickBtn = document.getElementById('pickImages');
const fileInput = document.getElementById('imageFiles');
const thumbs = document.getElementById('thumbs');
const coverImage = document.getElementById('coverImage');
let uploadedImages = []; // {id, dataUrl, sizeKB, cover}

pickBtn?.addEventListener('click', ()=> fileInput.click());
fileInput?.addEventListener('change', async (e)=>{
  const files = Array.from(e.target.files || []);
  for (const f of files) {
    const dataUrl = await readFileAsDataURL(f);
    const resized = await resizeDataUrl(dataUrl, 1200, 0.8);
    const id = Date.now() + Math.random();
    uploadedImages.push({ id, dataUrl: resized.dataUrl, sizeKB: Math.round(resized.size/1024), cover: uploadedImages.length === 0 });
    renderThumbs();
  }
  // clear input
  fileInput.value = '';
});

function readFileAsDataURL(file){ return new Promise(res => { const r = new FileReader(); r.onload = e=>res(e.target.result); r.readAsDataURL(file); }); }
function resizeDataUrl(dataUrl, maxWidth=1200, quality=0.8){
  return new Promise(res=>{
    const img = new Image();
    img.onload = ()=>{
      const scale = Math.min(1, maxWidth / img.width);
      const w = Math.round(img.width * scale);
      const h = Math.round(img.height * scale);
      const canvas = document.createElement('canvas'); canvas.width = w; canvas.height = h;
      const ctx = canvas.getContext('2d'); ctx.drawImage(img,0,0,w,h);
      canvas.toBlob(blob=>{
        const reader = new FileReader();
        reader.onload = ()=> res({ dataUrl: reader.result, size: blob.size });
        reader.readAsDataURL(blob);
      }, 'image/jpeg', quality);
    };
    img.src = dataUrl;
  });
}

function renderThumbs(){
  thumbs.innerHTML = '';
  for (const img of uploadedImages){
    const wrapper = document.createElement('div');
    wrapper.className = 'relative border rounded overflow-hidden';
    wrapper.innerHTML = `
      <img src="${img.dataUrl}" class="w-full h-28 object-cover cursor-pointer" onclick="insertImageToEditor('${img.dataUrl}')">
      <div class="absolute top-2 right-2 flex gap-1">
        <button onclick="setCoverImage('${img.id}')" class="px-2 py-1 text-xs rounded ${img.cover? 'bg-amber-600 text-white': 'bg-white text-gray-700'}">Cover</button>
        <button onclick="removeUploadedImage('${img.id}')" class="px-2 py-1 bg-white text-red-600 rounded">Hapus</button>
      </div>
      <div class="p-2 text-xs text-gray-600">${img.sizeKB} KB</div>
    `;
    thumbs.appendChild(wrapper);
  }
  // update hidden cover if set
  const cov = uploadedImages.find(i=>i.cover);
  coverImage.value = cov ? cov.dataUrl : '';
}

/* image helpers */
function setCoverImage(id){
  uploadedImages = uploadedImages.map(i=> ({ ...i, cover: i.id==id }));
  renderThumbs();
}
function removeUploadedImage(id){
  uploadedImages = uploadedImages.filter(i=> i.id != id);
  renderThumbs();
}

/* insert image to editor at caret */
function insertImageToEditor(src){
  const editor = document.getElementById('editor');
  editor.focus();
  const sel = window.getSelection();
  if (!sel || sel.rangeCount===0){
    editor.insertAdjacentHTML('beforeend', `<p><img src="${src}" class="max-w-full rounded"></p>`);
    updatePreview();
    return;
  }
  const range = sel.getRangeAt(0);
  const imgNode = document.createElement('img'); imgNode.src = src; imgNode.className='max-w-full rounded';
  range.insertNode(imgNode);
  range.setStartAfter(imgNode);
  range.collapse(true);
  sel.removeAllRanges(); sel.addRange(range);
  updatePreview();
}

/* editor command wrappers */
function exec(command, val=null){ document.execCommand(command,false,val); updatePreview(); }
function insertLink(){ const url = prompt('Masukkan URL (https://...)'); if(!url) return; exec('createLink', url); }

/* updatePreview */
const editorEl = document.getElementById('editor');
editorEl?.addEventListener('input', ()=> updatePreview());
function updatePreview(){
  document.getElementById('previewBody').innerHTML = editorEl.innerHTML;
  document.getElementById('bodyField').value = editorEl.innerHTML;
}

/* save draft / publish (AJAX examples) */
document.getElementById('saveDraft')?.addEventListener('click', ()=> submitArticle('draft'));
document.getElementById('publish')?.addEventListener('click', ()=> submitArticle('publish'));

async function submitArticle(mode){
  updatePreview();
  const formData = new FormData();
  formData.append('title', document.getElementById('title').value);
  formData.append('slug', document.getElementById('slug').value);
  formData.append('category', document.getElementById('category').value);
  formData.append('subcategory', document.getElementById('subcategory').value);
  formData.append('tags', document.getElementById('tagsField').value);
  formData.append('body', document.getElementById('bodyField').value);
  formData.append('mode', mode);
  // images: append dataUrls as files (optional: send raw blobs)
  uploadedImages.forEach((img, idx) => {
    // convert dataUrl to blob
    const blob = dataURLtoBlob(img.dataUrl);
    formData.append('images[]', blob, `img_${idx}.jpg`);
    if (img.cover) formData.append('cover_index', idx);
  });

  // example: POST to /articles/store (ganti sesuai)
  const token = document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content') || '{{ csrf_token() }}';
  const resp = await fetch('{{ url('/articles/store') }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': token },
    body: formData
  });

  if (!resp.ok){
    alert('Gagal menyimpan — periksa console / network.');
    console.error(await resp.text());
    return;
  }
  const data = await resp.json();
  if (data.success) {
    document.getElementById('statusLabel').textContent = mode === 'publish' ? 'Published' : 'Draft';
    alert('Sukses: ' + (data.message || 'Disimpan'));
    if (mode==='publish' && data.redirect) window.location.href = data.redirect;
  } else {
    alert('Terjadi masalah: ' + (data.message || 'unknown'));
  }
}

/* helpers */
function dataURLtoBlob(dataurl) {
  var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
      bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
  while(n--){ u8arr[n] = bstr.charCodeAt(n); }
  return new Blob([u8arr], {type:mime});
}
</script>
@endsection
