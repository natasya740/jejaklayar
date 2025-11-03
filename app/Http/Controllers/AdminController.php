<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel; // Asumsi model artikel Anda bernama Artikel

class AdminController extends Controller
{
    // Method yang dipanggil oleh rute admin.dashboard
    public function index()
    {
        // 💡 Di sini Anda akan menarik data Laravel yang sebelumnya Anda ambil via PHP murni
        
        // Contoh: Mengambil data untuk dashboard
        // Di sini Anda akan menjalankan query untuk mendapatkan total artikel, pending, published, dll.
        // Untuk saat ini, kita akan mengirim data dummy atau mengambil semua data.
        
        // Ambil semua artikel yang statusnya pending untuk antrian
        $pendingArticles = Artikel::where('status', 'pending')->with('user')->get(); 
        
        $stats = [
            'total_artikel' => Artikel::count(),
            'total_pending' => Artikel::where('status', 'pending')->count(),
            'total_published' => Artikel::where('status', 'published')->count(),
            'total_user' => \App\Models\User::count(), // Asumsi model User ada
        ];

        // Ganti 'admin.dashboard' dengan lokasi view Blade baru Anda
        return view('admin.dashboard', compact('pendingArticles', 'stats'));
    }

    // Method untuk Form Input Konten (artikel_form.html)
    public function showUploadForm()
    {
        return view('admin.artikel_form');
    }

    // Method untuk Kelola Artikel (artikel_list.html)
    public function listArticles()
    {
        // Ambil semua artikel untuk halaman kelola
        $articles = Artikel::all();
        return view('admin.artikel_list', compact('articles'));
    }
}
