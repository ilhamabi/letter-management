<?php

namespace App\Models;

use App\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'student_id',
    'letter_type_id',
    'assigned_to_user_id',
    'approval_flow_step_id',
    'status',
    'purpose',
    'attachment_path',
    'notes',
    'submitted_at',
])]
class Submission extends Model
{
    protected function cast(): array
    {
        return [
            'submitted_at' => 'datetime',
            'status' => SubmissionStatus::class,
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }

    public function assignedToUser()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function approvalFlowStep()
    {
        return $this->belongsTo(ApprovalFlowStep::class, 'approval_flow_step_id');
    }

    public function attachments()
    {
        return $this->hasMany(SubmissionAttachment::class);
    }

    public function logs()
    {
        return $this->hasMany(SubmissionLog::class);
    }
}
