<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum OrderType: string implements HasColor, HasIcon, HasLabel
{
    case ORDER = 'order';
    case DELIVERY_NOTE = 'delivery_note';

    public function getLabel(): string
    {
        return match ($this) {
            self::ORDER => ucfirst(__('order')),
            self::DELIVERY_NOTE => ucfirst(__('delivery note')),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::ORDER => Color::Red,
            self::DELIVERY_NOTE => Color::Red,
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::ORDER => Heroicon::LockClosed,
            self::DELIVERY_NOTE => Heroicon::LockClosed,
        };
    }
}
