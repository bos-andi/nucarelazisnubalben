<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\GalleryItem;
use App\Models\Tag;
use App\Models\User;
use App\Models\VisitorStatistic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): RedirectResponse|View
    {
        // Check if user is approved (except superadmin)
        $user = auth()->user();
        if ($user->role === 'contributor' && !$user->is_approved) {
            // Check if verification data is complete
            if (!$user->phone || !$user->address || !$user->birth_place || !$user->birth_date || !$user->gender || !$user->occupation || !$user->ktp_file) {
                return redirect()->route('admin.verification')
                    ->with('error', 'Silakan lengkapi data verifikasi terlebih dahulu.');
            }
            return redirect()->route('admin.verification');
        }
        // Get statistics for dashboard
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::whereNotNull('published_at')->count(),
            'featured_articles' => Article::where('is_featured', true)->count(),
            'total_categories' => Category::count(),
            'total_tags' => Tag::count(),
            'total_gallery' => GalleryItem::count(),
            'total_users' => User::count(),
        ];

        // Get visitor statistics
        $visitor_stats = [
            'today_visitors' => VisitorStatistic::getTodayVisitors(),
            'today_unique_visitors' => VisitorStatistic::getTodayUniqueVisitors(),
            'month_visitors' => VisitorStatistic::getThisMonthVisitors(),
            'total_visitors' => VisitorStatistic::getTotalVisitors(),
        ];

        // Get recent articles
        $recent_articles = Article::with('category', 'user')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Get popular categories (categories with most articles)
        $popular_categories = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->limit(5)
            ->get();

        // Get monthly article statistics for chart
        $monthly_stats = Article::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        $chart_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $chart_data[] = $monthly_stats[$i] ?? 0;
        }

        // Get visitor chart data (last 7 days)
        $visitor_chart_data = VisitorStatistic::getLastSevenDaysData();
        
        // Get top pages
        $top_pages = VisitorStatistic::getTopPages(5);
        
        // Get device statistics
        $device_stats = VisitorStatistic::getDeviceStats();
        
        // Get browser statistics
        $browser_stats = VisitorStatistic::getBrowserStats();

        return view('admin.dashboard.index', compact(
            'stats', 
            'visitor_stats', 
            'recent_articles', 
            'popular_categories', 
            'chart_data', 
            'visitor_chart_data',
            'top_pages',
            'device_stats',
            'browser_stats'
        ));
    }
}
