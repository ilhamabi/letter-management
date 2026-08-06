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

  public function bg(): string
  {
    return match ($this) {
      self::ACADEMIC_ADVISOR => 'bg-amikom-gold',
      self::INTERNSHIP_SUPERVISOR => 'bg-amikom-green',
      self::THESIS_SUPERVISOR => 'bg-amikom-green',
      self::HEAD_OF_STUDY_PROGRAM => 'bg-amikom-purple',
    };
  }

  public function badgeClass(): string
  {
    return "text-white {$this->bg()}";
  }

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }
}
