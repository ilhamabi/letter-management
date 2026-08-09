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
            'name' => 'Andi Saputra',
            'username' => '20210002',
            'email' => 'andi.saputra@example.com',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Citra Dewi',
            'username' => '20210003',
            'email' => 'citra.dewi@example.com',
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

        User::create([
            'name' => 'Dr. Heri Setyawan, M.Kom.',
            'username' => '19870003',
            'email' => 'lecturer3@example.com',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);
    }
}
