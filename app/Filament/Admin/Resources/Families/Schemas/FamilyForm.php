<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Families\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class FamilyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(Str::ucfirst(__('name')))
                    ->required(),
            ]);
    }
}
