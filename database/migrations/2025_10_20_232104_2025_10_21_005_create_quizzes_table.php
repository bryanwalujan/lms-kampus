<?php
// database/migrations/xxxx_xx_xx_create_quizzes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->text('instructions')->nullable();
            $table->integer('total_questions');
            $table->integer('time_limit')->default(30); // menit
            $table->decimal('passing_score', 5, 2)->default(70.00);
            $table->enum('status', ['draft', 'published', 'active', 'closed', 'archived'])->default('draft');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('max_attempts')->default(1);
            $table->boolean('randomize_questions')->default(true);
            $table->boolean('show_results_immediately')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
};