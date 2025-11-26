@extends('layouts.dashboard_admin')

@section('title', 'Kelola Artikel')
@section('page-title', 'Kelola Artikel')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-lg font-semibold">Semua Artikel</h2>

        <div class="flex items-center gap-4">
            <a href="{{ route('admin.artikel.pending') }}" class="text-sm text-indigo-600 hover:underline">
                Lihat yang menunggu ({{ \App\Models\Artikel::where('status', 'pending')->count() }})
            </a>

            @can('create', App\Models\Artikel::class)
                {{-- atau role check --}}
                <a href="{{ route('admin.artikel.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-green-700 transition">
                    <i class="fas fa-plus mr-2"></i> Tambah Konten
                </a>
            @endcan
        </div>
    </div>


    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Penulis</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($artikels as $a)
                        <tr>
                            <td class="px-6 py-3">{{ Str::limit($a->title, 60) }}</td>
                            <td class="px-6 py-3">{{ $a->user->name ?? '-' }}</td>
                            <td class="px-6 py-3">{{ ucfirst($a->status ?? 'draft') }}</td>
                            <td class="px-6 py-3">{{ $a->created_at ? $a->created_at->format('Y-m-d') : '-' }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('admin.artikel.review', $a->id) }}" class="text-indigo-600 mr-2">Lihat</a>
                                <a href="{{ route('admin.artikel.edit', $a->id) }}" class="text-yellow-600 mr-2">Edit</a>

                                <form action="{{ route('admin.artikel.destroy', $a->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-rose-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-400">Belum ada artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $artikels->links() }}
        </div>
    </div>
@endsection
