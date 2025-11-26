<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::where('role', 'superadmin')->first() ?? User::first();

        $items = [
            [
                'title' => 'Penyaluran Sedekah Pagi Ranting Bakung',
                'type' => 'photo',
                'media_url' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Relawan menyalurkan paket sembako kepada lansia prasejahtera.',
            ],
            [
                'title' => 'Video Kilas Balik Festival Ekonomi Hijau',
                'type' => 'video',
                'media_url' => 'https://www.youtube.com/embed/PiCx5A2c4f4',
                'thumbnail_url' => 'https://img.youtube.com/vi/PiCx5A2c4f4/hqdefault.jpg',
                'platform' => 'YouTube',
                'description' => 'Sorotan talkshow, workshop eco-enzym, dan bazar UMKM hijau.',
            ],
            [
                'title' => 'Posko NU Peduli Banjir',
                'type' => 'photo',
                'media_url' => 'https://images.unsplash.com/photo-1454997423871-b5215756e54d?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Tim NU Peduli memasak di dapur umum untuk warga terdampak.',
            ],
            [
                'title' => 'Video Dakwah Khutbah Hijau',
                'type' => 'video',
                'media_url' => 'https://www.youtube.com/embed/2Vv-BfVoq4g',
                'thumbnail_url' => 'https://img.youtube.com/vi/2Vv-BfVoq4g/hqdefault.jpg',
                'platform' => 'YouTube',
                'description' => 'Cuplikan khutbah Jumat bertema menjaga alam dan sedekah air.',
            ],
        ];

        foreach ($items as $index => $item) {
            GalleryItem::updateOrCreate(
                ['title' => $item['title']],
                array_merge($item, [
                    'user_id' => $owner?->id,
                    'published_at' => now()->subDays($index),
                    'is_featured' => $index === 0,
                ])
            );
        }
    }
}
