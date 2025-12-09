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
        Schema::create('khutbah_jumats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('arabic_content'); // Konten bahasa Arab
            $table->text('indonesian_content'); // Terjemahan bahasa Indonesia
            $table->date('khutbah_date'); // Tanggal khutbah
            $table->string('khatib')->nullable(); // Nama khatib
            $table->string('location')->nullable(); // Lokasi khutbah
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khutbah_jumats');
    }
};





