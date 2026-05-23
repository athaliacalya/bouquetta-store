<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed flowers
        $this->call(FlowerSeeder::class);

        // Create default admin user
        User::updateOrCreate(
            ['email' => 'admin@bouquetta.id'],
            [
                'name'      => 'Admin Bouquetta',
                'email'     => 'admin@bouquetta.id',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'is_active' => true,
                'phone'     => '08123456789',
            ]
        );

        // Create demo customer
        User::updateOrCreate(
            ['email' => 'demo@bouquetta.id'],
            [
                'name'      => 'Demo Customer',
                'email'     => 'demo@bouquetta.id',
                'password'  => Hash::make('demo123'),
                'role'      => 'customer',
                'is_active' => true,
                'phone'     => '08987654321',
            ]
        );
    }
}
