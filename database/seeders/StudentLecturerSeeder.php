<?php

namespace Database\Seeders;

use App\Enums\ApprovalRole;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\StudentLecturer;
use Illuminate\Database\Seeder;

class StudentLecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentLecturer::create([
            'student_id' => Student::first()->id,
            'lecturer_id' => Lecturer::first()->id,
            'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR,
            'is_active' => true,
        ]);
    }
}
