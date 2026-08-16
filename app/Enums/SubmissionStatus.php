<?php

namespace App\Enums;

enum SubmissionStatus: string
{
  case PENDING = 'PENDING';
  case IN_REVIEW = 'IN_REVIEW';
  case REJECTED = 'REJECTED';
  case APPROVED = 'APPROVED';
  case GENERATED = 'GENERATED';

  public function label(): string
  {
    return match ($this) {
      self::PENDING => 'Menunggu',
      self::IN_REVIEW => 'Diproses',
      self::REJECTED => 'Ditolak',
      self::APPROVED => 'Disetujui',
      self::GENERATED => 'Selesai',
    };
  }

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }

  public function icon(): string
  {
    return match ($this) {
      self::APPROVED, self::GENERATED => 'check_circle',
      self::REJECTED => 'cancel',
      self::IN_REVIEW => 'hourglass_top',
      self::PENDING => 'clock',
    };
  }

  public function badgeClass(): string
  {
    return match ($this) {
      self::PENDING => 'bg-amber-100 text-amber-800 border-amber-200',
      self::IN_REVIEW => 'bg-amber-100 text-amber-800 border-amber-200',
      self::REJECTED => 'bg-red-100 text-red-800 border-red-200',
      self::APPROVED => 'bg-green-100 text-green-800 border-green-200',
      self::GENERATED => 'bg-green-100 text-green-800 border-green-200',
    };
  }
}
