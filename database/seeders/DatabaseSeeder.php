<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Membership;
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

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        Membership::create(['name' => 'Basic', 'description' => 'Akses terbatas', 'monthly_price' => 150000]);
        Membership::create(['name' => 'Premium', 'description' => 'Akses 24/7', 'monthly_price' => 300000]);
        Membership::create(['name' => 'Premium', 'description' => 'Akses 24/7 + trainer', 'monthly_price' => 500000]);
    }
}
