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
        Schema::create('visitor_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->string('page_url');
            $table->string('page_title')->nullable();
            $table->string('referrer')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('device_type')->nullable(); // mobile, desktop, tablet
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->integer('session_duration')->default(0); // in seconds
            $table->boolean('is_unique_visitor')->default(false);
            $table->date('visit_date');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['visit_date', 'ip_address']);
            $table->index('page_url');
            $table->index('is_unique_visitor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_statistics');
    }
};