<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Machines\Schemas;

use App\Enums\MachineType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class MachineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ToggleButtons::make('type')
                    ->label(Str::ucfirst(__('type')))
                    ->options(MachineType::class)
                    ->inline()
                    ->required(),
                TextInput::make('name')
                    ->label(ucfirst(__('name')))
                    ->required(),
            ]);
    }
}
