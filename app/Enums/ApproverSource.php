<?php

namespace App\Enums;

enum ApproverSource: string
{
  case STUDENT_LECTURER = 'STUDENT_LECTURER';
  case LECTURER_POSITION = 'LECTURER_POSITION';

  public function label(): string
  {
    return match ($this) {
      self::STUDENT_LECTURER => 'Student Lecturer Relation',
      self::LECTURER_POSITION => 'Lecturer Position',
    };
  }

  public function badgeClass(): string
  {
    return match ($this) {
      self::STUDENT_LECTURER => 'bg-cyan-100 text-cyan-800 border border-cyan-200',
      self::LECTURER_POSITION => 'bg-violet-100 text-violet-800 border border-violet-200',
    };
  }

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }
}
