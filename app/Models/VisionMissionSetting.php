<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionMissionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'vision',
        'mission',
        'background_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the first (and should be only) vision mission setting record
     */
    public static function getSettings(): self
    {
        return self::firstOrCreate([]);
    }
}