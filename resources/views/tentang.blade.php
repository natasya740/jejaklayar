@extends('layouts.app')

@section('title', 'Tentang Jejak Layar')

@section('content')

<!-- Hero Section -->
<section class="relative bg-cover bg-center flex items-center justify-center"
    style="background-image: url('{{ asset('images/bg-jejak.jpg') }}'); min-height: 75vh;">
    <div class="absolute inset-0 bg-yellow-900/50"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center px-6 pt-16">
        <h1 class="text-4xl md:text-5xl font-extrabold text-yellow-200 mb-6 drop-shadow-lg">
            Tentang Jejak Layar
        </h1>

        <p class="text-lg md:text-xl text-yellow-100 font-medium leading-relaxed drop-shadow-md">
            Jejak Layar adalah platform digital yang didedikasikan untuk mendokumentasikan,
            mengarsipkan, dan memperkenalkan kekayaan budaya dan pustaka Indonesia kepada dunia.
            Kami percaya bahwa warisan budaya adalah identitas bangsa yang harus dijaga dan diwariskan.
        </p>

        <p class="mt-6 text-yellow-300 font-semibold text-base">
            Versi Aplikasi: 1.0.0
        </p>
    </div>
</section>

<!-- Konten Utama -->
<section class="bg-yellow-50/30 w-full px-6 py-24 text-center flex flex-col items-center">
    
    <h2 class="text-3xl font-bold text-yellow-900 mb-14">
        Visi dan Misi Kami
    </h2>

    <!-- Grid Visi & Misi -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 justify-center items-stretch">

        <!-- Visi -->
        <div class="bg-white p-10 rounded-2xl shadow-md border border-yellow-200
                    hover:shadow-lg transition duration-300 w-full max-w-[400px] mx-auto text-center">
            <h3 class="text-2xl font-semibold text-yellow-800 mb-4">🌟 Visi</h3>
            <p class="text-gray-700 text-lg leading-relaxed">
                Melestarikan dan memperkenalkan budaya Melayu Bengkalis ke generasi muda dan dunia.
            </p>
        </div>

        <!-- Misi -->
        <div class="bg-white p-10 rounded-2xl shadow-md border border-yellow-200
                    hover:shadow-lg transition duration-300 w-full max-w-[400px] mx-auto text-center">
            <h3 class="text-2xl font-semibold text-yellow-800 mb-4">🎯 Misi</h3>
            <ul class="text-gray-700 text-lg leading-relaxed space-y-3 list-none">
                <li>📖 Mendokumentasikan seni, adat, dan tradisi lokal.</li>
                <li>💾 Menyediakan pustaka digital budaya Melayu Bengkalis.</li>
                <li>🎓 Mengedukasi generasi muda lewat media interaktif.</li>
            </ul>
        </div>

    </div>

    <!-- Tim Kami -->
    <div class="mt-24">
        <h2 class="text-3xl font-bold text-yellow-900 mb-8">
            Tim Kami
        </h2>
        <ul class="text-gray-800 text-lg font-medium space-y-3 list-none">
            <li>👩‍💻 Natasya</li>
            <li>👨‍💻 Irfan Iswandi</li>
            <li>👩‍💻 Masdinar Akmi</li>
        </ul>
    </div>

</section>

@endsection
