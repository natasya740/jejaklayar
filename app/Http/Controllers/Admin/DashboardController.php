<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\MiniAudit;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = \App\Models\User::count();
        $totalArtikel = Article::count();
        $pendingArtikel = Article::where('status','pending')->count();
        $categories = Category::count();
        $tags = Tag::count();
        $recentAudits = MiniAudit::latest()->limit(6)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalArtikel',
            'pendingArtikel',
            'categories',
            'tags',
            'recentAudits'
        ));
    }
}
