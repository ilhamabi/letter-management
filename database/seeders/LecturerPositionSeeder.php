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
        $kaprodiUsernames = ['19870001', '19870002', '19870004', '19870008'];

        foreach ($kaprodiUsernames as $username) {
            $lecturer = Lecturer::where('employee_number', $username)->first();
            if ($lecturer) {
                LecturerPosition::create([
                    'lecturer_id' => $lecturer->id,
                    'position' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
                    'is_active' => true,
                ]);
            }
        }
    }
}
