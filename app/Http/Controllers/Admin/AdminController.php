<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Artikel;
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
            'totalArtikel'    => Artikel::count(),
            'pendingArtikel'  => Artikel::where('status', 'pending')->count(),
        ]);
    }


    /* ============================================================
     *  ARTIKEL LIST
     * ============================================================ */
    public function indexArtikel()
    {
        $artikels = Artikel::latest()->paginate(15);
        return view('admin.artikel.index', compact('artikels'));
    }


    public function pendingArtikel()
    {
        $artikels = Artikel::where('status', 'pending')->latest()->paginate(15);
        return view('admin.artikel.pending', compact('artikels'));
    }


    public function reviewArtikel(Artikel $artikel)
    {
        return view('admin.artikel.show', compact('artikel'));
    }


    /* ============================================================
     *  CREATE ARTIKEL (ADMIN)
     * ============================================================ */
    public function createArtikel()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.artikel.create', compact('categories', 'tags'));
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

        $artikel = Artikel::create($data);

        // TAGS (optional)
        if (!empty($data['tags']) && method_exists(Artikel::class, 'tags')) {
            $tagList = array_filter(array_map('trim', explode(',', $data['tags'])));
            $tagIds = [];

            foreach ($tagList as $t) {
                $tag = Tag::firstOrCreate(['name' => $t], ['slug' => Str::slug($t)]);
                $tagIds[] = $tag->id;
            }

            $artikel->tags()->sync($tagIds);
        }

        return redirect()->route('admin.artikel.show')->with('success', 'Artikel berhasil dibuat!');
    }


    /* ============================================================
     *  EDIT ARTIKEL
     * ============================================================ */
    public function editArtikel(Artikel $artikel)
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.artikel.edit', compact('artikel', 'categories', 'tags'));
    }


    public function updateArtikel(Request $request, Artikel $artikel)
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

        return redirect()->route('admin.artikel.show')->with('success', 'Artikel berhasil diperbarui.');
    }


    /* ============================================================
     *  DELETE ARTIKEL
     * ============================================================ */
    public function destroyArtikel(Artikel $artikel)
    {
        if ($artikel->image) {
            Storage::disk('public')->delete($artikel->image);
        }

        $artikel->delete();

        return redirect()->route('admin.artikel.show')->with('success', 'Artikel berhasil dihapus.');
    }


    /* ============================================================
     *  VALIDASI ARTIKEL
     * ============================================================ */
    public function approveArtikel(Artikel $artikel)
    {
        $artikel->update(['status' => 'published']);
        return back()->with('success', 'Artikel diterbitkan.');
    }


    public function rejectArtikel(Request $request, Artikel $artikel)
    {
        $request->validate(['feedback' => 'required|string']);

        $artikel->update([
            'status'   => 'rejected',
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Artikel ditolak.');
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
