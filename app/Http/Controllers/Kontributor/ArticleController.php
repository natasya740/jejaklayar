<?php
// app/Http/Controllers/Kontributor/ArticleController.php

namespace App\Http\Controllers\Kontributor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the kontributor's articles.
     */
    public function index(Request $request)
    {
        $query = Article::with(['category', 'subCategory'])
            ->byUser(Auth::id())
            ->latest();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        $articles = $query->paginate(10);
        $categories = Category::all();

        return view('kontributor.articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        $categories = Category::with('subCategories')->get();
        $subCategories = SubCategory::all(); // TAMBAHAN: Kirim semua subkategori
        return view('kontributor.articles.create', compact('categories', 'subCategories'));
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,pending',
        ]);

        try {
            DB::beginTransaction();

            // Upload featured image jika ada
            $featuredImagePath = null;
            if ($request->hasFile('featured_image')) {
                $featuredImagePath = $request->file('featured_image')->store('articles/featured', 'public');
            }

            // Buat artikel
            $article = Article::create([
                'user_id' => Auth::id(),
                'title' => $validated['title'],
                'category_id' => $validated['category_id'],
                'sub_category_id' => $validated['sub_category_id'],
                'excerpt' => $validated['excerpt'],
                'content' => $validated['content'],
                'featured_image' => $featuredImagePath,
                'status' => $validated['status'],
                'published_at' => $validated['status'] === 'pending' ? now() : null,
            ]);

            // Extract dan simpan gambar dari content CKEditor
            $this->extractAndSaveImagesFromContent($article);

            DB::commit();

            return redirect()
                ->route('kontributor.articles.index')
                ->with('success', 'Artikel berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Hapus featured image jika ada error
            if ($featuredImagePath && Storage::exists($featuredImagePath)) {
                Storage::delete($featuredImagePath);
            }

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        // Pastikan artikel milik user yang login
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $article->load(['category', 'subCategory', 'files']);
        
        return view('kontributor.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article)
    {
        // Pastikan artikel milik user yang login
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya bisa edit jika status draft atau ditolak
        if (!in_array($article->status, ['draft', 'archived'])) {
            return back()->with('error', 'Artikel dengan status ' . $article->status . ' tidak dapat diedit.');
        }

        $categories = Category::with('subCategories')->get();
        $subCategories = SubCategory::all(); // TAMBAHAN: Kirim semua subkategori
        $article->load('files');
        
        return view('kontributor.articles.edit', compact('article', 'categories', 'subCategories'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        // Pastikan artikel milik user yang login
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya bisa update jika status draft atau archived
        if (!in_array($article->status, ['draft', 'archived'])) {
            return back()->with('error', 'Artikel dengan status ' . $article->status . ' tidak dapat diedit.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,pending',
        ]);

        try {
            DB::beginTransaction();

            // Upload featured image baru jika ada
            if ($request->hasFile('featured_image')) {
                // Hapus featured image lama
                if ($article->featured_image && Storage::exists($article->featured_image)) {
                    Storage::delete($article->featured_image);
                }
                $validated['featured_image'] = $request->file('featured_image')->store('articles/featured', 'public');
            }

            // Update artikel
            $article->update([
                'title' => $validated['title'],
                'category_id' => $validated['category_id'],
                'sub_category_id' => $validated['sub_category_id'],
                'excerpt' => $validated['excerpt'],
                'content' => $validated['content'],
                'featured_image' => $validated['featured_image'] ?? $article->featured_image,
                'status' => $validated['status'],
                'published_at' => $validated['status'] === 'pending' ? now() : null,
            ]);

            // Hapus file lama yang tidak digunakan dan extract gambar baru
            $this->cleanupUnusedImages($article);
            $this->extractAndSaveImagesFromContent($article);

            DB::commit();

            return redirect()
                ->route('kontributor.articles.index')
                ->with('success', 'Artikel berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        // Pastikan artikel milik user yang login
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya bisa hapus jika status draft
        if ($article->status !== 'draft') {
            return back()->with('error', 'Hanya artikel draft yang dapat dihapus.');
        }

        try {
            DB::beginTransaction();

            // Hapus featured image
            if ($article->featured_image && Storage::exists($article->featured_image)) {
                Storage::delete($article->featured_image);
            }

            // Hapus semua file terkait (akan trigger deleting event di model File)
            $article->files()->delete();

            // Hapus artikel
            $article->delete();

            DB::commit();

            return redirect()
                ->route('kontributor.articles.index')
                ->with('success', 'Artikel berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Upload image for CKEditor.
     */
    public function uploadImage(Request $request)
    {
        \Log::info('CKEditor Upload Request', [
            'has_file' => $request->hasFile('upload'),
            'all_files' => $request->allFiles(),
        ]);

        try {
            $request->validate([
                'upload' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120' // 5MB
            ]);

            if (!$request->hasFile('upload')) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'Tidak ada file yang diupload.'
                    ]
                ], 400);
            }

            $file = $request->file('upload');

            if (!$file->isValid()) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'File tidak valid: ' . $file->getErrorMessage()
                    ]
                ], 400);
            }

            // Buat nama file unik
            $filename = 'article_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            
            \Log::info('Uploading CKEditor image', [
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType()
            ]);

            // Simpan ke storage/app/public/articles/content
            $path = $file->storeAs('articles/content', $filename, 'public');

            if (!$path) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'Gagal menyimpan file ke storage.'
                    ]
                ], 500);
            }

            // URL untuk akses file
            $url = asset('storage/' . $path);

            \Log::info('CKEditor image uploaded successfully', [
                'path' => $path,
                'url' => $url
            ]);

            // Simpan path ke session untuk tracking (opsional)
            $uploadedImages = session('article_uploaded_images', []);
            $uploadedImages[] = $path;
            session(['article_uploaded_images' => $uploadedImages]);

            // Response untuk CKEditor 5
            return response()->json([
                'uploaded' => 1,
                'url' => $url
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('CKEditor validation error', ['errors' => $e->errors()]);
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Validasi gagal: ' . implode(', ', $e->errors()['upload'] ?? ['Unknown error'])
                ]
            ], 422);
        } catch (\Exception $e) {
            \Log::error('CKEditor upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Upload gagal: ' . $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Get subcategories by category.
     */
    public function getSubCategories(Request $request)
    {
        $categoryId = $request->category_id;
        $subCategories = SubCategory::where('category_id', $categoryId)->get();

        return response()->json([
            'success' => true,
            'data' => $subCategories
        ]);
    }

    /**
     * Extract images from content and save to files table.
     */
    private function extractAndSaveImagesFromContent(Article $article)
    {
        // Extract semua URL gambar dari content
        preg_match_all('/<img[^>]+src="([^">]+)"/', $article->content, $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $imageUrl) {
                // Check jika URL adalah dari storage kita
                if (strpos($imageUrl, 'storage/articles/content') !== false) {
                    // Extract path dari URL
                    $path = str_replace(asset('storage/'), '', $imageUrl);
                    
                    // Check apakah file sudah ada di database
                    $existingFile = File::where('filepath', $path)
                        ->where('fileable_type', Article::class)
                        ->where('fileable_id', $article->id)
                        ->first();
                    
                    if (!$existingFile) {
                        // Simpan ke database
                        File::create([
                            'filepath' => $path,
                            'fileable_id' => $article->id,
                            'fileable_type' => Article::class,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Clean up unused images from files table.
     */
    private function cleanupUnusedImages(Article $article)
    {
        $files = $article->files;
        
        foreach ($files as $file) {
            // Check apakah filepath ada di content
            if (strpos($article->content, $file->filepath) === false) {
                // File tidak digunakan, hapus
                $file->delete();
            }
        }
    }
}