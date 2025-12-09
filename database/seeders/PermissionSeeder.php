<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Content Management
            [
                'name' => 'manage_articles',
                'display_name' => 'Kelola Berita',
                'group' => 'content',
                'description' => 'Bisa menambah, edit, dan hapus berita',
            ],
            [
                'name' => 'manage_gallery',
                'display_name' => 'Kelola Galeri',
                'group' => 'content',
                'description' => 'Bisa menambah, edit, dan hapus galeri',
            ],
            [
                'name' => 'manage_khutbah',
                'display_name' => 'Kelola Khutbah Jum\'at',
                'group' => 'content',
                'description' => 'Bisa menambah, edit, dan hapus khutbah Jum\'at',
            ],
            
            // Master Data
            [
                'name' => 'manage_categories',
                'display_name' => 'Kelola Kategori',
                'group' => 'master_data',
                'description' => 'Bisa menambah, edit, dan hapus kategori',
            ],
            [
                'name' => 'manage_tags',
                'display_name' => 'Kelola Tag',
                'group' => 'master_data',
                'description' => 'Bisa menambah, edit, dan hapus tag',
            ],
            [
                'name' => 'manage_programs',
                'display_name' => 'Kelola Program',
                'group' => 'master_data',
                'description' => 'Bisa menambah, edit, dan hapus program',
            ],
            
            // User Management
            [
                'name' => 'manage_contributors',
                'display_name' => 'Kelola Kontributor',
                'group' => 'users',
                'description' => 'Bisa approve, reject, dan manage kontributor',
            ],
            [
                'name' => 'manage_permissions',
                'display_name' => 'Kelola Permission',
                'group' => 'users',
                'description' => 'Bisa mengatur permission untuk setiap user',
            ],
            
            // Settings
            [
                'name' => 'manage_settings',
                'display_name' => 'Kelola Pengaturan Website',
                'group' => 'settings',
                'description' => 'Bisa mengubah pengaturan website',
            ],
            [
                'name' => 'manage_adsense',
                'display_name' => 'Kelola AdSense',
                'group' => 'settings',
                'description' => 'Bisa mengatur AdSense',
            ],
            [
                'name' => 'manage_organization',
                'display_name' => 'Kelola Organisasi',
                'group' => 'settings',
                'description' => 'Bisa mengubah informasi organisasi',
            ],
            [
                'name' => 'manage_contact',
                'display_name' => 'Kelola Kontak',
                'group' => 'settings',
                'description' => 'Bisa mengubah informasi kontak',
            ],
            [
                'name' => 'manage_system_updates',
                'display_name' => 'Kelola System Updates',
                'group' => 'settings',
                'description' => 'Bisa mengakses dan manage system updates',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
