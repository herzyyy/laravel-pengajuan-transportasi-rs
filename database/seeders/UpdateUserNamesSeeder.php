<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateUserNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing users to split their names
        $users = User::all();
        
        foreach ($users as $user) {
            // Split first_name into first and last name
            $nameParts = explode(' ', trim($user->first_name), 2);
            
            $user->update([
                'first_name' => $nameParts[0] ?? 'User',
                'last_name' => $nameParts[1] ?? 'Default',
            ]);
        }
        
        // Create demo accounts if they don't exist
        if (!User::where('first_name', 'Test')->where('last_name', 'User')->exists()) {
            User::create([
                'first_name' => 'Test',
                'last_name' => 'User',
                'password' => bcrypt('password'),
                'unit_kerja' => 'Unit Demo',
                'role' => 'user',
            ]);
        }
        
        if (!User::where('first_name', 'Admin')->where('last_name', 'Azra')->exists()) {
            User::create([
                'first_name' => 'Admin',
                'last_name' => 'Azra',
                'password' => bcrypt('password123'),
                'unit_kerja' => 'Administrator',
                'role' => 'admin',
            ]);
        }
    }
}
