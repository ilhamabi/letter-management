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
        // Administrator
        User::create([
            'name' => 'System Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'role' => UserRole::ADMIN,
            'password' => 'password',
        ]);

        // Students
        User::create([
            'name' => 'Budi Santoso',
            'username' => '21.01.0001',
            'email' => 'student@example.com',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Andi Saputra',
            'username' => '21.01.0002',
            'email' => 'andi.saputra@example.com',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Citra Dewi',
            'username' => '22.01.0003',
            'email' => 'citra.dewi@example.com',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Doni Pratama',
            'username' => '22.01.0004',
            'email' => 'doni.pratama@example.com',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Eka Rahmawati',
            'username' => '23.01.0005',
            'email' => 'eka.rahmawati@example.com',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Fajar Nugraha',
            'username' => '23.01.0006',
            'email' => 'fajar.nugraha@example.com',
            'role' => UserRole::STUDENT,
            'password' => 'password',
        ]);

        // Multi-Role Lecturers
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

        User::create([
            'name' => 'Dr. Bambang Susilo, M.T.',
            'username' => '19870004',
            'email' => 'lecturer4@example.com',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);

        // Single-Role Lecturers
        User::create([
            'name' => 'Dr. Eko Prasetyo, M.Kom.',
            'username' => '19870005',
            'email' => 'lecturer5@example.com',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Dra. Fitriani, M.T.',
            'username' => '19870006',
            'email' => 'lecturer6@example.com',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Dr. Ginanjar Utama, M.Sc.',
            'username' => '19870007',
            'email' => 'lecturer7@example.com',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Dr. Hendra Wijaya, M.Kom.',
            'username' => '19870008',
            'email' => 'lecturer8@example.com',
            'role' => UserRole::LECTURER,
            'password' => 'password',
        ]);
    }
}
