<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get all student users
        $studentUsers = User::where('role', 'student')->get();
        
        // Majors array
        $majors = [
            'Computer Science',
            'Information Systems',
            'Software Engineering',
            'Data Science',
            'Artificial Intelligence',
            'Cybersecurity',
            'Business Information Technology',
            'Computer Engineering',
            'Information Technology',
            'Network Engineering',
        ];
        
        // Entry years
        $entryYears = [2020, 2021, 2022, 2023];
        
        foreach ($studentUsers as $index => $user) {
            $nim = '10' . str_pad($index + 1, 6, '0', STR_PAD_LEFT);
            
            Student::create([
                'user_id' => $user->id,
                'nim' => $nim,
                'full_name' => $faker->name,
                'major' => $faker->randomElement($majors),
                'entry_year' => $faker->randomElement($entryYears),
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'birth_date' => $faker->dateTimeBetween('-25 years', '-18 years'),
                'gender' => $faker->randomElement(['male', 'female']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}