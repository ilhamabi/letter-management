<?php

namespace App\Models;

use App\Enums\ApprovalRole;
use App\Enums\ApproverSource;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'approval_flow_id',
    'name',
    'approval_role',
    'approver_source',
    'step_order',
])]

class ApprovalFlowStep extends Model
{
    protected $casts = [
        'approval_role' => ApprovalRole::class,
        'approver_source' => ApproverSource::class,
    ];

    public function approvalFlow()
    {
        return $this->belongsTo(ApprovalFlow::class);
    }

    public function submissionLogs()
    {
        return $this->hasMany(SubmissionLog::class);
    }
}
