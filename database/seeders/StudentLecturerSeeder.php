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
        $lec1 = Lecturer::where('employee_number', '19870001')->first(); // Dr. Ahmad Wijaya (Wali + Kaprodi)
        $lec2 = Lecturer::where('employee_number', '19870002')->first(); // Dr. Siti Rahma (Magang + Kaprodi)
        $lec3 = Lecturer::where('employee_number', '19870003')->first(); // Dr. Heri Setyawan (Wali + TA)
        $lec4 = Lecturer::where('employee_number', '19870004')->first(); // Dr. Bambang Susilo (Multi-Role All)
        $lec5 = Lecturer::where('employee_number', '19870005')->first(); // Dr. Eko Prasetyo (Single Wali)
        $lec6 = Lecturer::where('employee_number', '19870006')->first(); // Dra. Fitriani (Single Magang)
        $lec7 = Lecturer::where('employee_number', '19870007')->first(); // Dr. Ginanjar Utama (Single TA)

        $stu1 = Student::where('student_number', '21.01.0001')->first(); // Budi (All relations)
        $stu2 = Student::where('student_number', '21.01.0002')->first(); // Andi (Wali + Magang)
        $stu3 = Student::where('student_number', '22.01.0003')->first(); // Citra (Multi-role single lecturer)
        $stu4 = Student::where('student_number', '22.01.0004')->first(); // Doni (Wali Only)
        $stu5 = Student::where('student_number', '23.01.0005')->first(); // Eka (Magang Only)
        $stu6 = Student::where('student_number', '23.01.0006')->first(); // Fajar (TA Only)

        // 1. Student 1 (Budi): All distinct relations
        if ($stu1) {
            if ($lec1) StudentLecturer::create(['student_id' => $stu1->id, 'lecturer_id' => $lec1->id, 'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR, 'is_active' => true]);
            if ($lec2) StudentLecturer::create(['student_id' => $stu1->id, 'lecturer_id' => $lec2->id, 'lecturer_role' => ApprovalRole::INTERNSHIP_SUPERVISOR, 'is_active' => true]);
            if ($lec3) StudentLecturer::create(['student_id' => $stu1->id, 'lecturer_id' => $lec3->id, 'lecturer_role' => ApprovalRole::THESIS_SUPERVISOR, 'is_active' => true]);
        }

        // 2. Student 2 (Andi): Wali + Magang + TA
        if ($stu2) {
            if ($lec3) StudentLecturer::create(['student_id' => $stu2->id, 'lecturer_id' => $lec3->id, 'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR, 'is_active' => true]);
            if ($lec2) StudentLecturer::create(['student_id' => $stu2->id, 'lecturer_id' => $lec2->id, 'lecturer_role' => ApprovalRole::INTERNSHIP_SUPERVISOR, 'is_active' => true]);
            if ($lec2) StudentLecturer::create(['student_id' => $stu2->id, 'lecturer_id' => $lec2->id, 'lecturer_role' => ApprovalRole::THESIS_SUPERVISOR, 'is_active' => true]);
        }

        // 3. Student 3 (Citra): All assigned to Dr. Bambang Susilo (Multi-role test)
        if ($stu3 && $lec4) {
            StudentLecturer::create(['student_id' => $stu3->id, 'lecturer_id' => $lec4->id, 'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR, 'is_active' => true]);
            StudentLecturer::create(['student_id' => $stu3->id, 'lecturer_id' => $lec4->id, 'lecturer_role' => ApprovalRole::INTERNSHIP_SUPERVISOR, 'is_active' => true]);
            StudentLecturer::create(['student_id' => $stu3->id, 'lecturer_id' => $lec4->id, 'lecturer_role' => ApprovalRole::THESIS_SUPERVISOR, 'is_active' => true]);
        }

        // 4. Student 4 (Doni): Wali + Magang
        if ($stu4 && $lec5) {
            StudentLecturer::create(['student_id' => $stu4->id, 'lecturer_id' => $lec5->id, 'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR, 'is_active' => true]);
            StudentLecturer::create(['student_id' => $stu4->id, 'lecturer_id' => $lec5->id, 'lecturer_role' => ApprovalRole::INTERNSHIP_SUPERVISOR, 'is_active' => true]);
        }

        // 5. Student 5 (Eka): Wali + Magang
        if ($stu5 && $lec6) {
            StudentLecturer::create(['student_id' => $stu5->id, 'lecturer_id' => $lec6->id, 'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR, 'is_active' => true]);
            StudentLecturer::create(['student_id' => $stu5->id, 'lecturer_id' => $lec6->id, 'lecturer_role' => ApprovalRole::INTERNSHIP_SUPERVISOR, 'is_active' => true]);
        }

        // 6. Student 6 (Fajar): Wali + TA
        if ($stu6 && $lec7) {
            StudentLecturer::create(['student_id' => $stu6->id, 'lecturer_id' => $lec6->id, 'lecturer_role' => ApprovalRole::ACADEMIC_ADVISOR, 'is_active' => true]);
            StudentLecturer::create(['student_id' => $stu6->id, 'lecturer_id' => $lec7->id, 'lecturer_role' => ApprovalRole::THESIS_SUPERVISOR, 'is_active' => true]);
        }
    }
}
