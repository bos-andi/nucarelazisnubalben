<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VisitorStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'page_url',
        'page_title',
        'referrer',
        'country',
        'city',
        'device_type',
        'browser',
        'os',
        'session_duration',
        'is_unique_visitor',
        'visit_date',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'is_unique_visitor' => 'boolean',
    ];

    /**
     * Get total visitors for today
     */
    public static function getTodayVisitors(): int
    {
        return self::whereDate('visit_date', today())->count();
    }

    /**
     * Get total unique visitors for today
     */
    public static function getTodayUniqueVisitors(): int
    {
        return self::whereDate('visit_date', today())
            ->where('is_unique_visitor', true)
            ->count();
    }

    /**
     * Get total visitors this month
     */
    public static function getThisMonthVisitors(): int
    {
        return self::whereMonth('visit_date', now()->month)
            ->whereYear('visit_date', now()->year)
            ->count();
    }

    /**
     * Get total visitors all time
     */
    public static function getTotalVisitors(): int
    {
        return self::count();
    }

    /**
     * Get visitors data for the last 7 days
     */
    public static function getLastSevenDaysData(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $visitors = self::whereDate('visit_date', $date)->count();
            $uniqueVisitors = self::whereDate('visit_date', $date)
                ->where('is_unique_visitor', true)
                ->count();
            
            $data[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'visitors' => $visitors,
                'unique_visitors' => $uniqueVisitors,
            ];
        }
        return $data;
    }

    /**
     * Get top pages by visits
     */
    public static function getTopPages(int $limit = 10): array
    {
        return self::selectRaw('page_url, page_title, COUNT(*) as visits')
            ->groupBy('page_url', 'page_title')
            ->orderByDesc('visits')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get device statistics
     */
    public static function getDeviceStats(): array
    {
        return self::selectRaw('device_type, COUNT(*) as count')
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get()
            ->toArray();
    }

    /**
     * Get browser statistics
     */
    public static function getBrowserStats(): array
    {
        return self::selectRaw('browser, COUNT(*) as count')
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray();
    }
}