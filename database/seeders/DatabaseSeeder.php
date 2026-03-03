<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['name' => 'Test User'],
            [
                'email' => 'test@example.com',
                'unit_kerja' => 'IGD',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        User::updateOrCreate(
            ['name' => 'Administrator'],
            [
                'email' => 'admin@example.com',
                'unit_kerja' => 'Umum',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
    }
}
