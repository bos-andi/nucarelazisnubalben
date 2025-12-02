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
        Schema::table('users', function (Blueprint $table) {
            $table->string('ktp_file')->nullable()->after('avatar');
            $table->boolean('is_ktp_verified')->default(false)->after('ktp_file');
            $table->timestamp('ktp_verified_at')->nullable()->after('is_ktp_verified');
            $table->unsignedBigInteger('ktp_verified_by')->nullable()->after('ktp_verified_at');
            
            $table->foreign('ktp_verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['ktp_verified_by']);
            $table->dropColumn(['ktp_file', 'is_ktp_verified', 'ktp_verified_at', 'ktp_verified_by']);
        });
    }
};
