@extends('layouts.dashboard')

@section('title', 'Artikel Saya')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Karyaku</h2>
            <p class="text-sm text-gray-500">Pantau status artikel yang sudah kamu kirim.</p>
        </div>
        <a href="{{ route('kontributor.artikel.form') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition flex items-center gap-2 text-sm font-medium">
            <i class="fas fa-plus"></i> Tulis Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <th class="p-4 font-semibold">Judul Artikel</th>
                    <th class="p-4 font-semibold">Kategori</th>
                    <th class="p-4 font-semibold">Tanggal</th>
                    <th class="p-4 font-semibold text-center">Status</th>
                    <th class="p-4 font-semibold text-center">Catatan Admin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($artikels as $artikel)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-medium text-gray-900">{{ Str::limit($artikel->title, 40) }}</td>
                    <td class="p-4">
                        <span class="bg-gray-100 text-gray-600 py-1 px-2 rounded text-xs border border-gray-200">
                            {{ $artikel->category->name ?? 'Umum' }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-500">{{ $artikel->created_at->format('d M Y') }}</td>
                    <td class="p-4 text-center">
                        @if($artikel->status == 'published')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                Tayang
                            </span>
                        @elseif($artikel->status == 'rejected')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                Ditolak
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                Pending
                            </span>
                        @endif
                    </td>
                    <td class="p-4 text-center text-gray-500 italic max-w-xs truncate">
                        {{ $artikel->feedback ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-feather-alt text-4xl mb-3 text-gray-200"></i>
                            <p>Belum ada artikel.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection