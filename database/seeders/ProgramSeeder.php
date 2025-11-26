<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'title' => 'Sedekah Produktif',
                'icon' => '🌱',
                'description' => 'Pemberdayaan UMKM hijau dengan modal bergulir dan pendampingan branding.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Respon Cepat Bencana',
                'icon' => '🤝',
                'description' => 'Gerak cepat relawan NU Peduli membawa logistik dan layanan kesehatan.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Beasiswa Santri',
                'icon' => '📚',
                'description' => 'Investasi pendidikan dengan pelatihan wirausaha digital bagi santri kreatif.',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($programs as $program) {
            Program::firstOrCreate(
                ['title' => $program['title']],
                $program
            );
        }
    }
}