<?php

namespace App\Enums;

enum UserRole: string
{
  case ADMIN = 'ADMIN';
  case LECTURER = 'LECTURER';
  case STUDENT = 'STUDENT';

  public function label(): string
  {
    return match ($this) {
      self::ADMIN => 'Admin',
      self::STUDENT => 'Student',
      self::LECTURER => 'Lecturer',
    };
  }

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }
}
