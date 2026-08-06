<?php

namespace App\Enums;

enum SubmissionLogStatus: string
{
  case APPROVED = 'APPROVED';
  case REJECTED = 'REJECTED';

  public function label(): string
  {
    return match ($this) {
      self::APPROVED => 'Approved',
      self::REJECTED => 'Rejected',
    };
  }

  public function badgeClass(): string
  {
    return match ($this) {
      self::APPROVED => 'bg-green-100 text-green-800 border border-green-200',
      self::REJECTED => 'bg-red-100 text-red-800 border border-red-200',
    };
  }
}
