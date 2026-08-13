<?php

namespace App\Enums;

enum LetterTypeStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Aktif',
            self::INACTIVE => 'Non-Aktif',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
            self::INACTIVE => 'bg-gray-100 text-gray-500 border border-gray-200',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::ACTIVE => 'check_circle',
            self::INACTIVE => 'cancel',
        };
    }

    public static function fromBoolean(bool $isActive): self
    {
        return $isActive ? self::ACTIVE : self::INACTIVE;
    }
}
