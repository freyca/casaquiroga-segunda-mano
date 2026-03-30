<?php

declare(strict_types=1);

namespace App\Filament\Resources\Familias;

use App\Filament\Resources\Familias\Pages\CreateFamilia;
use App\Filament\Resources\Familias\Pages\EditFamilia;
use App\Filament\Resources\Familias\Pages\ListFamilias;
use App\Filament\Resources\Familias\Schemas\FamiliaForm;
use App\Filament\Resources\Familias\Tables\FamiliasTable;
use App\Models\Familia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FamiliaResource extends Resource
{
    protected static ?string $model = Familia::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return FamiliaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FamiliasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFamilias::route('/'),
            'create' => CreateFamilia::route('/create'),
            'edit' => EditFamilia::route('/{record}/edit'),
        ];
    }
}
