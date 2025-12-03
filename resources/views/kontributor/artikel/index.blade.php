@extends('layouts.dashboard_kontributor')

@section('title', 'Artikel Saya')
@section('page-title', 'Artikel Saya')
@section('page-subtitle', 'Kelola semua artikel yang telah Anda buat')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <select id="filter-status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Disetujui</option>
            <option value="rejected">Ditolak</option>
        </select>
    </div>
    
    <a href="{{ route('kontributor.artikel.create') }}" 
       class="inline-flex items-center gap-2 bg-yellow-500 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-yellow-600 transition-colors">
        <i class="fa fa-plus"></i>
        <span>Artikel Baru</span>
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($articles ?? [] as $article)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $article->title }}</div>
                        <div class="text-sm text-gray-500 mt-1">{{ Str::limit($article->excerpt, 60) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-600">{{ $article->category->name ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($article->status === 'approved')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                <i class="fa fa-check-circle"></i> Disetujui
                            </span>
                        @elseif($article->status === 'pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                <i class="fa fa-clock"></i> Pending
                            </span>
                        @elseif($article->status === 'rejected')
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                                <i class="fa fa-times-circle"></i> Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $article->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('kontributor.artikel.show', $article->id) }}" 
                               class="text-blue-600 hover:text-blue-700" title="Lihat">
                                <i class="fa fa-eye"></i>
                            </a>
                            
                            @if($article->status === 'pending' || $article->status === 'rejected')
                            <a href="{{ route('kontributor.artikel.edit', $article->id) }}" 
                               class="text-yellow-600 hover:text-yellow-700" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endif
                            
                            @if($article->status === 'pending')
                            <form action="{{ route('kontributor.artikel.destroy', $article->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="fa fa-inbox text-4xl mb-3 opacity-50"></i>
                        <p class="mb-4">Belum ada artikel</p>
                        <a href="{{ route('kontributor.artikel.create') }}" 
                           class="inline-flex items-center gap-2 bg-yellow-500 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-yellow-600">
                            <i class="fa fa-plus"></i>
                            <span>Buat Artikel Pertama</span>
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(($articles ?? collect())->count() > 0)
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $articles->links() }}
    </div>
    @endif
</div>
@endsection