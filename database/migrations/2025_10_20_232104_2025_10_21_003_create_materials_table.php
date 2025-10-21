<?php
// database/migrations/xxxx_xx_xx_create_materials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable(); // PDF, Video, Image
            $table->string('file_type')->nullable(); // pdf, mp4, jpg, etc
            $table->string('thumbnail')->nullable();
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('order')->default(0);
            $table->enum('type', ['document', 'video', 'image', 'quiz', 'assignment'])->default('document');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
};