<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'content',
        'data',
        'image',
        'chairman_photo',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Get setting by key
     */
    public static function getByKey(string $key): ?self
    {
        return static::where('key', $key)->where('is_active', true)->first();
    }

    /**
     * Get all active settings ordered by sort_order
     */
    public static function getActive(): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('is_active', true)->orderBy('sort_order')->get();
    }

    /**
     * Update or create setting by key
     */
    public static function updateOrCreateByKey(string $key, array $data): self
    {
        return static::updateOrCreate(['key' => $key], $data);
    }

    /**
     * Get default profile photo URL
     */
    public static function getDefaultProfilePhoto(): string
    {
        return asset('images/default-profile.svg');
    }

    /**
     * Get chairman photo from organization structure
     */
    public function getChairmanPhoto(): string
    {
        // First check if there's a specific chairman photo
        if ($this->chairman_photo) {
            return $this->chairman_photo;
        }

        // Then check if chairman exists in organization structure
        if ($this->key === 'organization_structure' && $this->data && isset($this->data['positions'])) {
            foreach ($this->data['positions'] as $position) {
                if (isset($position['is_chairman']) && $position['is_chairman'] && !empty($position['photo'])) {
                    return $position['photo'];
                }
            }
        }

        // Return default photo
        return self::getDefaultProfilePhoto();
    }

    /**
     * Get position photo or default
     */
    public static function getPositionPhoto(?string $photo): string
    {
        return $photo ?: self::getDefaultProfilePhoto();
    }
}
