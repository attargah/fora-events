<?php

namespace App\Enums;


use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use phpDocumentor\Reflection\Types\Self_;

enum EventStatus: string implements HasLabel, HasColor
{
    case Active = 'active';

    case Inactive = 'inactive';
    case Expired = 'expired';
    case Draft = 'draft';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Expired => 'Expired',
            self::Draft => 'Draft',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'danger',
            self::Expired => 'warning',
            self::Draft => 'secondary',
        };
    }


}
