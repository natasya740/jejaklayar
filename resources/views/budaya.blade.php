@extends('layouts.app')

@section('title', 'Budaya Melayu Bengkalis')

@section('content')
<!-- Header Section -->
<section class="bg-yellow-300 py-16 text-center">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Budaya Melayu Bengkalis</h1>
        <p class="text-gray-700 max-w-2xl mx-auto">
            Selami kekayaan seni, adat, dan tradisi — dijaga, diceritakan, dan dipelajari bersama.
        </p>
        <button class="mt-6 bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg shadow-md">
            Jelajahi Kategori
        </button>
    </div>
</section>


<!-- Kategori Budaya -->
<section class="py-12 bg-gray-100">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-2xl font-bold mb-8 text-gray-800">Kategori Budaya</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $kategori = [
                    ['judul' => 'Seni', 'deskripsi' => 'Musik, tari (zapin), dan teater tradisional yang memikat.', 'gambar' => 'seni.jpg'],
                    ['judul' => 'Adat & Tradisi', 'deskripsi' => 'Upacara, prosesi, dan aturan adat yang mengikat komunitas.', 'gambar' => 'adat.jpg'],
                    ['judul' => 'Pakaian', 'deskripsi' => 'Busana yang melambangkan status, estetika, dan identitas.', 'gambar' => 'pakaian.jpg'],
                    ['judul' => 'Rumah Adat', 'deskripsi' => 'Arsitektur panggung yang menyimpan filosofi hidup masyarakat pesisir.', 'gambar' => 'rumah_adat.jpg'],
                    ['judul' => 'Makanan & Minuman Tradisional', 'deskripsi' => 'Resep dan hidangan yang diwariskan turun-temurun.', 'gambar' => 'makanan.jpg'],
                    ['judul' => 'Tokoh Budaya', 'deskripsi' => 'Figur yang berperan penting dalam pelestarian budaya.', 'gambar' => 'tokoh.jpg'],
                ];
            @endphp

            @foreach($kategori as $item)
                <div class="bg-cover bg-center rounded-xl shadow-lg overflow-hidden relative"
                    style="background-image: url('{{ asset('images/'.$item['gambar']) }}'); height: 220px;">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-white p-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $item['judul'] }}</h3>
                        <p class="text-sm">{{ $item['deskripsi'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Kutipan -->
<section class="bg-yellow-200 py-6 text-center">
    <p class="italic text-lg font-medium text-gray-800">
        “Di mana bumi dipijak, di situ langit dijunjung.”
    </p>
</section>

<!-- Warisan Section -->
<section class="bg-gray-200 py-12 text-center">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Warisan Melayu — Identitas Kita</h2>
    <p class="text-gray-600 max-w-xl mx-auto">
        Melestarikan masa lalu untuk masa depan yang lebih berakar.
    </p>
</section>
@endsection
