<?php

declare(strict_types=1);

namespace App\Filament\Resources\Familias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FamiliaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
            ]);
    }
}
