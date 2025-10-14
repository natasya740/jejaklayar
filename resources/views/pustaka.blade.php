@extends('layouts.app')

@section('title', 'Pustaka Digital Jejak Layar')

@section('content')

<!-- 🔸 Header -->
<section class="bg-yellow-300 py-16 text-center">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">
            Pustaka Digital <span class="text-yellow-900">Jejak Layar</span>
        </h1>
        <p class="text-gray-700 max-w-2xl mx-auto">
            Temukan arsip budaya Melayu dalam bentuk cerita rakyat, kamus, dokumen, dan referensi modern.
        </p>
    </div>
</section>

<!-- 🔸 Filter Tombol -->
<section class="py-6 bg-white shadow-sm">
    <div class="container mx-auto px-6 text-center">
        <div id="filterButtons" class="flex justify-center gap-3 flex-wrap">
            <button id="btn-cerita" 
                    class="filter-btn active px-5 py-2 rounded-full font-semibold border border-yellow-400 bg-yellow-400 text-white transition">
                Cerita Rakyat
            </button>
            <button id="btn-kamus2" 
                    class="filter-btn px-5 py-2 rounded-full font-semibold border border-gray-400 text-gray-700 hover:bg-gray-100 transition">
                Kamus Melayu
            </button>
            <button id="btn-sejarah" 
                    class="filter-btn px-5 py-2 rounded-full font-semibold border border-gray-400 text-gray-700 hover:bg-gray-100 transition">
                Sejarah
            </button>
        </div>
    </div>
</section>

<!-- 🔸 Konten Pustaka -->
<section class="bg-gray-100 py-12">
    <div class="container mx-auto px-6">

        <!-- Cerita Rakyat -->
        <div id="cerita-section" class="tab-content">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Cerita Rakyat</h2>
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-6">
                <div class="bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition">
                    <img src="{{ asset('images/cerita1.jpg') }}" class="rounded-lg mb-3 h-40 w-full object-cover" alt="Cerita Rakyat">
                    <h3 class="font-bold text-gray-800">Legenda Putri Tujuh</h3>
                    <p class="text-sm text-gray-600 mt-1">Asal-usul legenda terkenal di Bengkalis...</p>
                </div>

                <div class="bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition">
                    <img src="{{ asset('images/cerita2.jpg') }}" class="rounded-lg mb-3 h-40 w-full object-cover" alt="Cerita Rakyat">
                    <h3 class="font-bold text-gray-800">Si Lancang dan Kapalnya</h3>
                    <p class="text-sm text-gray-600 mt-1">Kisah rakyat yang sarat makna tentang kesetiaan...</p>
                </div>

                <div class="bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition">
                    <img src="{{ asset('images/cerita3.jpg') }}" class="rounded-lg mb-3 h-40 w-full object-cover" alt="Cerita Rakyat">
                    <h3 class="font-bold text-gray-800">Asal Usul Sungai Jantan</h3>
                    <p class="text-sm text-gray-600 mt-1">Cerita rakyat tentang asal mula nama sungai...</p>
                </div>
            </div>
        </div>

        <!-- Kamus Melayu -->
        <div id="kamus-section" class="tab-content hidden">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Kamus Bahasa Melayu</h2>
            <div class="flex flex-wrap gap-2 mb-6 justify-center">
                @foreach(range('A','Z') as $letter)
                    <button class="bg-yellow-300 hover:bg-yellow-400 text-gray-800 font-semibold px-3 py-1 rounded">
                        {{ $letter }}
                    </button>
                @endforeach
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4 shadow">
                    <h4 class="font-bold text-gray-800">Akar</h4>
                    <p class="text-sm text-gray-600">Makna: bagian tumbuhan yang berada di bawah tanah.</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow">
                    <h4 class="font-bold text-gray-800">Balai</h4>
                    <p class="text-sm text-gray-600">Makna: tempat berkumpul masyarakat dalam acara adat.</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow">
                    <h4 class="font-bold text-gray-800">Cempaka</h4>
                    <p class="text-sm text-gray-600">Makna: bunga harum yang digunakan dalam adat Melayu.</p>
                </div>
            </div>
        </div>

        <!-- Sejarah -->
        <div id="sejarah-section" class="tab-content hidden">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Sejarah Melayu Bengkalis</h2>
            <div class="space-y-4">
                <div class="bg-white rounded-lg p-4 shadow-md">
                    <h3 class="font-bold text-gray-900">Masa Kerajaan Siak</h3>
                    <p class="text-sm text-gray-700 mt-1">Kerajaan Siak memiliki pengaruh besar terhadap budaya Melayu di Bengkalis...</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-md">
                    <h3 class="font-bold text-gray-900">Kolonial Belanda</h3>
                    <p class="text-sm text-gray-700 mt-1">Periode kolonial membawa perubahan besar dalam sistem adat dan pemerintahan...</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-md">
                    <h3 class="font-bold text-gray-900">Bengkalis Modern</h3>
                    <p class="text-sm text-gray-700 mt-1">Transformasi budaya ke era digital melalui portal Jejak Layar...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🔸 Script -->
<script>
    const buttons = document.querySelectorAll('.filter-btn');
    const sections = {
        cerita: document.getElementById('cerita-section'),
        kamus: document.getElementById('kamus-section'),
        sejarah: document.getElementById('sejarah-section')
    };

    function showSection(name) {
        Object.values(sections).forEach(sec => sec.classList.add('hidden'));
        sections[name].classList.remove('hidden');
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('bg-yellow-400', 'text-white', 'border-yellow-400'));
            btn.classList.add('bg-yellow-400', 'text-white', 'border-yellow-400');

            if (btn.id.includes('cerita')) showSection('cerita');
            if (btn.id.includes('kamus')) showSection('kamus');
            if (btn.id.includes('sejarah')) showSection('sejarah');
        });
    });
</script>

@endsection
