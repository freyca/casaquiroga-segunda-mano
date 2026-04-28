<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Schemas;

use App\Enums\OrderType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ToggleButtons::make('type')
                    ->label(Str::ucfirst(__('type')))
                    ->default(OrderType::ORDER)
                    ->options(OrderType::class)
                    ->inline()
                    ->required(),
                TextInput::make('number')
                    ->label(Str::ucfirst(__('number')))
                    ->required(),
            ]);
    }
}
