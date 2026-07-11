<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Create users with different roles
        # Administrator
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@amikom.ac.id',
            'role' => UserRole::ADMIN,
            'password' => 'password',
        ]);

        # Students
        User::create([
            'name' => 'Adi Prasetyo',
            'username' => '23.01.0001',
            'email' => 'adi.prasetyo@amikom.ac.id',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'username' => '23.01.0002',
            'email' => 'budi.santoso@amikom.ac.id',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Citra Dewi',
            'username' => '23.01.0003',
            'email' => 'citra.dewi@amikom.ac.id',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        # Lecturers
        User::create([
            'name' => 'Ahmad Fauzi',
            'username' => '190302101',
            'email' => 'ahmad.fauzi@amikom.ac.id',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Bangkit Pratama',
            'username' => '190302102',
            'email' => 'bangkit.pratama@amikom.ac.id',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Candra Wijaya',
            'username' => '190302103',
            'email' => 'candra.wijaya@amikom.ac.id',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);
    }
}
