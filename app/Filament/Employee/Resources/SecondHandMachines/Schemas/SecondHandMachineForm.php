<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Schemas;

use App\Enums\SellStatus;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

final class SecondHandMachineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ToggleButtons::make('sell_status')
                    ->label(ucfirst(__('sell_status')))
                    ->options(SellStatus::class)
                    ->required()
                    ->inline(),

                Textarea::make('note_description')
                    ->label(ucfirst(__('note')))
                    ->required(),
            ])->columns(1);
    }
}
