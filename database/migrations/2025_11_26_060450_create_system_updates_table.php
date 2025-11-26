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
        Schema::create('system_updates', function (Blueprint $table) {
            $table->id();
            $table->string('version')->nullable();
            $table->string('commit_hash')->nullable();
            $table->string('branch')->default('main');
            $table->text('description')->nullable();
            $table->json('changes')->nullable(); // List of changed files
            $table->enum('status', ['pending', 'in_progress', 'completed', 'failed', 'rolled_back'])->default('pending');
            $table->text('log')->nullable(); // Deployment log
            $table->text('error_message')->nullable();
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_updates');
    }
};