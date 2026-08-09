<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'letter_type_id' => [
                'required',
                'exists:letter_types,id',
            ],
            'purpose' => [
                'required',
                'string',
                'max:2000',
            ],
            'attachments' => [
                'nullable',
                'array',
            ],
            'attachments.*' => [
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],
            'group_members' => [
                'nullable',
                'array',
            ],
            'group_members.*' => [
                'nullable',
                'string',
            ],
        ];
    }
}
