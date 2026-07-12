<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Create students with their corresponding user accounts
        Student::create([
            'user_id' => 2, // Assuming the user with ID 2 is a student
            'student_number' => '23.01.0001',
            'batch_year' => 2023,
            'semester' => 6,
            'gpa' => 3.75,
            'total_credits' => 120,
            'academic_status' => 'Active',
        ]);

        Student::create([
            'user_id' => 3, // Assuming the user with ID 3 is a student
            'student_number' => '23.01.0002',
            'batch_year' => 2023,
            'semester' => 6,
            'gpa' => 3.90,
            'total_credits' => 120,
            'academic_status' => 'Active',
        ]);

        Student::create([
            'user_id' => 4, // Assuming the user with ID 4 is a student
            'student_number' => '23.01.0003',
            'batch_year' => 2023,
            'semester' => 6,
            'gpa' => 3.60,
            'total_credits' => 120,
            'academic_status' => 'Active',
        ]);
    }
}
