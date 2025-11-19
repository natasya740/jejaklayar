<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard Admin
    public function index()
    {
        // Hitung statistik
        $totalUsers = User::count();
        $pendingArtikel = Artikel::where('status', 'pending')->count();
        $publishedArtikel = Artikel::where('status', 'published')->count();

        // Ambil 5 artikel pending terbaru untuk tabel dashboard
        $pendingArtikelsList = Artikel::where('status', 'pending')
                                     ->with(['user', 'category']) // Eager load relasi
                                     ->latest()
                                     ->take(5)
                                     ->get();

        return view('admin.dashboard', compact('totalUsers', 'pendingArtikel', 'publishedArtikel', 'pendingArtikelsList'));
    }

    // Halaman List Artikel Pending
    public function pendingArtikel()
    {
        // Ambil semua artikel pending dengan pagination
        $artikels = Artikel::where('status', 'pending')
                           ->with(['user', 'category'])
                           ->latest()
                           ->paginate(10);

        return view('admin.artikel.pending', compact('artikels'));
    }

    // Halaman Review Single Artikel
    public function reviewArtikel($id)
    {
        $artikel = Artikel::with(['user', 'category'])->findOrFail($id);
        return view('admin.artikel.review', compact('artikel'));
    }

    // Logika Approve (Terbitkan)
    public function approveArtikel($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->status = 'published';
        $artikel->save();

        return redirect()->route('admin.artikel.pending')->with('success', 'Artikel berhasil diterbitkan!');
    }

    // Logika Reject (Tolak)
    public function rejectArtikel(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string'
        ]);

        $artikel = Artikel::findOrFail($id);
        $artikel->status = 'rejected';
        $artikel->feedback = $request->feedback; // Simpan alasan penolakan
        $artikel->save();

        return redirect()->route('admin.artikel.pending')->with('success', 'Artikel ditolak dan dikembalikan ke kontributor.');
    }
}