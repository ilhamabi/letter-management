<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Seeder;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lecturer::create([
            'user_id' => User::where(
                'username',
                '19870001'
            )->first()->id,
            'employee_number' => '19870001',
            'national_lecturer_number' => '0123456789',
        ]);

        Lecturer::create([
            'user_id' => User::where(
                'username',
                '19870002'
            )->first()->id,
            'employee_number' => '19870002',
            'national_lecturer_number' => '9876543210',
        ]);

        Lecturer::create([
            'user_id' => User::where(
                'username',
                '19870003'
            )->first()->id,
            'employee_number' => '19870003',
            'national_lecturer_number' => '5554443322',
        ]);
    }
}
