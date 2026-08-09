<?php

namespace App\Models;

use App\Enums\SubmissionLogStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'submission_id',
    'approval_flow_step_id',
    'user_id',
    'status',
    'notes',
])]

class SubmissionLog extends Model
{
    protected function casts(): array
    {
        return [
            'status' => SubmissionLogStatus::class,
        ];
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function approvalFlowStep()
    {
        return $this->belongsTo(
            ApprovalFlowStep::class,
            'approval_flow_step_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
