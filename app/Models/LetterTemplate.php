<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'letter_type_id',
    'name',
    'body_content',
    'is_active',
])]
class LetterTemplate extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }
}
