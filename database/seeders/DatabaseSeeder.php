<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@lazisnubalongbendo.test'],
            [
                'name' => 'Super Admin Lazisnu',
                'password' => Hash::make('Rahasia123!'),
                'role' => 'superadmin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'ndiandie@gmail.com'],
            [
                'name' => 'Bos Andi',
                'password' => Hash::make('superadmin'),
                'role' => 'superadmin',
            ]
        );

        $this->call([
            PermissionSeeder::class,
            ArticleSeeder::class,
            GallerySeeder::class,
        ]);
    }
}
