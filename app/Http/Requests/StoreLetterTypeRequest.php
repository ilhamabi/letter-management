<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLetterTypeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:letter_types,code',
            'description' => 'nullable|string',
            'approval_flow_id' => 'required|exists:approval_flows,id',
            'is_active' => 'required|boolean',
            'minimum_gpa' => 'nullable|numeric|min:0|max:4.00',
            'minimum_credits' => 'nullable|integer|min:0',
            'requires_attachment' => 'nullable|boolean',
            'allow_group_submission' => 'nullable|boolean',
            'template_content' => 'nullable|string',
            'content' => 'nullable|string',
        ];
    }

    /**
     * Custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Jenis Surat',
            'code' => 'Kode Surat',
            'description' => 'Deskripsi Jenis Surat',
            'approval_flow_id' => 'Alur Persetujuan',
            'is_active' => 'Status',
            'minimum_gpa' => 'Minimal IPK',
            'minimum_credits' => 'Minimal Total SKS',
            'template_content' => 'Template Isi Surat',
        ];
    }
}
