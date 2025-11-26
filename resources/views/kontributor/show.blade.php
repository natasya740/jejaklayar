@extends('layouts.dashboard_kontributor')

@section('page-title', 'Detail Artikel')
@section('page-subtitle', 'Pratinjau artikelmu')

@section('content')

<div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">

    {{-- Header Artikel --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $artikel->title }}</h1>
            <p class="text-gray-500 text-sm">
                Ditulis pada {{ $artikel->created_at->format('d M Y • H:i') }}
            </p>
        </div>

        {{-- Status Badge --}}
        <span class="px-3 py-1 rounded-lg text-sm font-semibold
            @if($artikel->status == 'published') bg-green-100 text-green-700
            @elseif($artikel->status == 'pending') bg-yellow-100 text-yellow-700
            @else bg-red-100 text-red-700 @endif">
            {{ ucfirst($artikel->status) }}
        </span>
    </div>

    {{-- Gambar Sampul --}}
    @if($artikel->thumbnail)
    <div class="mb-6">
        <img src="{{ asset('uploads/thumbnails/' . $artikel->thumbnail) }}"
             class="w-full rounded-lg shadow-md"
             alt="Thumbnail Artikel">
    </div>
    @endif

    {{-- Konten Artikel --}}
    <div class="prose max-w-none mb-10">
        {!! $artikel->content !!}
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex items-center gap-3 border-t pt-4">

        {{-- Tombol Kembali --}}
        <a href="{{ route('kontributor.dashboard') }}"
           class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">
            <i class="fa fa-arrow-left mr-1"></i> Kembali
        </a>

    </div>

</div>

@endsection
