<?php
// database/migrations/xxxx_xx_xx_create_attendances_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_member_id')->constrained('class_members')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('absent');
            $table->decimal('checkin_latitude', 10, 8)->nullable();
            $table->decimal('checkin_longitude', 11, 8)->nullable();
            $table->decimal('checkin_distance', 8, 2)->nullable(); // meter
            $table->timestamp('checkin_time')->nullable();
            $table->decimal('checkout_latitude', 10, 8)->nullable();
            $table->decimal('checkout_longitude', 11, 8)->nullable();
            $table->decimal('checkout_distance', 8, 2)->nullable();
            $table->timestamp('checkout_time')->nullable();
            $table->integer('duration_minutes')->nullable(); // total durasi kehadiran
            $table->boolean('auto_checkin')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['schedule_id', 'user_id']);
            $table->index(['class_member_id', 'schedule_id']);
            $table->index('checkin_time');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};