<!-- Kategori utama -->
<select id="select-kategori" name="category_id" class="w-full p-2">
  <option value="">Pilih Kategori</option>
  @foreach($roots as $r)
    <option value="{{ $r->id }}">{{ $r->name }}</option>
  @endforeach
</select>

<!-- Subkategori dynamic -->
<select id="select-subkategori" name="subcategory_id" class="w-full p-2 mt-2" style="display:none;">
  <option value="">Pilih Subkategori</option>
</select>

<!-- Sub-Sub -->
<select id="select-subsub" name="subsub_id" class="w-full p-2 mt-2" style="display:none;">
  <option value="">Pilih bagian lebih spesifik</option>
</select>

<!-- Preview path -->
<div id="kategori-path" class="mt-2 text-sm text-gray-600"></div>

<!-- Tags (typeahead + chips) -->
<input id="tag-input" type="text" placeholder="Ketik tag dan tekan Enter" class="w-full p-2 mt-3" />
<div id="selected-tags" class="mt-2"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const apiBase = '/api/kategori'; // /api/kategori/{kategori}/subkategori

  const selRoot = document.getElementById('select-kategori');
  const selSub = document.getElementById('select-subkategori');
  const selSubSub = document.getElementById('select-subsub');
  const pathDiv = document.getElementById('kategori-path');

  const tagInput = document.getElementById('tag-input');
  const selectedTags = document.getElementById('selected-tags');
  let tags = [];

  function renderTags() {
    selectedTags.innerHTML = '';
    tags.forEach((t,i) => {
      const chip = document.createElement('span');
      chip.className = 'inline-block bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full mr-2 mb-2 text-sm';
      chip.innerHTML = `${t} <a href="#" data-i="${i}" class="ml-2 text-xs text-gray-500 remove-tag">x</a>`;
      selectedTags.appendChild(chip);
    });
  }

  selectedTags.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-tag')) {
      e.preventDefault();
      const i = parseInt(e.target.dataset.i, 10);
      tags.splice(i,1);
      renderTags();
    }
  });

  tagInput.addEventListener('keydown', function(e){
    if (e.key === 'Enter' && tagInput.value.trim()) {
      e.preventDefault();
      tags.push(tagInput.value.trim());
      tagInput.value = '';
      renderTags();
    }
  });

  selRoot.addEventListener('change', function(){
    const id = this.value;
    selSub.style.display = 'none'; selSub.innerHTML = '<option value=\"\">Pilih Subkategori</option>';
    selSubSub.style.display = 'none'; selSubSub.innerHTML = '<option value=\"\">Pilih bagian lebih spesifik</option>';
    pathDiv.textContent = '';

    if (!id) return;

    fetch(`${apiBase}/${id}/subkategori`).then(r=>r.json()).then(data=>{
      if (Array.isArray(data) && data.length) {
        selSub.style.display = 'block';
        data.forEach(c => {
          const opt = document.createElement('option'); opt.value = c.id; opt.textContent = c.name;
          selSub.appendChild(opt);
        });
      }
    });

    // update path display
    const rootText = selRoot.options[selRoot.selectedIndex].text;
    pathDiv.textContent = `Kategori: ${rootText}`;
  });

  selSub.addEventListener('change', function(){
    const id = this.value;
    selSubSub.style.display = 'none'; selSubSub.innerHTML = '<option value=\"\">Pilih bagian lebih spesifik</option>';
    if (!id) return;

    fetch(`${apiBase}/${id}/subkategori`).then(r=>r.json()).then(data=>{
      if (Array.isArray(data) && data.length) {
        selSubSub.style.display = 'block';
        data.forEach(c => {
          const opt = document.createElement('option'); opt.value = c.id; opt.textContent = c.name;
          selSubSub.appendChild(opt);
        });
      }
    });

    const rootText = selRoot.options[selRoot.selectedIndex].text;
    const subText = selSub.options[selSub.selectedIndex].text;
    pathDiv.textContent = `Kategori: ${rootText} › ${subText}`;
  });

  selSubSub.addEventListener('change', function(){
    const rootText = selRoot.options[selRoot.selectedIndex].text;
    const subText = selSub.options[selSub.selectedIndex].text;
    const subsubText = selSubSub.options[selSubSub.selectedIndex].text;
    pathDiv.textContent = `Kategori: ${rootText} › ${subText} › ${subsubText}`;
  });
});
</script>
