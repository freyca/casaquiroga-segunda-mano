<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum Tax: int implements HasColor, HasIcon, HasLabel
{
    case Zero = 0;
    case TwentyOne = 21;

    public function getLabel(): string
    {
        return match ($this) {
            Tax::Zero => '0%',
            Tax::TwentyOne => '21%',
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            Tax::Zero => Color::Green,
            Tax::TwentyOne => Color::Gray,
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            Tax::Zero => Heroicon::XCircle,
            Tax::TwentyOne => Heroicon::ReceiptPercent,
        };
    }
}
