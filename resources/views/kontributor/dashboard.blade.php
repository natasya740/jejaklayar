@extends('layouts.dashboard_kontributor') <!-- Panggil Layout Utama -->

@section('title', 'Dashboard Kontributor')

@section('content')
{{-- Modernized Kontributor Dashboard — Yellow accents, micro-animations --}}

<style>
  /* small component-specific styles (optional: move to app.css) */
  .row-hover { transition: transform .16s ease, box-shadow .16s ease; }
  .row-hover:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(2,6,23,0.06); }

  /* simple shimmer for hero (can be removed) */
  @keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
  }
  .shimmer {
    background: linear-gradient(90deg, rgba(244,180,0,0.06) 0%, rgba(255,255,255,0.8) 50%, rgba(244,180,0,0.06) 100%);
    background-size: 200% 100%;
    animation: shimmer 2.2s linear infinite;
  }
</style>

<div class="space-y-6">

  <!-- HERO -->
  <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div class="space-y-2">
      <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Halo, {{ Auth::user()->name }} <span class="inline-block">👋</span></h2>
      <p class="text-sm text-gray-500">Selamat datang kembali di panel penulis. Kelola artikel Anda di sini.</p>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('kontributor.artikel.create') }}"
      class="inline-flex items-center gap-2 px-4 py-2 rounded-lg shadow-sm 
          bg-gradient-to-r from-yellow-400 to-yellow-500 
          text-[#071027] font-semibold 
          focus:ring-4 focus:ring-yellow-200 
          hover:-translate-y-1 transition">
     Tambah Artikel
     </a>

        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="#071027" stroke-width="1.6"><path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span class="text-sm">Tulis Artikel Baru</span>
      </a>
      <a href="{{ route('kontributor.artikel.index') }}" class="text-sm text-gray-600 hover:underline hidden md:inline">Lihat Semua Artikel</a>

    </div>
  </div>

  <!-- STATISTICS -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <!-- Total Artikel -->
    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-yellow-400 stat-card">
      <div class="flex items-center justify-between gap-4">
        <div>
          <p class="text-xs text-gray-500 font-semibold">Total Artikel</p>
          <div id="total-articles" class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $artikels->count() }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-yellow-50 flex items-center justify-center">
          <i class="fas fa-newspaper text-yellow-600 text-lg"></i>
        </div>
      </div>
      <p class="mt-3 text-xs text-gray-400">Semua artikel yang kamu kirim (draft, pending, atau published).</p>
    </div>

    <!-- Published -->
    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-yellow-400 stat-card">
      <div class="flex items-center justify-between gap-4">
        <div>
          <p class="text-xs text-gray-500 font-semibold">Tayang / Published</p>
          <div class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $published_count ?? 0 }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-yellow-50 flex items-center justify-center">
          <i class="fas fa-check-circle text-yellow-600 text-lg"></i>
        </div>
      </div>
      <p class="mt-3 text-xs text-gray-400">Artikel yang sudah dipublikasikan oleh admin.</p>
    </div>

    <!-- Pending -->
    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-yellow-400 stat-card">
      <div class="flex items-center justify-between gap-4">
        <div>
          <p class="text-xs text-gray-500 font-semibold">Menunggu Validasi</p>
          <div class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $pending_count ?? 0 }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-yellow-50 flex items-center justify-center">
          <i class="fas fa-hourglass text-yellow-600 text-lg"></i>
        </div>
      </div>
      <p class="mt-3 text-xs text-gray-400">Artikel yang belum divalidasi oleh admin.</p>
    </div>
  </div>

  <!-- ARTICLE LIST -->
  <div class="bg-white rounded-2xl overflow-hidden shadow-sm">
    <div class="px-6 py-4 flex items-center justify-between bg-gradient-to-r from-yellow-50 to-white border-b">
      <div class="flex items-center gap-3">
        <h3 class="font-bold text-gray-800">Artikel Terbaru</h3>
        <span class="text-sm text-gray-500">— pantau status kirimanmu</span>
      </div>
      <div>
        <a href="{{ route('kontributor.artikel.index') }}" class="text-sm text-yellow-600 hover:underline">Lihat Semua</a>

      </div>
    </div>

    <div class="p-4 space-y-3">
      @if($artikels->isEmpty())
        <div class="text-center py-6 text-gray-500">Belum ada artikel. <a href="{{ route('kontributor.artikel.create') }}" class="text-yellow-600 font-semibold">Tulis sekarang</a>

      @else
        <ul class="space-y-3">
          @foreach($artikels->take(6) as $artikel)
            <li class="row-hover bg-white rounded-xl p-4 flex items-start justify-between gap-4 border border-gray-100">
              <div class="flex items-start gap-4 min-w-0">
                <div class="w-12 h-12 rounded-lg bg-yellow-50 flex items-center justify-center text-yellow-700">
                  <i class="fas fa-file-alt"></i>
                </div>
                <div class="min-w-0">
                  <a href="{{ url('/kontributor/artikel/'.$artikel->id) }}" class="block font-semibold text-gray-900 truncate hover:text-yellow-600 transition">{{ $artikel->title }}</a>
                  <div class="text-xs text-gray-400 mt-1">{{ $artikel->category->name ?? 'Tanpa Kategori' }} • {{ $artikel->created_at->format('d M Y') }}</div>
                </div>
              </div>

              <div class="flex items-center gap-3">
                {{-- Status pill --}}
                <span class="px-3 py-1 rounded-md text-xs font-semibold
                      {{ $artikel->status == 'published' ? 'pill-green' : ($artikel->status == 'rejected' ? 'pill-red' : 'pill-yellow') }}">
                  {{ ucfirst($artikel->status) }}
                </span>

                {{-- Actions (view only, edit link points to form with edit query) --}}
                <div class="flex items-center gap-2">
                  <a href="{{ url('/kontributor/artikel/'.$artikel->id) }}" class="text-sm text-gray-500 hover:text-yellow-600 transition">Lihat</a>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>

  <!-- small tips -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="col-span-2"></div>
    <div class="bg-white rounded-xl p-4 shadow-sm">
      <h4 class="font-semibold text-gray-800">Tips Penulis</h4>
      <ul class="mt-2 text-sm text-gray-500 space-y-2">
        <li>Gunakan judul singkat & menarik.</li>
        <li>Tambahkan gambar sampul berkualitas.</li>
        <li>Periksa ejaan & tata bahasa sebelum kirim.</li>
      </ul>
    </div>
  </div>

</div>

@push('scripts')
<script>
  // simple gentle number animation for "total articles"
  document.addEventListener('DOMContentLoaded', ()=> {
    const el = document.getElementById('total-articles');
    if(!el) return;
    const end = parseInt(el.textContent) || 0;
    let current = 0;
    if (end > 0) {
      const step = Math.max(1, Math.round(end / 25));
      const timer = setInterval(()=>{
        current += step;
        if(current >= end){
          el.textContent = end;
          clearInterval(timer);
        } else {
          el.textContent = current;
        }
      }, 24);
    }
  });
</script>
@endpush

@endsection
