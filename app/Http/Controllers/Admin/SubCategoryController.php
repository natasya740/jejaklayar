<?php
// app/Http/Controllers/Admin/SubCategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')
            ->withCount('articles')
            ->latest()
            ->paginate(10);
        
        return view('admin.sub-categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.sub-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:sub_categories,name',
            'description' => 'nullable|string'
        ]);

        SubCategory::create($validated);

        return redirect()
            ->route('admin.sub-categories.index')
            ->with('success', 'Sub Kategori berhasil ditambahkan!');
    }

    public function show(SubCategory $subCategory)
    {
        $subCategory->load(['category', 'articles']);
        return view('admin.sub-categories.show', compact('subCategory'));
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.sub-categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:sub_categories,name,' . $subCategory->id,
            'description' => 'nullable|string'
        ]);

        $subCategory->update($validated);

        return redirect()
            ->route('admin.sub-categories.index')
            ->with('success', 'Sub Kategori berhasil diperbarui!');
    }

    public function destroy(SubCategory $subCategory)
    {
        // Cek apakah ada artikel
        if ($subCategory->articles()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus sub kategori yang masih memiliki artikel!');
        }

        $subCategory->delete();

        return redirect()
            ->route('admin.sub-categories.index')
            ->with('success', 'Sub Kategori berhasil dihapus!');
    }

    // Method untuk mengambil sub kategori berdasarkan kategori (untuk AJAX)
    public function getByCategory($categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)
            ->orderBy('name')
            ->get();
        
        return response()->json($subCategories);
    }
}