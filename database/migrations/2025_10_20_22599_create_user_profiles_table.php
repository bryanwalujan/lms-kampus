<?php
// database/migrations/xxxx_create_user_profiles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('avatar')->nullable();
            $table->string('nim_nidn')->unique()->nullable();
            $table->string('department')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('bio')->nullable();
            $table->decimal('last_latitude', 10, 8)->nullable();
            $table->decimal('last_longitude', 11, 8)->nullable();
            $table->timestamp('last_checkin')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};