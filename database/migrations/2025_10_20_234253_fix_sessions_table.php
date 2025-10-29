<?php
// database/migrations/xxxx_fix_sessions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Drop jika ada
        Schema::dropIfExists('sessions');
        
        // Buat ulang dengan struktur BENAR
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload'); // ✅ PENTING: longText
            $table->integer('last_activity')->index();
            $table->timestamps();
        });
        
        // Add foreign key constraint
        Schema::table('sessions', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
};