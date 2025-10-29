<?php
// database/migrations/xxxx_xx_xx_create_quiz_attempts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_member_id')->constrained('class_members')->onDelete('cascade');
            $table->integer('attempt_number')->default(1);
            $table->decimal('score', 5, 2)->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->integer('time_spent')->nullable(); // detik
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->enum('status', ['started', 'completed', 'submitted', 'graded'])->default('started');
            $table->longText('answers')->nullable(); // JSON: {"1": "A", "2": "text"}
            $table->timestamps();

            $table->unique(['quiz_id', 'user_id', 'attempt_number']);
            $table->index(['user_id', 'quiz_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_attempts');
    }
};