<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Brands;

use App\Filament\Admin\Resources\Brands\Pages\CreateBrand;
use App\Filament\Admin\Resources\Brands\Pages\EditBrand;
use App\Filament\Admin\Resources\Brands\Pages\ListBrands;
use App\Filament\Admin\Resources\Brands\Schemas\BrandForm;
use App\Filament\Admin\Resources\Brands\Tables\BrandsTable;
use App\Models\Brand;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return ucfirst(__('machines_management'));
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('brand'));
    }

    public static function getLabel(): string
    {
        return ucfirst(__('brand'));
    }

    public static function getPluralLabel(): string
    {
        return ucfirst(__('brands'));
    }

    public static function form(Schema $schema): Schema
    {
        return BrandForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BrandsTable::configure($table);
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
            'index' => ListBrands::route('/'),
            'create' => CreateBrand::route('/create'),
            'edit' => EditBrand::route('/{record}/edit'),
        ];
    }
}
