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
        Schema::create('organization_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // welcome_message, organization_structure, etc.
            $table->string('title')->nullable(); // Title for the section
            $table->longText('content')->nullable(); // Main content
            $table->json('data')->nullable(); // Additional structured data (positions with photos)
            $table->string('image')->nullable(); // Optional main image
            $table->string('chairman_photo')->nullable(); // Photo of chairman for welcome message
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['key', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_settings');
    }
};
