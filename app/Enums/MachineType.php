<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

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
            self::WOOD_CHIPPER => ucfirst(__('wood chipper')),
            self::LAWN_MOWER => ucfirst(__('lawn mower')),
            self::BRUSHCUTTER => ucfirst(__('brushcutter')),
            self::TILLER => ucfirst(__('tiller / cultivator')),
            self::ROBOT_LAWN_MOWER => ucfirst(__('robot lawn mower')),
            self::RIDE_ON_LAWN_MOWER => ucfirst(__('ride-on lawn mower')),
            self::OTHER => ucfirst(__('other')),
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
