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

final class FamilyResource extends Resource
{
    protected static ?string $model = Family::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): string
    {
        return ucfirst(__('machines_management'));
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('family'));
    }

    public static function getLabel(): string
    {
        return ucfirst(__('family'));
    }

    public static function getPluralLabel(): string
    {
        return ucfirst(__('families'));
    }

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
        return [];
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
