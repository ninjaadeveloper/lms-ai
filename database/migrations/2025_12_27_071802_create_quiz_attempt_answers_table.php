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
        Schema::create('quiz_attempt_answers', function (Blueprint $table) {
            $table->id();
        $table->foreignId('attempt_id')->constrained('quiz_attempts')->cascadeOnDelete();
        $table->foreignId('question_id')->constrained('quiz_questions')->cascadeOnDelete();
        $table->string('selected_option', 1)->nullable(); // A/B/C/D
        $table->string('correct_option', 1)->nullable();
        $table->boolean('is_correct')->default(false);
        $table->timestamps();

        $table->unique(['attempt_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempt_answers');
    }
};
