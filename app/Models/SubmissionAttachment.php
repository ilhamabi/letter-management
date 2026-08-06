<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'submission_id',
    'original_filename',
    'stored_filename',
    'file_path',
    'mime_type',
    'file_size',
])]

class SubmissionAttachment extends Model
{
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
