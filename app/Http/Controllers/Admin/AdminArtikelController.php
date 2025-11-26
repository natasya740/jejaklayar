<?php

namespace App\Http\Controllers\Admin; // Perhatikan namespace Admin

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Artikel;
use App\Models\Category;
use App\Models\Tag;

class AdminArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->paginate(15);
        return view('admin.artikel.index', compact('artikels'));
    }

    public function pending()
    {
        $artikels = Artikel::where('status', 'pending')->latest()->paginate(12);
        return view('admin.artikel.pending', compact('artikels'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('admin.artikel.create', compact('categories','tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'body_html'    => 'required|string|min:20',
            'top_category' => 'required|string|max:100',
            'subcategory'  => 'required|string|max:150',
            'slug'         => 'nullable|string|max:255|unique:artikels,slug',
            'excerpt'      => 'nullable|string|max:500',
            'tags'         => 'nullable|string',
            'images_meta'  => 'nullable|string',
            'cover_image'  => 'nullable|string',
            'status'       => 'nullable|in:draft,pending,published'
        ]);

        if (empty($data['slug'])) {
            $base = Str::slug($data['title']);
            $slug = $base; $i = 1;
            while (Artikel::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $data['slug'] = $slug;
        }

        // Process images_meta base64 -> store in storage/app/public/FOTO/
        $imagesSaved = [];
        if (!empty($data['images_meta'])) {
            $meta = json_decode($data['images_meta'], true);
            if (is_array($meta)) {
                foreach ($meta as $idx => $img) {
                    if (!empty($img['dataUrl']) && preg_match('/^data:image\/(\w+);base64,/', $img['dataUrl'], $m)) {
                        $ext = ($m[1] === 'jpeg') ? 'jpg' : $m[1];
                        $filename = 'artikel_' . time() . '_' . Str::random(6) . '.' . $ext;
                        $diskPath = 'FOTO/' . $filename;
                        $dataBlob = explode(',', $img['dataUrl'], 2)[1] ?? null;
                        if ($dataBlob) {
                            Storage::disk('public')->put($diskPath, base64_decode($dataBlob));
                            $imagesSaved[] = [
                                'file' => $diskPath,
                                'caption' => $img['caption'] ?? '',
                                'alt' => $img['alt'] ?? '',
                                'cover' => !empty($img['cover']),
                                'order' => $img['order'] ?? $idx,
                            ];
                        }
                    } elseif (!empty($img['file'])) {
                        $imagesSaved[] = [
                            'file' => $img['file'],
                            'caption' => $img['caption'] ?? '',
                            'alt' => $img['alt'] ?? '',
                            'cover' => !empty($img['cover']),
                            'order' => $img['order'] ?? $idx,
                        ];
                    }
                }
            }
        }

        $cover = $data['cover_image'] ?? null;
        if (!$cover && count($imagesSaved) > 0) {
            foreach ($imagesSaved as $im) { if (!empty($im['cover'])) { $cover = $im['file']; break; } }
            if (!$cover) $cover = $imagesSaved[0]['file'];
        }

        $artikel = Artikel::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'top_category' => $data['top_category'],
            'subcategory' => $data['subcategory'],
            'excerpt' => $data['excerpt'] ?? null,
            'body_html' => $data['body_html'],
            'tags' => $data['tags'] ?? null,
            'cover_image' => $cover,
            'images_meta' => !empty($imagesSaved) ? json_encode($imagesSaved) : null,
            'status' => $data['status'] ?? 'draft',
            'user_id' => Auth::id(),
        ]);

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

    public function review(Artikel $artikel)
    {
        if ($artikel->status !== 'pending') {
            return redirect()->route('admin.artikel.pending')->with('error', 'Artikel ini bukan status pending.');
        }
        return view('admin.artikel.review', compact('artikel'));
    }

    public function approve(Artikel $artikel)
    {
        $artikel->update(['status' => 'published']);
        return back()->with('success', 'Artikel berhasil diterbitkan.');
    }

    public function reject(Request $request, Artikel $artikel)
    {
        $request->validate(['feedback' => 'required|string|max:1000']);
        $artikel->update(['status' => 'rejected', 'feedback' => $request->feedback]);
        return back()->with('success', 'Artikel berhasil ditolak.');
    }

    public function destroy(Artikel $artikel)
    {
        if ($artikel->images_meta) {
            try {
                $meta = json_decode($artikel->images_meta, true);
                if (is_array($meta)) {
                    foreach ($meta as $m) {
                        if (!empty($m['file']) && Storage::disk('public')->exists($m['file'])) {
                            Storage::disk('public')->delete($m['file']);
                        }
                    }
                }
            } catch (\Exception $e) {}
        }
        if ($artikel->cover_image && Storage::disk('public')->exists($artikel->cover_image)) {
            Storage::disk('public')->delete($artikel->cover_image);
        }
        $artikel->delete();
        return redirect()->route('admin.artikel.show')->with('success', 'Artikel berhasil dihapus.');
    }
}
