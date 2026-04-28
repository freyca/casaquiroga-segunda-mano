<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

enum IssueType: string implements HasColor, HasIcon, HasLabel
{
    case MISSING_ITEMS = 'missing_items';
    case TRANSPORT_DAMAGE = 'transport_damage';
    case MALFUNCTION = 'malfunction';
    case USAGE_QUESTION = 'usage_question';

    public function getLabel(): string
    {
        return match ($this) {
            self::MISSING_ITEMS => Str::ucfirst(__('missing items')),
            self::TRANSPORT_DAMAGE => Str::ucfirst(__('damage during transport')),
            self::MALFUNCTION => Str::ucfirst(__('malfunction')),
            self::USAGE_QUESTION => Str::ucfirst(__('usage question')),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::MISSING_ITEMS => Color::Orange,
            self::TRANSPORT_DAMAGE => Color::Teal,
            self::MALFUNCTION => Color::Pink,
            self::USAGE_QUESTION => Color::Yellow,
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::MISSING_ITEMS => Heroicon::Cog,
            self::TRANSPORT_DAMAGE => Heroicon::Truck,
            self::MALFUNCTION => Heroicon::Cog6Tooth,
            self::USAGE_QUESTION => Heroicon::QuestionMarkCircle,
        };
    }
}
