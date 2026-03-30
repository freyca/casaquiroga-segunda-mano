<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Tax: int implements HasLabel, HasColor, HasIcon
{
    case Zero      = 0;
    case TwentyOne = 21;

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            Tax::Zero      => '0%',
            Tax::TwentyOne => '21%',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            Tax::Zero      => 'gray',
            Tax::TwentyOne => 'primary',
        };
    }

    public function getIcon(): string|null
    {
        return match ($this) {
            Tax::Zero      => 'heroicon-o-x-circle',
            Tax::TwentyOne => 'heroicon-o-receipt-percent',
        };
    }
}
