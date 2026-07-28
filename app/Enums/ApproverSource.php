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

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }
}
