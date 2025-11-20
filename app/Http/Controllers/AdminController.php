<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 1. Dashboard Admin
    public function index()
    {
        // Hitung statistik real-time
        $totalUsers = User::count();
        $pendingArtikel = Artikel::where('status', 'pending')->count();
        $publishedArtikel = Artikel::where('status', 'published')->count();

        // Ambil 5 artikel pending terbaru untuk tabel ringkasan di dashboard
        $pendingArtikelsList = Artikel::where('status', 'pending')
                                     ->with(['user', 'category']) // Optimasi query
                                     ->latest()
                                     ->take(5)
                                     ->get();

        return view('admin.dashboard', compact('totalUsers', 'pendingArtikel', 'publishedArtikel', 'pendingArtikelsList'));
    }

    // 2. Halaman List Artikel Pending (READ)
    public function pendingArtikel()
    {
        $artikels = Artikel::where('status', 'pending')
                           ->with(['user', 'category'])
                           ->latest()
                           ->paginate(10);

        // PERBAIKAN: Mengarah ke file 'index.blade.php' di dalam folder 'admin/artikel'
        return view('admin.artikel.index', compact('artikels'));
    }

    // 3. Halaman Review Single Artikel (READ DETAIL)
    public function reviewArtikel($id)
    {
        $artikel = Artikel::with(['user', 'category'])->findOrFail($id);
        
        // PERBAIKAN: Mengarah ke file 'show.blade.php' di dalam folder 'admin/artikel'
        return view('admin.artikel.show', compact('artikel'));
    }

    // 4. Logika Approve (UPDATE STATUS)
    public function approveArtikel($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update(['status' => 'published']); // Cara penulisan lebih singkat

        return redirect()->route('admin.artikel.pending')->with('success', 'Artikel berhasil diterbitkan!');
    }

    // 5. Logika Reject (UPDATE STATUS)
    public function rejectArtikel(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string'
        ]);

        $artikel = Artikel::findOrFail($id);
        $artikel->update([
            'status' => 'rejected',
            'feedback' => $request->feedback
        ]);

        return redirect()->route('admin.artikel.pending')->with('success', 'Artikel ditolak dan dikembalikan ke kontributor.');
    }

    // 6. Logika Hapus (DELETE - Fitur Baru)
    public function destroyArtikel($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();

        return back()->with('success', 'Artikel berhasil dihapus permanen.');
    }
}