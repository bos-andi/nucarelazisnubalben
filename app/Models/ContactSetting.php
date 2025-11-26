<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_subtitle',
        'header_title',
        'header_description',
        'office_title',
        'office_address',
        'office_hours',
        'phone',
        'email',
        'instagram',
        'facebook',
        'whatsapp_number',
        'whatsapp_text',
        'map_embed_url',
        'show_map',
        'form_subtitle',
        'form_title',
        'form_description',
        'form_action_url',
        'form_enabled',
        'is_active',
    ];

    protected $casts = [
        'show_map' => 'boolean',
        'form_enabled' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the first (and should be only) contact setting record
     */
    public static function getSettings(): self
    {
        return self::firstOrCreate([]);
    }

    /**
     * Get WhatsApp URL
     */
    public function getWhatsAppUrl(): string
    {
        return "https://wa.me/{$this->whatsapp_number}";
    }

    /**
     * Get formatted phone number for display
     */
    public function getFormattedPhone(): string
    {
        // Convert from international format to local display
        $phone = $this->phone;
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }
        return $phone;
    }
}