<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VisitorStatistic;
// use Jenssegers\Agent\Agent;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for admin routes, API routes, and assets
        if ($this->shouldSkipTracking($request)) {
            return $next($request);
        }

        try {
            $this->trackVisitor($request);
        } catch (\Exception $e) {
            // Log error but don't break the request
            \Log::error('Visitor tracking failed: ' . $e->getMessage());
        }

        return $next($request);
    }

    /**
     * Determine if we should skip tracking for this request
     */
    private function shouldSkipTracking(Request $request): bool
    {
        $path = $request->path();
        
        // Skip admin routes
        if (str_starts_with($path, 'dashboard') || str_starts_with($path, 'adminlur')) {
            return true;
        }

        // Skip API routes
        if (str_starts_with($path, 'api/')) {
            return true;
        }

        // Skip assets and static files
        $skipExtensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf'];
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if (in_array(strtolower($extension), $skipExtensions)) {
            return true;
        }

        // Skip AJAX requests
        if ($request->ajax()) {
            return true;
        }

        return false;
    }

    /**
     * Track the visitor
     */
    private function trackVisitor(Request $request): void
    {
        $ipAddress = $this->getClientIpAddress($request);
        $today = today();
        $userAgent = $request->userAgent() ?? '';

        // Check if this is a unique visitor (first visit today from this IP)
        $isUniqueVisitor = !VisitorStatistic::where('ip_address', $ipAddress)
            ->whereDate('visit_date', $today)
            ->exists();

        // Get device and browser info from user agent
        $deviceType = $this->getDeviceTypeFromUserAgent($userAgent);
        $browser = $this->getBrowserFromUserAgent($userAgent);
        $os = $this->getOSFromUserAgent($userAgent);

        // Create visitor record
        VisitorStatistic::create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'page_url' => $request->fullUrl(),
            'page_title' => $this->getPageTitle($request),
            'referrer' => $request->header('referer'),
            'device_type' => $deviceType,
            'browser' => $browser,
            'os' => $os,
            'is_unique_visitor' => $isUniqueVisitor,
            'visit_date' => $today,
        ]);
    }

    /**
     * Get client IP address
     */
    private function getClientIpAddress(Request $request): string
    {
        $ipKeys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ips = explode(',', $_SERVER[$key]);
                return trim($ips[0]);
            }
        }

        return $request->ip() ?? '127.0.0.1';
    }

    /**
     * Get device type from user agent
     */
    private function getDeviceTypeFromUserAgent(string $userAgent): string
    {
        $userAgent = strtolower($userAgent);
        
        if (preg_match('/mobile|android|iphone|ipod|blackberry|windows phone/i', $userAgent)) {
            return 'mobile';
        } elseif (preg_match('/tablet|ipad/i', $userAgent)) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    /**
     * Get browser from user agent
     */
    private function getBrowserFromUserAgent(string $userAgent): string
    {
        if (preg_match('/chrome/i', $userAgent)) {
            return 'Chrome';
        } elseif (preg_match('/firefox/i', $userAgent)) {
            return 'Firefox';
        } elseif (preg_match('/safari/i', $userAgent)) {
            return 'Safari';
        } elseif (preg_match('/edge/i', $userAgent)) {
            return 'Edge';
        } elseif (preg_match('/opera/i', $userAgent)) {
            return 'Opera';
        } else {
            return 'Unknown';
        }
    }

    /**
     * Get OS from user agent
     */
    private function getOSFromUserAgent(string $userAgent): string
    {
        if (preg_match('/windows/i', $userAgent)) {
            return 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            return 'macOS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            return 'Linux';
        } elseif (preg_match('/android/i', $userAgent)) {
            return 'Android';
        } elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
            return 'iOS';
        } else {
            return 'Unknown';
        }
    }

    /**
     * Get page title based on route
     */
    private function getPageTitle(Request $request): string
    {
        $routeName = $request->route()?->getName();
        
        $titles = [
            'home' => 'Beranda',
            'news' => 'Berita',
            'programs' => 'Program',
            'gallery' => 'Galeri',
            'contact' => 'Kontak',
            'visi-misi' => 'Visi Misi',
            'sambutan' => 'Sambutan',
            'struktur' => 'Struktur Organisasi',
            'articles.show' => 'Detail Artikel',
            'gallery.show' => 'Detail Galeri',
            'author.profile' => 'Profil Penulis',
        ];

        return $titles[$routeName] ?? 'Halaman Website';
    }
}