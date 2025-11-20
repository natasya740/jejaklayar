<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk manajemen file

class KontributorController extends Controller {
    
    // 1. Dashboard Utama
    public function index() {
        $user = Auth::user();
        $artikels = Artikel::where('user_id', $user->id)->with('category')->latest()->get();
        return view('kontributor.dashboard', compact('user', 'artikels'));
    }

    // 2. Form Tulis Artikel
    public function showArticleForm() {
        $kategoris = Category::all(); 
        return view('kontributor.artikel.create', compact('kategoris'));
    }

    // 3. Simpan Artikel (HANYA BOLEH ADA SATU FUNGSI INI)
    public function storeContent(Request $request) {
        // A. Validasi
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required',
            'isi' => 'required',
            // Validasi gambar: Wajib file gambar, maks 2MB (2048 KB)
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
        ]);

        // B. Logika Upload Cover Image
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Upload ke folder: storage/app/public/artikels
            $imagePath = $request->file('image')->store('artikels', 'public');
        }

        // C. Simpan ke Database
        Artikel::create([
            'user_id' => Auth::id(),
            'category_id' => $request->kategori_id,
            'title' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . Str::random(5),
            'content' => $request->isi, // Gambar di dalam teks akan tersimpan sebagai HTML di sini
            'image' => $imagePath,      // Path Cover Image tersimpan di sini
            'status' => 'pending'
        ]);

        return redirect()->route('kontributor.artikel.saya')->with('success', 'Artikel terkirim! Menunggu validasi admin.');
    }
    
    // 4. List Artikel Saya
    public function listMyArticles() {
        $user = Auth::user();
        $artikels = Artikel::where('user_id', $user->id)->with('category')->latest()->get();
        return view('kontributor.artikel.index', compact('artikels'));
    }
    
    // Alias
    public function viewStatus() { 
        return $this->listMyArticles(); 
    }

    // 5. Profil
    public function showProfil() {
        return view('kontributor.profil');
    }

    public function updateProfil(Request $request) {
        $user = Auth::user();
        $user->name = $request->name;
        $user->save();
        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}