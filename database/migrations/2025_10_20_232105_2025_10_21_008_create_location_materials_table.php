<?php
// database/migrations/xxxx_xx_xx_create_location_materials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('location_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->decimal('radius_trigger', 8, 2)->default(50); // meter untuk trigger
            $table->integer('priority')->default(0); // urutan tampil
            $table->boolean('auto_play')->default(false); // otomatis main saat dekat
            $table->timestamps();

            $table->unique(['location_id', 'material_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_materials');
    }
};