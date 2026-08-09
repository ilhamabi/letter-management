<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'user_id' => User::where('username', '20210001')->first()->id,
            'student_number' => '20210001',
            'batch_year' => 2021,
            'semester' => 8,
            'gpa' => 3.75,
            'total_credits' => 144,
            'academic_status' => 'ACTIVE',
        ]);

        Student::create([
            'user_id' => User::where('username', '20210002')->first()->id,
            'student_number' => '20210002',
            'batch_year' => 2021,
            'semester' => 8,
            'gpa' => 3.65,
            'total_credits' => 140,
            'academic_status' => 'ACTIVE',
        ]);

        Student::create([
            'user_id' => User::where('username', '20210003')->first()->id,
            'student_number' => '20210003',
            'batch_year' => 2021,
            'semester' => 8,
            'gpa' => 3.80,
            'total_credits' => 142,
            'academic_status' => 'ACTIVE',
        ]);
    }
}
