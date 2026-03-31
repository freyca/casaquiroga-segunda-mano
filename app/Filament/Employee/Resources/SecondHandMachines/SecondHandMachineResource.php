<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines;

use App\Filament\Employee\Resources\SecondHandMachines\Pages\ListSecondHandMachines;
use App\Filament\Employee\Resources\SecondHandMachines\Pages\ViewSecondHandMachine;
use App\Filament\Employee\Resources\SecondHandMachines\Schemas\SecondHandMachineForm;
use App\Filament\Employee\Resources\SecondHandMachines\Tables\SecondHandMachinesTable;
use App\Models\SecondHandMachine;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class SecondHandMachineResource extends Resource
{
    protected static ?string $model = SecondHandMachine::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Truck;

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('second_hand_machine'));
    }

    public static function getPluralLabel(): string
    {
        return ucfirst(__('second_hand_machines'));
    }

    public static function table(Table $table): Table
    {
        return SecondHandMachinesTable::configure($table);
    }

    public static function form(Schema $schema): Schema
    {
        return SecondHandMachineForm::configure($schema);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSecondHandMachines::route('/'),
            'view' => ViewSecondHandMachine::route('/{record}'),
        ];
    }
}
