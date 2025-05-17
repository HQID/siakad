<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get all lecturers
        $lecturers = Lecturer::all();
        
        // Course data
        $courses = [
            [
                'code' => 'CS101',
                'name' => 'Introduction to Computer Science',
                'credits' => 3,
                'semester' => 'Fall 2023',
                'description' => 'An introductory course to computer science principles and programming concepts.'
            ],
            [
                'code' => 'CS102',
                'name' => 'Programming Fundamentals',
                'credits' => 4,
                'semester' => 'Fall 2023',
                'description' => 'Basic programming concepts using a high-level programming language.'
            ],
            [
                'code' => 'CS201',
                'name' => 'Data Structures and Algorithms',
                'credits' => 4,
                'semester' => 'Spring 2024',
                'description' => 'Study of data structures, algorithms, and their applications.'
            ],
            [
                'code' => 'CS202',
                'name' => 'Database Systems',
                'credits' => 3,
                'semester' => 'Spring 2024',
                'description' => 'Introduction to database concepts, design, and implementation.'
            ],
            [
                'code' => 'CS301',
                'name' => 'Software Engineering',
                'credits' => 4,
                'semester' => 'Fall 2023',
                'description' => 'Principles and practices of software development and project management.'
            ],
            [
                'code' => 'CS302',
                'name' => 'Web Development',
                'credits' => 3,
                'semester' => 'Fall 2023',
                'description' => 'Concepts and technologies for developing web applications.'
            ],
            [
                'code' => 'CS303',
                'name' => 'Mobile Application Development',
                'credits' => 3,
                'semester' => 'Spring 2024',
                'description' => 'Principles and practices of mobile application development.'
            ],
            [
                'code' => 'CS401',
                'name' => 'Artificial Intelligence',
                'credits' => 4,
                'semester' => 'Fall 2023',
                'description' => 'Introduction to artificial intelligence concepts and applications.'
            ],
            [
                'code' => 'CS402',
                'name' => 'Machine Learning',
                'credits' => 4,
                'semester' => 'Spring 2024',
                'description' => 'Fundamentals of machine learning algorithms and applications.'
            ],
            [
                'code' => 'CS403',
                'name' => 'Computer Networks',
                'credits' => 3,
                'semester' => 'Fall 2023',
                'description' => 'Principles and practices of computer networking.'
            ],
            [
                'code' => 'CS404',
                'name' => 'Cybersecurity',
                'credits' => 3,
                'semester' => 'Spring 2024',
                'description' => 'Introduction to cybersecurity concepts and practices.'
            ],
            [
                'code' => 'CS405',
                'name' => 'Cloud Computing',
                'credits' => 3,
                'semester' => 'Fall 2023',
                'description' => 'Introduction to cloud computing technologies and services.'
            ],
            [
                'code' => 'CS406',
                'name' => 'Big Data Analytics',
                'credits' => 4,
                'semester' => 'Spring 2024',
                'description' => 'Concepts and technologies for big data processing and analytics.'
            ],
            [
                'code' => 'CS407',
                'name' => 'Computer Graphics',
                'credits' => 3,
                'semester' => 'Fall 2023',
                'description' => 'Principles and techniques of computer graphics.'
            ],
            [
                'code' => 'CS408',
                'name' => 'Operating Systems',
                'credits' => 4,
                'semester' => 'Spring 2024',
                'description' => 'Concepts and principles of operating systems.'
            ],
            [
                'code' => 'CS409',
                'name' => 'Distributed Systems',
                'credits' => 3,
                'semester' => 'Fall 2023',
                'description' => 'Principles and practices of distributed computing systems.'
            ],
            [
                'code' => 'CS410',
                'name' => 'Human-Computer Interaction',
                'credits' => 3,
                'semester' => 'Spring 2024',
                'description' => 'Principles and practices of designing user interfaces and interactions.'
            ],
            [
                'code' => 'CS411',
                'name' => 'Computer Vision',
                'credits' => 4,
                'semester' => 'Fall 2023',
                'description' => 'Introduction to computer vision algorithms and applications.'
            ],
            [
                'code' => 'CS412',
                'name' => 'Natural Language Processing',
                'credits' => 4,
                'semester' => 'Spring 2024',
                'description' => 'Concepts and techniques for processing and understanding natural language.'
            ],
            [
                'code' => 'CS413',
                'name' => 'Internet of Things',
                'credits' => 3,
                'semester' => 'Fall 2023',
                'description' => 'Introduction to IoT technologies, architectures, and applications.'
            ],
        ];
        
        foreach ($courses as $courseData) {
            Course::create([
                'code' => $courseData['code'],
                'name' => $courseData['name'],
                'credits' => $courseData['credits'],
                'semester' => $courseData['semester'],
                'description' => $courseData['description'],
                'lecturer_id' => $lecturers->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}