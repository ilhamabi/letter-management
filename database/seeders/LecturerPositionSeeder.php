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
        $lecturer = Lecturer::first();

        LecturerPosition::create([
            'lecturer_id' => Lecturer::first()->id,
            'position' => ApprovalRole::ACADEMIC_ADVISOR,
            'is_active' => true,
        ]);

        LecturerPosition::create([
            'lecturer_id' => Lecturer::find(2)->id,
            'position' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
            'is_active' => true,
        ]);
    }
}
