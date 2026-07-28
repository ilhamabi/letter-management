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
        User::create([
            'name' => 'System Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'role' => UserRole::ADMIN,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'username' => '20210001',
            'email' => 'student@example.com',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Dr. Ahmad Wijaya',
            'username' => '19870001',
            'email' => 'lecturer1@example.com',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Dr. Siti Rahma',
            'username' => '19870002',
            'email' => 'lecturer2@example.com',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);
    }
}
