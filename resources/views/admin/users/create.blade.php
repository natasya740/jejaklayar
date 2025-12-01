@extends('layouts.dashboard_admin')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Tambah Pengguna Baru</h1>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali ke daftar</a>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 px-4 py-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-6 rounded shadow-md max-w-lg">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror" required>
                @error('email')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror" required>
                @error('password')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password confirmation --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2">
                    <option value="" {{ old('role') === null ? 'selected' : '' }}>-- Pilih Role (opsional) --</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kontributor" {{ old('role') === 'kontributor' ? 'selected' : '' }}>Kontributor</option>
                    <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                </select>
                @error('role')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- is_active --}}
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}
                        class="mr-2">
                    <span class="text-sm">Aktifkan akun</span>
                </label>
                @error('is_active')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:underline">Batal</a>
            </div>
        </form>
    </div>
@endsection
