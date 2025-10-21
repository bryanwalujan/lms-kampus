<?php
// database/migrations/xxxx_xx_xx_create_schedules_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('topic')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->integer('session_number')->default(1);
            $table->boolean('requires_attendance')->default(true);
            $table->timestamps();

            // Index untuk pencarian cepat
            $table->index(['date', 'start_time']);
            $table->index('class_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};