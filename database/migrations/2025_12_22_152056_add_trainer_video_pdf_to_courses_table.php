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
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('trainer_id')->nullable()
                ->constrained('users')->nullOnDelete()
                ->after('id');
            $table->string('video_url')->nullable()->after('description');
            $table->string('pdf_file')->nullable()->after('video_url'); // storage path
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('trainer_id');
            $table->dropColumn(['video_url', 'pdf_file']);
        });
    }
};
