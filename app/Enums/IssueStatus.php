<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

enum IssueStatus: string implements HasColor, HasIcon, HasLabel
{
    case CREATED = 'created';
    case IN_PROGRESS = 'in_progress';
    case CUSTOMER_PENDING = 'customer_pending';
    case FINISHED = 'finished';

    public function getLabel(): string
    {
        return match ($this) {
            self::CREATED => Str::ucfirst(__('enums.created')),
            self::IN_PROGRESS => Str::ucfirst(__('enums.in_progress')),
            self::CUSTOMER_PENDING => Str::ucfirst(__('enums.customer_pending')),
            self::FINISHED => Str::ucfirst(__('enums.finished')),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::CREATED => Color::Slate,
            self::IN_PROGRESS => Color::Emerald,
            self::CUSTOMER_PENDING => Color::Yellow,
            self::FINISHED => Color::Green,
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::CREATED => Heroicon::Check,
            self::IN_PROGRESS => Heroicon::RocketLaunch,
            self::CUSTOMER_PENDING => Heroicon::UserPlus,
            self::FINISHED => Heroicon::CheckBadge,
        };
    }
}
