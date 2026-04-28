<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

enum IssuePriority: string implements HasColor, HasIcon, HasLabel
{
    case STANDARD = 'standard';
    case EXPRESS = 'express';

    public function getLabel(): string
    {
        return match ($this) {
            self::STANDARD => Str::ucfirst(__('standard')),
            self::EXPRESS => Str::ucfirst(__('express')),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::STANDARD => Color::Blue,
            self::EXPRESS => Color::Red,
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::STANDARD => Heroicon::CheckCircle,
            self::EXPRESS => Heroicon::ArrowUpRight,
        };
    }
}
