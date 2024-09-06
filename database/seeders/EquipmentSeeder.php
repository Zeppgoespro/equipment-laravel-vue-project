<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipment::create([
            'equipment_type_id' => 1,
            'serial_number' => '12ABCDE7FG',
            'desc' => 'Маршрутизатор TP-Link.'
        ]);

        Equipment::create([
            'equipment_type_id' => 2,
            'serial_number' => '5XBYAZzba',
            'desc' => 'Маршрутизатор D-Link.'
        ]);
    }
}
