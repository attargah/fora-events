<?php

namespace App\Enums;


use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CheckoutStatus: string implements HasLabel, HasColor
{
    case Pending = 'pending';

    case Completed = 'completed';

    case Failed = 'failed';

    case Expired = 'expired';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Completed => 'Completed',
            self::Failed => 'Failed',
            self::Expired => 'Expired',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Completed => 'success',
            self::Failed => 'danger',
            self::Pending => 'secondary',
            self::Expired => 'warning',
        };
    }


}
