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
      self::ACADEMIC_ADVISOR => 'Academic Advisor',
      self::INTERNSHIP_SUPERVISOR => 'Internship Supervisor',
      self::THESIS_SUPERVISOR => 'Thesis Supervisor',
      self::HEAD_OF_STUDY_PROGRAM => 'Head of Study Program',
    };
  }

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }
}
