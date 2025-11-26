@extends('layouts.dashboard_admin')

@section('title', 'Validasi Artikel')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    
    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-list-alt text-indigo-600"></i>
                Daftar Artikel Pending
            </h1>
            <p class="text-sm text-gray-500 mt-1">Artikel yang menunggu proses validasi admin.</p>
        </div>

        {{-- TOMBOL TAMBAH ARTIKEL --}}
        <a href="{{ route('admin.artikel.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-md flex items-center gap-2 text-sm">
            <i class="fas fa-plus-circle"></i> Buat Artikel Baru
        </a>
    </div>

    {{-- JIKA KOSONG --}}
    @if($artikels->count() === 0)
        <div class="p-10 text-center text-gray-500 bg-gray-50 rounded-lg border border-gray-100">
            <i class="fas fa-check-circle text-5xl mb-4 text-green-200"></i>
            <p class="text-lg font-semibold text-gray-700">Tidak Ada Antrian</p>
            <p class="text-sm">Semua artikel sudah divalidasi.</p>
        </div>
    
    {{-- JIKA ADA DATA --}}
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="text-gray-600 uppercase text-xs border-b border-gray-200 bg-gray-50">
                        <th class="py-3 px-3 font-semibold">Judul</th>
                        <th class="py-3 px-3 font-semibold">Penulis</th>
                        <th class="py-3 px-3 font-semibold">Kategori</th>
                        <th class="py-3 px-3 font-semibold">Tanggal Kirim</th>
                        <th class="py-3 px-3 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-sm text-gray-700">
                    @foreach($artikels as $artikel)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-3 font-medium">{{ $artikel->title }}</td>
                            <td class="py-3 px-3">{{ $artikel->user->name }}</td>
                            <td class="py-3 px-3">
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs border border-gray-200">
                                    {{ $artikel->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-gray-500 text-xs">
                                {{ $artikel->created_at->format('d M Y') }}
                            </td>

                            <td class="py-3 px-3 text-center">
                                <a href="{{ route('admin.artikel.review', $artikel->id) }}"
                                   class="bg-indigo-600 text-white px-4 py-1.5 rounded text-xs font-semibold hover:bg-indigo-700 transition">
                                    Review →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-6 flex justify-between items-center">
            <span class="text-sm text-gray-600">
                Menampilkan {{ $artikels->firstItem() }}–{{ $artikels->lastItem() }} dari {{ $artikels->total() }} artikel
            </span>

            {{ $artikels->links() }}
        </div>
    @endif
</div>
@endsection
