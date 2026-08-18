<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class RejectSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isLecturer() ?? false;
    }

    public function rules(): array
    {
        return [
            'reason' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
