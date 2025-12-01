@extends('layouts.dashboard_admin')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="container mx-auto p-6">

        <div class="flex justify-between items-center mb-5">
            <h1 class="text-2xl font-bold">Kelola Pengguna</h1>

            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Tambah Pengguna
            </a>
        </div>

        {{-- SEARCH --}}
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama atau email..."
                class="border rounded px-3 py-2 w-64">
            <button class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">
                Cari
            </button>
        </form>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-3">
                {{ session('error') }}
            </div>
        @endif

        {{-- MAIN TABLE --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            @if ($users->count() === 0)
                <div class="p-6 text-center text-gray-600">
                    Tidak ada pengguna.
                </div>
            @else
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Nama</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">Role</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Dibuat</th>
                            <th class="p-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            @php $isSelf = auth()->check() && auth()->id() === $u->id; @endphp
                            <tr class="border-t">
                                <td class="p-3">{{ $u->id }}</td>
                                <td class="p-3">{{ $u->name }}</td>
                                <td class="p-3">{{ $u->email }}</td>

                                {{-- ROLE --}}
                                <td class="p-3">
                                    @if ($u->role === 'admin')
                                        <span class="bg-red-500 text-white px-2 py-1 rounded text-xs">Admin</span>
                                    @elseif($u->role === 'kontributor')
                                        <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs">Kontributor</span>
                                    @else
                                        <span class="bg-gray-500 text-white px-2 py-1 rounded text-xs">Member</span>
                                    @endif
                                </td>

                                {{-- STATUS --}}
                                <td class="p-3">
                                    @if ($u->is_active)
                                        <span class="bg-green-500 text-white px-2 py-1 rounded text-xs">Aktif</span>
                                    @else
                                        <span class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">Nonaktif</span>
                                    @endif
                                </td>

                                <td class="p-3">{{ optional($u->created_at)->format('Y-m-d') }}</td>

                                {{-- ACTION BUTTONS --}}
                                <td class="p-3 flex gap-2 items-center">

                                    {{-- TOGGLE STATUS --}}
                                    @if ($isSelf)
                                        {{-- Jika akun sendiri --}}
                                        @if ($u->is_active)
                                            {{-- Jika akun sendiri aktif => jangan tampilkan tombol nonaktifkan (disabled) --}}
                                            <button class="px-3 py-1 rounded bg-gray-300 text-white cursor-not-allowed"
                                                disabled title="Anda tidak boleh menonaktifkan akun sendiri">
                                                Anda
                                            </button>
                                        @else
                                            {{-- Jika akun sendiri nonaktif => izinkan aktivasi --}}
                                            <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button class="px-3 py-1 rounded bg-green-600 text-white">
                                                    Aktifkan Akun
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        {{-- Untuk user lain: toggle biasa --}}
                                        <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button
                                                class="px-3 py-1 rounded {{ $u->is_active ? 'bg-yellow-500 text-white' : 'bg-green-600 text-white' }}">
                                                {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Hapus (tidak boleh hapus diri sendiri) --}}
                                    @if ($isSelf)
                                        <button class="px-3 py-1 rounded bg-gray-300 text-white cursor-not-allowed" disabled
                                            title="Anda tidak dapat menghapus akun sendiri">
                                            Hapus
                                        </button>
                                    @else
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus pengguna ini?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 rounded bg-red-600 text-white">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-4 py-3">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
