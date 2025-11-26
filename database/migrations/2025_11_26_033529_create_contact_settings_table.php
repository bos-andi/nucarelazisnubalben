<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            
            // Header Section
            $table->string('header_subtitle')->default('Hubungi Kami');
            $table->string('header_title')->default('Sapa Tim Lazisnu Balongbendo');
            $table->text('header_description')->default('Kami siap membantu kolaborasi program kebaikan, penyaluran zakat, hingga publikasi berita komunitas Nahdliyin.');
            
            // Contact Info Section
            $table->string('office_title')->default('Sekretariat & Layanan');
            $table->text('office_address')->default('Jl. KH. Hasyim Asyari No. 12, Balongbendo, Sidoarjo');
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
            $table->text('form_description')->default('Isi data berikut, tim kami akan menghubungi maksimal 1x24 jam kerja.');
            $table->string('form_action_url')->nullable(); // For external form services like Formspree
            $table->boolean('form_enabled')->default(true);
            
            // Settings
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};