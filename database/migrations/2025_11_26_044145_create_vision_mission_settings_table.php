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
        Schema::create('vision_mission_settings', function (Blueprint $table) {
            $table->id();
            $table->text('vision')->default('Menjadi lembaga amil zakat terpercaya yang menghadirkan kemandirian ekonomi umat melalui pemberdayaan berkelanjutan dan transparansi pengelolaan dana sosial.');
            $table->text('mission')->default('1. Menghimpun, mengelola, dan menyalurkan zakat, infak, sedekah secara amanah dan profesional.
2. Memberdayakan mustahik melalui program ekonomi produktif dan pendampingan usaha.
3. Mengembangkan program sosial yang berdampak langsung pada peningkatan kesejahteraan masyarakat.
4. Membangun jaringan kemitraan strategis untuk memperluas jangkauan program kemanusiaan.
5. Menerapkan tata kelola organisasi yang transparan dan akuntabel.');
            $table->string('background_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vision_mission_settings');
    }
};