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
    'is_active',
])]

class LetterType extends Model
{
    protected $casts = [
        'requires_attachment' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function approvalFlow()
    {
        return $this->belongsTo(ApprovalFlow::class);
    }

    public function template()
    {
        return $this->hasMany(LetterTemplate::class);
    }

    public function activeTemplate()
    {
        return $this->hasOne(LetterTemplate::class)->where('is_active', true);
    }
}
