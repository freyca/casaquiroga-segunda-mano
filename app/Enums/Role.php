<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum Role: string implements HasColor, HasIcon, HasLabel
{
    case Admin = 'admin';
    case Employee = 'employee';
    case User = 'user';

    public function getLabel(): string
    {
        return match ($this) {
            Role::Admin => 'Admin',
            Role::Employee => 'Employee',
            Role::User => 'User',
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            Role::Admin => Color::Red,
            Role::Employee => Color::Blue,
            Role::User => Color::Gray,
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            Role::Admin => Heroicon::CalendarDays,
            Role::Employee => Heroicon::BuildingOffice,
            Role::User => Heroicon::BarsArrowUp,
        };
    }
}
