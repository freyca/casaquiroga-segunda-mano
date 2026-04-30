<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

enum OrderType: string implements HasColor, HasIcon, HasLabel
{
    case ORDER = 'order';
    case DELIVERY_NOTE = 'delivery_note';
    case BILL = 'bill';

    public function getLabel(): string
    {
        return match ($this) {
            self::ORDER => Str::ucfirst(__('enums.order')),
            self::DELIVERY_NOTE => Str::ucfirst(__('enums.delivery_note')),
            self::BILL => Str::ucfirst(__('enums.bill')),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::ORDER => Color::Lime,
            self::DELIVERY_NOTE => Color::Indigo,
            self::BILL => Color::Purple,
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::ORDER => Heroicon::OutlinedReceiptPercent,
            self::DELIVERY_NOTE => Heroicon::OutlinedDocument,
            self::BILL => Heroicon::OutlinedCreditCard,
        };
    }
}
