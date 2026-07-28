<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
])]

class ApprovalFlow extends Model
{
    public function steps()
    {
        return $this->hasMany(ApprovalFlowStep::class)->orderBy('step_order');
    }

    public function letterTypes()
    {
        return $this->hasMany(LetterType::class);
    }
}
