<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get all students and courses
        $students = Student::all();
        $courses = Course::all();
        
        // Statuses
        $statuses = ['active', 'completed', 'dropped'];
        
        // For each student, enroll in 3-8 courses
        foreach ($students as $student) {
            // Randomly select 3-8 courses
            $selectedCourses = $courses->random($faker->numberBetween(3, 8));
            
            foreach ($selectedCourses as $course) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'academic_year' => '2023/2024',
                    'semester' => $course->semester,
                    'status' => $faker->randomElement($statuses),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}