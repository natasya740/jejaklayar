@extends('layouts.dashboard') <!-- Panggil Layout Utama -->

@section('title', 'Dashboard Kontributor')

@section('content')
    <!-- ISI KONTEN DASHBOARD KONTRIBUTOR DIMULAI DARI SINI -->
    
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Halo, {{ Auth::user()->name }} 👋</h2>
        <p class="text-gray-500">Selamat datang kembali di panel penulis.</p>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-indigo-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Artikel</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $artikels->count() }}</h3>
                </div>
                <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                    <i class="fas fa-newspaper text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Tambahkan widget statistik lain disini jika mau -->
    </div>

    <!-- Tabel Ringkas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-700">Artikel Terbaru</h3>
            <a href="{{ route('kontributor.artikel.saya') }}" class="text-sm text-indigo-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="p-6">
            @if($artikels->isEmpty())
                <p class="text-gray-500 text-center py-4">Belum ada artikel. <a href="{{ route('kontributor.artikel.form') }}" class="text-indigo-600 underline">Tulis sekarang!</a></p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach($artikels->take(5) as $artikel)
                        <li class="py-3 flex justify-between items-center">
                            <span class="text-gray-700 font-medium">{{ $artikel->title }}</span>
                            <span class="px-2 py-1 rounded text-xs font-bold 
                                {{ $artikel->status == 'published' ? 'bg-green-100 text-green-700' : 
                                  ($artikel->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($artikel->status) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

@endsection