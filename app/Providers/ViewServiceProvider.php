<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share categories ke semua views
        View::composer('*', function ($view) {
            $categories = Category::withCount(['articles' => function($query) {
                $query->where('status', 'published')
                      ->whereNotNull('published_at')
                      ->where('published_at', '<=', now());
            }])
            ->orderBy('name')
            ->get();
            
            $view->with('globalCategories', $categories);
        });
    }
}