<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use Illuminate\Database\Seeder;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Create lecturers with their corresponding user accounts
        Lecturer::create([
            'user_id' => 5, // Assuming the user with ID 5 is a lecturer
            'employee_number' => '190302101',
            'national_lecturer_number' => '0512345678',
        ]);

        Lecturer::create([
            'user_id' => 6, // Assuming the user with ID 6 is a lecturer
            'employee_number' => '190302102',
            'national_lecturer_number' => '0565432109',
        ]);

        Lecturer::create([
            'user_id' => 7, // Assuming the user with ID 7 is a lecturer
            'employee_number' => '190302103',
            'national_lecturer_number' => '0578901234',
        ]);
    }
}
