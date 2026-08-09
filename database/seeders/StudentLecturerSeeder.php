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
        $students = Student::all();
        $lecturers = Lecturer::all();

        $academicAdvisorLecturer = $lecturers->first();
        $internshipSupervisorLecturer = $lecturers->skip(1)->first() ?? $academicAdvisorLecturer;
        $thesisSupervisorLecturer = $lecturers->last() ?? $academicAdvisorLecturer;

        foreach ($students as $student) {
            // Dosen Wali
            StudentLecturer::create([
                'student_id' => $student->id,
                'lecturer_id' => $academicAdvisorLecturer->id,
                'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR,
                'is_active' => true,
            ]);

            // Dosen Pembimbing Magang
            StudentLecturer::create([
                'student_id' => $student->id,
                'lecturer_id' => $internshipSupervisorLecturer->id,
                'lecturer_role' => ApprovalRole::INTERNSHIP_SUPERVISOR,
                'is_active' => true,
            ]);

            // Dosen Pembimbing Skripsi / Tugas Akhir
            StudentLecturer::create([
                'student_id' => $student->id,
                'lecturer_id' => $thesisSupervisorLecturer->id,
                'lecturer_role' => ApprovalRole::THESIS_SUPERVISOR,
                'is_active' => true,
            ]);
        }
    }
}
