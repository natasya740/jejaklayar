@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h2 class="text-3xl font-bold text-yellow-600 mb-6">Dashboard Kontributor</h2>

    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
        <h3 class="text-xl font-semibold mb-4">Identitas Kontributor</h3>
        <p><strong>Nama:</strong> {{ session('user')->nama }}</p>
        <p><strong>Email:</strong> {{ session('user')->email }}</p>
        <p><strong>Status:</strong> Kontributor Aktif</p>
    </div>

    <div class="mt-10">
        <h3 class="text-xl font-semibold mb-3">Input Konten Baru</h3>
        <form class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <input type="text" placeholder="Judul konten" class="border rounded-lg p-3 w-full">
                <select class="border rounded-lg p-3 w-full">
                    <option value="Sejarah">Sejarah</option>
                    <option value="Cerita Rakyat">Cerita Rakyat</option>
                    <option value="Budaya">Budaya</option>
                </select>
            </div>
            <textarea placeholder="Tuliskan isi konten..." class="border rounded-lg p-3 w-full h-32 mb-4"></textarea>
            <input type="file" class="mb-4">
            <button type="submit" class="btn-primary">Kirim untuk Validasi</button>
        </form>
    </div>
</div>
@endsection
