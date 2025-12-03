<?php
// app/Http/Controllers/Kontributor/DashboardController.php

namespace App\Http\Controllers\Kontributor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Statistik dasar
        $stats = [
            'total' => Article::byUser($userId)->count(),
            'published' => Article::byUser($userId)->where('status', 'published')->count(),
            'pending' => Article::byUser($userId)->where('status', 'pending')->count(),
            'draft' => Article::byUser($userId)->where('status', 'draft')->count(),
            'archived' => Article::byUser($userId)->where('status', 'archived')->count(),
        ];
        
        // Artikel terbaru (5 artikel terakhir)
        $recentArticles = Article::byUser($userId)
            ->with(['category', 'subCategory'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
        
        // Data untuk contribution graph (365 hari terakhir)
        $contributionData = $this->getContributionData($userId);
        
        // Statistik per bulan (12 bulan terakhir)
        $monthlyStats = $this->getMonthlyStats($userId);
        
        // Artikel paling populer (berdasarkan status published)
        $popularArticles = Article::byUser($userId)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('kontributor.dashboard', compact(
            'stats',
            'recentArticles',
            'contributionData',
            'monthlyStats',
            'popularArticles'
        ));
    }
    
    /**
     * Generate data untuk contribution graph seperti GitHub
     * 365 hari terakhir, grouped by date
     */
    private function getContributionData($userId)
    {
        $startDate = Carbon::now()->subDays(365);
        $endDate = Carbon::now();
        
        // Ambil semua artikel dalam 365 hari terakhir
        $articles = Article::byUser($userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();
        
        // Generate array untuk setiap hari dalam 365 hari terakhir
        $contributions = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dateKey = $currentDate->format('Y-m-d');
            $contributions[] = [
                'date' => $dateKey,
                'count' => $articles[$dateKey] ?? 0,
                'level' => $this->getContributionLevel($articles[$dateKey] ?? 0)
            ];
            $currentDate->addDay();
        }
        
        return $contributions;
    }
    
    /**
     * Tentukan level contribution untuk warna
     * 0 = no contribution, 1-4 = increasing intensity
     */
    private function getContributionLevel($count)
    {
        if ($count === 0) return 0;
        if ($count === 1) return 1;
        if ($count <= 3) return 2;
        if ($count <= 5) return 3;
        return 4; // 6+
    }
    
    /**
     * Statistik per bulan (12 bulan terakhir)
     */
    private function getMonthlyStats($userId)
    {
        $startDate = Carbon::now()->subMonths(12)->startOfMonth();
        
        $stats = Article::byUser($userId)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "published" THEN 1 ELSE 0 END) as published'),
                DB::raw('SUM(CASE WHEN status = "draft" THEN 1 ELSE 0 END) as draft')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        // Format untuk chart
        $months = [];
        $currentDate = $startDate->copy();
        
        for ($i = 0; $i < 12; $i++) {
            $monthKey = $currentDate->format('Y-m');
            $monthData = $stats->firstWhere('month', $monthKey);
            
            $months[] = [
                'month' => $currentDate->format('M Y'),
                'month_short' => $currentDate->format('M'),
                'total' => $monthData->total ?? 0,
                'published' => $monthData->published ?? 0,
                'draft' => $monthData->draft ?? 0,
            ];
            
            $currentDate->addMonth();
        }
        
        return $months;
    }
}