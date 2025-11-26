<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;

class DashboardController extends Controller
{
    /**
     * View untuk user dashboard.
     * Ubah sesuai folder view kamu.
     *
     * @var string
     */
    protected string $view = 'dashboard.index';

    /**
     * Apply auth middleware so controller methods only accessible by authenticated users.
     */
    public function __construct()
    {
        // Jika beberapa method ingin public, ubah aturan middleware di sini.
        $this->middleware('auth');
    }

    /**
     * Dashboard untuk user umum (bukan admin)
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function home(Request $request): View|RedirectResponse
    {
        // Karena kita pakai middleware('auth'), user pasti authenticated.
        // Namun tetap aman jika dipanggil tanpa middleware.
        $user = Auth::user();

        if (!$user) {
            // jika tidak login, kembalikan redirect — sesuai union return type.
            return redirect()->route('login');
        }

        // Hitungan safe berdasarkan user login
        $totalArtikel = $this->safeCountWhereUser(\App\Models\Artikel::class, $user->id);
        $categories   = $this->safeCount(\App\Models\Category::class);
        $tags         = $this->safeCount(\App\Models\Tag::class);

        // Artikel terbaru user
        $recentArticles = $this->safeGetLatestUser(\App\Models\Artikel::class, $user->id, 5);

        return view($this->view, compact(
            'user',
            'totalArtikel',
            'categories',
            'tags',
            'recentArticles'
        ));
    }

    /* ===========================
     *      HELPER FUNCTIONS
     * ===========================*/

    protected function safeCount(string $modelClass): int
    {
        try {
            if (!class_exists($modelClass)) return 0;

            $instance = new $modelClass;
            if (!Schema::hasTable($instance->getTable())) return 0;

            return (int) $modelClass::count();
        } catch (Exception $e) {
            return 0;
        }
    }

    protected function safeCountWhereUser(string $modelClass, int $userId): int
    {
        try {
            if (!class_exists($modelClass)) return 0;

            $instance = new $modelClass;
            if (!Schema::hasTable($instance->getTable())) return 0;

            // pastikan kolom user_id ada di tabel, or else the where will still run but be meaningless.
            return (int) $modelClass::where('user_id', $userId)->count();
        } catch (Exception $e) {
            return 0;
        }
    }

    protected function safeGetLatestUser(string $modelClass, int $userId, int $limit = 5): Collection
    {
        try {
            if (!class_exists($modelClass)) return collect();

            $instance = new $modelClass;
            if (!Schema::hasTable($instance->getTable())) return collect();

            return $modelClass::where('user_id', $userId)
                ->latest()
                ->limit($limit)
                ->get();
        } catch (Exception $e) {
            return collect();
        }
    }
}
