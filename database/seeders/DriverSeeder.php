<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Driver::insert([
            [
                'name' => 'Ahmad Supardi',
                'phone' => '081234567890',
                'license_number' => 'A-1234-5678-9012',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'phone' => '081234567891',
                'license_number' => 'A-2345-6789-0123',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cahyo Wibowo',
                'phone' => '081234567892',
                'license_number' => 'A-3456-7890-1234',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
