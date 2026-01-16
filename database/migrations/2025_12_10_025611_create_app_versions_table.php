<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if table already exists (for existing databases)
        if (!Schema::hasTable('app_versions')) {
            Schema::create('app_versions', function (Blueprint $table) {
                $table->id();
                $table->string('version')->unique(); // Format: 1.1, 1.2, 1.3, etc
                $table->string('version_string'); // Format: Versi 1.1 (20251205131551)
                $table->string('timestamp'); // Format: 20251205131551
                $table->text('description')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }

        // Insert initial version only if table is empty
        if (Schema::hasTable('app_versions') && DB::table('app_versions')->count() === 0) {
            DB::table('app_versions')->insert([
                'version' => '1.1',
                'version_string' => 'Versi 1.1 (' . date('YmdHis') . ')',
                'timestamp' => date('YmdHis'),
                'description' => 'Initial version',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_versions');
    }
};
