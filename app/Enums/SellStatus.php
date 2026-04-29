<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

enum SellStatus: string implements HasColor, HasIcon, HasLabel
{
    case Available = 'available';
    case InPreparation = 'in_preparation';
    case ArriveSoon = 'arrive_soon';
    case Reserved = 'reserved';
    case Sold = 'sold';

    public function getLabel(): string
    {
        return match ($this) {
            SellStatus::Available => Str::ucfirst(__('available')),
            SellStatus::InPreparation => Str::ucfirst(__('in_preparation')),
            SellStatus::ArriveSoon => Str::ucfirst(__('arrive_soon')),
            SellStatus::Reserved => Str::ucfirst(__('reserved')),
            SellStatus::Sold => Str::ucfirst(__('sold')),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            SellStatus::Available => Color::Green,
            SellStatus::InPreparation => Color::Purple,
            SellStatus::ArriveSoon => Color::Blue,
            SellStatus::Reserved => Color::Red,
            SellStatus::Sold => Color::Gray,
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            SellStatus::Available => Heroicon::CheckCircle,
            SellStatus::InPreparation => Heroicon::WrenchScrewdriver,
            SellStatus::ArriveSoon => Heroicon::ArrowDownCircle,
            SellStatus::Reserved => Heroicon::LockClosed,
            SellStatus::Sold => Heroicon::Banknotes,
        };
    }
}
