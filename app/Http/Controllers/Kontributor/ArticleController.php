<?php

namespace App\Http\Controllers\Contributor; // Sesuaikan dengan nama folder controller kamu

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Menampilkan daftar artikel milik KONTRIBUTOR yang sedang login.
     */
    public function index()
    {
        $articles = Article::with(['category', 'subCategory'])
            ->where('user_id', Auth::id()) // PENTING: Hanya ambil artikel milik user sendiri
            ->latest()
            ->paginate(15);
        
        // Sesuaikan dengan lokasi view kamu: resources/views/kontributor/artikel/index.blade.php
        return view('kontributor.artikel.index', compact('articles'));
    }

    /**
     * Form buat artikel baru
     */
    public function create()
    {
        // INI BAGIAN YANG MEMPERBAIKI ERROR "Undefined variable $categories"
        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::orderBy('name')->get();
        
        // Sesuaikan view: resources/views/kontributor/artikel/create.blade.php
        return view('kontributor.artikel.create', compact('categories', 'subCategories'));
    }

    /**
     * Simpan artikel baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // Kontributor mungkin tidak boleh langsung 'published', sesuaikan jika perlu
            'status' => 'required|in:draft,pending', 
        ]);

        $validated['user_id'] = Auth::id(); // Otomatis set pemilik artikel adalah user yang login
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5); // Tambah random string biar slug unik
        $validated['published_at'] = null; // Reset published_at, biar admin yang approve

        // Upload featured image
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = 'featured_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $validated['featured_image'] = $file->storeAs('articles/featured', $filename, 'public');
        }

        Article::create($validated);

        // Hapus session image temp
        session()->forget('article_uploaded_images');

        // Redirect ke route index kontributor
        return redirect()
            ->route('kontributor.artikel.index') // Pastikan nama route ini ada di web.php
            ->with('success', '✅ Artikel berhasil dikirim dan menunggu moderasi!');
    }

    /**
     * Edit form
     */
    public function edit(Article $article) // Pastikan parameter di route web.php menggunakan {article}
    {
        // KEAMANAN: Cek apakah artikel ini milik user yang login?
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit artikel ini.');
        }

        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::orderBy('name')->get();
        
        return view('kontributor.artikel.edit', compact('article', 'categories', 'subCategories'));
    }

    /**
     * Update artikel
     */
    public function update(Request $request, Article $article)
    {
        // KEAMANAN: Cek kepemilikan
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,pending',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Upload gambar baru
        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $file = $request->file('featured_image');
            $filename = 'featured_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $validated['featured_image'] = $file->storeAs('articles/featured', $filename, 'public');
        }

        // Jika status diubah jadi pending (diajukan ulang), reset published_at
        if ($validated['status'] == 'pending') {
            $validated['published_at'] = null;
        }

        $article->update($validated);

        return redirect()
            ->route('kontributor.artikel.index')
            ->with('success', '✅ Artikel berhasil diperbarui!');
    }

    /**
     * Hapus artikel
     */
    public function destroy(Article $article)
    {
        // KEAMANAN: Cek kepemilikan
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $this->cleanupContentImages($article->content);
        $article->delete();

        return redirect()
            ->route('kontributor.artikel.index')
            ->with('success', '🗑️ Artikel berhasil dihapus!');
    }

    /**
     * Upload Image CKEditor (Sama persis dengan Admin)
     */
    public function uploadImage(Request $request)
    {
        // ... (Kode sama persis dengan Admin Controller)
        // Copy paste isi function uploadImage dari kode admin kamu ke sini
        // Karena logic upload gambar tidak berubah meski user-nya kontributor
        
        \Log::info('CKEditor Upload Request', [
            'has_file' => $request->hasFile('upload'),
            'user_id' => Auth::id()
        ]);

        try {
            $request->validate([
                'upload' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120'
            ]);

            if (!$request->hasFile('upload')) {
                return response()->json(['error' => ['message' => 'No file uploaded.']], 400);
            }

            $file = $request->file('upload');
            $filename = 'content_' . Auth::id() . '_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('articles/content', $filename, 'public');
            $url = asset('storage/' . $path);

            return response()->json([
                'uploaded' => 1,
                'url' => $url
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => ['message' => $e->getMessage()]], 500);
        }
    }

    // Helper cleanup sama seperti admin
    private function cleanupContentImages($content)
    {
        preg_match_all('/<img[^>]+src="([^">]+)"/', $content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $imageUrl) {
                if (strpos($imageUrl, 'storage/articles/content/') !== false) {
                    $path = str_replace(asset('storage/'), '', $imageUrl);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        }
    }
}