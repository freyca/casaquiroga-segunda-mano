<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Brands\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(ucfirst(__('name')))
                    ->required(),
            ]);
    }
}
