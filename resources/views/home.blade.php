@extends('layouts.app')

@section('title', 'Beranda | Jejak Layar')

@section('content')

<!-- 🔹 Hero Section -->
<section class="text-center py-16 bg-white">
    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-4">
        Jelajahi Budaya & Sejarah Melayu Bengkalis
    </h1>
    <p class="text-gray-600 mb-8">
        Temukan kisah, tradisi, dan arsip — belajar sejarah jadi asyik.
    </p>

    <div class="space-x-4">
        <a href="{{ route('budaya') }}" class="btn-primary bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg shadow-md">
            Jelajahi Budaya
        </a>
        <a href="{{ route('pustaka') }}" class="btn-secondary bg-white border border-yellow-500 text-yellow-600 px-6 py-3 rounded-lg shadow-md hover:bg-yellow-100">
            Masuk Pustaka
        </a>
    </div>

    
</section>

<!-- 🔹 Koleksi -->
<section class="py-16 bg-gray-100 text-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Jelajahi Koleksi</h2>

    <div class="grid md:grid-cols-3 gap-8 px-6 md:px-20">
        <div class="bg-white rounded-lg shadow-md p-6">
            <span class="text-4xl">🎭</span>
            <h3 class="text-xl font-semibold mt-3">Budaya</h3>
            <p class="text-gray-600 mt-2">Musik, tarian, pakaian adat, dan tradisi hidup yang memperkaya identitas Melayu.</p>
            <a href="{{ route('budaya') }}" class="mt-4 inline-block text-yellow-600 font-medium hover:underline">Lihat Budaya →</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <span class="text-4xl">📚</span>
            <h3 class="text-xl font-semibold mt-3">Pustaka Digital</h3>
            <p class="text-gray-600 mt-2">Koleksi naskah, artikel, dan dokumen untuk belajar mendalam.</p>
            <a href="{{ route('pustaka') }}" class="mt-4 inline-block text-yellow-600 font-medium hover:underline">Masuk Pustaka →</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <span class="text-4xl">🗣️</span>
            <h3 class="text-xl font-semibold mt-3">Cerita rakyat</h3>
            <p class="text-gray-600 mt-2">Cerita rakyat dan media interaktif yang membuat belajar lebih seru.</p>
            <a href="#" class="mt-4 inline-block text-yellow-600 font-medium hover:underline">Baca Cerita →</a>
        </div>
    </div>
</section>

<!-- 🔹 Tentang -->
<section class="text-center py-12 bg-white">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Kenapa Jejak Layar?</h2>
    <p class="text-gray-600 max-w-2xl mx-auto">
        Kami mengumpulkan sumber lokal, arsip visual, dan cerita lisan untuk menjadi perpustakaan digital yang mudah diakses.
    </p>
</section>

<!-- 🔹 Tim -->
<section class="py-10 text-center bg-cover bg-center" 
         style="background-image: url('{{ asset('images/bg-jejaklayar.jpg') }}');">
    <h2 class="text-2xl font-bold text-gray-800 mb-3">Our Team</h2>
    <p class="italic text-gray-700 mb-8">
        “Menjaga Warisan dan Budaya, Mendekatkan Generasi Muda dengan Sejarahnya”
    </p>

    <div class="grid sm:grid-cols-3 gap-1 px-2 md:px-10 justify-center">
        <div class="bg-yellow-100/80 rounded-2xl shadow-md p-2 flex flex-col items-center w-55 mx-auto">
            <img src="{{ asset('images/team1.jpg') }}" 
                 alt="Irfan Iswandi" 
                 class="h-44 w-auto rounded-xl object-contain mx-auto">
            <p class="font-semibold text-gray-900 mt-2 text-base">Irfan Iswandi</p>
        </div>

        <div class="bg-yellow-100/80 rounded-2xl shadow-md p-2 flex flex-col items-center w-55 mx-auto">
            <img src="{{ asset('images/team2.jpg') }}" 
                 alt="Masnidar Akmi" 
                 class="h-44 w-auto rounded-xl object-contain mx-auto">
            <p class="font-semibold text-gray-900 mt-2 text-base">Masnidar Akmi</p>
        </div>

        <div class="bg-yellow-100/80 rounded-2xl shadow-md p-2 flex flex-col items-center w-55 mx-auto">
            <img src="{{ asset('images/team3.jpg') }}" 
                 alt="Natasya" 
                 class="h-44 w-auto rounded-xl object-contain mx-auto">
            <p class="font-semibold text-gray-900 mt-2 text-base">Natasya</p>
        </div>
    </div>
</section>


@endsection
