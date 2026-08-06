<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'submission_id',
    'student_id',
    'sort_order',
])]
class SubmissionGroupMember extends Model
{
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
