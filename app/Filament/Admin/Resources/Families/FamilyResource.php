<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Families;

use App\Filament\Admin\Resources\Families\Pages\CreateFamily;
use App\Filament\Admin\Resources\Families\Pages\EditFamily;
use App\Filament\Admin\Resources\Families\Pages\ListFamilies;
use App\Filament\Admin\Resources\Families\Schemas\FamilyForm;
use App\Filament\Admin\Resources\Families\Tables\FamiliesTable;
use App\Models\Family;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FamilyResource extends Resource
{
    protected static ?string $model = Family::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return FamilyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FamiliesTable::configure($table);
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
            'index' => ListFamilies::route('/'),
            'create' => CreateFamily::route('/create'),
            'edit' => EditFamily::route('/{record}/edit'),
        ];
    }
}
