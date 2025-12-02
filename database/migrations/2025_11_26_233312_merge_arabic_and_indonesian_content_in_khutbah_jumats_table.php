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
        Schema::table('khutbah_jumats', function (Blueprint $table) {
            // Add new content column
            $table->longText('content')->nullable()->after('slug');
        });

        // Migrate existing data: combine arabic_content and indonesian_content
        DB::statement("
            UPDATE khutbah_jumats 
            SET content = CONCAT(
                '<div class=\"arabic-content\" dir=\"rtl\" style=\"font-family: Amiri, Noto Sans Arabic, Arial, sans-serif; font-size: 18px; line-height: 2.5; margin-bottom: 2rem;\">',
                arabic_content,
                '</div>',
                '<div class=\"indonesian-content\" style=\"margin-top: 2rem;\">',
                indonesian_content,
                '</div>'
            )
        ");

        Schema::table('khutbah_jumats', function (Blueprint $table) {
            // Make content required after migration
            $table->longText('content')->nullable(false)->change();
            
            // Drop old columns
            $table->dropColumn(['arabic_content', 'indonesian_content']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('khutbah_jumats', function (Blueprint $table) {
            // Add back old columns
            $table->text('arabic_content')->after('slug');
            $table->text('indonesian_content')->after('arabic_content');
        });

        // Extract data back (simplified - just copy content to both)
        DB::statement("
            UPDATE khutbah_jumats 
            SET arabic_content = content,
                indonesian_content = content
        ");

        Schema::table('khutbah_jumats', function (Blueprint $table) {
            // Drop content column
            $table->dropColumn('content');
        });
    }
};
