<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create lecturer users
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => 'lecturer' . $i,
                'email' => 'lecturer' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'lecturer',
            ]);
        }

        // Create student users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'student' . $i,
                'email' => 'student' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
        }
    }
}