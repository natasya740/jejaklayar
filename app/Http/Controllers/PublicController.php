<?php
// app/Http/Controllers/PublicController.php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Halaman beranda - menampilkan artikel terbaru
     */
    public function index()
    {
        $latestArticles = Article::published()
            ->with(['category', 'subCategory', 'user'])
            ->latest('published_at')
            ->paginate(12);

        $categories = Category::withCount(['articles' => function($query) {
            $query->published();
        }])->get();

        return view('public.home', compact('latestArticles', 'categories'));
    }

    /**
     * Halaman kategori - menampilkan sub-kategori dan artikel dalam kategori
     * Dengan custom view untuk kategori tertentu
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $subCategories = SubCategory::where('category_id', $category->id)
            ->withCount(['articles' => function($query) {
                $query->published();
            }])
            ->get();

        $articles = Article::published()
            ->where('category_id', $category->id)
            ->with(['subCategory', 'user'])
            ->latest('published_at')
            ->paginate(12);

        // Check if custom view exists for this category
        $customViews = [
            'budaya' => 'public.categories.budaya',
            'pustaka' => 'public.categories.pustaka',
        ];

        // If custom view exists, use it
        if (isset($customViews[$slug]) && view()->exists($customViews[$slug])) {
            return view($customViews[$slug], compact('category', 'subCategories', 'articles'));
        }

        // Default category view with dynamic filtering
        return view('public.category', compact('category', 'subCategories', 'articles'));
    }

    /**
     * Halaman sub-kategori - menampilkan artikel dalam sub-kategori
     */
    public function subCategory($categorySlug, $subCategorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        
        $subCategory = SubCategory::where('slug', $subCategorySlug)
            ->where('category_id', $category->id)
            ->firstOrFail();

        $articles = Article::published()
            ->where('category_id', $category->id)
            ->where('sub_category_id', $subCategory->id)
            ->with(['user'])
            ->latest('published_at')
            ->paginate(12);

        return view('public.subcategory', compact('category', 'subCategory', 'articles'));
    }

    /**
     * Halaman detail artikel
     */
    public function article($categorySlug, $subCategorySlug, $articleSlug)
    {
        $article = Article::published()
            ->where('slug', $articleSlug)
            ->with(['category', 'subCategory', 'user', 'files'])
            ->firstOrFail();

        // Artikel terkait dari sub-kategori yang sama
        $relatedArticles = Article::published()
            ->where('sub_category_id', $article->sub_category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('public.article', compact('article', 'relatedArticles'));
    }

    /**
     * Halaman pencarian
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $articles = Article::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->with(['category', 'subCategory', 'user'])
            ->latest('published_at')
            ->paginate(12);

        return view('public.search', compact('articles', 'query'));
    }
}