<?php

/**
 * SubCategoryController.
 *
 * Mengelola CRUD sub kategori di halaman admin, termasuk
 * upload, update, dan penghapusan gambar thumbnail.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    /**
     * Tampilkan daftar sub kategori dengan kategori terkait dan jumlah artikel.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $subCategories = SubCategory::with('category')
            ->withCount('articles')
            ->latest()
            ->paginate(10);

        return view('admin.sub-categories.index', compact('subCategories'));
    }

    /**
     * Tampilkan form tambah sub kategori.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.sub-categories.create', compact('categories'));
    }

    /**
     * Simpan sub kategori baru ke database.
     *
     * Mendukung upload gambar opsional.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:sub_categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        // Jika ada file gambar, simpan ke storage disk 'public'
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('subcategories', 'public');
            $validated['image'] = $path;
        }

        SubCategory::create($validated);

        return redirect()
            ->route('admin.sub-categories.index')
            ->with('success', 'Sub Kategori berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail sub kategori.
     *
     * @return \Illuminate\View\View
     */
    public function show(SubCategory $subCategory)
    {
        $subCategory->load(['category', 'articles']);

        return view('admin.sub-categories.show', compact('subCategory'));
    }

    /**
     * Tampilkan form edit sub kategori.
     *
     * @return \Illuminate\View\View
     */
    public function edit(SubCategory $subCategory)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.sub-categories.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update data sub kategori yang ada.
     *
     * Mendukung penggantian gambar. Jika ada gambar baru,
     * gambar lama akan dihapus dari storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:sub_categories,name,'.$subCategory->id,
            'description' => 'nullable|string',
            // Maksimal 10MB (10240KB) agar konsisten dengan tampilan form dan proses store
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        // Jika ada gambar baru, hapus yang lama (jika ada), lalu simpan yang baru
        if ($request->hasFile('image')) {
            if ($subCategory->image && Storage::disk('public')->exists($subCategory->image)) {
                Storage::disk('public')->delete($subCategory->image);
            }

            $path = $request->file('image')->store('subcategories', 'public');
            $validated['image'] = $path;
        }

        $subCategory->update($validated);

        return redirect()
            ->route('admin.sub-categories.index')
            ->with('success', 'Sub Kategori berhasil diperbarui!');
    }

    /**
     * Hapus sub kategori dari database.
     *
     * Tidak boleh menghapus jika masih punya artikel.
     * Jika diizinkan, gambar di storage juga ikut dihapus.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SubCategory $subCategory)
    {
        // Cek apakah ada artikel
        if ($subCategory->articles()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus sub kategori yang masih memiliki artikel!');
        }

        // Hapus file gambar jika ada
        if ($subCategory->image && Storage::disk('public')->exists($subCategory->image)) {
            Storage::disk('public')->delete($subCategory->image);
        }

        $subCategory->delete();

        return redirect()
            ->route('admin.sub-categories.index')
            ->with('success', 'Sub Kategori berhasil dihapus!');
    }

    /**
     * Ambil daftar sub kategori berdasarkan kategori (untuk AJAX).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Ambil daftar sub kategori berdasarkan kategori (untuk AJAX).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByCategory(int $categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)
            ->orderBy('name')
            ->get();

        return response()->json($subCategories);
    }
}
