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
        $lecturers = [
            ['username' => '19870001', 'nidn' => '0123456789'], // Dr. Ahmad Wijaya
            ['username' => '19870002', 'nidn' => '9876543210'], // Dr. Siti Rahma
            ['username' => '19870003', 'nidn' => '5554443322'], // Dr. Heri Setyawan
            ['username' => '19870004', 'nidn' => '7778889999'], // Dr. Bambang Susilo
            ['username' => '19870005', 'nidn' => '1122334455'], // Dr. Eko Prasetyo
            ['username' => '19870006', 'nidn' => '2233445566'], // Dra. Fitriani
            ['username' => '19870007', 'nidn' => '3344556677'], // Dr. Ginanjar Utama
            ['username' => '19870008', 'nidn' => '4455667788'], // Dr. Hendra Wijaya
        ];

        foreach ($lecturers as $item) {
            $user = User::where('username', $item['username'])->first();
            if ($user) {
                Lecturer::create([
                    'user_id' => $user->id,
                    'employee_number' => $item['username'],
                    'national_lecturer_number' => $item['nidn'],
                ]);
            }
        }
    }
}
