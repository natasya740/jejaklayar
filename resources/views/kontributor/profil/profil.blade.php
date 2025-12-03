@extends('layouts.dashboard_kontributor')

@section('title', 'Dashboard Kontributor')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . auth()->user()->name)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Artikel -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Artikel</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalArticles ?? 0 }}</h3>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fa fa-file-alt text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Artikel Disetujui -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Disetujui</p>
                <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $approvedArticles ?? 0 }}</h3>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fa fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Artikel Pending -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Menunggu Review</p>
                <h3 class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingArticles ?? 0 }}</h3>
            </div>
            <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fa fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-xl shadow-lg p-8 mb-8 text-white">
    <h2 class="text-2xl font-bold mb-4">Mulai Berkontribusi</h2>
    <p class="mb-6 opacity-90">Bagikan pengetahuan dan cerita Anda tentang budaya Melayu Bengkalis</p>
    <a href="{{ route('kontributor.artikel.create') }}" 
       class="inline-flex items-center gap-2 bg-white text-yellow-600 px-6 py-3 rounded-lg font-semibold hover:shadow-xl transition-all">
        <i class="fa fa-plus-circle"></i>
        <span>Upload Artikel Baru</span>
    </a>
</div>

<!-- Recent Articles -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-900">Artikel Terbaru Saya</h3>
    </div>
    
    <div class="divide-y divide-gray-100">
        @forelse($recentArticles ?? [] as $article)
        <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 mb-1">{{ $article->title }}</h4>
                    <p class="text-sm text-gray-500">{{ $article->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex items-center gap-3">
                    @if($article->status === 'approved')
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                            Disetujui
                        </span>
                    @elseif($article->status === 'pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                            Pending
                        </span>
                    @elseif($article->status === 'rejected')
                        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                            Ditolak
                        </span>
                    @endif
                    
                    <a href="{{ route('kontributor.artikel.show', $article->id) }}" 
                       class="text-yellow-600 hover:text-yellow-700">
                        <i class="fa fa-eye"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="px-6 py-12 text-center text-gray-500">
            <i class="fa fa-inbox text-4xl mb-3 opacity-50"></i>
            <p>Belum ada artikel. Mulai berkontribusi sekarang!</p>
        </div>
        @endforelse
    </div>
    
    @if(($recentArticles ?? collect())->count() > 0)
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        <a href="{{ route('kontributor.artikel.index') }}" 
           class="text-yellow-600 hover:text-yellow-700 font-semibold text-sm">
            Lihat Semua Artikel →
        </a>
    </div>
    @endif
</div>
@endsection