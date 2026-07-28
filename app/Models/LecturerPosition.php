<?php

namespace App\Models;

use App\Enums\ApprovalRole;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'lecturer_id',
    'position',
    'is_active'
])]

class LecturerPosition extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
        'position' => ApprovalRole::class,
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
