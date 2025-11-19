<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KontributorController extends Controller {
    
    public function index() {
        $user = Auth::user();
        $artikels = Artikel::where('user_id', $user->id)->with('kategori')->latest()->get();
        // 💡 Menggunakan layout publik, jadi tidak perlu data kategori di sini
        return view('kontributor.dashboard', compact('user', 'artikels'));
    }

    public function showArticleForm() {
        // Ambil kategori induk (level 1)
        $kategoris = Kategori::whereNull('parent_id')->get();
        return view('kontributor.artikel_form', compact('kategoris'));
    }

    public function storeContent(Request $request) {
        $request->validate([
            'judul' => 'required', 'kategori_id' => 'required', 'isi' => 'required'
        ]);
        Artikel::create([
            'user_id' => Auth::id(),
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'status' => 'pending'
        ]);
        return redirect()->route('kontributor.dashboard')->with('success', 'Artikel terkirim!');
    }
    
    public function listMyArticles() {
        $user = Auth::user();
        $artikels = Artikel::where('user_id', $user->id)->latest()->get();
        return view('kontributor.artikel', compact('artikels'));
    }
    
    public function viewStatus() { return $this->listMyArticles(); }
}