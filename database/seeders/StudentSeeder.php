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
        $students = [
            ['username' => '21.01.0001', 'nim' => '21.01.0001', 'batch_year' => 2021, 'gpa' => 3.85, 'credits' => 115, 'semester' => 7], // Budi Santoso
            ['username' => '21.01.0002', 'nim' => '21.01.0002', 'batch_year' => 2021, 'gpa' => 3.45, 'credits' => 105, 'semester' => 7], // Andi Saputra
            ['username' => '22.01.0003', 'nim' => '22.01.0003', 'batch_year' => 2022, 'gpa' => 3.60, 'credits' => 85,  'semester' => 5], // Citra Dewi
            ['username' => '22.01.0004', 'nim' => '22.01.0004', 'batch_year' => 2022, 'gpa' => 3.20, 'credits' => 75,  'semester' => 5], // Doni Pratama
            ['username' => '23.01.0005', 'nim' => '23.01.0005', 'batch_year' => 2023, 'gpa' => 3.50, 'credits' => 55,  'semester' => 3], // Eka Rahmawati
            ['username' => '23.01.0006', 'nim' => '23.01.0006', 'batch_year' => 2023, 'gpa' => 3.10, 'credits' => 45,  'semester' => 3], // Fajar Nugraha
        ];

        foreach ($students as $item) {
            $user = User::where('username', $item['username'])->first();
            if ($user) {
                Student::create([
                    'user_id' => $user->id,
                    'student_number' => $item['nim'],
                    'batch_year' => $item['batch_year'],
                    'semester' => $item['semester'],
                    'gpa' => $item['gpa'],
                    'total_credits' => $item['credits'],
                    'academic_status' => 'ACTIVE',
                ]);
            }
        }
    }
}
