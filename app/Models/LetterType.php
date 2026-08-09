<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'approval_flow_id',
    'name',
    'code',
    'description',
    'minimum_gpa',
    'minimum_credits',
    'requires_attachment',
    'allow_group_submission',
    'is_active',
])]

class LetterType extends Model
{
    protected $casts = [
        'requires_attachment' => 'boolean',
        'allow_group_submission' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function approvalFlow()
    {
        return $this->belongsTo(ApprovalFlow::class);
    }

    public function templates()
    {
        return $this->hasMany(LetterTemplate::class);
    }

    public function activeTemplate()
    {
        return $this->hasOne(LetterTemplate::class)->where('is_active', true);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

}
