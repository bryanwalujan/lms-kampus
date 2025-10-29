<?php
// database/migrations/xxxx_create_classes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique(); // KODE-2024-001
            $table->text('description')->nullable();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'active', 'finished', 'cancelled'])->default('draft');
            $table->integer('max_students')->default(50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
};