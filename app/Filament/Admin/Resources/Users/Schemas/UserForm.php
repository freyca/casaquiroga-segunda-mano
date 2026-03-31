<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Enums\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function fullConfigure(Schema $schema): Schema
    {
        return $schema->components(self::fullFields());
    }

    public static function partialConfigure(Schema $schema): Schema
    {
        return $schema->components(self::baseFields());
    }

    /**
     * @return array<Component>
     */
    public static function baseFields(): array
    {
        return [
            TextInput::make('name')
                ->label(ucfirst(__('name')))
                ->required(),

            TextInput::make('email')
                ->label(ucfirst(__('email')))
                ->email()
                ->required(),

            TextInput::make('password')
                ->label(ucfirst(__('password')))
                ->password()
                ->dehydrated(fn (mixed $state) => filled($state))
                ->dehydrateStateUsing(fn (?string $state) => filled($state) ? Hash::make($state) : null)
                ->required(fn (string $context): bool => $context === 'create'),
        ];
    }

    /**
     * @return array<Component>
     */
    public static function fullFields(): array
    {
        return array_merge(self::baseFields(), [
            Select::make('role')
                ->label(ucfirst(__('role')))
                ->options(Role::class)
                ->default(Role::User)
                ->required(),
        ]);
    }
}
