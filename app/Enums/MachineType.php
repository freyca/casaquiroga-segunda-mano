<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

enum MachineType: string implements HasColor, HasIcon, HasLabel
{
    case WOOD_CHIPPER = 'wood_chipper';
    case LAWN_MOWER = 'lawn_mower';
    case BRUSHCUTTER = 'brushcutter';
    case TILLER = 'tiller';
    case ROBOT_LAWN_MOWER = 'robot_lawn_mower';
    case RIDE_ON_LAWN_MOWER = 'ride_on_lawn_mower';
    case OTHER = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::WOOD_CHIPPER => Str::ucfirst(__('enums.wood_chipper')),
            self::LAWN_MOWER => Str::ucfirst(__('enums.lawn_mower')),
            self::BRUSHCUTTER => Str::ucfirst(__('enums.brushcutter')),
            self::TILLER => Str::ucfirst(__('enums.tiller')),
            self::ROBOT_LAWN_MOWER => Str::ucfirst(__('enums.robot_lawn_mower')),
            self::RIDE_ON_LAWN_MOWER => Str::ucfirst(__('enums.ride_on_lawn_mower')),
            self::OTHER => Str::ucfirst(__('enums.other')),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::WOOD_CHIPPER => Color::Gray,
            self::LAWN_MOWER => Color::Green,
            self::BRUSHCUTTER => Color::Amber,
            self::TILLER => Color::Orange,
            self::ROBOT_LAWN_MOWER => Color::Blue,
            self::RIDE_ON_LAWN_MOWER => Color::Indigo,
            self::OTHER => Color::Gray,
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::WOOD_CHIPPER => Heroicon::Bolt,
            self::LAWN_MOWER => Heroicon::RectangleStack,
            self::BRUSHCUTTER => Heroicon::Scissors,
            self::TILLER => Heroicon::WrenchScrewdriver,
            self::ROBOT_LAWN_MOWER => Heroicon::CpuChip,
            self::RIDE_ON_LAWN_MOWER => Heroicon::Truck,
            self::OTHER => Heroicon::QuestionMarkCircle,
        };
    }
}
