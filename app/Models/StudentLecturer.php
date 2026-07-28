<?php

namespace App\Models;

use App\Enums\ApprovalRole;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'student_id',
    'lecturer_id',
    'lecturer_role',
    'is_active'
])]

class StudentLecturer extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
        'lecturer_role' => ApprovalRole::class,
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
