<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Schemas;

use App\Enums\Status;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class SecondHandMachineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ToggleButtons::make('sell_status')
                    ->label('Estado')
                    ->options(Status::class)
                    ->required()
                    ->inline(),

                Textarea::make('new_note')
                    ->label('Nota')
                    ->required(),
            ])->columns(1);
    }
}
