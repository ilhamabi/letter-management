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
      self::STUDENT => 'Mahasiswa',
      self::LECTURER => 'Dosen',
    };
  }

  public function badgeClass(): string
  {
    return match ($this) {
      self::ADMIN => 'bg-amber-100 text-amber-800 border border-amber-200',
      self::LECTURER => 'bg-sky-100 text-sky-800 border border-sky-200',
      self::STUDENT => 'bg-indigo-100 text-indigo-800 border border-indigo-200',
    };
  }

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }
}
