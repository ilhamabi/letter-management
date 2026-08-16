<?php

namespace App\Enums;

enum ApprovalRole: string
{
    case ACADEMIC_ADVISOR = 'ACADEMIC_ADVISOR';
    case INTERNSHIP_SUPERVISOR = 'INTERNSHIP_SUPERVISOR';
    case THESIS_SUPERVISOR = 'THESIS_SUPERVISOR';
    case HEAD_OF_STUDY_PROGRAM = 'HEAD_OF_STUDY_PROGRAM';

    public function label(): string
    {
        return match ($this) {
            self::ACADEMIC_ADVISOR => 'Dosen Wali',
            self::INTERNSHIP_SUPERVISOR => 'Dosen Pembimbing Magang',
            self::THESIS_SUPERVISOR => 'Dosen Pembimbing Skripsi/Tugas Akhir',
            self::HEAD_OF_STUDY_PROGRAM => 'Kepala Program Studi',
        };
    }

    /**
     * Short concise label for compact UI badges, tables, and sidebar chips.
     */
    public function shortLabel(): string
    {
        return match ($this) {
            self::ACADEMIC_ADVISOR => 'Dosen Wali',
            self::HEAD_OF_STUDY_PROGRAM => 'Kaprodi',
            self::INTERNSHIP_SUPERVISOR => 'Pembimbing Magang',
            self::THESIS_SUPERVISOR => 'Pembimbing TA',
        };
    }

    public function bg(): string
    {
        return match ($this) {
            self::HEAD_OF_STUDY_PROGRAM => 'bg-amikom-purple',
            self::ACADEMIC_ADVISOR => 'bg-amikom-gold',
            self::INTERNSHIP_SUPERVISOR, self::THESIS_SUPERVISOR => 'bg-amikom-green',
            self::THESIS_SUPERVISOR => 'bg-amikom-green',
        };
    }

    public function badgeClass(): string
    {
        return "text-white {$this->bg()}";
    }

    public function icon(): string
    {
        return match ($this) {
            self::ACADEMIC_ADVISOR => 'school',
            self::HEAD_OF_STUDY_PROGRAM => 'workspace_premium',
            self::INTERNSHIP_SUPERVISOR => 'work',
            self::THESIS_SUPERVISOR => 'menu_book',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
