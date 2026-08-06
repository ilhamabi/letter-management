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
      self::IN_REVIEW => 'Sedang Diproses',
      self::REJECTED => 'Ditolak',
      self::APPROVED => 'Disetujui',
      self::GENERATED => 'Selesai',
    };
  }

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }

  public function badgeClass(): string
  {
    return match ($this) {

      self::PENDING =>
      'bg-gray-100 text-gray-800',

      self::IN_REVIEW =>
      'bg-blue-100 text-blue-800',

      self::REJECTED =>
      'bg-red-100 text-red-800',

      self::APPROVED =>
      'bg-green-100 text-green-800',

      self::GENERATED =>
      'bg-emerald-100 text-emerald-800',
    };
  }
}
