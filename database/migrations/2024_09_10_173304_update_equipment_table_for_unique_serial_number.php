<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            // Удаляем старое уникальное ограничение.
            $table->dropUnique(['serial_number']);

            // Добавляем уникальное ограничение для serial_number относительно equipment_type_id.
            $table->unique(['serial_number', 'equipment_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {

            $table->dropUnique(['serial_number', 'equipment_type_id']);

            $table->unique('serial_number');
        });
    }
};
