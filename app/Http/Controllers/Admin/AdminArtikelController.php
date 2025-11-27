<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Artikel;
use App\Models\Category;
use App\Models\Tag;
use App\Models\File;

class AdminArtikelController extends Controller
{
    /**
     * Tampilkan daftar artikel
     */
    public function index()
    {
        $artikels = Artikel::latest()->paginate(15);
        return view('admin.artikel.index', compact('artikels'));
    }


    /**
     * Artikel pending
     */
    public function pending()
    {
        $artikels = Artikel::where('status', 'pending')->paginate(15);
        return view('admin.artikel.pending', compact('artikels'));
    }


    /**
     * Form create artikel
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('admin.artikel.create', compact('categories', 'tags'));
    }


    /**
     * Simpan artikel
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:artikels,slug',
            'content'     => 'required|string|min:10',
            'category_id' => 'required|integer',
            'status'      => 'required|in:draft,pending,published',
            'cover_image' => 'nullable|image|max:3048',
            'tags'        => 'nullable|array'
        ]);

        // 1. Slug otomatis
        if (empty($data['slug'])) {
            $base = Str::slug($data['title']);
            $slug = $base;
            $i = 1;

            while (Artikel::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }

            $data['slug'] = $slug;
        }

        // 2. Upload cover image
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')
                ->store('artikel/covers', 'public');
        }

        // 3. Simpan artikel
        $artikel = Artikel::create([
            'title'       => $data['title'],
            'slug'        => $data['slug'],
            'content'     => $data['content'],
            'category_id' => $data['category_id'],
            'user_id'     => Auth::id(),
            'image'       => $coverPath,
            'status'      => $data['status'],
        ]);

        // 4. Hubungkan tags
        if (!empty($data['tags'])) {
            $artikel->tags()->sync($data['tags']);
        }

        // 5. Hubungkan file CKEditor sementara → ke artikel
        $this->attachTemporaryFiles($request, $artikel);

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }


    /**
     * Tampilkan halaman review
     */
    public function review(Artikel $artikel)
    {
        if ($artikel->status !== 'pending') {
            return redirect()->route('admin.artikel.pending')
                ->with('error', 'Artikel ini bukan pending.');
        }

        return view('admin.artikel.review', compact('artikel'));
    }


    /**
     * Approve artikel
     */
    public function approve(Artikel $artikel)
    {
        $artikel->update(['status' => 'published']);
        return back()->with('success', 'Artikel disetujui & diterbitkan.');
    }


    /**
     * Reject artikel
     */
    public function reject(Request $request, Artikel $artikel)
    {
        $request->validate([
            'feedback' => 'required|string|max:500'
        ]);

        $artikel->update([
            'status'   => 'rejected',
            'feedback' => $request->feedback
        ]);

        return back()->with('success', 'Artikel berhasil ditolak.');
    }


    /**
     * Edit artikel
     */
    public function edit(Artikel $artikel)
    {
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('admin.artikel.edit', compact('artikel', 'categories', 'tags'));
    }


    /**
     * Update artikel
     */
    public function update(Request $request, Artikel $artikel)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => "required|string|max:255|unique:artikels,slug,{$artikel->id}",
            'content'     => 'required|string|min:10',
            'category_id' => 'required|integer',
            'status'      => 'required|in:draft,pending,published',
            'cover_image' => 'nullable|image|max:3048',
            'tags'        => 'nullable|array'
        ]);

        // Upload cover image baru → delete yg lama
        if ($request->hasFile('cover_image')) {
            if ($artikel->image && Storage::disk('public')->exists($artikel->image)) {
                Storage::disk('public')->delete($artikel->image);
            }

            $data['image'] = $request->file('cover_image')
                ->store('artikel/covers', 'public');
        }

        $artikel->update($data);

        // Update tags
        $artikel->tags()->sync($data['tags'] ?? []);

        // Hubungkan file CKEditor terbaru
        $this->attachTemporaryFiles($request, $artikel);

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }


    /**
     * Hapus artikel
     */
    public function destroy(Artikel $artikel)
    {
        // Hapus cover image
        if ($artikel->image && Storage::disk('public')->exists($artikel->image)) {
            Storage::disk('public')->delete($artikel->image);
        }

        // Hapus semua file media (polymorph)
        foreach ($artikel->files as $file) {
            if (Storage::disk('public')->exists($file->filepath)) {
                Storage::disk('public')->delete($file->filepath);
            }
            $file->delete();
        }

        $artikel->delete();

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }


    /**
     * Upload dari CKEditor
     */
    public function uploadFromCKEditor(Request $request)
    {
        if (!$request->hasFile('upload')) {
            return response()->json([
                'error' => ['message' => 'Tidak ada file yang dikirim.']
            ], 400);
        }

        $file = $request->file('upload');

        if (!$file->isValid()) {
            return response()->json([
                'error' => ['message' => 'Upload tidak valid.']
            ], 400);
        }

        // Simpan file
        $path = $file->store('artikel/media', 'public');

        // Simpan ke tabel files sebagai file loose
        $newFile = File::create([
            'filepath'      => $path,
            'fileable_id'   => null,               // BELUM terhubung
            'fileable_type' => Artikel::class
        ]);

        // CKEditor response
        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }


    /**
     * Hubungkan file CKEditor (loose) → ke artikel
     */
    private function attachTemporaryFiles(Request $request, Artikel $artikel)
    {
        // Jika tidak ada file CKEditor → skip
        if (!$request->has('images_meta') || empty($request->images_meta)) {
            return;
        }

        // images_meta = JSON list gambar base64 → skip (karena Anda memakai upload manual)
        // tetapi jika Anda memakai file loose → Anda bisa tambahkan logic di sini.
    }
}
