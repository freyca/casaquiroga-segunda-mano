<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines;

use App\Filament\Admin\Resources\SecondHandMachines\Pages\CreateSecondHandMachine;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\EditSecondHandMachine;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\ListSecondHandMachines;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\ViewSecondHandMachine;
use App\Filament\Admin\Resources\SecondHandMachines\Schemas\SecondHandMachineForm;
use App\Filament\Admin\Resources\SecondHandMachines\Schemas\SecondHandMachineInfolist;
use App\Filament\Admin\Resources\SecondHandMachines\Tables\SecondHandMachinesTable;
use App\Models\SecondHandMachine;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class SecondHandMachineResource extends Resource
{
    protected static ?string $model = SecondHandMachine::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Truck;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return Str::ucfirst(__('machines_management'));
    }

    public static function getNavigationLabel(): string
    {
        return Str::ucfirst(__('second_hand_machine'));
    }

    public static function getLabel(): string
    {
        return Str::ucfirst(__('second_hand_machine'));
    }

    public static function getPluralLabel(): string
    {
        return Str::ucfirst(__('second_hand_machines'));
    }

    public static function form(Schema $schema): Schema
    {
        return SecondHandMachineForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SecondHandMachinesTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SecondHandMachineInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSecondHandMachines::route('/'),
            'create' => CreateSecondHandMachine::route('/create'),
            'view' => ViewSecondHandMachine::route('/{record}'),
            'edit' => EditSecondHandMachine::route('/{record}/edit'),
        ];
    }
}
