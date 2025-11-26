@extends('layouts.admin')

@section('title','Kelola Pengguna')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Kelola Pengguna</h1>

    <form class="mb-4" method="GET">
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari pengguna..." class="input">
        <button class="btn">Cari</button>
    </form>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role ?? '-' }}</td>
                    <td>{{ $u->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $u->id ?? '') }}" class="btn btn-sm">Edit</a>
                        <form action="{{ route('admin.users.destroy', $u->id ?? '') }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus user?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
s