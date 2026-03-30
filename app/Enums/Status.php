<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Status: string implements HasLabel, HasColor, HasIcon
{
    case Disponible      = 'disponible';
    case EnPreparacion   = 'en_preparacion';
    case ProximaEntrada  = 'proxima_entrada';
    case Reservada       = 'reservada';
    case Vendida         = 'vendida';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            Status::Disponible     => 'Disponible',
            Status::EnPreparacion  => 'En preparación',
            Status::ProximaEntrada => 'Próxima entrada',
            Status::Reservada      => 'Reservada',
            Status::Vendida        => 'Vendida',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            Status::Disponible     => 'success',
            Status::EnPreparacion  => 'warning',
            Status::ProximaEntrada => 'info',
            Status::Reservada      => 'primary',
            Status::Vendida        => 'gray',
        };
    }

    public function getIcon(): string|null
    {
        return match ($this) {
            Status::Disponible     => 'heroicon-o-check-circle',
            Status::EnPreparacion  => 'heroicon-o-wrench-screwdriver',
            Status::ProximaEntrada => 'heroicon-o-arrow-down-circle',
            Status::Reservada      => 'heroicon-o-lock-closed',
            Status::Vendida        => 'heroicon-o-banknotes',
        };
    }
}
