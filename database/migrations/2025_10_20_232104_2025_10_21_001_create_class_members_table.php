<?php
// database/migrations/xxxx_xx_xx_create_class_members_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'active', 'inactive', 'graduated'])->default('pending');
            $table->date('joined_at')->useCurrent();
            $table->timestamps();

            $table->unique(['class_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_members');
    }
};