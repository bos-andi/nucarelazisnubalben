<?php

namespace App\Helpers;

class YouTubeHelper
{
    /**
     * Extract YouTube video ID from various YouTube URL formats
     */
    public static function extractVideoId($url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Pattern untuk berbagai format YouTube URL
        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/v\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Get YouTube thumbnail URL from video ID
     */
    public static function getThumbnailUrl($videoId, $quality = 'hqdefault'): string
    {
        if (empty($videoId)) {
            return '';
        }

        // Available qualities: default, mqdefault, hqdefault, sddefault, maxresdefault
        // Using hqdefault as it's more reliable than maxresdefault
        return "https://img.youtube.com/vi/{$videoId}/{$quality}.jpg";
    }

    /**
     * Get YouTube embed URL from video ID
     */
    public static function getEmbedUrl($videoId, $autoplay = false): string
    {
        if (empty($videoId)) {
            return '';
        }

        $params = [];
        if ($autoplay) {
            $params[] = 'autoplay=1';
        }
        
        $queryString = !empty($params) ? '?' . implode('&', $params) : '';
        
        return "https://www.youtube.com/embed/{$videoId}{$queryString}";
    }

    /**
     * Check if URL is a YouTube URL
     */
    public static function isYouTubeUrl($url): bool
    {
        return !empty($url) && (
            str_contains($url, 'youtube.com') || 
            str_contains($url, 'youtu.be')
        );
    }

    /**
     * Get all YouTube video info from URL
     */
    public static function getVideoInfo($url): array
    {
        $videoId = self::extractVideoId($url);
        
        if (!$videoId) {
            return [
                'video_id' => null,
                'thumbnail_url' => '',
                'embed_url' => '',
                'is_youtube' => false,
            ];
        }

        return [
            'video_id' => $videoId,
            'thumbnail_url' => self::getThumbnailUrl($videoId, 'hqdefault'),
            'embed_url' => self::getEmbedUrl($videoId),
            'is_youtube' => true,
        ];
    }

    /**
     * Get YouTube thumbnail URL with fallback qualities
     */
    public static function getThumbnailUrlWithFallback($videoId): string
    {
        if (empty($videoId)) {
            return '';
        }

        // Try different qualities in order of preference
        $qualities = ['hqdefault', 'mqdefault', 'default'];
        
        foreach ($qualities as $quality) {
            $url = "https://img.youtube.com/vi/{$videoId}/{$quality}.jpg";
            
            // Check if thumbnail exists (this is a simple approach)
            // In production, you might want to cache this or use a more sophisticated check
            return $url; // Return first quality for now
        }

        return '';
    }
}
