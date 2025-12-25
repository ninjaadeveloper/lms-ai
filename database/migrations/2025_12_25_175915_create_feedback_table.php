<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');          // student/trainer
            $table->string('user_role')->nullable();        // student/trainer (snapshot)
            $table->string('subject')->nullable();
            $table->text('message');
            $table->tinyInteger('rating')->nullable();      // 1-5 optional
            $table->string('status')->default('new');       // new/read/resolved optional
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
