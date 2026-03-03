<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Vehicle::insert([
            [
                'name' => 'mobil_umum_1',
                'type' => 'umum',
                'plate_number' => 'B 1234 ABC',
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'year' => 2020,
                'capacity' => 7,
                'is_active' => true,
                'notes' => 'Mobil umum untuk keperluan dinas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'mobil_umum_2',
                'type' => 'umum',
                'plate_number' => 'B 5678 DEF',
                'brand' => 'Daihatsu',
                'model' => 'Xenia',
                'year' => 2019,
                'capacity' => 7,
                'is_active' => true,
                'notes' => 'Mobil umum cadangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ambulans',
                'type' => 'ambulance',
                'plate_number' => 'B 9999 AMB',
                'brand' => 'Toyota',
                'model' => 'Hiace',
                'year' => 2021,
                'capacity' => 4,
                'is_active' => true,
                'notes' => 'Ambulans utama dengan peralatan lengkap',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ambulance_igd',
                'type' => 'ambulance',
                'plate_number' => 'B 8888 IGD',
                'brand' => 'Mitsubishi',
                'model' => 'L300',
                'year' => 2018,
                'capacity' => 3,
                'is_active' => true,
                'notes' => 'Ambulans IGD untuk emergency',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
