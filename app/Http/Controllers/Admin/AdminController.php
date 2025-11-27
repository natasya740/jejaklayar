<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /* ============================================================
     *  DASHBOARD
     * ============================================================ */
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers'      => User::count(),
            'totalArtikel'    => Article::count(),
            'pendingArtikel'  => Article::where('status', 'pending')->count(),
        ]);
    }


    /* ============================================================
     *  ARTIKEL LIST
     * ============================================================ */
    public function indexArtikel()
    {
        $artikels = Article::latest()->paginate(15);
        return view('admin.articles.index', compact('artikels'));
    }


    public function pendingArtikel()
    {
        $artikels = Article::where('status', 'pending')->latest()->paginate(15);
        return view('admin.articles.pending', compact('artikels'));
    }


    public function reviewArtikel(Article $artikel)
    {
        return view('admin.articles.show', compact('artikel'));
    }


    /* ============================================================
     *  CREATE ARTIKEL (ADMIN)
     * ============================================================ */
    public function createArtikel()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.articles.create', compact('categories', 'tags'));
    }


    public function storeArtikel(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:4096',
            'tags'        => 'nullable|string',
            'status'      => 'nullable|in:draft,pending,published'
        ]);

        // Upload gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('artikel', 'public');
        }

        // Generate slug
        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = auth()->id();
        $data['status'] = $data['status'] ?? 'published';

        $artikel = Article::create($data);

        // TAGS (optional)
        if (!empty($data['tags']) && method_exists(Article::class, 'tags')) {
            $tagList = array_filter(array_map('trim', explode(',', $data['tags'])));
            $tagIds = [];

            foreach ($tagList as $t) {
                $tag = Tag::firstOrCreate(['name' => $t], ['slug' => Str::slug($t)]);
                $tagIds[] = $tag->id;
            }

            $artikel->tags()->sync($tagIds);
        }

        return redirect()->route('admin.articles.show')->with('success', 'Artikel berhasil dibuat!');
    }


    /* ============================================================
     *  EDIT ARTIKEL
     * ============================================================ */
    public function editArtikel(Article $artikel)
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.articles.edit', compact('artikel', 'categories', 'tags'));
    }


    public function updateArtikel(Request $request, Article $artikel)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'status'   => 'required|in:draft,published,pending,rejected',
            'image'    => 'nullable|image|max:4096',
            'tags'     => 'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            if ($artikel->image) Storage::disk('public')->delete($artikel->image);
            $data['image'] = $request->file('image')->store('artikel', 'public');
        }

        $artikel->update($data);

        return redirect()->route('admin.articles.show')->with('success', 'Artikel berhasil diperbarui.');
    }


    /* ============================================================
     *  DELETE ARTIKEL
     * ============================================================ */
    public function destroyArtikel(Article $artikel)
    {
        if ($artikel->image) {
            Storage::disk('public')->delete($artikel->image);
        }

        $artikel->delete();

        return redirect()->route('admin.articles.show')->with('success', 'Artikel berhasil dihapus.');
    }


    /* ============================================================
     *  VALIDASI ARTIKEL
     * ============================================================ */
    public function approveArtikel(Article $artikel)
    {
        $artikel->update(['status' => 'published']);
        return back()->with('success', 'Article diterbitkan.');
    }


    public function rejectArtikel(Request $request, Article $artikel)
    {
        $request->validate(['feedback' => 'required|string']);

        $artikel->update([
            'status'   => 'rejected',
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Article ditolak.');
    }


    /* ============================================================
     *  USER & LOG
     * ============================================================ */
    public function users(Request $request)
    {
        $q = $request->q;
        $users = User::when($q, function ($qr) use ($q) {
            $qr->where('name', 'like', "%$q%")
               ->orWhere('email', 'like', "%$q%");
        })->latest()->paginate(15);

        return view('admin.users.index', compact('users', 'q'));
    }


    public function logs(Request $request)
    {
        $q = $request->q;

        // Jika ada ActivityLog
        if (class_exists(\App\Models\ActivityLog::class)) {
            $logs = \App\Models\ActivityLog::latest()->paginate(30);
        } else {
            // fallback ke MiniAudit
            $logs = \App\Models\MiniAudit::latest()->paginate(30);
        }

        return view('admin.logs.index', compact('logs', 'q'));
    }
}
