<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'submission_id',
    'letter_number',
    'file_path',
    'qr_token',
    'generated_at',
])]
class GeneratedLetter extends Model
{
    protected function casts(): array
    {
        return [
            'generated_at' => 'datetime',
        ];
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
