<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Enums\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class UserForm
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
                ->label(Str::ucfirst(__('app.name')))
                ->required(),

            TextInput::make('email')
                ->label(Str::ucfirst(__('app.email')))
                ->email()
                ->required(fn (string $context): bool => $context === 'create'),

            TextInput::make('phone')
                ->label(Str::ucfirst(__('app.phone')))
                ->tel(),
        ];
    }

    /**
     * @return array<Component>
     */
    public static function fullFields(): array
    {
        return array_merge(
            self::baseFields(),
            [
                TextInput::make('password')
                    ->label(Str::ucfirst(__('app.password')))
                    ->password()
                    ->dehydrated(fn (mixed $state): bool => filled($state))
                    ->dehydrateStateUsing(fn (?string $state) => filled($state) ? Hash::make($state) : null)
                    ->required(fn (string $context): bool => $context === 'create'),

                Select::make('role')
                    ->label(Str::ucfirst(__('app.role')))
                    ->options(Role::class)
                    ->default(Role::User)
                    ->required(),
            ]
        );
    }
}
