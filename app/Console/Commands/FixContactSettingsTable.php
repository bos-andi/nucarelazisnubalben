<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

class FixContactSettingsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:contact-settings-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix contact_settings table if it does not exist (even if migration is marked as run)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔧 Checking contact_settings table...');
        $this->newLine();

        // Check if table exists
        if (Schema::hasTable('contact_settings')) {
            $this->info('✅ Table contact_settings already exists.');
            
            // Check if table has data
            $count = DB::table('contact_settings')->count();
            if ($count > 0) {
                $this->info("   📊 Found {$count} record(s) in the table.");
            } else {
                $this->warn('   ⚠️  Table exists but is empty.');
                if ($this->confirm('   Do you want to insert default data?', true)) {
                    $this->insertDefaultData();
                }
            }
            
            return 0;
        }

        // Table doesn't exist, create it
        $this->warn('⚠️  Table contact_settings does not exist.');
        $this->info('📝 Creating table contact_settings...');

        try {
            Schema::create('contact_settings', function (Blueprint $table) {
                $table->id();
                
                // Header Section
                $table->string('header_subtitle')->default('Hubungi Kami');
                $table->string('header_title')->default('Sapa Tim Lazisnu Balongbendo');
                $table->text('header_description')->nullable(); // TEXT cannot have default value in MySQL
                
                // Contact Info Section
                $table->string('office_title')->default('Sekretariat & Layanan');
                $table->text('office_address')->nullable(); // TEXT cannot have default value in MySQL
                $table->string('office_hours')->default('Senin - Sabtu, 08.00 - 16.00 WIB');
                $table->string('phone')->default('0813-1234-5678');
                $table->string('email')->default('media@lazisnubalongbendo.or.id');
                $table->string('instagram')->default('@lazisnu.balongbendo');
                $table->string('facebook')->default('Lazisnu Balongbendo');
                $table->string('whatsapp_number')->default('6281312345678');
                $table->string('whatsapp_text')->default('Chat WhatsApp');
                
                // Map Section
                $table->text('map_embed_url')->nullable();
                $table->boolean('show_map')->default(true);
                
                // Form Section
                $table->string('form_subtitle')->default('Formulir Singkat');
                $table->string('form_title')->default('Kirim kebutuhan programmu');
                $table->text('form_description')->nullable(); // TEXT cannot have default value in MySQL
                $table->string('form_action_url')->nullable(); // For external form services like Formspree
                $table->boolean('form_enabled')->default(true);
                
                // Settings
                $table->boolean('is_active')->default(true);
                
                $table->timestamps();
            });

            $this->info('✅ Table contact_settings created successfully!');
            $this->newLine();

            // Insert default data (required since TEXT columns can't have default values)
            $this->info('📥 Inserting default data...');
            $this->insertDefaultData();

            $this->newLine();
            $this->info('🎉 Fix completed successfully!');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error creating table: ' . $e->getMessage());
            $this->error('   Stack trace: ' . $e->getTraceAsString());
            return 1;
        }
    }

    /**
     * Insert default data into contact_settings table
     */
    private function insertDefaultData(): void
    {
        $this->info('📥 Inserting default data...');

        try {
            DB::table('contact_settings')->insert([
                'header_subtitle' => 'Hubungi Kami',
                'header_title' => 'Sapa Tim Lazisnu Balongbendo',
                'header_description' => 'Kami siap membantu kolaborasi program kebaikan, penyaluran zakat, hingga publikasi berita komunitas Nahdliyin.',
                'office_title' => 'Sekretariat & Layanan',
                'office_address' => 'Jl. KH. Hasyim Asyari No. 12, Balongbendo, Sidoarjo',
                'office_hours' => 'Senin - Sabtu, 08.00 - 16.00 WIB',
                'phone' => '0813-1234-5678',
                'email' => 'media@lazisnubalongbendo.or.id',
                'instagram' => '@lazisnu.balongbendo',
                'facebook' => 'Lazisnu Balongbendo',
                'whatsapp_number' => '6281312345678',
                'whatsapp_text' => 'Chat WhatsApp',
                'map_embed_url' => null,
                'show_map' => true,
                'form_subtitle' => 'Formulir Singkat',
                'form_title' => 'Kirim kebutuhan programmu',
                'form_description' => 'Isi data berikut, tim kami akan menghubungi maksimal 1x24 jam kerja.',
                'form_action_url' => null,
                'form_enabled' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->info('✅ Default data inserted successfully!');
        } catch (\Exception $e) {
            $this->error('❌ Error inserting data: ' . $e->getMessage());
        }
    }
}
