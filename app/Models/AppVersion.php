<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'version',
        'version_string',
        'timestamp',
        'description',
        'created_by'
    ];

    /**
     * Get the user who created this version
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get current version
     */
    public static function current(): ?self
    {
        return self::latest('created_at')->first();
    }

    /**
     * Get next version number
     */
    public static function getNextVersion(): string
    {
        $current = self::current();
        if (!$current) {
            return '1.1';
        }

        // Extract major and minor version
        $parts = explode('.', $current->version);
        $major = (int)$parts[0];
        $minor = (int)$parts[1];

        // Increment minor version
        $minor++;

        return "{$major}.{$minor}";
    }

    /**
     * Create new version
     */
    public static function createNew(?string $description = null): self
    {
        $version = self::getNextVersion();
        $timestamp = date('YmdHis');
        $versionString = "Versi {$version} ({$timestamp})";

        return self::create([
            'version' => $version,
            'version_string' => $versionString,
            'timestamp' => $timestamp,
            'description' => $description ?? 'Update package generated',
            'created_by' => auth()->id()
        ]);
    }
}
