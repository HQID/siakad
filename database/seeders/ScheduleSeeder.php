<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get all courses
        $courses = Course::all();
        
        // Days of the week
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        
        // Time slots
        $timeSlots = [
            ['08:00', '09:40'],
            ['10:00', '11:40'],
            ['13:00', '14:40'],
            ['15:00', '16:40'],
        ];
        
        // Rooms
        $rooms = ['A101', 'A102', 'A103', 'B101', 'B102', 'B103', 'C101', 'C102', 'C103'];
        
        // Create schedules for each course
        foreach ($courses as $course) {
            // Each course has 1-2 schedules
            $scheduleCount = $faker->numberBetween(1, 2);
            
            for ($i = 0; $i < $scheduleCount; $i++) {
                $timeSlot = $faker->randomElement($timeSlots);
                
                Schedule::create([
                    'course_id' => $course->id,
                    'day' => $faker->randomElement($days),
                    'start_time' => $timeSlot[0],
                    'end_time' => $timeSlot[1],
                    'room' => $faker->randomElement($rooms),
                    'academic_year' => '2023/2024',
                    'semester' => $course->semester,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}