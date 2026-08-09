<?php

namespace App\Models;

use App\Enums\ApprovalRole;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'employee_number',
    'national_lecturer_number'
])]

class Lecturer extends Model
{
    /** @use HasFactory<\Database\Factories\LecturerFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function positions()
    {
        return $this->hasMany(LecturerPosition::class);
    }

    public function studentLecturers()
    {
        return $this->hasMany(StudentLecturer::class);
    }

    /**
     * Get all active roles for the lecturer dynamically from database relations.
     * Consumes ApprovalRole Enum as Single Source of Truth for labels, codes, and background colors.
     * Deduplicates logically by role code to prevent duplicate role badges on sidebar.
     */
    public function getActiveRoles(): array
    {
        $roles = [];

        // 1. Fetch positions (e.g., Kaprodi)
        $positions = $this->positions()->where('is_active', true)->get();
        foreach ($positions as $pos) {
            $roleEnum = $pos->position instanceof ApprovalRole
                ? $pos->position
                : (is_string($pos->position) ? ApprovalRole::tryFrom($pos->position) : null);

            $roleCode = $roleEnum?->value ?? (string) $pos->position;

            $roles[] = [
                'name' => $roleEnum?->shortLabel() ?? $roleEnum?->label() ?? $roleCode,
                'code' => $roleCode,
                'bg' => $roleEnum?->bg() ?? 'bg-amikom-purple',
                'badgeClass' => $roleEnum?->badgeClass() ?? 'text-white bg-amikom-purple',
            ];
        }

        // 2. Fetch student lecturer roles (e.g., Dosen Wali, Dosen Pembimbing)
        $studentRoles = $this->studentLecturers()
            ->where('is_active', true)
            ->select('lecturer_role')
            ->distinct()
            ->get();

        foreach ($studentRoles as $sr) {
            $roleEnum = $sr->lecturer_role instanceof ApprovalRole
                ? $sr->lecturer_role
                : (is_string($sr->lecturer_role) ? ApprovalRole::tryFrom($sr->lecturer_role) : null);

            $roleCode = $roleEnum?->value ?? (string) $sr->lecturer_role;

            $roles[] = [
                'name' => $roleEnum?->shortLabel() ?? $roleEnum?->label() ?? $roleCode,
                'code' => $roleCode,
                'bg' => $roleEnum?->bg() ?? 'bg-blue-600',
                'badgeClass' => $roleEnum?->badgeClass() ?? 'text-white bg-blue-600',
            ];
        }

        if (empty($roles)) {
            $roles = [
                [
                    'name' => ApprovalRole::ACADEMIC_ADVISOR->shortLabel(),
                    'code' => ApprovalRole::ACADEMIC_ADVISOR->value,
                    'bg' => ApprovalRole::ACADEMIC_ADVISOR->bg(),
                    'badgeClass' => ApprovalRole::ACADEMIC_ADVISOR->badgeClass(),
                ],
                [
                    'name' => ApprovalRole::HEAD_OF_STUDY_PROGRAM->shortLabel(),
                    'code' => ApprovalRole::HEAD_OF_STUDY_PROGRAM->value,
                    'bg' => ApprovalRole::HEAD_OF_STUDY_PROGRAM->bg(),
                    'badgeClass' => ApprovalRole::HEAD_OF_STUDY_PROGRAM->badgeClass(),
                ],
            ];
        }

        // Deduplicate roles logically by role code
        return collect($roles)->unique('code')->values()->all();
    }
}
