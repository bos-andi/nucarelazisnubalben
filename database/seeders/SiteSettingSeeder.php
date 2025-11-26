<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
            ],
            [
                'key' => 'site_title',
                'value' => 'Balongbendo Newsroom',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'site_subtitle',
                'value' => 'Lazisnu MWC NU',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'hero_title',
                'value' => 'Kabar Kebaikan & Aksi Hijau Dari Bumi Balongbendo',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_description',
                'value' => 'Menguatkan gerakan zakat, infak, sedekah, dan program sosial untuk menghadirkan kemandirian ekonomi umat.',
                'type' => 'textarea',
                'group' => 'homepage',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}