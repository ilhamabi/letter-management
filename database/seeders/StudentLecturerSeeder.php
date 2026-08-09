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

        $lecturerA = $lecturers->skip(0)->first(); // Dr. Ahmad Wijaya (Dosen Wali + Kaprodi)
        $lecturerB = $lecturers->skip(1)->first(); // Dr. Siti Rahma (Dosen Pembimbing + Kaprodi)
        $lecturerC = $lecturers->skip(2)->first(); // Dr. Heri Setyawan (Dosen Wali + Dosen Pembimbing)
        $lecturerD = $lecturers->skip(3)->first(); // Dr. Bambang Susilo (Dosen Wali + Dosen Pembimbing + Kaprodi)

        foreach ($students as $index => $student) {
            if ($index === 0) {
                // Student 1 (Budi Santoso) -> Lecturer A is Dosen Wali, Lecturer B is Internship Supervisor, Lecturer C is Thesis Supervisor
                StudentLecturer::create([
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturerA->id,
                    'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR,
                    'is_active' => true,
                ]);

                StudentLecturer::create([
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturerB->id,
                    'lecturer_role' => ApprovalRole::INTERNSHIP_SUPERVISOR,
                    'is_active' => true,
                ]);

                StudentLecturer::create([
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturerC->id,
                    'lecturer_role' => ApprovalRole::THESIS_SUPERVISOR,
                    'is_active' => true,
                ]);
            } elseif ($index === 1) {
                // Student 2 (Andi Saputra) -> Lecturer C is Dosen Wali, Lecturer B is Thesis Supervisor & Internship Supervisor
                StudentLecturer::create([
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturerC->id,
                    'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR,
                    'is_active' => true,
                ]);

                StudentLecturer::create([
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturerB->id,
                    'lecturer_role' => ApprovalRole::INTERNSHIP_SUPERVISOR,
                    'is_active' => true,
                ]);

                StudentLecturer::create([
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturerB->id,
                    'lecturer_role' => ApprovalRole::THESIS_SUPERVISOR,
                    'is_active' => true,
                ]);
            } else {
                // Student 3 (Citra Dewi) -> Lecturer D is Dosen Wali + Internship Supervisor + Thesis Supervisor
                StudentLecturer::create([
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturerD->id,
                    'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR,
                    'is_active' => true,
                ]);

                StudentLecturer::create([
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturerD->id,
                    'lecturer_role' => ApprovalRole::INTERNSHIP_SUPERVISOR,
                    'is_active' => true,
                ]);

                StudentLecturer::create([
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturerD->id,
                    'lecturer_role' => ApprovalRole::THESIS_SUPERVISOR,
                    'is_active' => true,
                ]);
            }
        }
    }
}
