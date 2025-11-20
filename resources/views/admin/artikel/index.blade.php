@extends('layouts.dashboard')

@section('title', 'Validasi Artikel')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Antrian Validasi</h2>
            <p class="text-sm text-gray-500">Daftar artikel pending yang perlu diperiksa.</p>
        </div>
        <div class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full">
            {{ $artikels->total() }} Pending
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white text-gray-500 uppercase text-xs tracking-wider border-b border-gray-200">
                    <th class="p-4 font-semibold">Penulis</th>
                    <th class="p-4 font-semibold">Judul Artikel</th>
                    <th class="p-4 font-semibold">Kategori</th>
                    <th class="p-4 font-semibold">Waktu Masuk</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($artikels as $artikel)
                <tr class="hover:bg-indigo-50 transition group">
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                {{ substr($artikel->user->name, 0, 1) }}
                            </div>
                            <div class="font-medium text-gray-900">{{ $artikel->user->name }}</div>
                        </div>
                    </td>
                    <td class="p-4 font-medium">{{ Str::limit($artikel->title, 50) }}</td>
                    <td class="p-4">
                        <span class="bg-gray-100 text-gray-600 py-1 px-2 rounded text-xs border border-gray-200">
                            {{ $artikel->category->name ?? '-' }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-500 text-xs">
                        {{ $artikel->created_at->diffForHumans() }}
                    </td>
                    <td class="p-4 text-center">
                        <a href="{{ route('admin.artikel.review', $artikel->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-xs font-bold hover:bg-indigo-700 transition shadow-sm">
                            Review <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-check-circle text-5xl mb-4 text-green-100"></i>
                            <p class="text-lg text-gray-500">Semua Bersih!</p>
                            <p class="text-sm">Tidak ada antrian validasi saat ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($artikels->hasPages())
        <div class="p-4 border-t border-gray-200">
            {{ $artikels->links() }}
        </div>
    @endif
</div>
@endsection