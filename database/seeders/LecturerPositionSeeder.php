<?php

namespace Database\Seeders;

use App\Enums\ApprovalRole;
use App\Models\Lecturer;
use App\Models\LecturerPosition;
use Illuminate\Database\Seeder;

class LecturerPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturers = Lecturer::all();

        $lecturerA = $lecturers->skip(0)->first(); // Dr. Ahmad Wijaya
        $lecturerB = $lecturers->skip(1)->first(); // Dr. Siti Rahma
        $lecturerD = $lecturers->skip(3)->first(); // Dr. Bambang Susilo

        // Lecturer A: Kaprodi
        if ($lecturerA) {
            LecturerPosition::create([
                'lecturer_id' => $lecturerA->id,
                'position' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
                'is_active' => true,
            ]);
        }

        // Lecturer B: Kaprodi
        if ($lecturerB) {
            LecturerPosition::create([
                'lecturer_id' => $lecturerB->id,
                'position' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
                'is_active' => true,
            ]);
        }

        // Lecturer D: Kaprodi
        if ($lecturerD) {
            LecturerPosition::create([
                'lecturer_id' => $lecturerD->id,
                'position' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
                'is_active' => true,
            ]);
        }
    }
}
