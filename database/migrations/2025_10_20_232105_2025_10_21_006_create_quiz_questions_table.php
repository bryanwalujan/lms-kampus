<?php
// database/migrations/xxxx_xx_xx_create_quiz_questions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->longText('options')->nullable(); // JSON: ["A", "B", "C", "D"]
            $table->text('correct_answer'); // A, B, C, D atau JSON untuk essay
            $table->decimal('score', 5, 2)->default(1.00);
            $table->enum('type', ['multiple_choice', 'true_false', 'essay', 'fill_blank'])->default('multiple_choice');
            $table->text('explanation')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('quiz_id');
            $table->index('order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_questions');
    }
};