@extends('layouts.dashboard')

@section('title', 'Review Artikel')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        
        @if($artikel->image)
            <div class="mb-8 rounded-xl overflow-hidden shadow-md border border-gray-100 group">
                <img src="{{ asset('storage/' . $artikel->image) }}" 
                     alt="{{ $artikel->title }}" 
                     class="w-full h-auto max-h-[500px] object-cover transform transition duration-500 group-hover:scale-105">
            </div>
        @endif

        <div class="mb-6 flex items-center gap-3 text-sm text-gray-500 border-b border-gray-100 pb-4">
            <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full font-semibold text-xs border border-indigo-100">
                {{ $artikel->category->name ?? 'Umum' }}
            </span>
            <span>•</span>
            <span><i class="far fa-clock mr-1"></i> {{ $artikel->created_at->format('d F Y, H:i') }} WIB</span>
        </div>
        
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 leading-tight">{{ $artikel->title }}</h1>
        
        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            {!! $artikel->content !!}
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
            <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                <i class="fas fa-shield-alt text-indigo-600"></i> Panel Validasi
            </h3>
            
            <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-100 flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                    {{ substr($artikel->user->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold mb-0.5">Penulis</p>
                    <div class="font-bold text-gray-900 text-base leading-tight">{{ $artikel->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $artikel->user->email }}</div>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                
                <form action="{{ route('admin.artikel.approve', $artikel->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" onclick="return confirm('Terbitkan artikel ini?')" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition shadow-sm flex justify-center items-center gap-2">
                        <i class="fas fa-check-circle"></i> TERBITKAN
                    </button>
                </form>

                <hr class="border-gray-200 my-2">

                <form action="{{ route('admin.artikel.reject', $artikel->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="text-xs font-bold text-red-600 mb-1 block">Feedback Penolakan:</label>
                        <textarea name="feedback" class="w-full border border-red-200 bg-red-50 rounded-lg p-3 text-sm focus:ring-red-500 focus:border-red-500" rows="3" placeholder="Wajib diisi: Alasan artikel ditolak..." required></textarea>
                    </div>
                    <button type="submit" onclick="return confirm('Tolak artikel ini?')" class="w-full bg-white text-red-600 border border-red-200 py-2 rounded-lg font-bold hover:bg-red-50 transition flex justify-center items-center gap-2">
                        <i class="fas fa-times-circle"></i> TOLAK ARTIKEL
                    </button>
                </form>

                <hr class="border-gray-200 my-2">

                <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('PERINGATAN: Artikel akan dihapus permanen. Lanjutkan?')" class="w-full text-gray-400 hover:text-red-600 text-xs font-medium py-2 transition flex justify-center items-center gap-1 hover:underline">
                        <i class="fas fa-trash-alt"></i> Hapus Permanen
                    </button>
                </form>

            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                <a href="{{ route('admin.artikel.pending') }}" class="text-indigo-600 text-sm hover:underline font-medium">
                    &larr; Kembali ke Antrian
                </a>
            </div>
        </div>
    </div>
</div>
@endsection