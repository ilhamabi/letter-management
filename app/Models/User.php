<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'role', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isStudent(): bool
    {
        return $this->role === UserRole::STUDENT;
    }

    public function isLecturer(): bool
    {
        return $this->role === UserRole::LECTURER;
    }

    public function getDashboardRouteName(): string
    {
        return match ($this->role) {
            UserRole::ADMIN => 'admin.dashboard',
            UserRole::STUDENT => 'student.dashboard',
            UserRole::LECTURER => 'lecturer.dashboard',
        };
    }

    public function getDashboardUrl(): string
    {
        return route($this->getDashboardRouteName());
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function lecturer()
    {
        return $this->hasOne(Lecturer::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'assigned_to_user_id');
    }

    public function submissionLogs()
    {
        return $this->hasMany(SubmissionLog::class);
    }
}
