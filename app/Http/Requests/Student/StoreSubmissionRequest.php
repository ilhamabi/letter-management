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
            'group_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'additional_data' => [
                'nullable',
                'array',
            ],
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'start_date' => ['nullable', 'string', 'max:100'],
            'end_date' => ['nullable', 'string', 'max:100'],
            'thesis_title' => ['nullable', 'string', 'max:500'],
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

    /**
     * Configure the validator instance with academic requirement checks.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (! $this->letter_type_id) {
                return;
            }

            $letterType = \App\Models\LetterType::find($this->letter_type_id);
            if (! $letterType) {
                return;
            }

            $student = $this->user()?->student;
            if (! $student) {
                return;
            }

            if ($letterType->minimum_gpa && (float)$student->gpa < (float)$letterType->minimum_gpa) {
                $validator->errors()->add(
                    'letter_type_id',
                    "IPK Anda (" . number_format((float)$student->gpa, 2) . ") belum memenuhi syarat minimal IPK untuk jenis surat ini (Minimal: " . number_format((float)$letterType->minimum_gpa, 2) . ")."
                );
            }

            if ($letterType->minimum_credits && (int)$student->total_credits < (int)$letterType->minimum_credits) {
                $validator->errors()->add(
                    'letter_type_id',
                    "Total SKS Anda ({$student->total_credits} SKS) belum memenuhi syarat minimal SKS untuk jenis surat ini (Minimal: {$letterType->minimum_credits} SKS)."
                );
            }

            if ($letterType->requires_attachment && empty($this->file('attachments'))) {
                $validator->errors()->add(
                    'attachments',
                    "Jenis surat ini mewajibkan Anda untuk mengunggah setidaknya 1 berkas lampiran pendukung."
                );
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'letter_type_id.required' => 'Jenis Surat wajib dipilih.',
            'letter_type_id.exists' => 'Jenis surat yang dipilih tidak valid.',
            'purpose.required' => 'Keperluan / Alasan Pengajuan wajib diisi.',
            'purpose.max' => 'Keperluan / Alasan Pengajuan maksimal 2000 karakter.',
            'company_name.max' => 'Nama Perusahaan / Instansi maksimal 255 karakter.',
            'company_address.max' => 'Alamat Perusahaan / Instansi maksimal 500 karakter.',
            'thesis_title.max' => 'Judul Tugas Akhir maksimal 500 karakter.',
            'attachments.required' => 'Berkas lampiran pendukung wajib diunggah untuk jenis surat ini.',
            'attachments.*.max' => 'Ukuran berkas lampiran maksimal 5MB.',
            'attachments.*.mimes' => 'Format berkas lampiran harus berupa PDF, JPG, JPEG, atau PNG.',
        ];
    }
}
