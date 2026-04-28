<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum IssueStatus: string implements HasColor, HasIcon, HasLabel
{
    case CREATED = 'standard';
    case IN_PROGRESS = 'express';
    case CUSTOMER_PENDING = 'customer_peding';
    case FINISHED = 'finished';

    public function getLabel(): string
    {
        return match ($this) {
            self::CREATED => ucfirst(__('created')),
            self::IN_PROGRESS => ucfirst(__('in progress')),
            self::CUSTOMER_PENDING => ucfirst(__('customer pending')),
            self::FINISHED => ucfirst(__('finished')),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::CREATED => Color::Red,
            self::IN_PROGRESS => Color::Red,
            self::CUSTOMER_PENDING => Color::Red,
            self::FINISHED => Color::Red,
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::CREATED => Heroicon::LockClosed,
            self::IN_PROGRESS => Heroicon::LockClosed,
            self::CUSTOMER_PENDING => Heroicon::LockClosed,
            self::FINISHED => Heroicon::LockClosed,
        };
    }
}
