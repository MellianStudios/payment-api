<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum PaymentProvider: string
{
    case PROVIDER_ONE = 'PROVIDER_ONE';
    case PROVIDER_TWO = 'PROVIDER_TWO';

    public static function values(): Collection
    {
        return collect(self::cases())->pluck('value');
    }
}
