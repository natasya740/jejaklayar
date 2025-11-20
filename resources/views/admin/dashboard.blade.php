@extends('layouts.dashboard') <!-- Panggil Layout yang SAMA -->

@section('title', 'Dashboard Admin')

@section('content')
    
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Panel Monitoring</h2>
        <p class="text-gray-500">Ringkasan aktivitas Jejak Layar hari ini.</p>
    </div>

    <!-- Statistik Admin -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
            <p class="text-gray-500 text-sm uppercase font-bold">Total Pengguna</p>
            <h3 class="text-3xl font-bold">{{ $totalUsers }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
            <p class="text-gray-500 text-sm uppercase font-bold">Menunggu Validasi</p>
            <h3 class="text-3xl font-bold">{{ $pendingArtikel }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
            <p class="text-gray-500 text-sm uppercase font-bold">Artikel Tayang</p>
            <h3 class="text-3xl font-bold">{{ $publishedArtikel }}</h3>
        </div>
    </div>

    <!-- Tabel Artikel Pending -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Butuh Persetujuan</h3>
            <a href="{{ route('admin.artikel.pending') }}" class="text-indigo-600 text-sm font-bold hover:underline">Proses Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Penulis</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendingArtikelsList as $item)
                    <tr>
                        <td class="px-6 py-3 font-medium">{{ Str::limit($item->title, 30) }}</td>
                        <td class="px-6 py-3">{{ $item->user->name }}</td>
                        <td class="px-6 py-3">{{ $item->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-3 text-center">
                            <a href="{{ route('admin.artikel.review', $item->id) }}" class="text-indigo-600 hover:text-indigo-800 font-bold">Review</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">Aman, tidak ada antrian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection