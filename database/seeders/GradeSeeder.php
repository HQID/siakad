<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get all completed enrollments
        $completedEnrollments = Enrollment::where('status', 'completed')->get();
        
        // Get some active enrollments (70% of them)
        $activeEnrollments = Enrollment::where('status', 'active')->get()->random(
            (int) (Enrollment::where('status', 'active')->count() * 0.7)
        );
        
        // Combine enrollments
        $enrollments = $completedEnrollments->merge($activeEnrollments);
        
        // Grade letters mapping
        $gradeLetters = [
            [90, 100, 'A'],
            [85, 89.99, 'A-'],
            [80, 84.99, 'B+'],
            [75, 79.99, 'B'],
            [70, 74.99, 'B-'],
            [65, 69.99, 'C+'],
            [60, 64.99, 'C'],
            [50, 59.99, 'D'],
            [0, 49.99, 'E'],
        ];
        
        foreach ($enrollments as $enrollment) {
            // Generate random scores
            $assignmentScore = $faker->numberBetween(50, 100);
            $midExamScore = $faker->numberBetween(50, 100);
            $finalExamScore = $faker->numberBetween(50, 100);
            
            // Calculate final score (30% assignment, 30% mid exam, 40% final exam)
            $finalScore = ($assignmentScore * 0.3) + ($midExamScore * 0.3) + ($finalExamScore * 0.4);
            
            // Determine grade letter
            $gradeLetter = 'E';
            foreach ($gradeLetters as $grade) {
                if ($finalScore >= $grade[0] && $finalScore <= $grade[1]) {
                    $gradeLetter = $grade[2];
                    break;
                }
            }
            
            Grade::create([
                'enrollment_id' => $enrollment->id,
                'assignment_score' => $assignmentScore,
                'mid_exam_score' => $midExamScore,
                'final_exam_score' => $finalExamScore,
                'final_score' => $finalScore,
                'grade_letter' => $gradeLetter,
                'notes' => $faker->optional(0.7)->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}