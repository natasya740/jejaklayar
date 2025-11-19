@extends('layouts.admin')

@section('title', 'Validasi Artikel')

@section('content')
    <div class="page-header">
        <h1>Validasi Artikel</h1>
        <p>Daftar artikel yang dikirim kontributor dan menunggu persetujuan.</p>
    </div>

    <div class="card">
        <div class="card-body" style="padding: 0;">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Tanggal Masuk</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($artikels as $artikel)
                        <tr>
                            <td>
                                <div style="font-weight: 600;">{{ $artikel->title }}</div>
                            </td>
                            <td>{{ $artikel->user->name }}</td>
                            <td><span class="badge" style="background: #eee; color: #555;">{{ $artikel->category->name }}</span></td>
                            <td>{{ $artikel->created_at->diffForHumans() }}</td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.artikel.review', $artikel->id) }}" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Review
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: 20px;">
                {{ $artikels->links() }} {{-- Pagination --}}
            </div>
        </div>
    </div>
@endsection