<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles
     */
    public function index()
    {
        $articles = Article::with(['user', 'category', 'subCategory'])
            ->latest()
            ->paginate(15);
        
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new article
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::orderBy('name')->get();
        
        return view('admin.articles.create', compact('categories', 'subCategories'));
    }

    /**
     * Store a newly created article
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
            'status' => 'required|in:draft,pending,published,archived',
            'published_at' => 'nullable|date'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);

        // Upload featured image jika ada
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = 'featured_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $validated['featured_image'] = $file->storeAs('articles/featured', $filename, 'public');
        }

        // Set published_at jika status published dan tidak ada tanggal
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $article = Article::create($validated);

        // Clear temporary uploaded images from session
        session()->forget('article_uploaded_images');

        return redirect()
            ->route('admin.articles.index')
            ->with('success', '✅ Artikel berhasil ditambahkan!');
    }

    /**
     * Display the specified article
     */
    public function show(Article $article)
    {
        $article->load(['user', 'category', 'subCategory']);
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified article
     */
    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::orderBy('name')->get();
        
        return view('admin.articles.edit', compact('article', 'categories', 'subCategories'));
    }

    /**
     * Update the specified article
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,pending,published,archived',
            'published_at' => 'nullable|date'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Upload featured image baru jika ada
        if ($request->hasFile('featured_image')) {
            // Hapus gambar lama
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            
            $file = $request->file('featured_image');
            $filename = 'featured_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $validated['featured_image'] = $file->storeAs('articles/featured', $filename, 'public');
        }

        // Set published_at jika status berubah menjadi published
        if ($validated['status'] === 'published' && $article->status !== 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', '✅ Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified article
     */
    public function destroy(Article $article)
    {
        try {
            DB::beginTransaction();

            // Log untuk debugging
            Log::info('Attempting to delete article', [
                'article_id' => $article->id,
                'title' => $article->title,
                'user_id' => Auth::id()
            ]);

            // 1. Hapus featured image jika ada
            if ($article->featured_image) {
                if (Storage::disk('public')->exists($article->featured_image)) {
                    Storage::disk('public')->delete($article->featured_image);
                    Log::info('Deleted featured image', ['path' => $article->featured_image]);
                }
            }

            // 2. Hapus gambar dari konten artikel
            $deletedContentImages = $this->cleanupContentImages($article->content);
            Log::info('Deleted content images', ['count' => count($deletedContentImages)]);

            // 3. Simpan informasi artikel sebelum dihapus (untuk log)
            $articleTitle = $article->title;
            $articleId = $article->id;

            // 4. Hapus artikel dari database
            $article->delete();

            DB::commit();

            Log::info('Article deleted successfully', [
                'article_id' => $articleId,
                'title' => $articleTitle
            ]);

            return redirect()
                ->route('admin.articles.index')
                ->with('success', "🗑️ Artikel \"$articleTitle\" berhasil dihapus!");

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete article', [
                'article_id' => $article->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', '❌ Gagal menghapus artikel: ' . $e->getMessage());
        }
    }

    /**
     * Upload image dari CKEditor
     */
    public function uploadImage(Request $request)
    {
        Log::info('CKEditor Upload Request', [
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
            
            Log::info('Uploading CKEditor image', [
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

            Log::info('CKEditor image uploaded successfully', [
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
            Log::error('CKEditor validation error', ['errors' => $e->errors()]);
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Validasi gagal: ' . implode(', ', $e->errors()['upload'] ?? ['Unknown error'])
                ]
            ], 422);
        } catch (\Exception $e) {
            Log::error('CKEditor upload error', [
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
     * Helper: Cleanup images from content when deleting article
     * 
     * @param string $content HTML content containing images
     * @return array Paths of deleted images
     */
    private function cleanupContentImages($content)
    {
        $deletedImages = [];

        try {
            // Extract semua URL gambar dari konten HTML
            // Pola regex yang lebih robust untuk menangkap berbagai format URL
            preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $matches);
            
            if (!empty($matches[1])) {
                foreach ($matches[1] as $imageUrl) {
                    // Normalisasi URL untuk mendapatkan path relatif
                    $path = $this->extractStoragePath($imageUrl);
                    
                    if ($path && Storage::disk('public')->exists($path)) {
                        try {
                            Storage::disk('public')->delete($path);
                            $deletedImages[] = $path;
                            Log::info('Deleted content image', ['path' => $path]);
                        } catch (\Exception $e) {
                            Log::warning('Failed to delete content image', [
                                'path' => $path,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error during content images cleanup', [
                'error' => $e->getMessage()
            ]);
        }

        return $deletedImages;
    }

    /**
     * Extract storage path from full URL
     * 
     * @param string $url Full URL or path
     * @return string|null Storage path relative to public disk
     */
    private function extractStoragePath($url)
    {
        // Hapus base URL jika ada
        $url = str_replace([
            url('storage/'),
            asset('storage/'),
            '/storage/',
            'storage/'
        ], '', $url);

        // Hanya proses jika path termasuk articles/
        if (strpos($url, 'articles/') === 0 || strpos($url, '/articles/') === 0) {
            return ltrim($url, '/');
        }

        return null;
    }

    /**
     * Batch delete articles (optional - untuk future feature)
     */
    public function batchDestroy(Request $request)
    {
        $request->validate([
            'article_ids' => 'required|array',
            'article_ids.*' => 'exists:articles,id'
        ]);

        try {
            DB::beginTransaction();

            $deletedCount = 0;
            $errors = [];

            foreach ($request->article_ids as $articleId) {
                try {
                    $article = Article::findOrFail($articleId);
                    
                    // Hapus featured image
                    if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
                        Storage::disk('public')->delete($article->featured_image);
                    }
                    
                    // Hapus content images
                    $this->cleanupContentImages($article->content);
                    
                    // Hapus artikel
                    $article->delete();
                    $deletedCount++;
                    
                } catch (\Exception $e) {
                    $errors[] = "Gagal menghapus artikel ID {$articleId}: " . $e->getMessage();
                    Log::error('Batch delete error', [
                        'article_id' => $articleId,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            DB::commit();

            if ($deletedCount > 0) {
                $message = "✅ Berhasil menghapus {$deletedCount} artikel.";
                if (!empty($errors)) {
                    $message .= " Namun ada beberapa error: " . implode(', ', $errors);
                }
                return redirect()->back()->with('success', $message);
            }

            return redirect()->back()->with('error', '❌ Gagal menghapus artikel: ' . implode(', ', $errors));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Batch delete failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', '❌ Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}