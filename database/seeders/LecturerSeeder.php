<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get all lecturer users
        $lecturerUsers = User::where('role', 'lecturer')->get();
        
        // Specializations array
        $specializations = [
            'Database Systems',
            'Artificial Intelligence',
            'Software Engineering',
            'Computer Networks',
            'Cybersecurity',
            'Data Science',
            'Machine Learning',
            'Web Development',
            'Mobile Development',
            'Computer Graphics',
        ];
        
        // Academic degrees
        $academicDegrees = ['Ph.D.', 'M.Sc.', 'M.Tech.', 'M.Eng.', 'D.Sc.'];
        
        foreach ($lecturerUsers as $index => $user) {
            $nip = '20' . str_pad($index + 1, 6, '0', STR_PAD_LEFT);
            
            Lecturer::create([
                'user_id' => $user->id,
                'nip' => $nip,
                'full_name' => $faker->name,
                'specialization' => $faker->randomElement($specializations),
                'academic_degree' => $faker->randomElement($academicDegrees),
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}