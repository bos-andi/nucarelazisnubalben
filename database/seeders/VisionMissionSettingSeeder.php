<?php

namespace Database\Seeders;

use App\Models\VisionMissionSetting;
use Illuminate\Database\Seeder;

class VisionMissionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisionMissionSetting::updateOrCreate(
            ['id' => 1],
            [
                'vision' => 'Menjadi lembaga amil zakat terpercaya yang menghadirkan kemandirian ekonomi umat melalui pemberdayaan berkelanjutan dan transparansi pengelolaan dana sosial.',
                'mission' => '1. Menghimpun, mengelola, dan menyalurkan zakat, infak, sedekah secara amanah dan profesional.
2. Memberdayakan mustahik melalui program ekonomi produktif dan pendampingan usaha.
3. Mengembangkan program sosial yang berdampak langsung pada peningkatan kesejahteraan masyarakat.
4. Membangun jaringan kemitraan strategis untuk memperluas jangkauan program kemanusiaan.
5. Menerapkan tata kelola organisasi yang transparan dan akuntabel.',
                'background_image' => null,
                'is_active' => true,
            ]
        );
    }
}

