<?php

namespace App\Http\Controllers\Admin; // Perhatikan namespace Admin

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel; 
use App\Models\Category;

class AdminArtikelController extends Controller
{
    /**
     * Menampilkan daftar artikel yang menunggu validasi (untuk pending.blade.php)
     */
    public function pending()
    {
        $artikels = Artikel::where('status', 'pending')
                            ->with('user')
                            ->latest()
                            ->paginate(10); 
        
        return view('admin.artikel.pending', compact('artikels'));
    }

    /**
     * Menampilkan form untuk membuat artikel baru (untuk create.blade.php)
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.artikel.create', compact('categories')); 
    }

    /**
     * Menyimpan artikel baru ke database (logika penyimpanan dan upload gambar)
     */
    public function store(Request $request)
    {
        // ... (Logika validasi dan penyimpanan dari jawaban sebelumnya)
    }
    
    /**
     * Menampilkan detail artikel untuk di-review (untuk review.blade.php)
     * Rute: admin.artikel.review
     */
    public function review(Artikel $artikel)
    {
        // Pastikan hanya artikel pending yang bisa di-review di sini
        if ($artikel->status !== 'pending') {
            return redirect()->route('admin.artikel.pending')->with('error', 'Artikel sudah divalidasi.');
        }

        // Memuat view review/show artikel
        return view('admin.artikel.review', compact('artikel'));
    }

    /**
     * Logika untuk Menerbitkan artikel (admin.artikel.approve)
     */
    public function approve(Artikel $artikel)
    {
        // ... Logika update status menjadi 'approved'
    }

    /**
     * Logika untuk Menolak artikel (admin.artikel.reject)
     */
    public function reject(Request $request, Artikel $artikel)
    {
        // ... Logika update status menjadi 'rejected' dan simpan feedback
    }

    /**
     * Logika untuk Hapus artikel (admin.artikel.destroy)
     */
    public function destroy(Artikel $artikel)
    {
        // ... Logika hapus artikel dan gambar terkait
    }
}